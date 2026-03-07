@extends('layouts.template')

@section('content')
<style>
  body { font-family:'Times New Roman',Times,serif; background:#f7f8fc; }

  .pg-title { font-size:clamp(1.2rem,3vw,1.6rem); font-weight:700; color:#0f172a; margin:0 0 .2rem; letter-spacing:-.01em; }
  .pg-subtitle { font-size:.82rem; color:#94a3b8; margin:0; }

  .btn-back {
    font-family:'Times New Roman',Times,serif; font-size:.82rem; font-weight:600;
    padding:.45rem 1rem; border-radius:9px; background:#fff; border:1px solid #e2e8f0;
    color:#334155; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem;
    transition:all .15s; white-space:nowrap;
  }
  .btn-back:hover { background:#0f172a; color:#fff; border-color:#0f172a; }

  /* Card */
  .pg-card { background:#fff; border:1px solid #e8edf5; border-radius:18px; overflow:hidden; }
  .pg-card__head { padding:1rem 1.4rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:.65rem; }
  .pg-card__icon { width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:.85rem; flex-shrink:0; }
  .pg-card__title { font-size:.95rem; font-weight:700; color:#0f172a; margin:0; }
  .pg-card__body { padding:1.5rem; }
  .pg-card__footer { padding:1rem 1.4rem; border-top:1px solid #f1f5f9; background:#fafbfc; display:flex; gap:.625rem; flex-wrap:wrap; }

  /* Item banner (when coming from barang edit) */
  .item-banner {
    background:linear-gradient(135deg,#f5f3ff,#eff6ff);
    border:1px solid #e0e7ff; border-radius:12px;
    padding:.875rem 1.1rem; margin-bottom:1.5rem;
    display:flex; align-items:center; gap:.875rem; flex-wrap:wrap;
  }
  .item-banner__icon { width:38px; height:38px; border-radius:10px; background:#6366f1; color:#fff; display:flex; align-items:center; justify-content:center; font-size:.95rem; flex-shrink:0; }
  .item-banner__name { font-weight:700; font-size:.9rem; color:#0f172a; }
  .item-banner__code { font-family:'SF Mono','Fira Code',monospace; font-size:.74rem; color:#6366f1; background:#ede9fe; padding:.15rem .45rem; border-radius:5px; border:1px solid #ddd6fe; }

  /* Form elements */
  .pg-label { font-size:.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.07em; display:block; margin-bottom:.4rem; }
  .req { color:#ef4444; margin-left:.15rem; }

  .pg-input, .pg-select, .pg-textarea {
    font-family:'Times New Roman',Times,serif; font-size:.875rem; width:100%;
    padding:.55rem .9rem; border:1px solid #e2e8f0; border-radius:10px;
    background:#f8fafc; color:#334155; outline:none;
    transition:border-color .15s, box-shadow .15s;
  }
  .pg-textarea { resize:vertical; min-height:90px; }
  .pg-input:focus, .pg-select:focus, .pg-textarea:focus {
    border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.1); background:#fff;
  }
  .pg-input.is-invalid, .pg-select.is-invalid, .pg-textarea.is-invalid { border-color:#ef4444; }
  .invalid-msg { font-size:.75rem; color:#ef4444; margin-top:.3rem; }

  /* Currency prefix */
  .input-wrap { display:flex; }
  .input-prefix { padding:.55rem .8rem; background:#f1f5f9; border:1px solid #e2e8f0; border-right:none; border-radius:10px 0 0 10px; font-size:.82rem; color:#64748b; display:flex; align-items:center; white-space:nowrap; }
  .input-wrap .pg-input { border-radius:0 10px 10px 0; }

  /* Status radio toggle */
  .status-opts { display:flex; gap:.625rem; flex-wrap:wrap; margin-top:.3rem; }
  .status-opt { flex:1; min-width:110px; }
  .status-opt input[type=radio] { display:none; }
  .status-opt label {
    display:flex; align-items:center; justify-content:center; gap:.4rem;
    padding:.5rem .75rem; border:1.5px solid #e2e8f0; border-radius:9px;
    cursor:pointer; font-size:.8rem; font-weight:600;
    background:#f8fafc; color:#64748b; text-align:center; width:100%;
    transition:all .15s;
  }
  .status-opt input:checked + label.opt-selesai  { background:#f0fdf4; border-color:#6ee7b7; color:#15803d; }
  .status-opt input:checked + label.opt-proses   { background:#eff6ff; border-color:#93c5fd; color:#1d4ed8; }
  .status-opt input:checked + label.opt-ditunda  { background:#fffbeb; border-color:#fcd34d; color:#b45309; }
  .status-opt label:hover { border-color:#6366f1; color:#4f46e5; }

  /* Buttons */
  .pg-btn {
    font-family:'Times New Roman',Times,serif; font-size:.84rem; font-weight:700;
    padding:.55rem 1.2rem; border-radius:9px; border:none; cursor:pointer;
    display:inline-flex; align-items:center; gap:.4rem;
    transition:all .15s; text-decoration:none; white-space:nowrap;
  }
  .pg-btn-save   { background:#f59e0b; color:#fff; box-shadow:0 2px 8px rgba(245,158,11,.3); }
  .pg-btn-save:hover { background:#d97706; box-shadow:0 4px 16px rgba(245,158,11,.4); color:#fff; }
  .pg-btn-update { background:#6366f1; color:#fff; box-shadow:0 2px 8px rgba(99,102,241,.3); }
  .pg-btn-update:hover { background:#4f46e5; box-shadow:0 4px 16px rgba(99,102,241,.4); color:#fff; }
  .pg-btn-cancel { background:#fff; color:#64748b; border:1px solid #e2e8f0; }
  .pg-btn-cancel:hover { background:#f1f5f9; color:#334155; text-decoration:none; }

  .pg-sep { height:1px; background:#f1f5f9; margin:1.1rem 0; }

  @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
  .anim { animation:fadeUp .4s ease both; }
  .a1{animation-delay:.05s}

  @media(max-width:767px){
    .pg-card__body { padding:1.1rem; }
    .pg-card__footer { flex-direction:column; }
    .pg-btn { justify-content:center; }
    .status-opts { flex-direction:column; }
    .status-opt { min-width:unset; }
  }
  @media(max-width:575px){ .pg-title { font-size:1.2rem; } }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-start gap-3 mb-4 anim">
    <div>
      <h1 class="pg-title">
        {{ isset($riwayat) ? 'Edit' : 'Catat' }}
        <span style="color:#f59e0b">Perawatan</span>
      </h1>
      <p class="pg-subtitle">
        {{ isset($riwayat) ? 'Perbarui data riwayat perawatan' : 'Tambah riwayat perawatan barang inventaris' }}
      </p>
    </div>
    <a href="{{ route('riwayat-perawatan.index') }}" class="btn-back">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  <div class="pg-card anim a1">
    <div class="pg-card__head">
      <div class="pg-card__icon" style="background:#fff7ed;color:#f59e0b">
        <i class="fas fa-wrench"></i>
      </div>
      <h2 class="pg-card__title">
        {{ isset($riwayat) ? 'Form Edit Perawatan' : 'Form Tambah Perawatan' }}
      </h2>
    </div>

    <form action="{{ isset($riwayat) ? route('riwayat-perawatan.update', $riwayat->id_perawatan) : route('riwayat-perawatan.store') }}"
          method="POST">
      @csrf
      @if(isset($riwayat)) @method('PUT') @endif

      <div class="pg-card__body">

        {{-- Banner barang terpilih (dari tombol "Catat Perawatan" di form barang) --}}
        @if(isset($selectedItem))
        <div class="item-banner">
          <div class="item-banner__icon"><i class="fas fa-box"></i></div>
          <div>
            <div class="item-banner__name">{{ $selectedItem->nama_item }}</div>
            <span class="item-banner__code">{{ $selectedItem->kode_barang }}</span>
          </div>
        </div>
        @endif

        <div class="row g-3">

          {{-- Pilih Barang --}}
          <div class="col-12 col-lg-6">
            <label class="pg-label">Barang<span class="req">*</span></label>
            <select name="id_item"
                    class="pg-select @error('id_item') is-invalid @enderror" required>
              <option value="">Pilih Barang</option>
              @foreach($items as $item)
              <option value="{{ $item->id_item }}"
                {{ (isset($riwayat) && $riwayat->id_item == $item->id_item)
                   || old('id_item', request('id_item')) == $item->id_item ? 'selected' : '' }}>
                {{ $item->nama_item }} ({{ $item->kode_barang }})
              </option>
              @endforeach
            </select>
            @error('id_item')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Tanggal Perawatan --}}
          <div class="col-12 col-lg-6">
            <label class="pg-label">Tanggal Perawatan<span class="req">*</span></label>
            <input type="date"
                   class="pg-input @error('tanggal_perawatan') is-invalid @enderror"
                   name="tanggal_perawatan"
                   value="{{ isset($riwayat) ? $riwayat->tanggal_perawatan->format('Y-m-d') : old('tanggal_perawatan', date('Y-m-d')) }}"
                   required>
            @error('tanggal_perawatan')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Jenis Perawatan --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Jenis Perawatan<span class="req">*</span></label>
            <select name="jenis_perawatan"
                    class="pg-select @error('jenis_perawatan') is-invalid @enderror" required>
              <option value="">Pilih Jenis</option>
              @foreach(['Perbaikan','Penggantian','Pembersihan','Kalibrasi','Maintenance'] as $jenis)
              <option value="{{ $jenis }}"
                {{ (isset($riwayat) && $riwayat->jenis_perawatan == $jenis)
                   || old('jenis_perawatan') == $jenis ? 'selected' : '' }}>
                {{ $jenis }}
              </option>
              @endforeach
            </select>
            @error('jenis_perawatan')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Teknisi --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Teknisi<span class="req">*</span></label>
            <input type="text"
                   class="pg-input @error('teknisi') is-invalid @enderror"
                   name="teknisi"
                   value="{{ isset($riwayat) ? $riwayat->teknisi : old('teknisi') }}"
                   placeholder="Nama teknisi / vendor…" required>
            @error('teknisi')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Biaya --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Biaya<span class="req">*</span></label>
            <div class="input-wrap">
              <span class="input-prefix">Rp</span>
              <input type="number"
                     class="pg-input @error('biaya') is-invalid @enderror"
                     name="biaya"
                     value="{{ isset($riwayat) ? $riwayat->biaya : old('biaya', 0) }}"
                     min="0" step="0.01" required>
            </div>
            @error('biaya')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Status --}}
          <div class="col-12 col-md-6">
            <label class="pg-label">Status<span class="req">*</span></label>
            <div class="status-opts">
              @php
                $currentStatus = isset($riwayat) ? $riwayat->status : old('status', 'Selesai');
              @endphp
              <div class="status-opt">
                <input type="radio" name="status" id="st_selesai" value="Selesai"
                       {{ $currentStatus == 'Selesai' ? 'checked' : '' }}>
                <label for="st_selesai" class="opt-selesai">
                  <i class="fas fa-check-circle"></i> Selesai
                </label>
              </div>
              <div class="status-opt">
                <input type="radio" name="status" id="st_proses" value="Dalam Proses"
                       {{ $currentStatus == 'Dalam Proses' ? 'checked' : '' }}>
                <label for="st_proses" class="opt-proses">
                  <i class="fas fa-cog"></i> Dalam Proses
                </label>
              </div>
              <div class="status-opt">
                <input type="radio" name="status" id="st_ditunda" value="Ditunda"
                       {{ $currentStatus == 'Ditunda' ? 'checked' : '' }}>
                <label for="st_ditunda" class="opt-ditunda">
                  <i class="fas fa-pause-circle"></i> Ditunda
                </label>
              </div>
            </div>
            @error('status')<div class="invalid-msg mt-1">{{ $message }}</div>@enderror
          </div>

          <div class="col-12"><div class="pg-sep"></div></div>

          {{-- Deskripsi --}}
          <div class="col-12">
            <label class="pg-label">Deskripsi Pekerjaan<span class="req">*</span></label>
            <textarea class="pg-textarea @error('deskripsi') is-invalid @enderror"
                      name="deskripsi"
                      placeholder="Jelaskan detail perawatan yang dilakukan…"
                      required>{{ isset($riwayat) ? $riwayat->deskripsi : old('deskripsi') }}</textarea>
            @error('deskripsi')<div class="invalid-msg">{{ $message }}</div>@enderror
          </div>

          {{-- Catatan --}}
          <div class="col-12">
            <label class="pg-label">Catatan Tambahan</label>
            <textarea class="pg-textarea"
                      name="catatan"
                      style="min-height:70px"
                      placeholder="Rekomendasi atau catatan lanjutan (opsional)…">{{ isset($riwayat) ? $riwayat->catatan : old('catatan') }}</textarea>
          </div>

        </div>
      </div>

      <div class="pg-card__footer">
        <button type="submit" class="{{ isset($riwayat) ? 'pg-btn pg-btn-update' : 'pg-btn pg-btn-save' }}">
          <i class="fas fa-save"></i>
          {{ isset($riwayat) ? 'Perbarui' : 'Simpan Perawatan' }}
        </button>
        <a href="{{ route('riwayat-perawatan.index') }}" class="pg-btn pg-btn-cancel">
          <i class="fas fa-times"></i> Batal
        </a>
      </div>

    </form>
  </div>

</div>
@endsection