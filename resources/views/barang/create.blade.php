@extends('layouts.template')

@section('content')
<div class="page-inner">
    <!-- Modern Breadcrumb -->
    <div class="page-header mb-4">
        <h3 class="fw-bold mb-3">✨ Tambah Barang Baru</h3>
        <ul class="breadcrumbs mb-0">
            <li class="nav-item active">
                Tambah Barang
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="card-title mb-0">📝 Form Tambah Barang</div>
                    </div>
                </div>
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" id="formBarang">
                    @csrf
                    <div class="card-body">
                        <!-- Alert Errors -->
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle mr-2"></i>Terdapat kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                        @endif

                        <!-- Section 1: Informasi Dasar -->
                        <div class="form-section mb-4">
                            <h5 class="mb-3 pb-2 border-bottom">
                                <i class="fas fa-info-circle text-primary mr-2"></i>Informasi Dasar
                            </h5>
                            <div class="row">
                                <!-- Kode Barang -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('kode_barang') has-error @enderror">
                                        <label>Kode Barang <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="kode_barang" 
                                               value="{{ old('kode_barang', 'TIK-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}" 
                                               required>
                                        @error('kode_barang')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <small class="text-muted ml-3">
                                        <i class="fas fa-lightbulb mr-1"></i>Kode unik untuk identifikasi barang
                                    </small>
                                </div>

                                <!-- Nama Barang -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('nama_item') has-error @enderror">
                                        <label>Nama Barang <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="nama_item" 
                                               value="{{ old('nama_item') }}" 
                                               placeholder="Contoh: Laptop ASUS ROG"
                                               required>
                                        @error('nama_item')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Merk -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Merk/Brand</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="merk" 
                                               value="{{ old('merk') }}"
                                               placeholder="Contoh: ASUS, HP, Logitech">
                                    </div>
                                </div>

                                <!-- Kategori -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('id_kategori') has-error @enderror">
                                        <label>Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control" name="id_kategori" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategori as $kat)
                                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                                {{ $kat->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('id_kategori')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Lokasi & Kondisi -->
                        <div class="form-section mb-4">
                            <h5 class="mb-3 pb-2 border-bottom">
                                <i class="fas fa-map-marker-alt text-success mr-2"></i>Lokasi & Kondisi
                            </h5>
                            <div class="row">
                                <!-- Ruangan -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('id_ruangan') has-error @enderror">
                                        <label>Lokasi/Ruangan <span class="text-danger">*</span></label>
                                        <select class="form-control" name="id_ruangan" required>
                                            <option value="">-- Pilih Ruangan --</option>
                                            @foreach($ruangan as $ruang)
                                            <option value="{{ $ruang->id_ruangan }}" {{ old('id_ruangan') == $ruang->id_ruangan ? 'selected' : '' }}>
                                                {{ $ruang->nama_ruangan }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('id_ruangan')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kondisi -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('kondisi') has-error @enderror">
                                        <label>Kondisi Barang <span class="text-danger">*</span></label>
                                        <select class="form-control" name="kondisi" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>
                                                ✅ Baik
                                            </option>
                                            <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>
                                                ⚠️ Rusak Ringan
                                            </option>
                                            <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>
                                                ❌ Rusak Berat
                                            </option>
                                        </select>
                                        @error('kondisi')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Upload Foto -->
                        <div class="form-section">
                            <h5 class="mb-3 pb-2 border-bottom">
                                <i class="fas fa-camera text-info mr-2"></i>Foto Barang
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="btn-group d-flex mb-2" role="group">
                                            <label class="btn btn-outline-primary btn-sm flex-fill">
                                                <i class="fa fa-upload mr-1"></i> Upload File
                                                <input type="file" 
                                                       id="fileInput"
                                                       name="foto" 
                                                       accept="image/*"
                                                       onchange="previewImage(event)"
                                                       style="display: none;">
                                            </label>
                                            <button type="button" 
                                                    class="btn btn-outline-success btn-sm flex-fill"
                                                    onclick="openWebcam()">
                                                <i class="fa fa-camera mr-1"></i> Buka Webcam
                                            </button>
                                        </div>
                                        @error('foto')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                        <div class="text-muted small">
                                            <i class="fas fa-info-circle mr-1"></i>Format: JPG, JPEG, PNG (Max: 2MB)
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Webcam Container -->
                                    <div id="webcamContainer" style="display: none;">
                                        <div class="card">
                                            <div class="card-body text-center p-2">
                                                <p class="mb-2 font-weight-bold">Webcam:</p>
                                                <video id="webcam" 
                                                       autoplay 
                                                       playsinline
                                                       class="img-thumbnail"
                                                       style="max-width: 100%; max-height: 250px;">
                                                </video>
                                                <div class="mt-2">
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm"
                                                            onclick="capturePhoto()">
                                                        <i class="fa fa-camera mr-1"></i> Ambil Foto
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm"
                                                            onclick="closeWebcam()">
                                                        <i class="fa fa-times mr-1"></i> Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" style="display: none;">
                                        <div class="card">
                                            <div class="card-body text-center p-2">
                                                <p class="mb-2 font-weight-bold">Preview Foto:</p>
                                                <img id="preview" 
                                                     src="" 
                                                     alt="Preview" 
                                                     class="img-thumbnail shadow-sm"
                                                     style="max-width: 250px; max-height: 250px; object-fit: cover;">
                                                <div class="mt-2">
                                                    <button type="button" 
                                                            class="btn btn-warning btn-sm"
                                                            onclick="removePhoto()">
                                                        <i class="fa fa-trash mr-1"></i> Hapus Foto
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden canvas for capturing -->
                                    <canvas id="canvas" style="display: none;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-round">
                                <i class="fa fa-save mr-1"></i> Simpan Barang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.form-section {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 10px;
}
.form-group-default {
    background: #fff;
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 10px 15px;
    transition: all 0.3s;
}
.form-group-default:hover {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
}
.form-group-default.has-error {
    border-color: #dc3545;
}
.form-group-default label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #8898aa;
    font-weight: 600;
    margin-bottom: 5px;
}
.form-group-default input,
.form-group-default select {
    border: none;
    padding: 0;
    height: auto;
    font-size: 14px;
    font-weight: 500;
}
.form-group-default input:focus,
.form-group-default select:focus {
    outline: none;
    box-shadow: none;
}
#webcam {
    transform: scaleX(-1);
}
</style>
@endpush

@push('scripts')
<script>
let stream = null;
let capturedBlob = null;

// Preview image from file input
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('preview').src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('webcamContainer').style.display = 'none';
        };
        reader.readAsDataURL(file);
        capturedBlob = null;
    }
}

