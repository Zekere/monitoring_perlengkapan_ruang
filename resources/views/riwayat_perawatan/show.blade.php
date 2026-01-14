@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 mb-md-4 gap-2">
        <h2 class="mb-0 fs-4 fs-md-3">Detail Riwayat Perawatan</h2>
        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
            <a href="{{ route('riwayat-perawatan.edit', $riwayat->id_perawatan) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        <!-- Informasi Barang - Tampil Pertama di Mobile -->
        <div class="col-12 col-lg-4 order-2 order-lg-2">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fs-6">
                        <i class="fas fa-box"></i> Informasi Barang
                    </h5>
                </div>
                <div class="card-body p-3">
                    @if($riwayat->item->foto)
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/' . $riwayat->item->foto) }}" 
                                 alt="{{ $riwayat->item->nama_item }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 200px; object-fit: cover;">
                        </div>
                    @else
                        <div class="text-center mb-3 bg-light rounded p-4">
                            <i class="fas fa-image fa-3x text-muted"></i>
                            <p class="text-muted small mb-0 mt-2">Tidak ada foto</p>
                        </div>
                    @endif

                    <div class="info-item">
                        <div class="info-label">Kode Barang</div>
                        <div class="info-value">{{ $riwayat->item->kode_barang }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Nama Barang</div>
                        <div class="info-value">{{ $riwayat->item->nama_item }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Merk</div>
                        <div class="info-value">{{ $riwayat->item->merk }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Kategori</div>
                        <div class="info-value">{{ $riwayat->item->kategori->nama_kategori ?? '-' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Ruangan</div>
                        <div class="info-value">{{ $riwayat->item->ruangan->nama_ruangan ?? '-' }}</div>
                    </div>

                    <div class="info-item mb-0">
                        <div class="info-label">Kondisi Saat Ini</div>
                        <div class="info-value">
                            @if($riwayat->item->kondisi == 'Baik')
                                <span class="badge bg-success">Baik</span>
                            @elseif($riwayat->item->kondisi == 'Rusak Ringan')
                                <span class="badge bg-warning text-dark">Rusak Ringan</span>
                            @else
                                <span class="badge bg-danger">Rusak Berat</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Perawatan -->
        <div class="col-12 col-lg-8 order-1 order-lg-1">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fs-6">
                        <i class="fas fa-tools"></i> Informasi Perawatan
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <!-- Info Grid -->
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="info-box">
                                <div class="info-box-label">
                                    <i class="fas fa-calendar text-primary"></i> Tanggal Perawatan
                                </div>
                                <div class="info-box-value">
                                    {{ $riwayat->tanggal_perawatan->format('d F Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="info-box">
                                <div class="info-box-label">
                                    <i class="fas fa-cogs text-info"></i> Jenis Perawatan
                                </div>
                                <div class="info-box-value">
                                    <span class="badge bg-info">{{ $riwayat->jenis_perawatan }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="info-box">
                                <div class="info-box-label">
                                    <i class="fas fa-user-tie text-secondary"></i> Teknisi
                                </div>
                                <div class="info-box-value">
                                    {{ $riwayat->teknisi }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="info-box">
                                <div class="info-box-label">
                                    <i class="fas fa-money-bill-wave text-success"></i> Biaya
                                </div>
                                <div class="info-box-value text-success fw-bold">
                                    {{ $riwayat->formatted_biaya }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-box">
                                <div class="info-box-label">
                                    <i class="fas fa-flag text-warning"></i> Status
                                </div>
                                <div class="info-box-value">
                                    @if($riwayat->status == 'Selesai')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </span>
                                    @elseif($riwayat->status == 'Dalam Proses')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-spinner"></i> Dalam Proses
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-pause-circle"></i> Ditunda
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <div class="section-title">
                            <i class="fas fa-file-alt"></i> Deskripsi Perawatan
                        </div>
                        <div class="section-content">
                            {{ $riwayat->deskripsi }}
                        </div>
                    </div>

                    @if($riwayat->catatan)
                        <div class="mb-3">
                            <div class="section-title">
                                <i class="fas fa-sticky-note"></i> Catatan Tambahan
                            </div>
                            <div class="section-content">
                                {{ $riwayat->catatan }}
                            </div>
                        </div>
                    @endif

                    <hr class="my-3">

                    <!-- Timestamp Info -->
                    <div class="row g-2 small">
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-calendar-plus me-2"></i>
                                <div>
                                    <div class="fw-semibold">Dibuat</div>
                                    <div>{{ $riwayat->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-calendar-check me-2"></i>
                                <div>
                                    <div class="fw-semibold">Diperbarui</div>
                                    <div>{{ $riwayat->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Mobile Only -->
            <div class="d-lg-none mt-3">
                <div class="d-grid gap-2">
                    <a href="{{ route('riwayat-perawatan.edit', $riwayat->id_perawatan) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Data Perawatan
                    </a>
                    <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Info Item Styles */
.info-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 0.95rem;
    color: #212529;
    font-weight: 500;
}

/* Info Box Styles */
.info-box {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1rem;
    height: 100%;
    border-left: 3px solid #0d6efd;
    transition: all 0.3s;
}

.info-box:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.info-box-label {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-box-value {
    font-size: 1rem;
    color: #212529;
    font-weight: 600;
}

/* Section Styles */
.section-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #495057;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-content {
    font-size: 0.95rem;
    color: #6c757d;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    line-height: 1.6;
    border-left: 3px solid #dee2e6;
}

/* Badge Improvements */
.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Card Improvements */
.card {
    border: none;
    transition: transform 0.3s, box-shadow 0.3s;
}

@media (hover: hover) {
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
    }
}

.card-header {
    border-bottom: 2px solid rgba(255,255,255,0.2);
}

/* Image Styles */
img {
    transition: transform 0.3s;
}

@media (hover: hover) {
    img:hover {
        transform: scale(1.05);
    }
}

/* Mobile Optimizations */
@media (max-width: 576px) {
    .fs-4 {
        font-size: 1.15rem !important;
    }
    
    .fs-6 {
        font-size: 0.95rem !important;
    }
    
    .btn-sm {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }
    
    .info-box {
        padding: 0.75rem;
    }
    
    .info-box-label {
        font-size: 0.75rem;
    }
    
    .info-box-value {
        font-size: 0.9rem;
    }
    
    .section-title {
        font-size: 0.9rem;
    }
    
    .section-content {
        font-size: 0.85rem;
        padding: 0.75rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.6rem;
    }
}

/* Tablet Optimizations */
@media (min-width: 577px) and (max-width: 991px) {
    .info-box {
        padding: 0.85rem;
    }
    
    .card-body {
        padding: 1.25rem !important;
    }
}

/* Touch-friendly */
@media (max-width: 991px) {
    .btn {
        min-height: 42px;
    }
}

/* Print Styles */
@media print {
    .btn, .card-header {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Loading States */
.info-box-value:empty::after {
    content: '-';
    color: #adb5bd;
}
</style>
@endsection