@extends('layouts.template')

@section('content')
<style>
  body { font-family: 'Times New Roman', Times, serif; background: #f7f8fc; }

  /* ══════════════════════════════════════
     BACK BUTTON
  ══════════════════════════════════════ */
  .btn-back {
    font-family: 'Times New Roman', Times, serif;
    font-size: .82rem; font-weight: 600;
    padding: .45rem 1rem; border-radius: 9px;
    background: #fff; border: 1px solid #e2e8f0;
    color: #334155; text-decoration: none;
    display: inline-flex; align-items: center; gap: .4rem;
    transition: all .15s; white-space: nowrap;
  }
  .btn-back:hover { background: #0f172a; color: #fff; border-color: #0f172a; }

  /* ══════════════════════════════════════
     HEADER
  ══════════════════════════════════════ */
  .pg-title {
    font-family: 'Times New Roman', Times, serif;
    font-size: clamp(1.3rem, 3vw, 1.85rem);
    font-weight: 700; letter-spacing: -.01em;
    color: #0f172a; margin: 0 0 .2rem;
  }
  .pg-subtitle { font-size: .8rem; color: #94a3b8; margin: 0; }

  /* ══════════════════════════════════════
     ALERT
  ══════════════════════════════════════ */
  .pg-alert {
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 12px; padding: .875rem 1.1rem;
    font-size: .85rem; color: #15803d;
    display: flex; align-items: center; gap: .6rem;
    margin-bottom: 1.5rem;
  }
  .pg-alert .btn-close { margin-left: auto; opacity: .5; }

  /* ══════════════════════════════════════
     CARD
  ══════════════════════════════════════ */
  .pg-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 18px;
    overflow: hidden;
    transition: box-shadow .2s;
  }
  .pg-card__head {
    padding: 1rem 1.4rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: .65rem;
  }
  .pg-card__icon {
    width: 32px; height: 32px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; flex-shrink: 0;
  }
  .pg-card__title {
    font-family: 'Times New Roman', Times, serif;
    font-size: .95rem; font-weight: 700; color: #0f172a; margin: 0;
  }
  .pg-card__body { padding: 1.4rem; }

  /* ══════════════════════════════════════
     DETAIL ROWS
  ══════════════════════════════════════ */
  .detail-row {
    display: flex; gap: 1rem;
    padding: .7rem 0;
    border-bottom: 1px solid #f8fafc;
    align-items: flex-start;
  }
  .detail-row:first-child { padding-top: 0; }
  .detail-row:last-child  { border-bottom: none; padding-bottom: 0; }
  .dl {
    font-size: .72rem; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .07em;
    min-width: 145px; flex-shrink: 0; padding-top: .1rem;
  }
  .dv { font-size: .875rem; color: #0f172a; flex: 1; line-height: 1.5; }

  @media (max-width: 575px) {
    .detail-row { flex-direction: column; gap: .2rem; }
    .dl { min-width: unset; }
  }

  /* ══════════════════════════════════════
     DESCRIPTION BOX
  ══════════════════════════════════════ */
  .desc-box {
    background: #f8fafc; border: 1px solid #f1f5f9;
    border-radius: 10px; padding: .9rem 1.1rem;
    font-size: .875rem; color: #334155; line-height: 1.7;
  }

  /* ══════════════════════════════════════
     CODE CHIP
  ══════════════════════════════════════ */
  .code-chip {
    font-family: 'SF Mono', 'Fira Code', monospace;
    font-size: .74rem; color: #6366f1;
    background: #f5f3ff; padding: .18rem .5rem;
    border-radius: 6px; border: 1px solid #e0e7ff;
  }

  /* ══════════════════════════════════════
     BADGES
  ══════════════════════════════════════ */
  .badge-pill {
    display: inline-flex; align-items: center; gap: .32rem;
    font-size: .71rem; font-weight: 700;
    padding: .28rem .72rem; border-radius: 999px; letter-spacing: .03em;
    white-space: nowrap;
  }
  .badge-pill::before {
    content: ''; width: 5px; height: 5px;
    border-radius: 50%; background: currentColor; flex-shrink: 0;
  }
  .badge-menunggu    { background: #fffbeb; color: #b45309; }
  .badge-diproses    { background: #eff6ff; color: #1d4ed8; }
  .badge-selesai     { background: #f0fdf4; color: #15803d; }
  .badge-ringan      { background: #f0fdf4; color: #15803d; }
  .badge-sedang      { background: #fffbeb; color: #b45309; }
  .badge-berat       { background: #fef2f2; color: #b91c1c; }
  .badge-baik        { background: #f0fdf4; color: #15803d; }
  .badge-rusak-ringan{ background: #fffbeb; color: #b45309; }
  .badge-rusak-berat { background: #fef2f2; color: #b91c1c; }
  .badge-info        { background: #eff6ff; color: #1d4ed8; }

  /* ══════════════════════════════════════
     PHOTO
  ══════════════════════════════════════ */
  .photo-wrap {
    border-radius: 12px; overflow: hidden;
    border: 1px solid #e8edf5; cursor: pointer;
    transition: box-shadow .2s;
  }
  .photo-wrap:hover { box-shadow: 0 8px 28px rgba(15,23,42,.12); }
  .photo-wrap img { width: 100%; display: block; max-height: 260px; object-fit: cover; }
  .photo-hint { font-size: .74rem; color: #94a3b8; text-align: center; margin-top: .45rem; }

  /* ══════════════════════════════════════
     FORM
  ══════════════════════════════════════ */
  .pg-form-label {
    font-family: 'Times New Roman', Times, serif;
    font-size: .71rem; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .07em;
    display: block; margin-bottom: .4rem;
  }
  .pg-select {
    font-family: 'Times New Roman', Times, serif;
    font-size: .875rem; width: 100%;
    padding: .55rem .9rem;
    border: 1px solid #e2e8f0; border-radius: 10px;
    background: #f8fafc; color: #334155;
    outline: none; cursor: pointer;
    transition: border-color .15s, box-shadow .15s;
  }
  .pg-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }

  .pg-check-label {
    font-family: 'Times New Roman', Times, serif;
    font-size: .875rem; color: #334155; cursor: pointer;
  }

  .pg-btn-save {
    font-family: 'Times New Roman', Times, serif;
    font-size: .875rem; font-weight: 700;
    padding: .65rem 1.25rem; width: 100%; border-radius: 10px;
    background: #0f172a; color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    transition: all .15s;
  }
  .pg-btn-save:hover { background: #1e293b; box-shadow: 0 4px 16px rgba(15,23,42,.25); }

  /* ══════════════════════════════════════
     TIMELINE
  ══════════════════════════════════════ */
  .timeline { display: flex; flex-direction: column; }
  .tl-item {
    display: flex; gap: .875rem;
    position: relative; padding-bottom: 1.25rem;
  }
  .tl-item:last-child { padding-bottom: 0; }
  .tl-item:not(:last-child)::before {
    content: ''; position: absolute;
    left: 16px; top: 33px; bottom: 0;
    width: 1px; background: #f1f5f9;
  }
  .tl-dot {
    width: 33px; height: 33px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: .8rem;
  }
  .tl-dot--created { background: #f5f3ff; color: #6366f1; border: 1.5px solid #e0e7ff; }
  .tl-dot--updated { background: #eff6ff; color: #3b82f6; border: 1.5px solid #dbeafe; }
  .tl-time { font-size: .72rem; color: #94a3b8; margin-bottom: .2rem; }
  .tl-text { font-size: .84rem; color: #334155; font-weight: 600; }

  /* ══════════════════════════════════════
     DIVIDER
  ══════════════════════════════════════ */
  .pg-divider {
    height: 1px; background: #f1f5f9; margin: 1rem 0;
  }

  /* ══════════════════════════════════════
     ANIMATE
  ══════════════════════════════════════ */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .anim   { animation: fadeUp .4s ease both; }
  .a1 { animation-delay: .04s; }
  .a2 { animation-delay: .10s; }
  .a3 { animation-delay: .16s; }
  .a4 { animation-delay: .22s; }

  /* ══════════════════════════════════════
     RESPONSIVE TWEAKS
  ══════════════════════════════════════ */
  @media (max-width: 767px) {
    .pg-card__body { padding: 1.1rem; }
    .pg-card__head { padding: .875rem 1.1rem; }
  }
  @media (max-width: 575px) {
    .pg-title { font-size: 1.25rem; }
    .pg-btn-save { font-size: .82rem; padding: .6rem 1rem; }
  }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

  {{-- ── Header ── --}}
  <div class="d-flex justify-content-between align-items-start gap-3 mb-4 anim">
    <div>
      <h1 class="pg-title">Detail <span style="color:#6366f1">Pengaduan</span></h1>
      <p class="pg-subtitle">Referensi #{{ $pengaduan->id_pengaduan }}</p>
    </div>
    <a href="{{ route('pengaduan.index') }}" class="btn-back">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
  </div>

  {{-- ── Alert ── --}}
  @if(session('success'))
  <div class="pg-alert anim" role="alert">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="row g-3">

    {{-- ════════════════
         KOLOM KIRI
    ════════════════ --}}
    <div class="col-12 col-lg-8">

      {{-- Informasi Pengaduan --}}
      <div class="pg-card mb-3 anim a1">
        <div class="pg-card__head">
          <div class="pg-card__icon" style="background:#f5f3ff;color:#6366f1">
            <i class="bi bi-file-text"></i>
          </div>
          <h2 class="pg-card__title">Informasi Pengaduan</h2>
        </div>
        <div class="pg-card__body">

          <div class="detail-row">
            <span class="dl">Tanggal</span>
            <span class="dv">{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</span>
          </div>
          <div class="detail-row">
            <span class="dl">Pelapor</span>
            <span class="dv fw-semibold">{{ $pengaduan->nama_pelapor }}</span>
          </div>
          <div class="detail-row">
            <span class="dl">Email</span>
            <span class="dv">{{ $pengaduan->email_pelapor ?: '—' }}</span>
          </div>
          <div class="detail-row">
            <span class="dl">Status</span>
            <span class="dv">
              @php $sk = strtolower($pengaduan->status); @endphp
              <span class="badge-pill badge-{{ $sk }}">{{ $pengaduan->status }}</span>
            </span>
          </div>
          <div class="detail-row">
            <span class="dl">Tingkat Kerusakan</span>
            <span class="dv">
              @php $tk = strtolower($pengaduan->tingkat_kerusakan); @endphp
              <span class="badge-pill badge-{{ $tk }}">{{ $pengaduan->tingkat_kerusakan }}</span>
            </span>
          </div>

          <div class="pg-divider"></div>

          <div class="detail-row" style="flex-direction:column;gap:.55rem">
            <span class="dl">Deskripsi Kerusakan</span>
            <div class="desc-box">{{ $pengaduan->deskripsi }}</div>
          </div>

          @if($pengaduan->foto)
          <div class="detail-row" style="flex-direction:column;gap:.55rem;border-bottom:none">
            <span class="dl">Foto Kerusakan</span>
            <div class="photo-wrap" data-bs-toggle="modal" data-bs-target="#fotoModal">
              <img src="{{ asset($pengaduan->foto) }}" alt="Foto Kerusakan">
            </div>
            <p class="photo-hint"><i class="bi bi-zoom-in me-1"></i>Klik untuk memperbesar</p>
          </div>
          @endif

        </div>
      </div>

      {{-- Informasi Barang --}}
      <div class="pg-card anim a2">
        <div class="pg-card__head">
          <div class="pg-card__icon" style="background:#fff7ed;color:#f59e0b">
            <i class="bi bi-box-seam"></i>
          </div>
          <h2 class="pg-card__title">Informasi Barang</h2>
        </div>
        <div class="pg-card__body">

          <div class="detail-row">
            <span class="dl">Kode Barang</span>
            <span class="dv"><span class="code-chip">{{ $pengaduan->item->kode_barang }}</span></span>
          </div>
          <div class="detail-row">
            <span class="dl">Nama Barang</span>
            <span class="dv fw-semibold">{{ $pengaduan->item->nama_item }}</span>
          </div>
          <div class="detail-row">
            <span class="dl">Merk</span>
            <span class="dv">{{ $pengaduan->item->merk ?: '—' }}</span>
          </div>
          <div class="detail-row">
            <span class="dl">Kategori</span>
            <span class="dv">
              <span class="badge-pill badge-info">{{ $pengaduan->item->kategori->nama_kategori ?? '—' }}</span>
            </span>
          </div>
          <div class="detail-row">
            <span class="dl">Ruangan</span>
            <span class="dv">{{ $pengaduan->item->ruangan->nama_ruangan ?? '—' }}</span>
          </div>
          <div class="detail-row">
            <span class="dl">Kondisi Barang</span>
            <span class="dv">
              @php $kondisiKey = strtolower(str_replace(' ', '-', $pengaduan->item->kondisi)); @endphp
              <span class="badge-pill badge-{{ $kondisiKey }}">{{ $pengaduan->item->kondisi }}</span>
            </span>
          </div>

        </div>
      </div>

    </div>

    {{-- ════════════════
         KOLOM KANAN
    ════════════════ --}}
    <div class="col-12 col-lg-4">

      {{-- Update Status --}}
      <div class="pg-card mb-3 anim a3">
        <div class="pg-card__head">
          <div class="pg-card__icon" style="background:#f0fdf4;color:#22c55e">
            <i class="bi bi-pencil-square"></i>
          </div>
          <h2 class="pg-card__title">Update Status</h2>
        </div>
        <div class="pg-card__body">
          <form action="{{ route('pengaduan.updateStatus', $pengaduan->id_pengaduan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="pg-form-label">Status Pengaduan</label>
              <select name="status" class="pg-select" required>
                <option value="Menunggu" {{ $pengaduan->status=='Menunggu'?'selected':'' }}>Menunggu</option>
                <option value="Diproses" {{ $pengaduan->status=='Diproses'?'selected':'' }}>Diproses</option>
                <option value="Selesai"  {{ $pengaduan->status=='Selesai' ?'selected':'' }}>Selesai</option>
              </select>
            </div>

            <div class="mb-3">
              <div class="form-check d-flex align-items-center gap-2" style="padding-left:0">
                <input class="form-check-input m-0" type="checkbox"
                       name="update_kondisi" id="updateKondisi" value="1"
                       style="width:16px;height:16px;cursor:pointer;flex-shrink:0">
                <label class="pg-check-label" for="updateKondisi">
                  Update kondisi barang
                </label>
              </div>
            </div>

            <div class="mb-3" id="kondisiBarangDiv" style="display:none">
              <label class="pg-form-label">Kondisi Barang</label>
              <select name="kondisi_barang" class="pg-select">
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
              </select>
            </div>

            <button type="submit" class="pg-btn-save">
              <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
          </form>
        </div>
      </div>

      {{-- Timeline --}}
      <div class="pg-card anim a4">
        <div class="pg-card__head">
          <div class="pg-card__icon" style="background:#f8fafc;color:#64748b">
            <i class="bi bi-clock-history"></i>
          </div>
          <h2 class="pg-card__title">Timeline</h2>
        </div>
        <div class="pg-card__body">
          <div class="timeline">

            <div class="tl-item">
              <div class="tl-dot tl-dot--created">
                <i class="bi bi-file-earmark-plus"></i>
              </div>
              <div>
                <div class="tl-time">{{ $pengaduan->created_at->format('d M Y, H:i') }}</div>
                <div class="tl-text">Pengaduan dibuat</div>
              </div>
            </div>

            @if($pengaduan->updated_at != $pengaduan->created_at)
            <div class="tl-item">
              <div class="tl-dot tl-dot--updated">
                <i class="bi bi-arrow-repeat"></i>
              </div>
              <div>
                <div class="tl-time">{{ $pengaduan->updated_at->format('d M Y, H:i') }}</div>
                <div class="tl-text">
                  Status diperbarui →
                  <span class="badge-pill badge-{{ strtolower($pengaduan->status) }}"
                        style="font-size:.68rem;vertical-align:middle">
                    {{ $pengaduan->status }}
                  </span>
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

{{-- ── Foto Modal ── --}}
@if($pengaduan->foto)
<div class="modal fade" id="fotoModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4 overflow-hidden">
      <div class="modal-header border-0 px-4 pt-4 pb-2">
        <h5 class="modal-title"
            style="font-family:'Times New Roman',Times,serif;font-size:1rem;font-weight:700;color:#0f172a">
          Foto Kerusakan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-3 pt-1">
        <img src="{{ asset($pengaduan->foto) }}"
             alt="Foto Kerusakan"
             class="img-fluid rounded-3 w-100">
      </div>
    </div>
  </div>
</div>
@endif

@push('scripts')
<script>
  document.getElementById('updateKondisi').addEventListener('change', function() {
    document.getElementById('kondisiBarangDiv').style.display = this.checked ? 'block' : 'none';
  });
</script>
@endpush

@endsection