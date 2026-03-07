@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold mb-1 fs-4 fs-md-3">
                <i class="fas fa-box-open text-primary me-1"></i>
                Daftar Barang
            </h2>
            <p class="text-muted mb-0 small">Kelola seluruh data inventaris barang</p>
        </div>
        <a href="{{ route('riwayat-perawatan.statistik') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-chart-bar me-1"></i> Statistik Perawatan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total</p>
                            <h4 class="mb-0 fs-5 fs-md-3">{{ $barang->count() }}</h4>
                        </div>
                        <i class="fas fa-box fa-lg text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Baik</p>
                            <h4 class="mb-0 fs-5 fs-md-3">{{ $barang->where('kondisi', 'Baik')->count() }}</h4>
                        </div>
                        <i class="fas fa-check-circle fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Rusak Ringan</p>
                            <h4 class="mb-0 fs-5 fs-md-3">{{ $barang->where('kondisi', 'Rusak Ringan')->count() }}</h4>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-lg text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Rusak Berat</p>
                            <h4 class="mb-0 fs-5 fs-md-3">{{ $barang->where('kondisi', 'Rusak Berat')->count() }}</h4>
                        </div>
                        <i class="fas fa-times-circle fa-lg text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Tabel -->
    <div class="card shadow-sm">
        <div class="card-body p-2 p-md-3">
            <!-- Form Filter -->
            <form method="GET" action="{{ route('barang.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-3">
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="🔍 Cari barang..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="kategori" class="form-select form-select-sm">
                            <option value="">🏷️ Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="ruangan" class="form-select form-select-sm">
                            <option value="">📍 Ruangan</option>
                            @foreach($ruangan as $ruang)
                                <option value="{{ $ruang->id_ruangan }}" {{ request('ruangan') == $ruang->id_ruangan ? 'selected' : '' }}>
                                    {{ $ruang->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="kondisi" class="form-select form-select-sm">
                            <option value="">⚙️ Kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-12 col-lg-3">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                <i class="fas fa-rotate"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Info + Legenda -->
            <div class="mb-3 d-flex flex-wrap align-items-center gap-3">
                <p class="text-muted mb-0 small">
                    <i class="fas fa-info-circle"></i>
                    Menampilkan <strong>{{ $barang->count() }}</strong> data barang
                </p>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <small class="text-muted">Indikator Perawatan:</small>
                    <span class="badge rounded-pill" style="background:#fef3c7;color:#92400e;font-size:.7rem;">
                        <i class="fas fa-wrench me-1" style="font-size:.6rem;"></i>1–2x
                    </span>
                    <span class="badge rounded-pill" style="background:#fed7aa;color:#9a3412;font-size:.7rem;">
                        <i class="fas fa-wrench me-1" style="font-size:.6rem;"></i>3–5x
                    </span>
                    <span class="badge rounded-pill" style="background:#fecaca;color:#991b1b;font-size:.7rem;">
                        <i class="fas fa-fire me-1" style="font-size:.6rem;"></i>6x+
                    </span>
                    <small class="text-muted fst-italic">*Jumlah tidak berkurang meski riwayat dihapus</small>
                </div>
            </div>

            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px;">No</th>
                            <th style="width:120px;">Kode</th>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Ruangan</th>
                            <th class="text-center" style="width:120px;">Kondisi</th>
                            <th class="text-center" style="width:120px;">Perawatan</th>
                            <th class="text-center" style="width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $index => $item)
                            @php
                                // Gunakan kolom permanen jumlah_perawatan
                                $cnt = $item->jumlah_perawatan ?? 0;
                            @endphp
                            <tr>
                                <td style="color:#000;">{{ $index + 1 }}</td>
                                <td style="color:#000;" class="small">{{ $item->kode_barang }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="foto"
                                                 class="rounded me-2"
                                                 style="width:40px;height:40px;object-fit:cover;">
                                        @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center"
                                                 style="width:40px;height:40px;">
                                                <i class="fas fa-image text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="color:#000;">{{ $item->nama_item }}</div>
                                            <small class="text-muted">{{ $item->merk }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="color:#000;">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td style="color:#000;">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                                <td class="text-center">
                                    @if($item->kondisi == 'Baik')
                                        <span class="badge bg-success">{{ $item->kondisi }}</span>
                                    @elseif($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                    @else
                                        <span class="badge bg-danger">{{ $item->kondisi }}</span>
                                    @endif
                                </td>

                                {{-- ── INDIKATOR PERAWATAN (dari kolom permanen) ── --}}
                                <td class="text-center">
                                    @if($cnt == 0)
                                        <span class="text-muted small">—</span>
                                    @elseif($cnt <= 2)
                                        <span class="badge rounded-pill px-2"
                                              style="background:#fef3c7;color:#92400e;"
                                              data-bs-toggle="tooltip"
                                              title="Total {{ $cnt }}x perawatan">
                                            <i class="fas fa-wrench me-1" style="font-size:.65rem;"></i>{{ $cnt }}x
                                        </span>
                                    @elseif($cnt <= 5)
                                        <span class="badge rounded-pill px-2"
                                              style="background:#fed7aa;color:#9a3412;"
                                              data-bs-toggle="tooltip"
                                              title="Total {{ $cnt }}x perawatan — perhatikan barang ini">
                                            <i class="fas fa-wrench me-1" style="font-size:.65rem;"></i>{{ $cnt }}x
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-2 maintenance-pulse"
                                              style="background:#fecaca;color:#991b1b;"
                                              data-bs-toggle="tooltip"
                                              title="Total {{ $cnt }}x perawatan — barang sering rusak!">
                                            <i class="fas fa-fire me-1" style="font-size:.65rem;"></i>{{ $cnt }}x
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('barang.edit', $item) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('barang.destroy', $item->id_item) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data barang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                @forelse($barang as $index => $item)
                    @php $cnt = $item->jumlah_perawatan ?? 0; @endphp
                    <div class="card mb-2 shadow-sm"
                         style="{{ $cnt >= 6 ? 'border-left: 3px solid #dc2626 !important;' : ($cnt >= 3 ? 'border-left: 3px solid #f59e0b !important;' : '') }}">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-start">
                                <div class="me-2">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="foto"
                                             class="rounded" style="width:60px;height:60px;object-fit:cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                             style="width:60px;height:60px;">
                                            <i class="fas fa-image text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            <h6 class="mb-0 fw-bold" style="color:#000;">{{ $item->nama_item }}</h6>
                                            <small class="text-muted">{{ $item->kode_barang }}</small>
                                        </div>
                                        <div class="d-flex flex-column align-items-end gap-1">
                                            @if($item->kondisi == 'Baik')
                                                <span class="badge bg-success" style="font-size:.65rem;">Baik</span>
                                            @elseif($item->kondisi == 'Rusak Ringan')
                                                <span class="badge bg-warning text-dark" style="font-size:.65rem;">Rusak Ringan</span>
                                            @else
                                                <span class="badge bg-danger" style="font-size:.65rem;">Rusak Berat</span>
                                            @endif
                                            @if($cnt > 0)
                                                @if($cnt <= 2)
                                                    <span class="badge rounded-pill" style="background:#fef3c7;color:#92400e;font-size:.65rem;">
                                                        <i class="fas fa-wrench"></i> {{ $cnt }}x
                                                    </span>
                                                @elseif($cnt <= 5)
                                                    <span class="badge rounded-pill" style="background:#fed7aa;color:#9a3412;font-size:.65rem;">
                                                        <i class="fas fa-wrench"></i> {{ $cnt }}x
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill maintenance-pulse" style="background:#fecaca;color:#991b1b;font-size:.65rem;">
                                                        <i class="fas fa-fire"></i> {{ $cnt }}x
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <div class="small mb-2">
                                        <div class="text-muted">
                                            <i class="fas fa-tag text-primary me-1"></i>
                                            <span style="color:#000;">{{ $item->merk ?? '-' }}</span>
                                        </div>
                                        <div class="text-muted">
                                            <i class="fas fa-layer-group text-info me-1"></i>
                                            <span style="color:#000;">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                                        </div>
                                        <div class="text-muted">
                                            <i class="fas fa-door-open text-success me-1"></i>
                                            <span style="color:#000;">{{ $item->ruangan->nama_ruangan ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-1">
                                        <a href="{{ route('barang.edit', $item) }}" class="btn btn-warning btn-sm flex-fill">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('barang.destroy', $item->id_item) }}"
                                              method="POST"
                                              class="flex-fill"
                                              onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm w-100">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada data barang</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<style>
@media (max-width: 576px) {
    .fs-4 { font-size: 1.1rem !important; }
    .card-body { padding: 0.75rem; }
    h4.fs-5 { font-size: 1rem !important; }
    .small { font-size: 0.8rem; }
}
.btn-sm { padding: .375rem .75rem; font-size: .875rem; }
@media (max-width: 576px) {
    .btn-sm { padding: .25rem .5rem; font-size: .8rem; }
}
@keyframes maintenance-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .8; transform: scale(1.06); }
}
.maintenance-pulse {
    animation: maintenance-pulse 1.8s ease-in-out infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipEls = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipEls.forEach(function (el) { new bootstrap.Tooltip(el); });
});
</script>
@endsection