// Open webcam
async function openWebcam() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: { 
                width: { ideal: 1280 },
                height: { ideal: 720 }
            } 
        });
        
        const video = document.getElementById('webcam');
        video.srcObject = stream;
        
        document.getElementById('webcamContainer').style.display = 'block';
        document.getElementById('imagePreview').style.display = 'none';
    } catch (err) {
        alert('Tidak dapat mengakses webcam. Pastikan Anda memberikan izin akses kamera.');
        console.error('Error accessing webcam:', err);
    }
}

// Close webcam
function closeWebcam() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    document.getElementById('webcamContainer').style.display = 'none';
}

// Capture photo from webcam
function capturePhoto() {
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    const ctx = canvas.getContext('2d');
    // Flip horizontally to match what user sees
    ctx.translate(canvas.width, 0);
    ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0);
    
    // Convert canvas to blob
    canvas.toBlob(function(blob) {
        capturedBlob = blob;
        
        // Show preview
        const url = URL.createObjectURL(blob);
        preview.src = url;
        
        // Create a new File object from the blob
        const file = new File([blob], 'webcam-photo.jpg', { type: 'image/jpeg' });
        
        // Create a DataTransfer to set the file input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById('fileInput').files = dataTransfer.files;
        
        // Show preview and hide webcam
        document.getElementById('imagePreview').style.display = 'block';
        closeWebcam();
    }, 'image/jpeg', 0.9);
}

// Remove photo
function removePhoto() {
    document.getElementById('preview').src = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('fileInput').value = '';
    capturedBlob = null;
}

// Form validation enhancement
$(document).ready(function() {
    $('#formBarang').on('submit', function() {
        // Close webcam if still open
        closeWebcam();
        
        $(this).find('button[type="submit"]').prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');
    });
});

// Clean up webcam on page unload
window.addEventListener('beforeunload', function() {
    closeWebcam();
});
</script>
@endpush
@endsection