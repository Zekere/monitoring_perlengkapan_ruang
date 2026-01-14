@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <div class="page-header mb-3 mb-md-4">
        <h4 class="page-title fs-5 fs-md-4 mb-1">Update Barang</h4>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white p-2 p-md-3">
                    <h4 class="card-title fs-6 fs-md-5 mb-0">Form Update Barang</h4>
                </div>
                <form action="{{ route('barang.update', $item->id_item) }}" method="POST" enctype="multipart/form-data" id="formBarang">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-2 p-md-3">
                        <div class="row g-2 g-md-3">
                            <!-- Kode Barang -->
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kode_barang" class="form-label small fw-bold">
                                        Kode Barang <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-sm @error('kode_barang') is-invalid @enderror" 
                                           id="kode_barang" 
                                           name="kode_barang" 
                                           value="{{ old('kode_barang', $item->kode_barang) }}" 
                                           required>
                                    @error('kode_barang')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nama Barang -->
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_item" class="form-label small fw-bold">
                                        Nama Barang <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-sm @error('nama_item') is-invalid @enderror" 
                                           id="nama_item" 
                                           name="nama_item" 
                                           value="{{ old('nama_item', $item->nama_item) }}" 
                                           required>
                                    @error('nama_item')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Merk -->
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="merk" class="form-label small fw-bold">Merk</label>
                                    <input type="text" 
                                           class="form-control form-control-sm @error('merk') is-invalid @enderror" 
                                           id="merk" 
                                           name="merk" 
                                           value="{{ old('merk', $item->merk) }}">
                                    @error('merk')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_kategori" class="form-label small fw-bold">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-sm @error('id_kategori') is-invalid @enderror" 
                                            id="id_kategori" 
                                            name="id_kategori" 
                                            required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategori as $kat)
                                        <option value="{{ $kat->id_kategori }}" 
                                            {{ old('id_kategori', $item->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Ruangan -->
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_ruangan" class="form-label small fw-bold">
                                        Lokasi/Ruangan <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-sm @error('id_ruangan') is-invalid @enderror" 
                                            id="id_ruangan" 
                                            name="id_ruangan" 
                                            required>
                                        <option value="">-- Pilih Ruangan --</option>
                                        @foreach($ruangan as $ruang)
                                        <option value="{{ $ruang->id_ruangan }}" 
                                            {{ old('id_ruangan', $item->id_ruangan) == $ruang->id_ruangan ? 'selected' : '' }}>
                                            {{ $ruang->nama_ruangan }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('id_ruangan')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kondisi -->
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kondisi" class="form-label small fw-bold">
                                        Kondisi <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-sm @error('kondisi') is-invalid @enderror" 
                                            id="kondisi" 
                                            name="kondisi" 
                                            required>
                                        <option value="">-- Pilih Kondisi --</option>
                                        <option value="Baik" {{ old('kondisi', $item->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak Ringan" {{ old('kondisi', $item->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                        <option value="Rusak Berat" {{ old('kondisi', $item->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                    </select>
                                    @error('kondisi')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="foto" class="form-label small fw-bold">Foto Barang</label>
                                    
                                    <!-- Button Group -->
                                    <div class="d-grid d-sm-flex gap-2 mb-3">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('foto').click()">
                                            <i class="fa fa-upload"></i> Upload Foto
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm" onclick="openCamera()">
                                            <i class="fa fa-camera"></i> Ambil dari Kamera
                                        </button>
                                    </div>

                                    <!-- Hidden File Input -->
                                    <input type="file" 
                                           class="form-control-file d-none @error('foto') is-invalid @enderror" 
                                           id="foto" 
                                           name="foto" 
                                           accept="image/*"
                                           onchange="previewImage(event)">

                                    <!-- Hidden input untuk menyimpan foto dari kamera -->
                                    <input type="hidden" id="camera_photo" name="camera_photo">

                                    @error('foto')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG (Max: 2MB) - Kosongkan jika tidak ingin mengubah foto</small>
                                    
                                    <!-- Current Image -->
                                    @if($item->foto)
                                    <div class="mt-3" id="currentPhoto">
                                        <label class="small fw-bold">Foto Saat Ini:</label><br>
                                        <img src="{{ asset('storage/' . $item->foto) }}" 
                                             alt="Current Photo" 
                                             class="img-thumbnail" 
                                             style="max-width: 100%; width: 300px; height: auto;">
                                    </div>
                                    @endif

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <label class="small fw-bold">Preview Foto Baru:</label><br>
                                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; width: 300px; height: auto;">
                                        <br>
                                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearPhoto()">
                                            <i class="fa fa-trash"></i> Hapus Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white p-2 p-md-3">
                        <div class="d-grid d-sm-flex gap-2">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('barang.index') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kamera -->
<div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fs-6" id="cameraModalLabel">
                    <i class="fa fa-camera"></i> Ambil Foto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-2 p-md-3">
                <!-- Video Stream -->
                <video id="video" width="100%" height="auto" autoplay class="rounded"></video>
                
                <!-- Canvas untuk capture (hidden) -->
                <canvas id="canvas" style="display: none;"></canvas>
                
                <!-- Preview hasil capture -->
                <div id="capturedImageContainer" style="display: none;">
                    <img id="capturedImage" src="" alt="Captured" class="img-fluid rounded border border-success border-2">
                </div>
            </div>
            <div class="modal-footer p-2 p-md-3">
                <div class="d-grid d-sm-flex gap-2 w-100">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="captureBtn" onclick="capturePhoto()">
                        <i class="fa fa-camera"></i> Ambil Foto
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="retakeBtn" onclick="retakePhoto()" style="display: none;">
                        <i class="fa fa-redo"></i> Foto Ulang
                    </button>
                    <button type="button" class="btn btn-info btn-sm" id="usePhotoBtn" onclick="usePhoto()" style="display: none;">
                        <i class="fa fa-check"></i> Gunakan Foto
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let videoStream = null;
let capturedPhotoData = null;

// Preview image dari file upload
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('camera_photo').value = '';
        };
        reader.readAsDataURL(file);
    }
}

// Buka kamera
function openCamera() {
    const modal = new bootstrap.Modal(document.getElementById('cameraModal'));
    modal.show();
    
    const video = document.getElementById('video');
    
    // Request akses kamera
    navigator.mediaDevices.getUserMedia({ 
        video: { 
            facingMode: 'environment', // Gunakan kamera belakang di mobile
            width: { ideal: 1280 },
            height: { ideal: 720 }
        } 
    })
    .then(function(stream) {
        videoStream = stream;
        video.srcObject = stream;
        video.play();
        
        // Reset buttons
        document.getElementById('captureBtn').style.display = 'inline-block';
        document.getElementById('retakeBtn').style.display = 'none';
        document.getElementById('usePhotoBtn').style.display = 'none';
        document.getElementById('video').style.display = 'block';
        document.getElementById('capturedImageContainer').style.display = 'none';
    })
    .catch(function(err) {
        console.error("Error accessing camera: ", err);
        alert('Tidak dapat mengakses kamera. Pastikan browser memiliki izin kamera.');
    });
}

// Capture foto dari video stream
function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const capturedImage = document.getElementById('capturedImage');
    
    // Set canvas size sesuai video
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // Draw video frame ke canvas
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    
    // Convert canvas to base64
    capturedPhotoData = canvas.toDataURL('image/jpeg', 0.9);
    
    // Tampilkan preview
    capturedImage.src = capturedPhotoData;
    document.getElementById('video').style.display = 'none';
    document.getElementById('capturedImageContainer').style.display = 'block';
    
    // Update buttons
    document.getElementById('captureBtn').style.display = 'none';
    document.getElementById('retakeBtn').style.display = 'inline-block';
    document.getElementById('usePhotoBtn').style.display = 'inline-block';
}

// Foto ulang
function retakePhoto() {
    capturedPhotoData = null;
    document.getElementById('video').style.display = 'block';
    document.getElementById('capturedImageContainer').style.display = 'none';
    
    // Update buttons
    document.getElementById('captureBtn').style.display = 'inline-block';
    document.getElementById('retakeBtn').style.display = 'none';
    document.getElementById('usePhotoBtn').style.display = 'none';
}

// Gunakan foto yang sudah di-capture
function usePhoto() {
    if (capturedPhotoData) {
        // Set preview di form
        document.getElementById('preview').src = capturedPhotoData;
        document.getElementById('imagePreview').style.display = 'block';
        
        // Simpan data foto ke hidden input
        document.getElementById('camera_photo').value = capturedPhotoData;
        
        // Clear file input
        document.getElementById('foto').value = '';
        
        // Stop camera dan tutup modal
        stopCamera();
        const modal = bootstrap.Modal.getInstance(document.getElementById('cameraModal'));
        modal.hide();
        
        // Notifikasi
        alert('Foto berhasil diambil!');
    }
}

// Stop camera stream
function stopCamera() {
    if (videoStream) {
        videoStream.getTracks().forEach(track => track.stop());
        videoStream = null;
    }
}

// Clear/hapus foto
function clearPhoto() {
    document.getElementById('preview').src = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('foto').value = '';
    document.getElementById('camera_photo').value = '';
    capturedPhotoData = null;
}

// Stop camera saat modal ditutup
document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function () {
    stopCamera();
});

// Tambahkan handler untuk submit form dengan camera photo
document.getElementById('formBarang').addEventListener('submit', function(e) {
    const cameraPhoto = document.getElementById('camera_photo').value;
    const fileInput = document.getElementById('foto');
    
    // Jika ada foto dari kamera dan tidak ada file upload
    if (cameraPhoto && !fileInput.files.length) {
        // Convert base64 to blob
        fetch(cameraPhoto)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], "camera-photo.jpg", { type: "image/jpeg" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
            });
    }
});
</script>

