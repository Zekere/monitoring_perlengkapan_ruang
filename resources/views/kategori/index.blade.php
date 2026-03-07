@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-3 mb-md-4 gap-2">
        <div>
            <h2 class="mb-1 fs-4 fs-md-3">
                <i class="fas fa-tags text-primary"></i> Daftar Kategori
            </h2>
            <p class="text-muted mb-0 small">Kelola kategori barang inventaris</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Total Kategori</h6>
                            <h3 class="mb-0 fw-bold">{{ $kategori->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Total Aset</h6>
                            <h3 class="mb-0 fw-bold">{{ $kategori->sum(function($k) { return $k->items->count(); }) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="card shadow-sm border-0 d-none d-lg-block">
        <div class="card-header bg-light border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fs-6">
                    <i class="fas fa-list"></i> Data Kategori
                </h5>
                <span class="badge bg-primary">{{ $kategori->count() }} Kategori</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 text-dark fw-semibold" style="width: 60px;">No</th>
                            <th class="py-3 text-dark fw-semibold">Nama Kategori</th>
                            <th class="py-3 text-dark fw-semibold">Deskripsi</th>
                            <th class="py-3 text-dark fw-semibold" style="width: 120px;">Jumlah Aset</th>
                            <th class="py-3 text-dark fw-semibold" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $index => $item)
                        <tr id="row-{{ $item->id_kategori }}">
                            <td class="align-middle text-dark">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <span class="fw-semibold text-dark">{{ $item->nama_kategori }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($item->deskripsi)
                                    <span class="text-muted small">{{ Str::limit($item->deskripsi, 60) }}</span>
                                @else
                                    <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-info bg-opacity-75">
                                    <i class="fas fa-box"></i> {{ $item->items->count() }} item
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kategori.edit', $item->id_kategori) }}" 
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger"
                                            onclick="confirmDelete({{ $item->id_kategori }}, '{{ $item->nama_kategori }}', {{ $item->items->count() }})"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">Belum ada data kategori</p>
                                <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Tambah Kategori Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="d-lg-none">
        @forelse($kategori as $index => $item)
        <div class="card shadow-sm mb-3 border-0" id="card-{{ $item->id_kategori }}">
            <div class="card-body p-3">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Kategori #{{ $index + 1 }}</div>
                            <h6 class="mb-0 fw-bold">{{ $item->nama_kategori }}</h6>
                        </div>
                    </div>
                    <span class="badge bg-info">
                        {{ $item->items->count() }} item
                    </span>
                </div>

                <!-- Deskripsi -->
                @if($item->deskripsi)
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="fas fa-align-left me-1"></i>
                        {{ Str::limit($item->deskripsi, 100) }}
                    </small>
                </div>
                @endif

                <hr class="my-2">

                <!-- Action Buttons -->
                <div class="d-flex gap-2">
                    <a href="{{ route('kategori.edit', $item->id_kategori) }}" 
                       class="btn btn-warning btn-sm flex-fill">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" 
                            class="btn btn-danger btn-sm"
                            onclick="confirmDelete({{ $item->id_kategori }}, '{{ $item->nama_kategori }}', {{ $item->items->count() }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-3">Belum ada data kategori</p>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Kategori Pertama
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
/* Icon Boxes */
.icon-box {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.icon-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

/* Card Styling */
.card {
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

@media (hover: hover) {
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
    }
}

/* Table Styling */
.table thead th {
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: all 0.2s;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Button Styling */
.btn {
    font-weight: 500;
    transition: all 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-group .btn {
    transform: none;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
}

/* Alert Styling */
.alert {
    border-radius: 0.5rem;
    border: none;
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #198754;
    background-color: #d1e7dd;
}

/* Badge Styling */
.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Empty State */
.fa-inbox {
    opacity: 0.3;
}

/* Mobile Optimizations */
@media (max-width: 576px) {
    .fs-4 {
        font-size: 1.15rem !important;
    }
    
    .fs-6 {
        font-size: 0.95rem !important;
    }
    
    h3 {
        font-size: 1.5rem;
    }
    
    h6 {
        font-size: 0.9rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
    }
    
    .icon-box {
        width: 45px;
        height: 45px;
        font-size: 1.2rem;
    }
    
    .icon-circle {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.6rem;
    }
}

/* Tablet Optimizations */
@media (min-width: 577px) and (max-width: 991px) {
    .table {
        font-size: 0.9rem;
    }
}

/* Touch-friendly */
@media (max-width: 991px) {
    .btn {
        min-height: 38px;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.95);
    }
}

.fade-out {
    animation: fadeOut 0.5s forwards;
}

/* Loading State */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}
</style>

<script>
// Delete confirmation function
function confirmDelete(id, nama, itemCount) {
    let warningText = '';
    let warningIcon = 'warning';
    
    if (itemCount > 0) {
        warningText = `<div class="alert alert-warning mt-3 mb-0">
            <i class="fas fa-exclamation-triangle"></i>
            Kategori ini memiliki <strong>${itemCount} barang</strong> terkait.
            Hapus kategori akan mempengaruhi data barang tersebut.
        </div>`;
        warningIcon = 'error';
    }
    
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Apakah Anda yakin ingin menghapus kategori <strong>"${nama}"</strong>?${warningText}`,
        icon: warningIcon,
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Add fade out animation
            const row = document.getElementById('row-' + id);
            const card = document.getElementById('card-' + id);
            
            if (row) row.classList.add('fade-out');
            if (card) card.classList.add('fade-out');
            
            // Submit form after animation
            setTimeout(() => {
                const form = document.getElementById('deleteForm');
                form.action = "{{ url('kategori') }}/" + id;
                form.submit();
            }, 500);
        }
    });
}

// Auto-dismiss alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection

@section('styles')
<style>
/* SweetAlert2 Custom Styling */
.swal2-popup {
    border-radius: 1rem;
    font-family: inherit;
}

.swal2-title {
    font-size: 1.5rem;
    font-weight: 700;
}

.swal2-html-container {
    font-size: 1rem;
}

.swal2-html-container .alert {
    text-align: left;
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-size: 0.9rem;
}

.swal2-actions {
    gap: 0.5rem;
}

.swal2-actions .btn {
    padding: 0.5rem 1.5rem;
    font-size: 0.95rem;
}

/* Mobile SweetAlert */
@media (max-width: 576px) {
    .swal2-popup {
        width: 90%;
        padding: 1.5rem;
    }
    
    .swal2-title {
        font-size: 1.25rem;
    }
    
    .swal2-html-container {
        font-size: 0.9rem;
    }
    
    .swal2-html-container .alert {
        font-size: 0.85rem;
        padding: 0.5rem;
    }
    
    .swal2-actions .btn {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
}
</style>
@endsection
