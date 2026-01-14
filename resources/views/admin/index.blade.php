@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-3 mb-md-4 gap-2">
        <div>
            <h2 class="mb-1 fs-4 fs-md-3">
                <i class="fas fa-user-shield text-primary"></i> Kelola Admin
            </h2>
            <p class="text-muted mb-0 small">Tambah, edit, atau hapus akun admin</p>
        </div>
        <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Admin
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

    <!-- Error Alert -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div>{{ session('error') }}</div>
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
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Total Admin</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger me-3">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Super Admin</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->where('role', 'superadmin')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-secondary bg-opacity-10 text-secondary me-3">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Admin</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->where('role', 'admin')->count() }}</h3>
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
                    <i class="fas fa-list"></i> Daftar Admin
                </h5>
                <span class="badge bg-primary">{{ $users->count() }} Admin</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 text-dark fw-semibold" style="width: 60px;">No</th>
                            <th class="py-3 text-dark fw-semibold">Nama</th>
                            <th class="py-3 text-dark fw-semibold">Email</th>
                            <th class="py-3 text-dark fw-semibold" style="width: 120px;">Role</th>
                            <th class="py-3 text-dark fw-semibold" style="width: 140px;">Terdaftar</th>
                            <th class="py-3 text-dark fw-semibold" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr id="row-{{ $user->id }}">
                            <td class="align-middle text-dark">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle {{ $user->role == 'superadmin' ? 'bg-danger' : 'bg-secondary' }} bg-opacity-10 me-2">
                                        <i class="fas fa-user {{ $user->role == 'superadmin' ? 'text-danger' : 'text-secondary' }}"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                        @if($user->id == auth()->id())
                                            <span class="badge bg-primary ms-2">Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td class="align-middle">
                                @if($user->role == 'superadmin')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-crown"></i> Super Admin
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-user-tie"></i> Admin
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.edit', $user->id) }}" 
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id != auth()->id())
                                    <button type="button" 
                                            class="btn btn-danger"
                                            onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}', '{{ $user->role }}')"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-secondary" disabled title="Tidak dapat menghapus akun sendiri">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">Belum ada data admin</p>
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
        @forelse($users as $index => $user)
        <div class="card shadow-sm mb-3 border-0 {{ $user->id == auth()->id() ? 'border-start border-primary border-3' : '' }}" id="card-{{ $user->id }}">
            <div class="card-body p-3">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="avatar-circle {{ $user->role == 'superadmin' ? 'bg-danger' : 'bg-secondary' }} bg-opacity-10 me-2">
                            <i class="fas fa-user {{ $user->role == 'superadmin' ? 'text-danger' : 'text-secondary' }}"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Admin #{{ $index + 1 }}</div>
                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                        </div>
                    </div>
                    @if($user->role == 'superadmin')
                        <span class="badge bg-danger">
                            <i class="fas fa-crown"></i> Super
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            Admin
                        </span>
                    @endif
                </div>

                <!-- Info Grid -->
                <div class="row g-2 small mb-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-envelope me-2"></i>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-calendar me-2"></i>
                            <span>Terdaftar {{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    @if($user->id == auth()->id())
                    <div class="col-12">
                        <span class="badge bg-primary">
                            <i class="fas fa-user-check"></i> Akun Anda
                        </span>
                    </div>
                    @endif
                </div>

                <hr class="my-2">

                <!-- Action Buttons -->
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.edit', $user->id) }}" 
                       class="btn btn-warning btn-sm flex-fill">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @if($user->id != auth()->id())
                    <button type="button" 
                            class="btn btn-danger btn-sm"
                            onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}', '{{ $user->role }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                    @else
                    <button class="btn btn-secondary btn-sm" disabled title="Tidak dapat menghapus akun sendiri">
                        <i class="fas fa-ban"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-3">Belum ada data admin</p>
                <a href="{{ route('admin.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Admin
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

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
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

.btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-group .btn {
    transform: none;
}

.btn-group .btn:hover:not(:disabled) {
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

.alert-danger {
    border-left-color: #dc3545;
    background-color: #f8d7da;
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

/* Current User Highlight */
.border-start.border-primary {
    border-left-width: 4px !important;
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
    
    .avatar-circle {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
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

/* Disabled button */
.btn:disabled {
    opacity: 0.5;
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
function confirmDelete(id, nama, role) {
    let roleText = role === 'superadmin' ? 'Super Admin' : 'Admin';
    let warningHtml = '';
    
    if (role === 'superadmin') {
        warningHtml = `<div class="alert alert-warning mt-3 mb-0">
            <i class="fas fa-exclamation-triangle"></i>
            Anda akan menghapus <strong>Super Admin</strong>. 
            Pastikan ada Super Admin lain yang aktif!
        </div>`;
    }
    
    Swal.fire({
        title: 'Hapus Admin?',
        html: `Apakah Anda yakin ingin menghapus ${roleText} <strong>"${nama}"</strong>?
               <br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
               ${warningHtml}`,
        icon: role === 'superadmin' ? 'error' : 'warning',
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
                form.action = "{{ url('admin') }}/" + id;
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
    border-left: 4px solid #ffc107;
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
