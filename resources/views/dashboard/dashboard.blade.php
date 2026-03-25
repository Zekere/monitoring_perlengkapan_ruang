@extends('layouts.template')

@section('content')

<div class="container-fluid px-2 px-md-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
        <div>
            <h4 class="mb-1 fs-5 fs-md-4">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}</h4>
            <p class="text-muted mb-0 small" id="realtime-clock"></p>
        </div>
    </div>

    <!-- Cards Statistik -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">

        <!-- Total Barang -->
        <div class="col-6 col-md-3">
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

        <!-- Kategori -->
        <div class="col-6 col-md-3">
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

        <!-- Ruangan -->
        <div class="col-6 col-md-3">
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

        <!-- Total Nilai Barang — otomatis SUM dari database -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-cash-stack text-success fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Total Nilai Barang</p>
                            <p class="mb-0 fw-bold text-success" style="font-size:clamp(.75rem,1.8vw,.9rem);">
                                Rp {{ number_format($totalNilaiBarang, 0, ',', '.') }}
                            </p>
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
                            <canvas id="kondisiBarangChart" style="max-height:200px;max-width:200px;"></canvas>
                        </div>
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                            @php
                                $totalBaik = 0; $totalRusakRingan = 0; $totalRusakBerat = 0;
                                if(isset($kondisiBarang)) {
                                    foreach($kondisiBarang as $k) {
                                        if($k->kondisi == 'Baik')         $totalBaik = $k->total;
                                        elseif($k->kondisi == 'Rusak Ringan') $totalRusakRingan = $k->total;
                                        elseif($k->kondisi == 'Rusak Berat')  $totalRusakBerat = $k->total;
                                    }
                                }
                            @endphp
                            <div class="mb-2 p-2 p-md-3" style="background:#f8f9fa;border-radius:8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-2" style="width:15px;height:15px;"></span>
                                        <span class="small">Kondisi Baik</span>
                                    </div>
                                    <strong class="text-success">{{ $totalBaik }}</strong>
                                </div>
                            </div>
                            <div class="mb-2 p-2 p-md-3" style="background:#f8f9fa;border-radius:8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning me-2" style="width:15px;height:15px;"></span>
                                        <span class="small">Rusak Ringan</span>
                                    </div>
                                    <strong class="text-warning">{{ $totalRusakRingan }}</strong>
                                </div>
                            </div>
                            <div class="mb-0 p-2 p-md-3" style="background:#f8f9fa;border-radius:8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-danger me-2" style="width:15px;height:15px;"></span>
                                        <span class="small">Rusak Berat</span>
                                    </div>
                                    <strong class="text-danger">{{ $totalRusakBerat }}</strong>
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
                    <canvas id="kategoriChart" style="height:200px;"></canvas>
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
                    <!-- Desktop -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="small">No</th>
                                    <th class="small">Kode</th>
                                    <th class="small">Nama</th>
                                    <th class="small">Kategori</th>
                                    <th class="small">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangTerbaru as $index => $barang)
                                <tr>
                                    <td class="small">{{ $index + 1 }}</td>
                                    <td><code class="small">{{ $barang->kode_barang ?? '-' }}</code></td>
                                    <td class="small">{{ $barang->nama_item }}</td>
                                    <td><span class="badge bg-info small">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td class="small text-success fw-bold">
                                        @if($barang->harga_satuan > 0)
                                            Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4 small">Belum ada data barang</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile -->
                    <div class="d-md-none p-2">
                        @forelse($barangTerbaru as $barang)
                            <div class="card mb-2 border">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 small fw-bold">{{ $barang->nama_item }}</h6>
                                            <code class="small text-muted">{{ $barang->kode_barang ?? '-' }}</code>
                                        </div>
                                        <span class="badge bg-info small">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                                    </div>
                                    <p class="mb-0 small fw-bold text-success">
                                        @if($barang->harga_satuan > 0)
                                            Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}
                                        @else
                                            <span class="text-muted fw-normal">Harga belum diisi</span>
                                        @endif
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
                <div class="card-header bg-white border-0 p-2 p-md-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                    <h5 class="mb-0 fs-6 fs-md-5">
                        <i class="fas fa-history text-secondary me-1"></i> Riwayat Pengecekan Terbaru
                    </h5>
                    <a href="{{ route('riwayat.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-list d-none d-sm-inline"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <!-- Desktop -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="small">Tanggal</th>
                                    <th class="small">Kode</th>
                                    <th class="small">Nama Barang</th>
                                    <th class="small">Jenis</th>
                                    <th class="small">Perubahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengecekanTerbaru as $r)
                                <tr>
                                    <td>
                                        <small>
                                            <strong>{{ $r->created_at->format('d/m/Y') }}</strong><br>
                                            <span class="text-muted">{{ $r->created_at->format('H:i') }}</span>
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('riwayat.show', $r->id_item) }}" class="text-primary text-decoration-none">
                                            <code class="small">{{ $r->kode_barang }}</code>
                                        </a>
                                    </td>
                                    <td class="small">{{ $r->nama_item }}</td>
                                    <td>
                                        @if($r->jenis_perubahan == 'Kondisi')
                                            <span class="badge bg-warning text-dark" style="font-size:.65rem;"><i class="fas fa-tools"></i> Kondisi</span>
                                        @elseif($r->jenis_perubahan == 'Ruangan')
                                            <span class="badge bg-info" style="font-size:.65rem;"><i class="fas fa-door-open"></i> Ruangan</span>
                                        @elseif($r->jenis_perubahan == 'Semua')
                                            <span class="badge bg-danger" style="font-size:.65rem;"><i class="fas fa-sync"></i> Semua</span>
                                        @else
                                            <span class="badge bg-secondary" style="font-size:.65rem;"><i class="fas fa-edit"></i> Data</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            @if($r->kondisi_lama !== $r->kondisi_baru)
                                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                                    <span class="badge bg-light text-dark" style="font-size:.6rem;">{{ $r->kondisi_lama ?? 'Baru' }}</span>
                                                    <i class="fas fa-arrow-right" style="font-size:.6rem;opacity:.6;"></i>
                                                    <span class="badge @if($r->kondisi_baru=='Baik') bg-success @elseif($r->kondisi_baru=='Rusak Ringan') bg-warning text-dark @else bg-danger @endif" style="font-size:.6rem;">{{ $r->kondisi_baru }}</span>
                                                </div>
                                            @endif
                                            @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                                <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                                                    <span class="badge bg-light text-dark" style="font-size:.6rem;">{{ $r->ruanganLama->nama_ruangan ?? 'Tidak ada' }}</span>
                                                    <i class="fas fa-arrow-right" style="font-size:.6rem;opacity:.6;"></i>
                                                    <span class="badge bg-info" style="font-size:.6rem;">{{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada' }}</span>
                                                </div>
                                            @endif
                                        </small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4 small">Belum ada riwayat pengecekan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile -->
                    <div class="d-md-none p-2">
                        @forelse($pengecekanTerbaru as $r)
                            <div class="card mb-2 border">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            <a href="{{ route('riwayat.show', $r->id_item) }}" class="text-primary text-decoration-none">
                                                <h6 class="mb-0 small fw-bold">{{ $r->kode_barang }}</h6>
                                            </a>
                                            <small class="text-muted">{{ $r->nama_item }}</small>
                                        </div>
                                        @if($r->jenis_perubahan == 'Kondisi')
                                            <span class="badge bg-warning text-dark" style="font-size:.65rem;">Kondisi</span>
                                        @elseif($r->jenis_perubahan == 'Ruangan')
                                            <span class="badge bg-info" style="font-size:.65rem;">Ruangan</span>
                                        @elseif($r->jenis_perubahan == 'Semua')
                                            <span class="badge bg-danger" style="font-size:.65rem;">Semua</span>
                                        @else
                                            <span class="badge bg-secondary" style="font-size:.65rem;">Data</span>
                                        @endif
                                    </div>
                                    @if($r->kondisi_lama !== $r->kondisi_baru)
                                        <div class="d-flex align-items-center gap-1 mb-1 flex-wrap">
                                            <small class="text-muted">Kondisi:</small>
                                            <span class="badge bg-light text-dark" style="font-size:.6rem;">{{ $r->kondisi_lama ?? 'Baru' }}</span>
                                            <i class="fas fa-arrow-right" style="font-size:.6rem;opacity:.6;"></i>
                                            <span class="badge @if($r->kondisi_baru=='Baik') bg-success @elseif($r->kondisi_baru=='Rusak Ringan') bg-warning text-dark @else bg-danger @endif" style="font-size:.6rem;">{{ $r->kondisi_baru }}</span>
                                        </div>
                                    @endif
                                    @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                        <div class="d-flex align-items-center gap-1 mb-1 flex-wrap">
                                            <small class="text-muted">Ruangan:</small>
                                            <span class="badge bg-light text-dark" style="font-size:.6rem;">{{ $r->ruanganLama->nama_ruangan ?? 'Tidak ada' }}</span>
                                            <i class="fas fa-arrow-right" style="font-size:.6rem;opacity:.6;"></i>
                                            <span class="badge bg-info" style="font-size:.6rem;">{{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada' }}</span>
                                        </div>
                                    @endif
                                    <div class="border-top pt-1 mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> {{ $r->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted py-4 small">Belum ada riwayat pengecekan</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
@media (max-width:576px) { .fs-5{font-size:.95rem!important} .fs-6{font-size:.85rem!important} .small{font-size:.8rem} }
@media (max-width:768px) { .btn-sm{padding:.25rem .5rem;font-size:.8rem} }
#kondisiBarangChart,#kategoriChart{max-width:100%;height:auto!important}
@media (max-width:576px){#kondisiBarangChart{max-height:180px!important;max-width:180px!important}}
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Chart Kondisi Barang
    const kondisiDataRaw = @json($kondisiBarang ?? []);
    const ctxKondisi = document.getElementById('kondisiBarangChart').getContext('2d');
    let labels = [], sortedData = [], colors = [];

    if (kondisiDataRaw && kondisiDataRaw.length > 0) {
        const baik = kondisiDataRaw.find(k => k.kondisi === 'Baik');
        const rusakRingan = kondisiDataRaw.find(k => k.kondisi === 'Rusak Ringan');
        const rusakBerat  = kondisiDataRaw.find(k => k.kondisi === 'Rusak Berat');
        if (baik && baik.total > 0)             { labels.push('Baik');         sortedData.push(baik.total);        colors.push('#28a745'); }
        if (rusakRingan && rusakRingan.total > 0){ labels.push('Rusak Ringan'); sortedData.push(rusakRingan.total); colors.push('#ffc107'); }
        if (rusakBerat  && rusakBerat.total > 0) { labels.push('Rusak Berat');  sortedData.push(rusakBerat.total);  colors.push('#dc3545'); }
    }

    if (sortedData.length > 0) {
        new Chart(ctxKondisi, {
            type: 'doughnut',
            data: { labels, datasets: [{ data: sortedData, backgroundColor: colors, borderWidth: 3, borderColor: '#fff' }] },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ctx.label + ': ' + ctx.parsed + ' (' + ((ctx.parsed / ctx.dataset.data.reduce((a,b)=>a+b,0))*100).toFixed(1) + '%)' } }
                }
            }
        });
    } else {
        const c = document.getElementById('kondisiBarangChart');
        c.style.display = 'none';
        c.parentElement.innerHTML += '<p class="text-center text-muted small">Belum ada data</p>';
    }

    // Chart Distribusi Kategori
    const kategoriData = @json($distribusiKategori ?? []);
    if (kategoriData && kategoriData.length > 0) {
        new Chart(document.getElementById('kategoriChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: kategoriData.map(k => k.nama_kategori),
                datasets: [{ label: 'Jumlah Barang', data: kategoriData.map(k => k.total), backgroundColor: '#3b82f6', borderRadius: 5 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    }

    // Realtime clock
    function updateClock() {
        const now = new Date();
        const hari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        document.getElementById('realtime-clock').textContent =
            hari[now.getDay()] + ', ' + now.getDate() + ' ' + bulan[now.getMonth()] + ' ' + now.getFullYear() +
            '  |  ' + String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0') + ':' + String(now.getSeconds()).padStart(2,'0');
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endpush