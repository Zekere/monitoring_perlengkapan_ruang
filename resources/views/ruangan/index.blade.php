@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">🏢 Daftar Ruangan</h2>
            <p class="text-muted">Kelola semua ruangan yang ada</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter dan Tombol Tambah Ruangan -->
    <div class="row mb-4">
        <div class="col-md-3 text-end">
            <a href="{{ route('ruangan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Ruangan
            </a>
        </div>
    </div>

    <!-- Tabel Ruangan -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="color: #000;">NO</th>
                            <th style="color: #000;">NAMA RUANGAN</th>
                            <th style="color: #000;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangan as $index => $ruang)
                        <tr>
                            <td style="color: #000;">{{ $ruangan->firstItem() + $index }}</td> <!-- Menampilkan nomor urut dengan pagination -->
                            <td style="color: #000;">{{ $ruang->nama_ruangan }}</td> <!-- Menampilkan nama ruangan -->
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('ruangan.edit', $ruang->id_ruangan) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Form Hapus -->
                                <form action="{{ route('ruangan.destroy', $ruang->id_ruangan) }}" method="POST" class="d-inline delete-form" onsubmit="return confirmDelete(this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($ruangan->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $ruangan->firstItem() }} - {{ $ruangan->lastItem() }} dari {{ $ruangan->total() }} data
                </div>
                <div>
                    {{ $ruangan->links() }} <!-- Menampilkan link pagination -->
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Fungsi untuk menambahkan animasi dan konfirmasi menggunakan SweetAlert2
function confirmDelete(form) {
    // Menggunakan SweetAlert2 untuk konfirmasi penghapusan
    Swal.fire({
        title: 'Yakin ingin menghapus ruangan ini?',
        text: "Data ini akan dihapus permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika tombol Hapus ditekan, kirim form untuk menghapus
            form.submit();
        }
    });

    return false; // Mencegah form dikirim langsung
}
</script>
@endsection

@section('styles')
<style>
/* Animasi untuk tombol hapus (opsional) */
.fade-out {
    animation: fadeOut 0.5s forwards;
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}
</style>
@endsection