<style>
/* Responsive Form */
@media (max-width: 576px) {
    .page-title {
        font-size: 1.1rem !important;
    }
    
    .card-title {
        font-size: 1rem !important;
    }
    
    .form-label {
        font-size: 0.85rem !important;
    }
    
    .form-control-sm, .form-select-sm {
        font-size: 0.85rem;
        padding: 0.375rem 0.5rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.85rem;
    }
}

/* Modal Responsive */
#cameraModal .modal-dialog {
    max-width: 95%;
    margin: 0.5rem auto;
}

@media (min-width: 576px) {
    #cameraModal .modal-dialog {
        max-width: 540px;
    }
}

@media (min-width: 768px) {
    #cameraModal .modal-dialog {
        max-width: 720px;
    }
}

@media (min-width: 992px) {
    #cameraModal .modal-dialog {
        max-width: 800px;
    }
}

/* Video & Image Responsive */
#video, #capturedImage {
    max-width: 100%;
    height: auto;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Button Group Responsive */
.d-grid button {
    width: 100%;
}

@media (min-width: 576px) {
    .d-sm-flex button {
        width: auto;
    }
}

/* Image Preview Responsive */
.img-thumbnail {
    max-width: 100%;
    height: auto;
    object-fit: cover;
}

/* Card Responsive */
.card {
    border-radius: 0.5rem;
}

.card-header {
    border-bottom: 1px solid #dee2e6;
}

.card-footer {
    border-top: 1px solid #dee2e6;
}

/* Gap utilities untuk button */
.gap-2 {
    gap: 0.5rem;
}

/* Modal Button Responsive */
@media (max-width: 576px) {
    .modal-footer .d-grid button {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .modal-footer .d-grid button:last-child {
        margin-bottom: 0;
    }
}
</style>
@endpush
@endsection