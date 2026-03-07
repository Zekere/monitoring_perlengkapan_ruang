@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
        <div>
            <h2 class="mb-1 fs-5 fs-md-4">🏢 Daftar Lokasi dan Ruangan</h2>
            <p class="text-muted mb-0 small">Kelola semua loaksi dan ruangan yang ada</p>
        </div>
        <a href="{{ route('ruangan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah lokasi dan ruangan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Info Total -->
    <div class="mb-3">
        <p class="text-muted mb-0 small">
            <i class="fas fa-info-circle"></i> 
            Menampilkan <strong>{{ $ruangan->count() }}</strong> Lokasi dan Ruangan
        </p>
    </div>

    <!-- Desktop Table View -->
    <div class="card shadow-sm d-none d-md-block">
        <div class="card-body p-2 p-md-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="small" width="80">NO</th>
                            <th class="small">NAMA LOKASI DAN RUANGAN</th>
                            <th class="small text-center" width="120">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangan as $index => $ruang)
                        <tr>
                            <td class="small" style="color: #000;">{{ $index + 1 }}</td>
                            <td style="color: #000;">{{ $ruang->nama_ruangan }}</td>
                            <td class="text-center">
                                <a href="{{ route('ruangan.edit', $ruang->id_ruangan) }}" 
                                   class="btn btn-sm btn-warning"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('ruangan.destroy', $ruang->id_ruangan) }}" 
                                      method="POST" 
                                      class="d-inline delete-form" 
                                      onsubmit="return confirmDelete(this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0 small">Tidak ada data lokasi dan ruangan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse($ruangan as $index => $ruang)
            <div class="card mb-2 shadow-sm border">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-primary me-2" style="font-size: 0.7rem;">
                                    #{{ $index + 1 }}
                                </span>
                                <h6 class="mb-0 small fw-bold">{{ $ruang->nama_ruangan }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-1">
                        <a href="{{ route('ruangan.edit', $ruang->id_ruangan) }}" 
                           class="btn btn-warning btn-sm flex-fill">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('ruangan.destroy', $ruang->id_ruangan) }}" 
                              method="POST" 
                              class="flex-fill delete-form" 
                              onsubmit="return confirmDelete(this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                <p class="text-muted mb-0 small">Tidak ada data ruangan</p>
                <a href="{{ route('ruangan.create') }}" class="btn btn-primary btn-sm mt-3">
                    <i class="fas fa-plus"></i> Tambah lokasi dan ruangan Pertama
                </a>
            </div>
        @endforelse
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Fungsi untuk konfirmasi hapus menggunakan SweetAlert2
function confirmDelete(form) {
    Swal.fire({
        title: 'Yakin ingin menghapus ruangan ini?',
        text: "Data ini akan dihapus permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Hapus',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });

    return false;
}
</script>
@endsection

@section('styles')
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
    
    h6.small {
        font-size: 0.9rem !important;
    }
}

/* Badge styling */
.badge {
    padding: 0.35em 0.65em;
    font-size: 0.75rem;
}

@media (max-width: 576px) {
    .badge {
        font-size: 0.7rem;
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

/* Button group */
.gap-1 {
    gap: 0.25rem;
}

/* Flex utilities */
.flex-fill {
    flex: 1 1 auto;
}

/* Table styling */
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

/* Alert styling */
@media (max-width: 576px) {
    .alert {
        font-size: 0.85rem;
        padding: 0.75rem;
    }
}

/* Empty state */
.fa-inbox {
    opacity: 0.5;
}

/* Animation */
@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

.fade-out {
    animation: fadeOut 0.5s forwards;
}

/* Button icon spacing */
.btn i {
    margin-right: 0.25rem;
}

@media (max-width: 576px) {
    .btn i {
        margin-right: 0.15rem;
    }
}
</style>
@endsection