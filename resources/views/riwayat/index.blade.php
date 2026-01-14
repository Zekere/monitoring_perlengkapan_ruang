@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white p-2 p-md-3">
                    <h3 class="card-title mb-0 fs-5 fs-md-4">
                        <i class="fas fa-history"></i> Riwayat Pengecekan Barang
                    </h3>
                </div>
                
                <div class="card-body p-2 p-md-3">
                    <!-- Filter Section -->
                    <form method="GET" action="{{ route('riwayat.index') }}" class="mb-3 mb-md-4">
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small fw-bold">Filter Barang</label>
                                <select name="id_item" class="form-select form-select-sm">
                                    <option value="">Semua Barang</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id_item }}" 
                                            {{ request('id_item') == $item->id_item ? 'selected' : '' }}>
                                            {{ $item->kode_barang }} - {{ $item->nama_item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-6 col-md-3 col-lg-2">
                                <label class="form-label small fw-bold">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control form-control-sm" 
                                    value="{{ request('start_date') }}">
                            </div>
                            
                            <div class="col-6 col-md-3 col-lg-2">
                                <label class="form-label small fw-bold">Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" 
                                    value="{{ request('end_date') }}">
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small fw-bold">Jenis Perubahan</label>
                                <select name="jenis_perubahan" class="form-select form-select-sm">
                                    <option value="">Semua Jenis</option>
                                    <option value="Kondisi" {{ request('jenis_perubahan') == 'Kondisi' ? 'selected' : '' }}>
                                        Kondisi
                                    </option>
                                    <option value="Ruangan" {{ request('jenis_perubahan') == 'Ruangan' ? 'selected' : '' }}>
                                        Ruangan
                                    </option>
                                    <option value="Semua" {{ request('jenis_perubahan') == 'Semua' ? 'selected' : '' }}>
                                        Semua Perubahan
                                    </option>
                                    <option value="Data" {{ request('jenis_perubahan') == 'Data' ? 'selected' : '' }}>
                                        Data Barang
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 col-lg-2">
                                <label class="form-label small fw-bold d-none d-lg-block">&nbsp;</label>
                                <div class="d-grid d-lg-flex gap-1">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('riwayat.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="{{ route('riwayat.export.pdf', request()->all()) }}" 
                                   class="btn btn-danger btn-sm" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th class="small" width="5%">No</th>
                                    <th class="small" width="12%">Tanggal & Waktu</th>
                                    <th class="small" width="12%">Kode Barang</th>
                                    <th class="small" width="15%">Nama Barang</th>
                                    <th class="small" width="10%">Jenis</th>
                                    <th class="small">Perubahan</th>
                                    <th class="small" width="12%">Diupdate Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $index => $r)
                                <tr>
                                    <td class="small">{{ $riwayat->firstItem() + $index }}</td>
                                    <td>
                                        <small>
                                            <strong>{{ $r->created_at->format('d/m/Y') }}</strong><br>
                                            {{ $r->created_at->format('H:i:s') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('riwayat.show', $r->id_item) }}" 
                                           class="text-primary">
                                            <strong class="small">{{ $r->kode_barang }}</strong>
                                        </a>
                                    </td>
                                    <td class="small">{{ $r->nama_item }}</td>
                                    <td>
                                        @if($r->jenis_perubahan == 'Kondisi')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-tools"></i> Kondisi
                                            </span>
                                        @elseif($r->jenis_perubahan == 'Ruangan')
                                            <span class="badge bg-info">
                                                <i class="fas fa-door-open"></i> Ruangan
                                            </span>
                                        @elseif($r->jenis_perubahan == 'Semua')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-sync"></i> Semua
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-edit"></i> Data
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            @if($r->kondisi_lama !== $r->kondisi_baru)
                                                <div class="mb-1">
                                                    <strong>Kondisi:</strong>
                                                    <span class="badge bg-light text-dark">{{ $r->kondisi_lama ?? 'Baru' }}</span>
                                                    <i class="fas fa-arrow-right"></i>
                                                    <span class="badge 
                                                        @if($r->kondisi_baru == 'Baik') bg-success
                                                        @elseif($r->kondisi_baru == 'Rusak Ringan') bg-warning text-dark
                                                        @else bg-danger
                                                        @endif">
                                                        {{ $r->kondisi_baru }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                                <div>
                                                    <strong>Ruangan:</strong>
                                                    <span class="badge bg-light text-dark">
                                                        {{ $r->ruanganLama->nama_ruangan ?? 'Tidak ada' }}
                                                    </span>
                                                    <i class="fas fa-arrow-right"></i>
                                                    <span class="badge bg-info">
                                                        {{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada' }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($r->keterangan)
                                                <div class="mt-2 text-muted">
                                                    <i class="fas fa-info-circle"></i> {{ $r->keterangan }}
                                                </div>
                                            @endif
                                        </small>
                                    </td>
                                    <td class="small">{{ $r->updated_by }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="small">Tidak ada riwayat ditemukan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile/Tablet Card View -->
                    <div class="d-lg-none">
                        @forelse($riwayat as $index => $r)
                            <div class="card mb-2 shadow-sm border">
                                <div class="card-body p-2">
                                    <!-- Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <a href="{{ route('riwayat.show', $r->id_item) }}" 
                                               class="text-primary text-decoration-none">
                                                <h6 class="mb-0 small fw-bold">{{ $r->kode_barang }}</h6>
                                            </a>
                                            <small class="text-muted">{{ $r->nama_item }}</small>
                                        </div>
                                        <div class="text-end">
                                            @if($r->jenis_perubahan == 'Kondisi')
                                                <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">
                                                    <i class="fas fa-tools"></i> Kondisi
                                                </span>
                                            @elseif($r->jenis_perubahan == 'Ruangan')
                                                <span class="badge bg-info" style="font-size: 0.7rem;">
                                                    <i class="fas fa-door-open"></i> Ruangan
                                                </span>
                                            @elseif($r->jenis_perubahan == 'Semua')
                                                <span class="badge bg-danger" style="font-size: 0.7rem;">
                                                    <i class="fas fa-sync"></i> Semua
                                                </span>
                                            @else
                                                <span class="badge bg-secondary" style="font-size: 0.7rem;">
                                                    <i class="fas fa-edit"></i> Data
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Timestamp -->
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> 
                                            {{ $r->created_at->format('d/m/Y H:i:s') }}
                                        </small>
                                    </div>

                                    <!-- Changes -->
                                    <div class="mb-2">
                                        @if($r->kondisi_lama !== $r->kondisi_baru)
                                            <div class="mb-1">
                                                <strong class="small">Kondisi:</strong>
                                                <div class="d-flex align-items-center gap-1 mt-1">
                                                    <span class="badge bg-light text-dark" style="font-size: 0.7rem;">
                                                        {{ $r->kondisi_lama ?? 'Baru' }}
                                                    </span>
                                                    <i class="fas fa-arrow-right small"></i>
                                                    <span class="badge 
                                                        @if($r->kondisi_baru == 'Baik') bg-success
                                                        @elseif($r->kondisi_baru == 'Rusak Ringan') bg-warning text-dark
                                                        @else bg-danger
                                                        @endif" style="font-size: 0.7rem;">
                                                        {{ $r->kondisi_baru }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                            <div class="mb-1">
                                                <strong class="small">Ruangan:</strong>
                                                <div class="d-flex align-items-center gap-1 mt-1">
                                                    <span class="badge bg-light text-dark" style="font-size: 0.7rem;">
                                                        {{ $r->ruanganLama->nama_ruangan ?? 'Tidak ada' }}
                                                    </span>
                                                    <i class="fas fa-arrow-right small"></i>
                                                    <span class="badge bg-info" style="font-size: 0.7rem;">
                                                        {{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Footer -->
                                    <div class="border-top pt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> {{ $r->updated_by }}
                                        </small>
                                    </div>

                                    @if($r->keterangan)
                                        <div class="mt-2 p-2 bg-light rounded">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> {{ $r->keterangan }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted small">Tidak ada riwayat ditemukan</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($riwayat->hasPages())
                    <div class="mt-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                            <div class="text-muted small">
                                Menampilkan {{ $riwayat->firstItem() }} - {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} data
                            </div>
                            <div>
                                {{ $riwayat->appends(request()->all())->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Responsive improvements */
@media (max-width: 576px) {
    .fs-5 { font-size: 0.95rem !important; }
    .small { font-size: 0.8rem !important; }
    
    .card-body {
        padding: 0.75rem !important;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.85rem;
    }
}

/* Badge styling */
.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

@media (max-width: 576px) {
    .badge {
        font-size: 0.7rem;
        padding: 0.25em 0.5em;
    }
}

/* Form controls */
.form-select-sm, .form-control-sm {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
}

@media (max-width: 576px) {
    .form-select-sm, .form-control-sm {
        font-size: 0.8rem;
        padding: 0.375rem 0.5rem;
    }
}

/* Card mobile styling */
.d-lg-none .card {
    border-radius: 0.5rem;
    transition: transform 0.2s;
}

.d-lg-none .card:hover {
    transform: translateY(-2px);
}

/* Gap utility */
.gap-1 {
    gap: 0.25rem;
}

/* Table responsive text */
.table small {
    font-size: 0.85em;
}

@media (max-width: 576px) {
    .table small {
        font-size: 0.8em;
    }
}

/* Icon alignment */
.fas {
    vertical-align: middle;
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

/* Timeline arrow */
.fa-arrow-right {
    font-size: 0.7rem;
    opacity: 0.7;
}

/* Border top for footer */
.border-top {
    border-top: 1px solid #dee2e6 !important;
}
</style>
@endpush