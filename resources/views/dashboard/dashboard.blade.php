@extends('layouts.template')

@section('content')

<div class="container-fluid px-2 px-md-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
        <div>
            <h4 class="mb-1 fs-5 fs-md-4">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}</h4>
            <p class="text-muted mb-0 small">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
    </div>

    <!-- Cards Statistik -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-box-seam text-primary fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Total Barang</p>
                            <h3 class="mb-0 fs-5 fs-md-3">{{ $totalBarang }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-tag text-info fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Kategori</p>
                            <h3 class="mb-0 fs-5 fs-md-3">{{ $totalKategori }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-geo-alt text-warning fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Ruangan</p>
                            <h3 class="mb-0 fs-5 fs-md-3">{{ $totalRuangan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <!-- Kondisi Barang -->
        <div class="col-12 col-lg-6 mb-2 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 p-2 p-md-3">
                    <h5 class="mb-0 fs-6 fs-md-5">Kondisi Barang</h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div class="row g-2">
                        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                            <canvas id="kondisiBarangChart" style="max-height: 200px; max-width: 200px;"></canvas>
                        </div>
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
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
                            
                            <div class="mb-2 p-2 p-md-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-2" style="width: 15px; height: 15px;"></span>
                                        <span class="small" style="font-weight: 500;">Kondisi Baik</span>
                                    </div>
                                    <strong class="text-success fs-6 fs-md-5">{{ $totalBaik }}</strong>
                                </div>
                            </div>
                            
                            <div class="mb-2 p-2 p-md-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning me-2" style="width: 15px; height: 15px;"></span>
                                        <span class="small" style="font-weight: 500;">Rusak Ringan</span>
                                    </div>
                                    <strong class="text-warning fs-6 fs-md-5">{{ $totalRusakRingan }}</strong>
                                </div>
                            </div>
                            
                            <div class="mb-0 p-2 p-md-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-danger me-2" style="width: 15px; height: 15px;"></span>
                                        <span class="small" style="font-weight: 500;">Rusak Berat</span>
                                    </div>
                                    <strong class="text-danger fs-6 fs-md-5">{{ $totalRusakBerat }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi per Kategori -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 p-2 p-md-3">
                    <h5 class="mb-0 fs-6 fs-md-5">Distribusi per Kategori</h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <canvas id="kategoriChart" style="height: 200px;"></canvas>
                </div>
            </div>
        </div>
    </div>

   
    <!-- Tables -->
    <div class="row g-2 g-md-3">
        <!-- Barang Terbaru -->
        <div class="col-12 col-lg-6 mb-2 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 p-2 p-md-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                    <h5 class="mb-0 fs-6 fs-md-5">Barang Terbaru</h5>
                    <div class="d-flex gap-1 flex-wrap">
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-list d-none d-sm-inline"></i> Lihat Semua
                        </a>
                        <a href="{{ route('export.barang') }}" class="btn btn-sm btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> <span class="d-none d-sm-inline">PDF</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="small">No</th>
                                    <th class="small">Kode</th>
                                    <th class="small">Nama</th>
                                    <th class="small">Kategori</th>
                                    <th class="small">Merk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangTerbaru as $index => $barang)
                                <tr>
                                    <td class="small">{{ $index + 1 }}</td>
                                    <td><code class="small">{{ $barang->kode_barang ?? '-' }}</code></td>
                                    <td class="small">{{ $barang->nama_item }}</td>
                                    <td>
                                        <span class="badge bg-info small">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td class="small">{{ $barang->merk ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4 small">Belum ada data barang</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none p-2">
                        @forelse($barangTerbaru as $index => $barang)
                            <div class="card mb-2 border">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 small fw-bold">{{ $barang->nama_item }}</h6>
                                            <code class="small text-muted">{{ $barang->kode_barang ?? '-' }}</code>
                                        </div>
                                        <span class="badge bg-info small">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                                    </div>
                                    <p class="mb-0 small text-muted">
                                        <i class="fas fa-tag"></i> {{ $barang->merk ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted py-4 small">Belum ada data barang</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pengecekan -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 p-2 p-md-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fs-6 fs-md-5">Riwayat Pengecekan</h5>
                    <a href="{{ route('pengecekan.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list d-none d-sm-inline"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="small">Tanggal</th>
                                    <th class="small">Ruangan</th>
                                    <th class="small">Barang</th>
                                    <th class="small">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengecekanTerbaru as $pengecekan)
                                    @foreach($pengecekan->detailPengecekan->take(1) as $detail)
                                    <tr>
                                        <td class="small">{{ \Carbon\Carbon::parse($pengecekan->tanggal_cek)->format('d/m/Y') }}</td>
                                        <td class="small">{{ $pengecekan->ruangan->nama_ruangan ?? '-' }}</td>
                                        <td class="small">{{ $detail->item->nama_item ?? '-' }}</td>
                                        <td>
                                            <span class="badge small
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
                                    <td colspan="4" class="text-center text-muted py-4 small">Belum ada riwayat pengecekan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none p-2">
                        @forelse($pengecekanTerbaru as $pengecekan)
                            @foreach($pengecekan->detailPengecekan->take(1) as $detail)
                                <div class="card mb-2 border">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div>
                                                <h6 class="mb-0 small fw-bold">{{ $detail->item->nama_item ?? '-' }}</h6>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($pengecekan->tanggal_cek)->format('d/m/Y') }}</small>
                                            </div>
                                            <span class="badge small
                                                @if($detail->kondisi == 'Baik') bg-success
                                                @elseif($detail->kondisi == 'Rusak Ringan') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $detail->kondisi }}
                                            </span>
                                        </div>
                                        <p class="mb-0 small text-muted">
                                            <i class="fas fa-door-open"></i> {{ $pengecekan->ruangan->nama_ruangan ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @empty
                            <p class="text-center text-muted py-4 small">Belum ada riwayat pengecekan</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-6">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label class="form-label small">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="nama_item" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Merk</label>
                        <input type="text" class="form-control form-control-sm" name="merk">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" name="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            @foreach(\App\Models\Kategori::all() as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Responsive improvements */
@media (max-width: 576px) {
    .fs-5 { font-size: 0.95rem !important; }
    .fs-6 { font-size: 0.85rem !important; }
    .card-body { padding: 0.75rem; }
    .small { font-size: 0.8rem; }
}

@media (max-width: 768px) {
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
}

/* Chart responsive */
#kondisiBarangChart, #kategoriChart {
    max-width: 100%;
    height: auto !important;
}

@media (max-width: 576px) {
    #kondisiBarangChart {
        max-height: 180px !important;
        max-width: 180px !important;
    }
}
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Chart Kondisi Barang (Doughnut) dengan warna yang sesuai
    const kondisiDataRaw = @json($kondisiBarang ?? []);
    console.log('Data Kondisi:', kondisiDataRaw);
    
    const ctxKondisi = document.getElementById('kondisiBarangChart').getContext('2d');
    
    let labels = [];
    let sortedData = [];
    let colors = [];
    
    if (kondisiDataRaw && kondisiDataRaw.length > 0) {
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
        const canvas = document.getElementById('kondisiBarangChart');
        canvas.style.display = 'none';
        const container = canvas.parentElement;
        container.innerHTML += '<p class="text-center text-muted small">Belum ada data kondisi barang</p>';
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
                            precision: 0,
                            font: {
                                size: window.innerWidth < 576 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: window.innerWidth < 576 ? 10 : 12
                            }
                        }
                    }
                }
            }
        });
    }

    // Chart Tren Kondisi (Line)
    const trenData = @json($kondisiPerBulan ?? []);
    
    if (trenData && trenData.length > 0) {
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