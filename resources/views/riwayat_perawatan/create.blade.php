@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ isset($riwayat) ? 'Edit' : 'Tambah' }} Riwayat Perawatan</h2>
        <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($riwayat) ? route('riwayat-perawatan.update', $riwayat->id_perawatan) : route('riwayat-perawatan.store') }}" 
                  method="POST">
                @csrf
                @if(isset($riwayat))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Barang <span class="text-danger">*</span></label>
                            <select name="id_item" class="form-select @error('id_item') is-invalid @enderror" required>
                                <option value="">Pilih Barang</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id_item }}" 
                                            {{ (isset($riwayat) && $riwayat->id_item == $item->id_item) || old('id_item') == $item->id_item ? 'selected' : '' }}>
                                        {{ $item->nama_item }} ({{ $item->kode_barang }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_item')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Perawatan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_perawatan" 
                                   class="form-control @error('tanggal_perawatan') is-invalid @enderror" 
                                   value="{{ isset($riwayat) ? $riwayat->tanggal_perawatan->format('Y-m-d') : old('tanggal_perawatan') }}" 
                                   required>
                            @error('tanggal_perawatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Perawatan <span class="text-danger">*</span></label>
                            <select name="jenis_perawatan" class="form-select @error('jenis_perawatan') is-invalid @enderror" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Perbaikan" {{ (isset($riwayat) && $riwayat->jenis_perawatan == 'Perbaikan') || old('jenis_perawatan') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                <option value="Penggantian" {{ (isset($riwayat) && $riwayat->jenis_perawatan == 'Penggantian') || old('jenis_perawatan') == 'Penggantian' ? 'selected' : '' }}>Penggantian</option>
                                <option value="Pembersihan" {{ (isset($riwayat) && $riwayat->jenis_perawatan == 'Pembersihan') || old('jenis_perawatan') == 'Pembersihan' ? 'selected' : '' }}>Pembersihan</option>
                                <option value="Kalibrasi" {{ (isset($riwayat) && $riwayat->jenis_perawatan == 'Kalibrasi') || old('jenis_perawatan') == 'Kalibrasi' ? 'selected' : '' }}>Kalibrasi</option>
                                <option value="Maintenance" {{ (isset($riwayat) && $riwayat->jenis_perawatan == 'Maintenance') || old('jenis_perawatan') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('jenis_perawatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Teknisi <span class="text-danger">*</span></label>
                            <input type="text" name="teknisi" 
                                   class="form-control @error('teknisi') is-invalid @enderror" 
                                   value="{{ isset($riwayat) ? $riwayat->teknisi : old('teknisi') }}" 
                                   placeholder="Nama Teknisi" 
                                   required>
                            @error('teknisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Biaya (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="biaya" 
                                   class="form-control @error('biaya') is-invalid @enderror" 
                                   value="{{ isset($riwayat) ? $riwayat->biaya : old('biaya') }}" 
                                   placeholder="0" 
                                   min="0" 
                                   step="0.01" 
                                   required>
                            @error('biaya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Selesai" {{ (isset($riwayat) && $riwayat->status == 'Selesai') || old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dalam Proses" {{ (isset($riwayat) && $riwayat->status == 'Dalam Proses') || old('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="Ditunda" {{ (isset($riwayat) && $riwayat->status == 'Ditunda') || old('status') == 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Jelaskan detail perawatan yang dilakukan" 
                                      required>{{ isset($riwayat) ? $riwayat->deskripsi : old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan" 
                                      class="form-control @error('catatan') is-invalid @enderror" 
                                      rows="2" 
                                      placeholder="Catatan tambahan (opsional)">{{ isset($riwayat) ? $riwayat->catatan : old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection