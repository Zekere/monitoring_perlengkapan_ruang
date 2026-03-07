@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">

    {{-- ── Header ── --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 fs-4">
                <i class="fas fa-chart-bar text-primary me-2"></i>Statistik Perawatan Barang
            </h2>
            <p class="text-muted mb-0 small">Analisis frekuensi perawatan & kondisi inventaris</p>
        </div>
        <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-outline-secondary btn-sm mt-2 mt-md-0">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #4f46e5 !important;">
                <div class="card-body p-3">
                    <p class="text-muted mb-1 small fw-semibold text-uppercase" style="letter-spacing:.05em;">Total Perawatan</p>
                    <h3 class="fw-bold mb-0" style="color:#4f46e5;">{{ $totalPerawatan }}</h3>
                    <small class="text-muted">Semua waktu</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #059669 !important;">
                <div class="card-body p-3">
                    <p class="text-muted mb-1 small fw-semibold text-uppercase" style="letter-spacing:.05em;">Barang Dirawat</p>
                    <h3 class="fw-bold mb-0" style="color:#059669;">{{ $totalBarangDirawat }}</h3>
                    <small class="text-muted">Unik item</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #d97706 !important;">
                <div class="card-body p-3">
                    <p class="text-muted mb-1 small fw-semibold text-uppercase" style="letter-spacing:.05em;">Total Biaya</p>
                    <h3 class="fw-bold mb-0" style="color:#d97706;font-size:1.1rem;">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Akumulasi</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc2626 !important;">
                <div class="card-body p-3">
                    <p class="text-muted mb-1 small fw-semibold text-uppercase" style="letter-spacing:.05em;">Dalam Proses</p>
                    <h3 class="fw-bold mb-0" style="color:#dc2626;">{{ $statusDalamProses }}</h3>
                    <small class="text-muted">Belum selesai</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- ── Top 10 Barang Paling Sering Dirawat ── --}}
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3 px-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-trophy text-warning me-2"></i>
                        Top 10 Barang Paling Sering Dirawat
                    </h6>
                </div>
                <div class="card-body p-3">
                    @forelse($topBarang as $index => $item)
                        @php
                            $pct = round(($item->riwayat_perawatan_count / $maxCount) * 100);
                            $colors = ['#ef4444','#f97316','#f59e0b','#84cc16','#22c55e','#14b8a6','#3b82f6','#8b5cf6','#ec4899','#6b7280'];
                            $color = $colors[$index] ?? '#6b7280';
                            $medal = $index == 0 ? '🥇' : ($index == 1 ? '🥈' : ($index == 2 ? '🥉' : ''));
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center gap-2" style="min-width:0;">
                                    <span class="fw-bold text-muted" style="font-size:.75rem;min-width:20px;">
                                        {{ $medal ?: ($index + 1) . '.' }}
                                    </span>
                                    <div style="min-width:0;">
                                        <div class="fw-semibold text-truncate" style="font-size:.85rem;color:#1e293b;max-width:220px;">
                                            {{ $item->nama_item }}
                                        </div>
                                        <div class="text-muted" style="font-size:.72rem;">
                                            {{ $item->kode_barang }}
                                            @if($item->ruangan) · {{ $item->ruangan->nama_ruangan }} @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    {{-- Badge kondisi --}}
                                    @if($item->kondisi == 'Baik')
                                        <span class="badge bg-success" style="font-size:.65rem;">Baik</span>
                                    @elseif($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark" style="font-size:.65rem;">Rusak Ringan</span>
                                    @else
                                        <span class="badge bg-danger" style="font-size:.65rem;">Rusak Berat</span>
                                    @endif
                                    {{-- Jumlah perawatan --}}
                                    <span class="fw-bold" style="font-size:.85rem;color:{{ $color }};min-width:28px;text-align:right;">
                                        {{ $item->riwayat_perawatan_count }}x
                                    </span>
                                </div>
                            </div>
                            {{-- Progress bar --}}
                            <div class="progress" style="height:6px;border-radius:99px;background:#f1f5f9;">
                                <div class="progress-bar"
                                     role="progressbar"
                                     style="width:{{ $pct }}%;background:{{ $color }};border-radius:99px;transition:width .6s ease {{ $index * 0.05 }}s;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-wrench fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data perawatan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ── Sidebar: Status + Jenis ── --}}
        <div class="col-12 col-lg-5">
            {{-- Status Perawatan --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3 px-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-pie-chart text-primary me-2"></i>
                        Status Perawatan
                    </h6>
                </div>
                <div class="card-body p-3">
                    @php $tot = max($statusSelesai + $statusDalamProses + $statusDitunda, 1); @endphp

                    {{-- Donut-style visual --}}
                    <div class="d-flex justify-content-around mb-3">
                        <div class="text-center">
                            <div class="fw-bold fs-4" style="color:#059669;">{{ $statusSelesai }}</div>
                            <small class="text-muted">Selesai</small>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold fs-4" style="color:#d97706;">{{ $statusDalamProses }}</div>
                            <small class="text-muted">Proses</small>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold fs-4" style="color:#6b7280;">{{ $statusDitunda }}</div>
                            <small class="text-muted">Ditunda</small>
                        </div>
                    </div>

                    {{-- Stacked bar --}}
                    <div class="d-flex rounded-pill overflow-hidden" style="height:14px;">
                        @if($statusSelesai > 0)
                        <div style="width:{{ round($statusSelesai/$tot*100) }}%;background:#059669;" title="Selesai: {{ $statusSelesai }}"></div>
                        @endif
                        @if($statusDalamProses > 0)
                        <div style="width:{{ round($statusDalamProses/$tot*100) }}%;background:#d97706;" title="Dalam Proses: {{ $statusDalamProses }}"></div>
                        @endif
                        @if($statusDitunda > 0)
                        <div style="width:{{ round($statusDitunda/$tot*100) }}%;background:#6b7280;" title="Ditunda: {{ $statusDitunda }}"></div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="text-success">{{ round($statusSelesai/$tot*100) }}%</small>
                        <small class="text-warning">{{ round($statusDalamProses/$tot*100) }}%</small>
                        <small class="text-secondary">{{ round($statusDitunda/$tot*100) }}%</small>
                    </div>
                </div>
            </div>

            {{-- Jenis Perawatan --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 px-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-tools text-info me-2"></i>
                        Jenis Perawatan Terbanyak
                    </h6>
                </div>
                <div class="card-body p-3">
                    @php $maxJenis = $jenisPerawatan->max('jumlah') ?: 1; @endphp
                    @forelse($jenisPerawatan->take(6) as $jenis)
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1 me-2" style="min-width:0;">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-truncate small fw-semibold" style="max-width:180px;color:#334155;">
                                        {{ $jenis->jenis_perawatan }}
                                    </span>
                                    <span class="small text-muted ms-1">{{ $jenis->jumlah }}x</span>
                                </div>
                                <div class="progress" style="height:5px;border-radius:99px;background:#f1f5f9;">
                                    <div class="progress-bar bg-info"
                                         style="width:{{ round($jenis->jumlah/$maxJenis*100) }}%;border-radius:99px;"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0 small">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ── Perawatan Per Bulan (Bar Chart visual) ── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3 px-3">
            <h6 class="fw-bold mb-0">
                <i class="fas fa-calendar-alt text-success me-2"></i>
                Perawatan Per Bulan ({{ date('Y') }})
            </h6>
        </div>
        <div class="card-body p-3">
            @php
                $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                $dataPerBulan = array_fill(1, 12, 0);
                foreach ($perawatanPerBulan as $p) {
                    $dataPerBulan[(int)$p->bulan] = $p->jumlah;
                }
                $maxBulan = max(array_values($dataPerBulan)) ?: 1;
            @endphp
            <div class="d-flex align-items-end gap-1 gap-md-2" style="height:100px;">
                @foreach($dataPerBulan as $bln => $jumlah)
                    @php
                        $pct = round(($jumlah / $maxBulan) * 100);
                        $isCurrentMonth = $bln == date('n');
                    @endphp
                    <div class="d-flex flex-column align-items-center flex-fill">
                        <div class="text-muted mb-1" style="font-size:.65rem;font-weight:600;">
                            {{ $jumlah > 0 ? $jumlah : '' }}
                        </div>
                        <div class="rounded-top w-100"
                             style="height:{{ max($pct, $jumlah > 0 ? 8 : 2) }}px;
                                    background: {{ $isCurrentMonth ? '#4f46e5' : ($jumlah > 0 ? '#a5b4fc' : '#e2e8f0') }};
                                    transition: height .4s ease;
                                    min-height: 4px;">
                        </div>
                        <div class="text-muted mt-1" style="font-size:.6rem;">
                            {{ $namaBulan[$bln - 1] }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex align-items-center gap-3 mt-2">
                <div class="d-flex align-items-center gap-1">
                    <div class="rounded" style="width:10px;height:10px;background:#4f46e5;"></div>
                    <small class="text-muted">Bulan ini</small>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <div class="rounded" style="width:10px;height:10px;background:#a5b4fc;"></div>
                    <small class="text-muted">Bulan lain</small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection