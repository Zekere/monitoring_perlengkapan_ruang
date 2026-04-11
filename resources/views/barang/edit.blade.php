@extends('layouts.template')

@section('content')
<style>
  body { font-family: 'Times New Roman', Times, serif; background: #f7f8fc; }
  .pg-title { font-size: clamp(1.2rem,3vw,1.6rem); font-weight:700; color:#0f172a; margin:0 0 .2rem; }
  .pg-subtitle { font-size:.82rem; color:#94a3b8; margin:0; }
  .pg-card { background:#fff; border:1px solid #e8edf5; border-radius:18px; overflow:hidden; }
  .pg-card__head { padding:1rem 1.4rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:.65rem; }
  .pg-card__icon { width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:.85rem; flex-shrink:0; }
  .pg-card__title { font-size:.95rem; font-weight:700; color:#0f172a; margin:0; }
  .pg-card__body { padding:1.5rem; }
  .pg-card__footer { padding:1rem 1.4rem; border-top:1px solid #f1f5f9; background:#fafbfc; display:flex; gap:.625rem; flex-wrap:wrap; align-items:center; justify-content:space-between; }
  .pg-label { font-size:.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.07em; display:block; margin-bottom:.4rem; }
  .req { color:#ef4444; margin-left:.15rem; }
  .pg-input, .pg-select, .pg-textarea {
    font-family:'Times New Roman',Times,serif; font-size:.875rem; width:100%;
    padding:.55rem .9rem; border:1px solid #e2e8f0; border-radius:10px;
    background:#f8fafc; color:#334155; outline:none;
    transition:border-color .15s, box-shadow .15s;
  }
  .pg-input:focus, .pg-select:focus, .pg-textarea:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.1); background:#fff; }
  .pg-input.is-invalid, .pg-select.is-invalid, .pg-textarea.is-invalid { border-color:#ef4444; }
  .pg-textarea { resize:vertical; min-height:90px; }
  .invalid-msg { font-size:.75rem; color:#ef4444; margin-top:.3rem; }
  .field-hint { font-size:.73rem; color:#94a3b8; margin-top:.3rem; }
  .pg-btn { font-family:'Times New Roman',Times,serif; font-size:.84rem; font-weight:700; padding:.5rem 1.1rem; border-radius:9px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:.4rem; transition:all .15s; text-decoration:none; white-space:nowrap; }
  .pg-btn-save { background:#0f172a; color:#fff; }
  .pg-btn-save:hover { background:#1e293b; box-shadow:0 4px 14px rgba(15,23,42,.25); color:#fff; }
  .pg-btn-cancel { background:#fff; color:#64748b; border:1px solid #e2e8f0; }
  .pg-btn-cancel:hover { background:#f1f5f9; color:#334155; text-decoration:none; }
  .pg-btn-upload { background:#f8fafc; color:#334155; border:1px solid #e2e8f0; }
  .pg-btn-upload:hover { background:#0f172a; color:#fff; border-color:#0f172a; }
  .pg-btn-camera { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
  .pg-btn-camera:hover { background:#1d4ed8; color:#fff; border-color:#1d4ed8; }
  .pg-btn-del-photo { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }
  .pg-btn-del-photo:hover { background:#b91c1c; color:#fff; border-color:#b91c1c; }
  .btn-perawatan { font-family:'Times New Roman',Times,serif; font-size:.84rem; font-weight:700; padding:.55rem 1.25rem; border-radius:9px; background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:.45rem; transition:all .15s; box-shadow:0 2px 10px rgba(245,158,11,.35); text-decoration:none; }
  .btn-perawatan:hover { background:linear-gradient(135deg,#d97706,#b45309); box-shadow:0 5px 18px rgba(245,158,11,.45); color:#fff; transform:translateY(-1px); }
  .photo-zone { border:2px dashed #e2e8f0; border-radius:12px; padding:1.25rem; background:#fafbfc; }
  .photo-zone:hover { border-color:#6366f1; }
  .photo-btns { display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:.875rem; }
  .photo-thumb { border-radius:10px; border:1px solid #e8edf5; width:100%; max-width:260px; height:auto; display:block; }
  .photo-section-label { font-size:.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.07em; margin-bottom:.5rem; display:block; }
  .pg-sep { height:1px; background:#f1f5f9; margin:1.25rem 0; }
  @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
  .anim { animation:fadeUp .4s ease both; }
  .a1{animation-delay:.05s}
  @media(max-width:767px){
    .pg-card__body{padding:1.1rem;}
    .pg-card__footer{flex-direction:column;align-items:stretch;}
    .pg-card__footer .footer-actions, .pg-card__footer .footer-secondary{width:100%;}
    .pg-btn,.btn-perawatan{justify-content:center;width:100%;}
  }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

  <div class="mb-4 anim">
    <h1 class="pg-title">Update <span style="color:#6366f1">Barang</span></h1>
    <p class="pg-subtitle">Detail pengecekan & pembaruan data inventaris</p>
  </div>

  <div class="pg-card anim a1">
    <div class="pg-card__head">
      <div class="pg-card__icon" style="background:#f5f3ff;color:#6366f1">
        <i class="fa fa-edit"></i>
      </div>
      <h2 class="pg-card__title">Form Update Barang</h2>
    </div>

    <form action="{{ route('barang.update', $item->id_item) }}" method="POST"
          enctype="multipart/form-data" id="formBarang">
      @csrf
      @method('PUT')

      <div class="pg-card__body">
        <div class="row g-3">

          {{-- Kode Barang --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Kode Barang<span class="req">*</span></label>
            <input type="text" class="pg-input @error('kode_barang') is-invalid @enderror"
                   name="kode_barang" value="{{ old('kode_barang', $item->kode_barang) }}" required>
            @error('kode_barang')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Nama Barang --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Nama Barang<span class="req">*</span></label>
            <input type="text" class="pg-input @error('nama_item') is-invalid @enderror"
                   name="nama_item" value="{{ old('nama_item', $item->nama_item) }}" required>
            @error('nama_item')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Merk --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Merk</label>
            <input type="text" class="pg-input @error('merk') is-invalid @enderror"
                   name="merk" value="{{ old('merk', $item->merk) }}">
            @error('merk')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Harga Satuan --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Nilai (Rp)</label>
            <input type="number" class="pg-input @error('harga_satuan') is-invalid @enderror"
                   name="harga_satuan" value="{{ old('harga_satuan', $item->harga_satuan ?? 0) }}" min="0">
            @error('harga_satuan')<div class="invalid-msg">{{ $message }}</div>@enderror
            <p class="field-hint">Harga perolehan per satuan barang</p>
          </div>

          {{-- Kategori --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Kategori<span class="req">*</span></label>
            <select class="pg-select @error('id_kategori') is-invalid @enderror" name="id_kategori" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategori as $kat)
              <option value="{{ $kat->id_kategori }}"
                {{ old('id_kategori', $item->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                {{ $kat->nama_kategori }}
              </option>
              @endforeach
            </select>
            @error('id_kategori')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Ruangan --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Lokasi / Ruangan<span class="req">*</span></label>
            <select class="pg-select @error('id_ruangan') is-invalid @enderror" name="id_ruangan" required>
              <option value="">-- Pilih Ruangan --</option>
              @foreach($ruangan as $ruang)
              <option value="{{ $ruang->id_ruangan }}"
                {{ old('id_ruangan', $item->id_ruangan) == $ruang->id_ruangan ? 'selected' : '' }}>
                {{ $ruang->nama_ruangan }}
              </option>
              @endforeach
            </select>
            @error('id_ruangan')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Kondisi --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Kondisi<span class="req">*</span></label>
            <select class="pg-select @error('kondisi') is-invalid @enderror" name="kondisi" required>
              <option value="">-- Pilih Kondisi --</option>
              <option value="Baik"         {{ old('kondisi', $item->kondisi) == 'Baik'         ? 'selected' : '' }}>Baik</option>
              <option value="Rusak Ringan" {{ old('kondisi', $item->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
              <option value="Rusak Berat"  {{ old('kondisi', $item->kondisi) == 'Rusak Berat'  ? 'selected' : '' }}>Rusak Berat</option>
            </select>
            @error('kondisi')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Deskripsi --}}
          <div class="col-12">
            <label class="pg-label">Deskripsi Barang</label>
            <textarea class="pg-textarea @error('deskripsi') is-invalid @enderror"
                      name="deskripsi"
                      placeholder="Contoh: Laptop untuk keperluan administrasi kantor, dilengkapi RAM 8GB dan SSD 256GB...">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
            @error('deskripsi')<div class="invalid-msg">{{ $message }}</div>@enderror
            <p class="field-hint"><i class="fas fa-info-circle me-1"></i>Opsional — tuliskan spesifikasi atau keterangan tambahan barang</p>
          </div>

          {{-- Foto --}}
          <div class="col-12">
            <div class="pg-sep"></div>
            <label class="pg-label">Foto Barang</label>
            <div class="photo-zone">
              <div class="photo-btns">
                <button type="button" class="pg-btn pg-btn-upload" onclick="document.getElementById('foto').click()">
                  <i class="fa fa-upload"></i> Upload Foto
                </button>
                <button type="button" class="pg-btn pg-btn-camera" onclick="openCamera()">
                  <i class="fa fa-camera"></i> Ambil dari Kamera
                </button>
              </div>
              <input type="file" id="foto" name="foto" accept="image/*"
                     class="d-none @error('foto') is-invalid @enderror"
                     onchange="previewImage(event)">
              <input type="hidden" id="camera_photo" name="camera_photo">
              @error('foto')<div class="invalid-msg">{{ $message }}</div>@enderror
              <p class="field-hint">Format: JPG, JPEG, PNG (Maks: 2MB) — Kosongkan jika tidak ingin mengubah foto</p>

              @if($item->foto)
              <div class="mt-3" id="currentPhoto">
                <span class="photo-section-label">Foto Saat Ini</span>
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Barang" class="photo-thumb">
              </div>
              @endif

              <div id="imagePreview" class="mt-3" style="display:none">
                <span class="photo-section-label">Preview Foto Baru</span>
                <img id="preview" src="" alt="Preview" class="photo-thumb">
                <br>
                <button type="button" class="pg-btn pg-btn-del-photo mt-2" onclick="clearPhoto()">
                  <i class="fa fa-trash"></i> Hapus Foto
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="pg-card__footer">
        <div class="footer-actions d-flex gap-2 flex-wrap">
          <button type="submit" class="pg-btn pg-btn-save">
            <i class="fa fa-save"></i> Update
          </button>
          <a href="{{ route('barang.index') }}" class="pg-btn pg-btn-cancel">
            <i class="fa fa-times"></i> Batal
          </a>
        </div>
        <div class="footer-secondary">
          <a href="{{ route('riwayat-perawatan.create', ['id_item' => $item->id_item]) }}" class="btn-perawatan">
            <i class="fa fa-wrench"></i> Catat Perawatan
          </a>
        </div>
      </div>

    </form>
  </div>

</div>

{{-- Modal Kamera --}}
<div class="modal fade" id="cameraModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4 overflow-hidden">
      <div class="modal-header border-0 px-4 pt-4 pb-2">
        <h5 class="modal-title" style="font-family:'Times New Roman',Times,serif;font-weight:700;color:#0f172a;font-size:1rem">
          <i class="fa fa-camera me-2" style="color:#6366f1"></i>Ambil Foto
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 pb-3 text-center">
        <video id="video" width="100%" height="auto" autoplay style="border-radius:10px;border:1px solid #e8edf5;"></video>
        <canvas id="canvas" style="display:none;"></canvas>
        <div id="capturedImageContainer" style="display:none;">
          <img id="capturedImage" src="" alt="Captured" style="max-width:100%;border-radius:10px;border:1.5px solid #6366f1;">
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 gap-2 flex-wrap">
        <button type="button" class="pg-btn pg-btn-cancel" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
        <button type="button" class="pg-btn pg-btn-save" id="captureBtn" onclick="capturePhoto()"><i class="fa fa-camera"></i> Ambil Foto</button>
        <button type="button" class="pg-btn pg-btn-upload" id="retakeBtn" onclick="retakePhoto()" style="display:none;"><i class="fa fa-redo"></i> Foto Ulang</button>
        <button type="button" class="pg-btn pg-btn-camera" id="usePhotoBtn" onclick="usePhoto()" style="display:none;"><i class="fa fa-check"></i> Gunakan Foto</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
let videoStream = null, capturedPhotoData = null;

function previewImage(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
    document.getElementById('preview').src = ev.target.result;
    document.getElementById('imagePreview').style.display = 'block';
    document.getElementById('camera_photo').value = '';
  };
  reader.readAsDataURL(file);
}

function openCamera() {
  new bootstrap.Modal(document.getElementById('cameraModal')).show();
  navigator.mediaDevices.getUserMedia({ video: { facingMode:'environment', width:{ideal:1280}, height:{ideal:720} } })
    .then(stream => {
      videoStream = stream;
      const v = document.getElementById('video');
      v.srcObject = stream; v.play();
      document.getElementById('captureBtn').style.display = 'inline-flex';
      document.getElementById('retakeBtn').style.display = 'none';
      document.getElementById('usePhotoBtn').style.display = 'none';
      document.getElementById('video').style.display = 'block';
      document.getElementById('capturedImageContainer').style.display = 'none';
    })
    .catch(() => alert('Tidak dapat mengakses kamera.'));
}

function capturePhoto() {
  const v = document.getElementById('video'), c = document.getElementById('canvas');
  c.width = v.videoWidth; c.height = v.videoHeight;
  c.getContext('2d').drawImage(v, 0, 0, c.width, c.height);
  capturedPhotoData = c.toDataURL('image/jpeg', 0.9);
  document.getElementById('capturedImage').src = capturedPhotoData;
  document.getElementById('video').style.display = 'none';
  document.getElementById('capturedImageContainer').style.display = 'block';
  document.getElementById('captureBtn').style.display = 'none';
  document.getElementById('retakeBtn').style.display = 'inline-flex';
  document.getElementById('usePhotoBtn').style.display = 'inline-flex';
}

function retakePhoto() {
  capturedPhotoData = null;
  document.getElementById('video').style.display = 'block';
  document.getElementById('capturedImageContainer').style.display = 'none';
  document.getElementById('captureBtn').style.display = 'inline-flex';
  document.getElementById('retakeBtn').style.display = 'none';
  document.getElementById('usePhotoBtn').style.display = 'none';
}

function usePhoto() {
  if (!capturedPhotoData) return;
  document.getElementById('preview').src = capturedPhotoData;
  document.getElementById('imagePreview').style.display = 'block';
  document.getElementById('camera_photo').value = capturedPhotoData;
  document.getElementById('foto').value = '';
  stopCamera();
  bootstrap.Modal.getInstance(document.getElementById('cameraModal')).hide();
}

function stopCamera() {
  if (videoStream) { videoStream.getTracks().forEach(t => t.stop()); videoStream = null; }
}

function clearPhoto() {
  document.getElementById('preview').src = '';
  document.getElementById('imagePreview').style.display = 'none';
  document.getElementById('foto').value = '';
  document.getElementById('camera_photo').value = '';
  capturedPhotoData = null;
}

document.getElementById('cameraModal').addEventListener('hidden.bs.modal', stopCamera);
</script>
@endpush
@endsection