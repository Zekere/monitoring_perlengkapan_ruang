@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
        <div>
            <h4 class="mb-1 fs-5 fs-md-4">Pengaduan Kerusakan Inventaris</h4>
            <p class="text-muted mb-0 small">Kelola dan pantau pengaduan kerusakan barang</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-clock-history text-warning fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Menunggu</p>
                            <h3 class="mb-0 fs-5 fs-md-3">{{ $stats['menunggu'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-gear text-info fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Diproses</p>
                            <h3 class="mb-0 fs-5 fs-md-3">{{ $stats['diproses'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-check-circle text-success fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Selesai</p>
                            <h3 class="mb-0 fs-5 fs-md-3">{{ $stats['selesai'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-2 p-md-3 rounded">
                                <i class="bi bi-file-text text-primary fs-5 fs-md-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-md-3">
                            <p class="text-muted mb-1 small">Total</p>
                            <h3 class="mb-0 fs-5 fs-md-3">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Tabel -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-2 p-md-3">
                    <h5 class="mb-0 fs-6 fs-md-5">Daftar Pengaduan</h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <!-- Filter -->
                    <form method="GET" action="{{ route('pengaduan.index') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-12 col-md-4">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label small fw-bold">Tingkat Kerusakan</label>
                                <select name="tingkat" class="form-select form-select-sm">
                                    <option value="">Semua Tingkat</option>
                                    <option value="Ringan" {{ request('tingkat') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="Sedang" {{ request('tingkat') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="Berat" {{ request('tingkat') == 'Berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label small fw-bold d-none d-md-block">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary btn-sm flex-fill">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="small" width="50">No</th>
                                    <th class="small">Tanggal</th>
                                    <th class="small">Pelapor</th>
                                    <th class="small">Barang</th>
                                    <th class="small">Tingkat</th>
                                    <th class="small">Status</th>
                                    <th class="small" width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengaduan as $item)
                                <tr>
                                    <td class="small">{{ $loop->iteration + ($pengaduan->currentPage() - 1) * $pengaduan->perPage() }}</td>
                                    <td class="small">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong class="small">{{ $item->nama_pelapor }}</strong><br>
                                        <small class="text-muted">{{ $item->email_pelapor ?: '-' }}</small>
                                    </td>
                                    <td>
                                        <strong class="small">{{ $item->item->nama_item }}</strong><br>
                                        <small class="text-muted">{{ $item->item->kode_barang }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->tingkat_badge }} small">
                                            {{ $item->tingkat_kerusakan }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->status_badge }} small">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pengaduan.show', $item->id_pengaduan) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <p class="text-muted mb-0 small">Tidak ada data pengaduan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        @forelse($pengaduan as $item)
                            <div class="card mb-2 shadow-sm border">
                                <div class="card-body p-2">
                                    <!-- Header Card -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0 small fw-bold">{{ $item->nama_pelapor }}</h6>
                                            <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-{{ $item->status_badge }}" style="font-size: 0.7rem;">
                                                {{ $item->status }}
                                            </span>
                                            <span class="badge bg-{{ $item->tingkat_badge }}" style="font-size: 0.7rem;">
                                                {{ $item->tingkat_kerusakan }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-2">
                                        <div class="small mb-1">
                                            <i class="bi bi-box text-primary me-1"></i>
                                            <strong>{{ $item->item->nama_item }}</strong>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="bi bi-tag me-1"></i>
                                            {{ $item->item->kode_barang }}
                                        </div>
                                        @if($item->email_pelapor)
                                        <div class="small text-muted">
                                            <i class="bi bi-envelope me-1"></i>
                                            {{ $item->email_pelapor }}
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Action Button -->
                                    <div class="d-grid">
                                        <a href="{{ route('pengaduan.show', $item->id_pengaduan) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-0 small">Tidak ada data pengaduan</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($pengaduan->hasPages())
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center flex-column flex-md-row gap-2">
                            <div class="text-muted small">
                                Menampilkan {{ $pengaduan->firstItem() }} - {{ $pengaduan->lastItem() }} dari {{ $pengaduan->total() }} data
                            </div>
                            <div>
                                {{ $pengaduan->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Responsive improvements */
@media (max-width: 576px) {
    .fs-5 { font-size: 0.95rem !important; }
    .fs-6 { font-size: 0.85rem !important; }
    .small { font-size: 0.8rem; }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    h3.fs-5 {
        font-size: 1rem !important;
    }
}

/* Badge responsive */
.badge {
    padding: 0.35em 0.65em;
    font-size: 0.75rem;
}

@media (max-width: 576px) {
    .badge {
        font-size: 0.65rem;
        padding: 0.25em 0.5em;
    }
}

/* Card mobile styling */
.d-md-none .card {
    border-radius: 0.5rem;
    transition: transform 0.2s;
}

.d-md-none .card:hover {
    transform: translateY(-2px);
}

/* Button group responsive */
.d-flex.gap-2 {
    gap: 0.5rem;
}

/* Form select responsive */
.form-select-sm {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
}

@media (max-width: 576px) {
    .form-select-sm {
        font-size: 0.8rem;
        padding: 0.375rem 0.5rem;
    }
}

/* Pagination responsive */
@media (max-width: 576px) {
    .pagination {
        font-size: 0.85rem;
    }
    
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
    }
}

/* Icon spacing */
.bi {
    vertical-align: middle;
}

/* Flex utilities */
@media (max-width: 767px) {
    .flex-fill {
        flex: 1 1 auto;
    }
}
</style>
@endsection