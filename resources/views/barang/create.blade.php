@extends('layouts.template')

@section('content')
<div class="page-inner">
    <div class="page-header mb-4">
        <h3 class="fw-bold mb-3">✨ Tambah Barang Baru</h3>
        <ul class="breadcrumbs mb-0">
            <li class="nav-item active">Tambah Barang</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="card-title mb-0">📝 Form Tambah Barang</div>
                </div>
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" id="formBarang">
                    @csrf
                    <div class="card-body">

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle mr-2"></i>Terdapat kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                        @endif

                        <!-- Informasi Dasar -->
                        <div class="form-section mb-4">
                            <h5 class="mb-3 pb-2 border-bottom">
                                <i class="fas fa-info-circle text-primary mr-2"></i>Informasi Dasar
                            </h5>
                            <div class="row">

                                <!-- Kode Barang -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('kode_barang') has-error @enderror">
                                        <label>Kode Barang <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="kode_barang"
                                               value="{{ old('kode_barang', 'PU-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}"
                                               required>
                                        @error('kode_barang')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>

                                <!-- Nama Barang -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('nama_item') has-error @enderror">
                                        <label>Nama Barang <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_item"
                                               value="{{ old('nama_item') }}" placeholder="Contoh: Laptop" required>
                                        @error('nama_item')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>

                                <!-- Merk -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Merk/Brand</label>
                                        <input type="text" class="form-control" name="merk"
                                               value="{{ old('merk') }}" placeholder="Contoh: ASUS, HP, Logitech">
                                    </div>
                                </div>

                                <!-- Harga Satuan -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('harga_satuan') has-error @enderror">
                                        <label>Nilai (Rp)</label>
                                        <input type="number" class="form-control" name="harga_satuan"
                                               value="{{ old('harga_satuan', 0) }}" min="0"
                                               placeholder="Contoh: 5000000">
                                        @error('harga_satuan')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <small class="text-muted ml-3">
                                        <i class="fas fa-info-circle mr-1"></i>Harga per satuan barang
                                    </small>
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
                                        @error('id_kategori')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12">
                                    <div class="form-group form-group-default @error('deskripsi') has-error @enderror">
                                        <label>Deskripsi Barang</label>
                                        <textarea class="form-control" name="deskripsi" rows="3"
                                                  placeholder="Contoh: Laptop untuk keperluan administrasi kantor, dilengkapi RAM 8GB dan SSD 256GB">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <small class="text-muted ml-3">
                                        <i class="fas fa-info-circle mr-1"></i>Opsional — tuliskan spesifikasi atau keterangan tambahan barang
                                    </small>
                                </div>

                            </div>
                        </div>

                        <!-- Lokasi & Kondisi -->
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
                                        @error('id_ruangan')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>

                                <!-- Kondisi -->
                                <div class="col-md-6">
                                    <div class="form-group form-group-default @error('kondisi') has-error @enderror">
                                        <label>Kondisi Barang <span class="text-danger">*</span></label>
                                        <select class="form-control" name="kondisi" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>✅ Baik</option>
                                            <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>⚠️ Rusak Ringan</option>
                                            <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>❌ Rusak Berat</option>
                                        </select>
                                        @error('kondisi')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Foto Barang -->
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
                                                <input type="file" id="fileInput" name="foto" accept="image/*"
                                                       onchange="previewImage(event)" style="display: none;">
                                            </label>
                                            <button type="button" class="btn btn-outline-success btn-sm flex-fill"
                                                    onclick="openWebcam()">
                                                <i class="fa fa-camera mr-1"></i> Buka Webcam
                                            </button>
                                        </div>
                                        @error('foto')<div class="text-danger small">{{ $message }}</div>@enderror
                                        <div class="text-muted small">
                                            <i class="fas fa-info-circle mr-1"></i>Format: JPG, JPEG, PNG (Max: 2MB)
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="webcamContainer" style="display: none;">
                                        <div class="card">
                                            <div class="card-body text-center p-2">
                                                <p class="mb-2 font-weight-bold">Webcam:</p>
                                                <video id="webcam" autoplay playsinline class="img-thumbnail"
                                                       style="max-width: 100%; max-height: 250px;"></video>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-success btn-sm" onclick="capturePhoto()">
                                                        <i class="fa fa-camera mr-1"></i> Ambil Foto
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="closeWebcam()">
                                                        <i class="fa fa-times mr-1"></i> Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="imagePreview" style="display: none;">
                                        <div class="card">
                                            <div class="card-body text-center p-2">
                                                <p class="mb-2 font-weight-bold">Preview Foto:</p>
                                                <img id="preview" src="" alt="Preview" class="img-thumbnail shadow-sm"
                                                     style="max-width: 250px; max-height: 250px; object-fit: cover;">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="removePhoto()">
                                                        <i class="fa fa-trash mr-1"></i> Hapus Foto
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.form-section { padding: 1.5rem; background: #f8f9fa; border-radius: 10px; }
.form-group-default { background: #fff; border: 1px solid #e3e6f0; border-radius: 8px; padding: 10px 15px; transition: all 0.3s; }
.form-group-default:hover { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102,126,234,.1); }
.form-group-default.has-error { border-color: #dc3545; }
.form-group-default label { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #8898aa; font-weight: 600; margin-bottom: 5px; }
.form-group-default input,
.form-group-default select,
.form-group-default textarea { border: none; padding: 0; height: auto; font-size: 14px; font-weight: 500; width: 100%; background: transparent; }
.form-group-default input:focus,
.form-group-default select:focus,
.form-group-default textarea:focus { outline: none; box-shadow: none; }
.form-group-default textarea { resize: vertical; min-height: 75px; }
#webcam { transform: scaleX(-1); }
</style>
@endpush

@push('scripts')
<script>
let stream = null;

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview').src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('webcamContainer').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

async function openWebcam() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        document.getElementById('webcam').srcObject = stream;
        document.getElementById('webcamContainer').style.display = 'block';
        document.getElementById('imagePreview').style.display = 'none';
    } catch (err) {
        alert('Tidak dapat mengakses webcam.');
    }
}

function closeWebcam() {
    if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
    document.getElementById('webcamContainer').style.display = 'none';
}

function capturePhoto() {
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.translate(canvas.width, 0); ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0);
    canvas.toBlob(function(blob) {
        const url = URL.createObjectURL(blob);
        document.getElementById('preview').src = url;
        const file = new File([blob], 'webcam-photo.jpg', { type: 'image/jpeg' });
        const dt = new DataTransfer(); dt.items.add(file);
        document.getElementById('fileInput').files = dt.files;
        document.getElementById('imagePreview').style.display = 'block';
        closeWebcam();
    }, 'image/jpeg', 0.9);
}

function removePhoto() {
    document.getElementById('preview').src = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('fileInput').value = '';
}

$(document).ready(function() {
    $('#formBarang').on('submit', function() {
        closeWebcam();
        $(this).find('button[type="submit"]').prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');
    });
});

window.addEventListener('beforeunload', closeWebcam);
</script>
@endpush
@endsection