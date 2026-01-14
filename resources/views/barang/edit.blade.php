@extends('layouts.template')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Update Barang</h4>
        <ul class="breadcrumbs">
           
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Update Barang</h4>
                </div>
                <form action="{{ route('barang.update', $item->id_item) }}" method="POST" enctype="multipart/form-data" id="formBarang">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Kode Barang -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('kode_barang') is-invalid @enderror" 
                                           id="kode_barang" 
                                           name="kode_barang" 
                                           value="{{ old('kode_barang', $item->kode_barang) }}" 
                                           required>
                                    @error('kode_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nama Barang -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_item">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_item') is-invalid @enderror" 
                                           id="nama_item" 
                                           name="nama_item" 
                                           value="{{ old('nama_item', $item->nama_item) }}" 
                                           required>
                                    @error('nama_item')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Merk -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="merk">Merk</label>
                                    <input type="text" 
                                           class="form-control @error('merk') is-invalid @enderror" 
                                           id="merk" 
                                           name="merk" 
                                           value="{{ old('merk', $item->merk) }}">
                                    @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('id_kategori') is-invalid @enderror" 
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
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Ruangan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_ruangan">Lokasi/Ruangan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('id_ruangan') is-invalid @enderror" 
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
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kondisi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kondisi">Kondisi <span class="text-danger">*</span></label>
                                    <select class="form-control @error('kondisi') is-invalid @enderror" 
                                            id="kondisi" 
                                            name="kondisi" 
                                            required>
                                        <option value="">-- Pilih Kondisi --</option>
                                        <option value="Baik" {{ old('kondisi', $item->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak Ringan" {{ old('kondisi', $item->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                        <option value="Rusak Berat" {{ old('kondisi', $item->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                    </select>
                                    @error('kondisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto - UPDATED WITH CAMERA -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="foto">Foto Barang</label>
                                    
                                    <!-- Button Group -->
                                    <div class="btn-group mb-3" role="group">
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('foto').click()">
                                            <i class="fa fa-upload"></i> Upload Foto
                                        </button>
                                        <button type="button" class="btn btn-info" onclick="openCamera()">
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
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG (Max: 2MB) - Kosongkan jika tidak ingin mengubah foto</small>
                                    
                                    <!-- Current Image -->
                                    @if($item->foto)
                                    <div class="mt-3" id="currentPhoto">
                                        <label>Foto Saat Ini:</label><br>
                                        <img src="{{ asset('storage/' . $item->foto) }}" 
                                             alt="Current Photo" 
                                             class="img-thumbnail" 
                                             style="max-width: 300px;">
                                    </div>
                                    @endif

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <label>Preview Foto Baru:</label><br>
                                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                        <br>
                                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearPhoto()">
                                            <i class="fa fa-trash"></i> Hapus Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Update
                        </button>
                        <a href="{{ route('barang.index') }}" class="btn btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kamera -->
<div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="cameraModalLabel">
                    <i class="fa fa-camera"></i> Ambil Foto
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <!-- Video Stream -->
                <video id="video" width="100%" height="auto" autoplay style="max-width: 640px; border: 2px solid #ddd; border-radius: 8px;"></video>
                
                <!-- Canvas untuk capture (hidden) -->
                <canvas id="canvas" style="display: none;"></canvas>
                
                <!-- Preview hasil capture -->
                <div id="capturedImageContainer" style="display: none;">
                    <img id="capturedImage" src="" alt="Captured" style="max-width: 100%; border: 2px solid #28a745; border-radius: 8px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
                <button type="button" class="btn btn-success" id="captureBtn" onclick="capturePhoto()">
                    <i class="fa fa-camera"></i> Ambil Foto
                </button>
                <button type="button" class="btn btn-primary" id="retakeBtn" onclick="retakePhoto()" style="display: none;">
                    <i class="fa fa-redo"></i> Foto Ulang
                </button>
                <button type="button" class="btn btn-info" id="usePhotoBtn" onclick="usePhoto()" style="display: none;">
                    <i class="fa fa-check"></i> Gunakan Foto Ini
                </button>
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
    $('#cameraModal').modal('show');
    
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
        $('#cameraModal').modal('hide');
        
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
$('#cameraModal').on('hidden.bs.modal', function () {
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
/* Style untuk button group */
.btn-group {
    display: flex;
    gap: 10px;
}

/* Style untuk modal */
#cameraModal .modal-dialog {
    max-width: 800px;
}

#video, #capturedImage {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    #cameraModal .modal-dialog {
        max-width: 95%;
        margin: 10px auto;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        width: 100%;
    }
}
</style>
@endpush
@endsection