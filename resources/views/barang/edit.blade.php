@extends('layouts.template')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Barang</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('barang.index') }}">Barang</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Barang</h4>
                </div>
                <form action="{{ route('barang.update', $item->id_item) }}" method="POST" enctype="multipart/form-data">
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

                            <!-- Foto -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto">Foto Barang</label>
                                    <input type="file" 
                                           class="form-control-file @error('foto') is-invalid @enderror" 
                                           id="foto" 
                                           name="foto" 
                                           accept="image/*"
                                           onchange="previewImage(event)">
                                    @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG (Max: 2MB) - Kosongkan jika tidak ingin mengubah foto</small>
                                    
                                    <!-- Current Image -->
                                    @if($item->foto)
                                    <div class="mt-2">
                                        <label>Foto Saat Ini:</label><br>
                                        <img src="{{ asset('storage/' . $item->foto) }}" 
                                             alt="Current Photo" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                    </div>
                                    @endif

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <label>Preview Foto Baru:</label><br>
                                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
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

@push('scripts')
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
        document.getElementById('imagePreview').style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush
@endsection