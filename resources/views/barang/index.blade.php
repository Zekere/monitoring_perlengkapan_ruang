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
    </div>

    <!-- Alert -->
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
                        <i class="fas fa-box fa-lg fa-md-2x text-primary"></i>
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
                        <i class="fas fa-check-circle fa-lg fa-md-2x text-success"></i>
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
                        <i class="fas fa-exclamation-triangle fa-lg fa-md-2x text-warning"></i>
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
                        <i class="fas fa-times-circle fa-lg fa-md-2x text-danger"></i>
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
                    <!-- Search -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="🔍 Cari barang..."
                               value="{{ request('search') }}">
                    </div>

                    <!-- Kategori -->
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

                    <!-- Ruangan -->
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

                    <!-- Kondisi -->
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="kondisi" class="form-select form-select-sm">
                            <option value="">⚙️ Kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>

                    <!-- Buttons -->
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

            <!-- Info Total Data -->
            <div class="mb-3">
                <p class="text-muted mb-0 small">
                    <i class="fas fa-info-circle"></i> 
                    Menampilkan <strong>{{ $barang->count() }}</strong> data barang
                </p>
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 120px;">Kode</th>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Ruangan</th>
                            <th class="text-center" style="width: 120px;">Kondisi</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $index => $item)
                            <tr>
                                <td style="color: #000;">{{ $index + 1 }}</td>
                                <td style="color: #000;" class="small">{{ $item->kode_barang }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="foto" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="color: #000;">{{ $item->nama_item }}</div>
                                            <small class="text-muted">{{ $item->merk }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="color: #000;">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td style="color: #000;">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                                <td class="text-center">
                                    @if($item->kondisi == 'Baik')
                                        <span class="badge bg-success">{{ $item->kondisi }}</span>
                                    @elseif($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                    @else
                                        <span class="badge bg-danger">{{ $item->kondisi }}</span>
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
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data barang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (visible only on mobile) -->
            <div class="d-md-none">
                @forelse($barang as $index => $item)
                    <div class="card mb-2 shadow-sm">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-start">
                                <!-- Image -->
                                <div class="me-2">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="foto" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-white"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            <h6 class="mb-0 fw-bold" style="color: #000;">{{ $item->nama_item }}</h6>
                                            <small class="text-muted">{{ $item->kode_barang }}</small>
                                        </div>
                                        <div>
                                            @if($item->kondisi == 'Baik')
                                                <span class="badge bg-success" style="font-size: 0.7rem;">Baik</span>
                                            @elseif($item->kondisi == 'Rusak Ringan')
                                                <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">Rusak Ringan</span>
                                            @else
                                                <span class="badge bg-danger" style="font-size: 0.7rem;">Rusak Berat</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="small mb-2">
                                        <div class="text-muted">
                                            <i class="fas fa-tag text-primary me-1"></i>
                                            <span style="color: #000;">{{ $item->merk ?? '-' }}</span>
                                        </div>
                                        <div class="text-muted">
                                            <i class="fas fa-layer-group text-info me-1"></i>
                                            <span style="color: #000;">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                                        </div>
                                        <div class="text-muted">
                                            <i class="fas fa-door-open text-success me-1"></i>
                                            <span style="color: #000;">{{ $item->ruangan->nama_ruangan ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
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
/* Responsive improvements */
@media (max-width: 576px) {
    .fs-4 { font-size: 1.1rem !important; }
    .card-body { padding: 0.75rem; }
    h4.fs-5 { font-size: 1rem !important; }
    .small { font-size: 0.8rem; }
}

@media (min-width: 768px) {
    .fa-md-2x { font-size: 2rem !important; }
}

/* Improve mobile button spacing */
.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

@media (max-width: 576px) {
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection