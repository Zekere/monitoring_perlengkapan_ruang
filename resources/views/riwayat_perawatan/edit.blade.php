@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 mb-md-4 gap-2">
        <h2 class="mb-0 fs-4 fs-md-3">Edit Riwayat Perawatan</h2>
        <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('riwayat-perawatan.update', $riwayat->id_perawatan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Barang -->
                    <div class="col-12 col-lg-6">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Barang <span class="text-danger">*</span>
                            </label>
                            <select name="id_item" class="form-select @error('id_item') is-invalid @enderror" required>
                                <option value="">Pilih Barang</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id_item }}" 
                                            {{ $riwayat->id_item == $item->id_item ? 'selected' : '' }}>
                                        {{ $item->nama_item }} ({{ $item->kode_barang }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_item')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Perawatan -->
                    <div class="col-12 col-lg-6">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Tanggal Perawatan <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_perawatan" 
                                   class="form-control @error('tanggal_perawatan') is-invalid @enderror" 
                                   value="{{ $riwayat->tanggal_perawatan->format('Y-m-d') }}" 
                                   required>
                            @error('tanggal_perawatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jenis Perawatan -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Jenis Perawatan <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_perawatan" class="form-select @error('jenis_perawatan') is-invalid @enderror" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Perbaikan"   {{ $riwayat->jenis_perawatan == 'Perbaikan'   ? 'selected' : '' }}>Perbaikan</option>
                                <option value="Penggantian" {{ $riwayat->jenis_perawatan == 'Penggantian' ? 'selected' : '' }}>Penggantian</option>
                                <option value="Pembersihan" {{ $riwayat->jenis_perawatan == 'Pembersihan' ? 'selected' : '' }}>Pembersihan</option>
                                <option value="Kalibrasi"   {{ $riwayat->jenis_perawatan == 'Kalibrasi'   ? 'selected' : '' }}>Kalibrasi</option>
                                <option value="Maintenance" {{ $riwayat->jenis_perawatan == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('jenis_perawatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Teknisi -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Teknisi <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="teknisi" 
                                   class="form-control @error('teknisi') is-invalid @enderror" 
                                   value="{{ $riwayat->teknisi }}" 
                                   placeholder="Nama Teknisi" 
                                   required>
                            @error('teknisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Biaya -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Biaya (Rp) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="biaya" 
                                   class="form-control @error('biaya') is-invalid @enderror" 
                                   value="{{ $riwayat->biaya }}" 
                                   placeholder="0" 
                                   min="0" 
                                   step="0.01" 
                                   required>
                            @error('biaya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" 
                                    id="statusSelect"
                                    class="form-select @error('status') is-invalid @enderror" 
                                    required>
                                <option value="Selesai"      {{ $riwayat->status == 'Selesai'      ? 'selected' : '' }}>Selesai</option>
                                <option value="Dalam Proses" {{ $riwayat->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="Ditunda"      {{ $riwayat->status == 'Ditunda'      ? 'selected' : '' }}>Ditunda</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Info otomatis, hanya muncul saat Selesai --}}
                            <div id="kondisiInfo" 
                                 class="mt-2 p-2 rounded d-flex align-items-center gap-2" 
                                 style="display:none !important; background:#d1fae5; color:#065f46; font-size:.82rem;">
                                <i class="fas fa-check-circle"></i>
                                <span>Kondisi barang akan otomatis berubah menjadi <strong>Baik</strong> setelah disimpan.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Jelaskan detail perawatan yang dilakukan" 
                                      required>{{ $riwayat->deskripsi }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">
                                Catatan Tambahan
                            </label>
                            <textarea name="catatan" 
                                      class="form-control @error('catatan') is-invalid @enderror" 
                                      rows="2" 
                                      placeholder="Catatan tambahan (opsional)">{{ $riwayat->catatan }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                    <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-secondary order-2 order-sm-1">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary order-1 order-sm-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@media (max-width: 576px) {
    .card-body {
        padding: 1rem !important;
    }
    h2 {
        font-size: 1.25rem !important;
    }
    .btn {
        width: 100%;
    }
    .form-label {
        margin-bottom: 0.25rem;
    }
    .form-control, .form-select {
        font-size: 0.95rem;
    }
}

@media (min-width: 577px) and (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
}

@media (max-width: 768px) {
    .form-control, .form-select {
        min-height: 44px;
        padding: 0.5rem 0.75rem;
    }
    textarea.form-control {
        min-height: 100px;
    }
}
</style>

<script>
(function () {
    const sel  = document.getElementById('statusSelect');
    const info = document.getElementById('kondisiInfo');

    function render() {
        if (sel.value === 'Selesai') {
            info.style.display = 'flex';
        } else {
            info.style.display = 'none';
        }
    }

    sel.addEventListener('change', render);
    render(); // jalankan saat halaman pertama kali dimuat
})();
</script>

@endsection