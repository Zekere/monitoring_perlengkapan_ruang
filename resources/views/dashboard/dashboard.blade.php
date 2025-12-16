@extends('layouts.template')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}</h4>
            <p class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
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
                            <p class="text-muted mb-1">Ruangan</p>
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
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <canvas id="kondisiBarangChart" style="max-height: 250px; max-width: 250px;"></canvas>
                        </div>
                        <div class="col-md-6 d-flex flex-column justify-content-center">
                            @php
                                $totalBaik = 0;
                                $totalRusakRingan = 0;
                                $totalRusakBerat = 0;
                                
                                if(isset($kondisiBarang)) {
                                    foreach($kondisiBarang as $kondisi) {
                                        if($kondisi->kondisi == 'Baik') {
                                            $totalBaik = $kondisi->total;
                                        } elseif($kondisi->kondisi == 'Rusak Ringan') {
                                            $totalRusakRingan = $kondisi->total;
                                        } elseif($kondisi->kondisi == 'Rusak Berat') {
                                            $totalRusakBerat = $kondisi->total;
                                        }
                                    }
                                }
                            @endphp
                            
                            <div class="mb-3 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-2" style="width: 20px; height: 20px;"></span>
                                        <span style="font-weight: 500;">Kondisi Baik</span>
                                    </div>
                                    <strong class="text-success fs-5">{{ $totalBaik }}</strong>
                                </div>
                            </div>
                            
                            <div class="mb-3 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning me-2" style="width: 20px; height: 20px;"></span>
                                        <span style="font-weight: 500;">Rusak Ringan</span>
                                    </div>
                                    <strong class="text-warning fs-5">{{ $totalRusakRingan }}</strong>
                                </div>
                            </div>
                            
                            <div class="mb-0 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-danger me-2" style="width: 20px; height: 20px;"></span>
                                        <span style="font-weight: 500;">Rusak Berat</span>
                                    </div>
                                    <strong class="text-danger fs-5">{{ $totalRusakBerat }}</strong>
                                </div>
                            </div>
                        </div>
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
    // Chart Kondisi Barang (Doughnut) dengan warna yang sesuai
    const kondisiDataRaw = @json($kondisiBarang ?? []);
    console.log('Data Kondisi:', kondisiDataRaw); // Debug
    
    const ctxKondisi = document.getElementById('kondisiBarangChart').getContext('2d');
    
    // Jika tidak ada data dari controller, ambil dari database langsung
    let labels = [];
    let sortedData = [];
    let colors = [];
    
    if (kondisiDataRaw && kondisiDataRaw.length > 0) {
        // Data dari controller
        const baik = kondisiDataRaw.find(k => k.kondisi === 'Baik');
        const rusakRingan = kondisiDataRaw.find(k => k.kondisi === 'Rusak Ringan');
        const rusakBerat = kondisiDataRaw.find(k => k.kondisi === 'Rusak Berat');
        
        if (baik && baik.total > 0) {
            labels.push('Baik');
            sortedData.push(baik.total);
            colors.push('#28a745');
        }
        
        if (rusakRingan && rusakRingan.total > 0) {
            labels.push('Rusak Ringan');
            sortedData.push(rusakRingan.total);
            colors.push('#ffc107');
        }
        
        if (rusakBerat && rusakBerat.total > 0) {
            labels.push('Rusak Berat');
            sortedData.push(rusakBerat.total);
            colors.push('#dc3545');
        }
    }
    
    // Jika masih tidak ada data, gunakan nilai default dari total yang ditampilkan
    if (sortedData.length === 0) {
        const totalBaik = {{ $totalBaik ?? 0 }};
        const totalRusakRingan = {{ $totalRusakRingan ?? 0 }};
        const totalRusakBerat = {{ $totalRusakBerat ?? 0 }};
        
        if (totalBaik > 0) {
            labels.push('Baik');
            sortedData.push(totalBaik);
            colors.push('#28a745');
        }
        if (totalRusakRingan > 0) {
            labels.push('Rusak Ringan');
            sortedData.push(totalRusakRingan);
            colors.push('#ffc107');
        }
        if (totalRusakBerat > 0) {
            labels.push('Rusak Berat');
            sortedData.push(totalRusakBerat);
            colors.push('#dc3545');
        }
    }
    
    console.log('Labels:', labels); // Debug
    console.log('Data:', sortedData); // Debug
    console.log('Colors:', colors); // Debug
    
    if (sortedData.length > 0) {
        new Chart(ctxKondisi, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: sortedData,
                    backgroundColor: colors,
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    } else {
        // Tampilkan pesan jika tidak ada data
        const canvas = document.getElementById('kondisiBarangChart');
        canvas.style.display = 'none';
        const container = canvas.parentElement;
        container.innerHTML += '<p class="text-center text-muted">Belum ada data kondisi barang</p>';
    }

    // Chart Distribusi Kategori (Bar)
    const kategoriData = @json($distribusiKategori ?? []);
    const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
    
    if (kategoriData && kategoriData.length > 0) {
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
    }

    // Chart Tren Kondisi (Line)
    const trenData = @json($kondisiPerBulan ?? []);
    
    if (trenData && trenData.length > 0) {
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
    }
</script>
@endpush