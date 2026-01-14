@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
        <div>
            <h4 class="mb-1 fs-5 fs-md-4">Detail Pengaduan Kerusakan</h4>
            <p class="text-muted mb-0 small">Informasi lengkap pengaduan #{{ $pengaduan->id_pengaduan }}</p>
        </div>
        <div>
            <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-2 g-md-3">
        <!-- Informasi Pengaduan -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm mb-2 mb-md-4">
                <div class="card-header bg-white border-0 p-2 p-md-3">
                    <h5 class="mb-0 fs-6 fs-md-5">
                        <i class="bi bi-file-text me-2"></i>Informasi Pengaduan
                    </h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Tanggal Pengaduan:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="small">{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Nama Pelapor:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="small">{{ $pengaduan->nama_pelapor }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Email Pelapor:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="small">{{ $pengaduan->email_pelapor ?: '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Status:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="badge bg-{{ $pengaduan->status_badge }} px-2 px-md-3 py-1 py-md-2">
                                {{ $pengaduan->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Tingkat Kerusakan:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="badge bg-{{ $pengaduan->tingkat_badge }} px-2 px-md-3 py-1 py-md-2">
                                {{ $pengaduan->tingkat_kerusakan }}
                            </span>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12">
                            <strong class="d-block mb-2 small">Deskripsi Kerusakan:</strong>
                            <div class="p-2 p-md-3 bg-light rounded">
                                <p class="mb-0 small">{{ $pengaduan->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($pengaduan->foto)
                    <div class="row">
                        <div class="col-12">
                            <strong class="d-block mb-2 small">Foto Kerusakan:</strong>
                            <div class="text-center">
                                <img src="{{ asset($pengaduan->foto) }}" 
                                    alt="Foto Kerusakan" 
                                    class="img-fluid rounded border"
                                    style="max-height: 300px; max-width: 100%; cursor: pointer;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#fotoModal">
                                <p class="small text-muted mt-2 mb-0">
                                    <i class="bi bi-zoom-in"></i> Klik untuk memperbesar
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Barang -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-2 p-md-3">
                    <h5 class="mb-0 fs-6 fs-md-5">
                        <i class="bi bi-box-seam me-2"></i>Informasi Barang
                    </h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Kode Barang:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <code class="small">{{ $pengaduan->item->kode_barang }}</code>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Nama Barang:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="small">{{ $pengaduan->item->nama_item }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Merk:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="small">{{ $pengaduan->item->merk ?: '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Kategori:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="badge bg-info small">{{ $pengaduan->item->kategori->nama_kategori ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 col-md-4">
                            <strong class="small">Ruangan:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="small">{{ $pengaduan->item->ruangan->nama_ruangan ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <strong class="small">Kondisi Barang Saat Ini:</strong>
                        </div>
                        <div class="col-12 col-md-8">
                            <span class="badge 
                                @if($pengaduan->item->kondisi == 'Baik') bg-success
                                @elseif($pengaduan->item->kondisi == 'Rusak Ringan') bg-warning
                                @else bg-danger
                                @endif
                                px-2 px-md-3 py-1 py-md-2 small">
                                {{ $pengaduan->item->kondisi }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status & Timeline -->
        <div class="col-12 col-lg-4">
            <!-- Update Status -->
            <div class="card border-0 shadow-sm mb-2 mb-md-4">
                <div class="card-header bg-white border-0 p-2 p-md-3">
                    <h5 class="mb-0 fs-6 fs-md-5">
                        <i class="bi bi-pencil-square me-2"></i>Update Status
                    </h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <form action="{{ route('pengaduan.updateStatus', $pengaduan->id_pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Status Pengaduan</label>
                            <select name="status" class="form-select form-select-sm" id="statusSelect" required>
                                <option value="Menunggu" {{ $pengaduan->status == 'Menunggu' ? 'selected' : '' }}>
                                    Menunggu
                                </option>
                                <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="update_kondisi" id="updateKondisi" value="1">
                                <label class="form-check-label small" for="updateKondisi">
                                    Update kondisi barang
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3" id="kondisiBarangDiv" style="display: none;">
                            <label class="form-label small fw-bold">Kondisi Barang</label>
                            <select name="kondisi_barang" class="form-select form-select-sm">
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-2 p-md-3">
                    <h5 class="mb-0 fs-6 fs-md-5">
                        <i class="bi bi-clock-history me-2"></i>Timeline
                    </h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div class="timeline-item d-flex mb-3">
                        <div class="timeline-badge bg-primary rounded-circle p-2 me-2 me-md-3 flex-shrink-0" style="width: 36px; height: 36px;">
                            <i class="bi bi-file-earmark-plus text-white" style="font-size: 1rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                {{ $pengaduan->created_at->format('d M Y, H:i') }}
                            </small>
                            <p class="mb-0 small"><strong>Pengaduan dibuat</strong></p>
                        </div>
                    </div>
                    
                    @if($pengaduan->updated_at != $pengaduan->created_at)
                    <div class="timeline-item d-flex">
                        <div class="timeline-badge bg-info rounded-circle p-2 me-2 me-md-3 flex-shrink-0" style="width: 36px; height: 36px;">
                            <i class="bi bi-arrow-repeat text-white" style="font-size: 1rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                {{ $pengaduan->updated_at->format('d M Y, H:i') }}
                            </small>
                            <p class="mb-0 small">
                                <strong>Status diupdate:</strong> {{ $pengaduan->status }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk zoom foto -->
@if($pengaduan->foto)
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-6">Foto Kerusakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img src="{{ asset($pengaduan->foto) }}" 
                    alt="Foto Kerusakan" 
                    class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@endif

<style>
/* Responsive improvements */
@media (max-width: 576px) {
    .fs-5 { font-size: 0.95rem !important; }
    .fs-6 { font-size: 0.85rem !important; }
    .small { font-size: 0.8rem !important; }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.85rem;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.25em 0.5em;
    }
    
    code {
        font-size: 0.75rem;
    }
}

/* Row spacing in detail view */
.row.mb-2 {
    margin-bottom: 0.5rem;
}

@media (max-width: 767px) {
    .row.mb-2 .col-12:first-child {
        margin-bottom: 0.25rem;
    }
}

/* Timeline styling */
.timeline-badge {
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 576px) {
    .timeline-badge {
        width: 32px !important;
        height: 32px !important;
        padding: 0.25rem !important;
    }
    
    .timeline-badge i {
        font-size: 0.875rem !important;
    }
}

/* Image responsive */
.img-fluid {
    max-width: 100%;
    height: auto;
}

/* Modal responsive */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
}

/* Form control responsive */
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

/* Badge responsive */
.badge {
    display: inline-block;
    padding: 0.35em 0.65em;
    font-size: 0.75rem;
}

@media (max-width: 576px) {
    .badge {
        font-size: 0.7rem;
        padding: 0.25em 0.5em;
    }
}

/* Alert responsive */
@media (max-width: 576px) {
    .alert {
        font-size: 0.85rem;
        padding: 0.75rem;
    }
}

/* Gap utilities */
.gap-2 {
    gap: 0.5rem;
}

/* Button group */
@media (max-width: 576px) {
    .d-grid button {
        padding: 0.5rem;
        font-size: 0.85rem;
    }
}

/* HR responsive */
hr {
    margin: 1rem 0;
}

@media (max-width: 576px) {
    hr {
        margin: 0.75rem 0;
    }
}

/* Text truncate for long content */
@media (max-width: 576px) {
    .text-muted {
        font-size: 0.8rem;
    }
}
</style>

@endsection

@push('scripts')
<script>
    // Toggle kondisi barang field
    document.getElementById('updateKondisi').addEventListener('change', function() {
        document.getElementById('kondisiBarangDiv').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush