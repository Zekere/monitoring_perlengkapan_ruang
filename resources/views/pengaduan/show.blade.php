@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Detail Pengaduan</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ url('/dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('pengaduan.index') }}">Pengaduan</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Detail</a>
            </li>
        </ul>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Main Info -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Informasi Pengaduan</h4>
                        <span class="badge badge-{{ $pengaduan->status_badge }} badge-lg">
                            {{ $pengaduan->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Info Pelapor -->
                    <div class="mb-4">
                        <h5 class="mb-3">👤 Informasi Pelapor</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Pelapor</label>
                                    <p class="mb-0 fw-bold">{{ $pengaduan->nama_pelapor }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Email</label>
                                    <p class="mb-0">{{ $pengaduan->email_pelapor ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Tanggal Laporan</label>
                                    <p class="mb-0">{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Info Barang -->
                    <div class="mb-4">
                        <h5 class="mb-3">📦 Informasi Barang</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Kode Barang</label>
                                    <p class="mb-0 fw-bold">{{ $pengaduan->item->kode_barang ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Barang</label>
                                    <p class="mb-0">{{ $pengaduan->item->nama_item ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Merk</label>
                                    <p class="mb-0">{{ $pengaduan->item->merk ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Kategori</label>
                                    <p class="mb-0">{{ $pengaduan->item->kategori->nama_kategori ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Ruangan</label>
                                    <p class="mb-0">{{ $pengaduan->item->ruangan->nama_ruangan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Info Kerusakan -->
                    <div class="mb-4">
                        <h5 class="mb-3">🔧 Informasi Kerusakan</h5>
                        <div class="mb-3">
                            <label class="text-muted small">Tingkat Kerusakan</label>
                            <div>
                                <span class="badge badge-{{ $pengaduan->tingkat_kerusakan_badge }} badge-lg">
                                    {{ $pengaduan->tingkat_kerusakan }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Deskripsi Kerusakan</label>
                            <p class="mb-0" style="white-space: pre-line;">{{ $pengaduan->deskripsi }}</p>
                        </div>
                    </div>

                    <!-- Foto Kerusakan -->
                    @if($pengaduan->foto_kerusakan)
                    <div class="mb-4">
                        <h5 class="mb-3">📷 Foto Kerusakan</h5>
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $pengaduan->foto_kerusakan) }}" 
                                 alt="Foto Kerusakan" 
                                 class="img-fluid rounded"
                                 style="max-height: 400px; cursor: pointer;"
                                 onclick="showImageModal(this.src)">
                            <p class="text-muted small mt-2">Klik gambar untuk memperbesar</p>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan Admin -->
                    @if($pengaduan->catatan_admin)
                    <hr>
                    <div class="mb-4">
                        <h5 class="mb-3">📝 Catatan Admin</h5>
                        <div class="alert alert-info">
                            <p class="mb-0" style="white-space: pre-line;">{{ $pengaduan->catatan_admin }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="col-md-4">
            <!-- Update Status -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tindakan</h4>
                </div>
                <div class="card-body">
                    <!-- Update Status Form -->
                    <form action="{{ route('pengaduan.updateStatus', $pengaduan->id_pengaduan) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Update Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Pending" {{ $pengaduan->status == 'Pending' ? 'selected' : '' }}>
                                    ⏳ Pending
                                </option>
                                <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>
                                    🔧 Diproses
                                </option>
                                <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>
                                    ✅ Selesai
                                </option>
                                <option value="Ditolak" {{ $pengaduan->status == 'Ditolak' ? 'selected' : '' }}>
                                    ❌ Ditolak
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>

                    <hr>

                    <!-- Add Note Form -->
                    <form action="{{ route('pengaduan.addNote', $pengaduan->id_pengaduan) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="catatan_admin" class="form-control" rows="4" placeholder="Tambahkan catatan...">{{ $pengaduan->catatan_admin }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-comment"></i> Simpan Catatan
                        </button>
                    </form>

                    <hr>

                    <!-- Other Actions -->
                    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary w-100 mb-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button onclick="confirmDelete({{ $pengaduan->id_pengaduan }})" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Hapus Pengaduan
                    </button>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Timeline</h4>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-badge bg-primary">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Pengaduan Dibuat</h6>
                                    <p class="text-muted small">
                                        {{ $pengaduan->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($pengaduan->tanggal_penanganan)
                        <div class="timeline-item">
                            <div class="timeline-badge bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Status: {{ $pengaduan->status }}</h6>
                                    <p class="text-muted small">
                                        {{ $pengaduan->tanggal_penanganan->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image Preview -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Kerusakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Preview">
            </div>
        </div>
    </div>
</div>

<!-- Form Delete Hidden -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    padding-bottom: 20px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: 10px;
    top: 30px;
    bottom: -20px;
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-badge {
    position: absolute;
    left: 0;
    top: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
}

.timeline-panel {
    padding: 0;
}

.timeline-title {
    font-size: 14px;
    margin-bottom: 5px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Pengaduan?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/pengaduan/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush