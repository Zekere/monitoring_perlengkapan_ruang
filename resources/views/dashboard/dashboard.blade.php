@extends('layouts.template')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}</h4>
            <p class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </button>
    </div>

    <!-- Cards Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-box-seam text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Barang</p>
                            <h3 class="mb-0">{{ $totalBarang }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-tag text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Kategori</p>
                            <h3 class="mb-0">{{ $totalKategori }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-geo-alt text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Lokasi</p>
                            <h3 class="mb-0">{{ $totalRuangan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <!-- Kondisi Barang -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Kondisi Barang</h5>
                </div>
                <div class="card-body">
                    <canvas id="kondisiBarangChart" height="200"></canvas>
                    <div class="mt-3">
                        @foreach($kondisiBarang as $kondisi)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge 
                                    @if($kondisi->kondisi == 'Baik') bg-success
                                    @elseif($kondisi->kondisi == 'Rusak Ringan') bg-warning
                                    @else bg-danger
                                    @endif me-2" style="width: 12px; height: 12px;"></span>
                                <span>{{ $kondisi->kondisi }}</span>
                            </div>
                            <strong>{{ $kondisi->total }}</strong>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi per Kategori -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Distribusi per Kategori</h5>
                </div>
                <div class="card-body">
                    <canvas id="kategoriChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tren Kondisi 1 Bulan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Tren Kondisi Barang (1 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="trenKondisiChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables -->
    <div class="row">
        <!-- Barang Terbaru -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Barang Terbaru</h5>
                    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Merk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangTerbaru as $index => $barang)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><code>{{ $barang->kode_barang ?? '-' }}</code></td>
                                    <td>{{ $barang->nama_item }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td>{{ $barang->merk ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data barang</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pengecekan -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Pengecekan</h5>
                    <a href="{{ route('pengecekan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Ruangan</th>
                                    <th>Barang</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengecekanTerbaru as $pengecekan)
                                    @foreach($pengecekan->detailPengecekan->take(1) as $detail)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($pengecekan->tanggal_cek)->format('d/m/Y') }}</td>
                                        <td>{{ $pengecekan->ruangan->nama_ruangan ?? '-' }}</td>
                                        <td>{{ $detail->item->nama_item ?? '-' }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($detail->kondisi == 'Baik') bg-success
                                                @elseif($detail->kondisi == 'Rusak Ringan') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $detail->kondisi }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada riwayat pengecekan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_item" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" name="merk">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            @foreach(\App\Models\Kategori::all() as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Chart Kondisi Barang (Doughnut)
    const kondisiData = @json($kondisiBarang);
    const ctxKondisi = document.getElementById('kondisiBarangChart').getContext('2d');
    new Chart(ctxKondisi, {
        type: 'doughnut',
        data: {
            labels: kondisiData.map(k => k.kondisi),
            datasets: [{
                data: kondisiData.map(k => k.total),
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Chart Distribusi Kategori (Bar)
    const kategoriData = @json($distribusiKategori);
    const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctxKategori, {
        type: 'bar',
        data: {
            labels: kategoriData.map(k => k.nama_kategori),
            datasets: [{
                label: 'Jumlah Barang',
                data: kategoriData.map(k => k.total),
                backgroundColor: '#3b82f6',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Chart Tren Kondisi (Line)
    const trenData = @json($kondisiPerBulan);
    
    // Group data by kondisi
    const groupedData = {};
    trenData.forEach(item => {
        if (!groupedData[item.kondisi]) {
            groupedData[item.kondisi] = [];
        }
        groupedData[item.kondisi].push({
            x: item.tanggal,
            y: item.total
        });
    });

    const datasets = Object.keys(groupedData).map(kondisi => {
        let color;
        if (kondisi === 'Baik') color = '#28a745';
        else if (kondisi === 'Rusak Ringan') color = '#ffc107';
        else color = '#dc3545';

        return {
            label: kondisi,
            data: groupedData[kondisi],
            borderColor: color,
            backgroundColor: color + '20',
            tension: 0.4,
            fill: true
        };
    });

    const ctxTren = document.getElementById('trenKondisiChart').getContext('2d');
    new Chart(ctxTren, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        displayFormats: {
                            day: 'DD MMM'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush