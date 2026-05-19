<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pengaduan Kerusakan</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    :root {
      --teal:       #1a5f73;
      --teal-dark:  #0f3d4d;
      --teal-light: #26667F;
      --accent:     #e8a44a;
      --accent-dim: rgba(232,164,74,.15);
      --glass:      rgba(255,255,255,.08);
      --glass-border: rgba(255,255,255,.18);
      --text-dark:  #1a2535;
      --text-mid:   #4a5568;
      --text-light: #94a3b8;
      --danger:     #e05252;
      --success:    #2eb872;
      --radius:     16px;
      --radius-sm:  10px;
      --shadow:     0 32px 80px rgba(0,0,0,.25);
      --shadow-sm:  0 4px 20px rgba(0,0,0,.08);
    }

    * { margin:0; padding:0; box-sizing:border-box; }

    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      background-image: url('{{ asset("assets/img/img/886747_peresmian spam semarang.jpg") }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      position: relative;
    }

    /* Overlay di atas background */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: linear-gradient(
        135deg,
        rgba(10, 30, 50, 0.72) 0%,
        rgba(26, 95, 115, 0.60) 50%,
        rgba(10, 30, 50, 0.72) 100%
      );
      z-index: 0;
    }

    /* Partikel dekoratif */
    body::after {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        radial-gradient(circle at 20% 20%, rgba(232,164,74,.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(26,95,115,.15) 0%, transparent 50%);
      z-index: 0;
      pointer-events: none;
    }

    .page-wrap {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 680px;
    }

    /* ── CARD UTAMA ── */
    .card {
      background: rgba(255,255,255,.97);
      border-radius: 24px;
      box-shadow: var(--shadow);
      overflow: hidden;
      animation: riseUp .7s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes riseUp {
      from { opacity:0; transform:translateY(40px) scale(.97); }
      to   { opacity:1; transform:translateY(0)    scale(1);   }
    }

    /* ── HEADER ── */
    .card-header {
      background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-light) 100%);
      padding: 36px 40px 32px;
      position: relative;
      overflow: hidden;
    }

    .card-header::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 200px; height: 200px;
      border-radius: 50%;
      background: rgba(255,255,255,.06);
    }

    .card-header::after {
      content: '';
      position: absolute;
      bottom: -80px; left: -40px;
      width: 260px; height: 260px;
      border-radius: 50%;
      background: rgba(232,164,74,.08);
    }

    .header-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--accent-dim);
      border: 1px solid rgba(232,164,74,.3);
      color: var(--accent);
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .08em;
      text-transform: uppercase;
      padding: 5px 12px;
      border-radius: 100px;
      margin-bottom: 14px;
      position: relative;
      z-index: 1;
    }

    .header-badge::before {
      content: '';
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--accent);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%,100% { opacity:1; transform:scale(1); }
      50%      { opacity:.5; transform:scale(1.4); }
    }

    .card-header h1 {
      font-family: 'DM Serif Display', serif;
      font-size: 26px;
      color: #fff;
      font-weight: 400;
      line-height: 1.25;
      position: relative;
      z-index: 1;
      margin-bottom: 8px;
    }

    .card-header p {
      font-size: 13px;
      color: rgba(255,255,255,.65);
      position: relative;
      z-index: 1;
    }

    /* ── STEP INDICATOR ── */
    .steps {
      display: flex;
      padding: 20px 40px;
      background: #f8fafc;
      border-bottom: 1px solid #eef2f7;
      gap: 0;
    }

    .step {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      position: relative;
    }

    .step:not(:last-child)::after {
      content: '';
      position: absolute;
      top: 14px;
      left: calc(50% + 14px);
      right: calc(-50% + 14px);
      height: 2px;
      background: #e2e8f0;
    }

    .step.active:not(:last-child)::after { background: var(--teal-light); }

    .step-dot {
      width: 28px; height: 28px;
      border-radius: 50%;
      background: #e2e8f0;
      display: flex; align-items: center; justify-content: center;
      font-size: 11px;
      font-weight: 700;
      color: var(--text-light);
      transition: all .3s;
      position: relative;
      z-index: 1;
    }

    .step.active .step-dot {
      background: var(--teal-light);
      color: #fff;
      box-shadow: 0 0 0 4px rgba(38,102,127,.18);
    }

    .step.done .step-dot {
      background: var(--success);
      color: #fff;
    }

    .step-label {
      font-size: 10px;
      font-weight: 600;
      color: var(--text-light);
      text-transform: uppercase;
      letter-spacing: .05em;
      white-space: nowrap;
    }

    .step.active .step-label { color: var(--teal-light); }

    /* ── FORM BODY ── */
    .form-body {
      padding: 36px 40px 32px;
    }

    /* Section title */
    .section-title {
      font-size: 11px;
      font-weight: 700;
      color: var(--text-light);
      text-transform: uppercase;
      letter-spacing: .1em;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section-title::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #eef2f7;
    }

    /* Form group */
    .form-group {
      margin-bottom: 22px;
    }

    .form-label {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 8px;
    }

    .form-label .req {
      color: var(--danger);
      font-size: 15px;
      line-height: 1;
    }

    .form-label .opt {
      font-size: 11px;
      font-weight: 400;
      color: var(--text-light);
      background: #f1f5f9;
      padding: 2px 7px;
      border-radius: 100px;
    }

    /* Input base */
    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid #e2e8f0;
      border-radius: var(--radius-sm);
      font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      color: var(--text-dark);
      background: #fafbfc;
      transition: all .2s;
      outline: none;
    }

    .form-control::placeholder { color: var(--text-light); }

    .form-control:focus {
      border-color: var(--teal-light);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(38,102,127,.1);
    }

    .form-control:hover:not(:focus) { border-color: #cbd5e1; }

    /* Input with icon */
    .input-wrap {
      position: relative;
    }

    .input-wrap .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      font-size: 16px;
      pointer-events: none;
      transition: color .2s;
    }

    .input-wrap:focus-within .input-icon { color: var(--teal-light); }
    .input-wrap .form-control { padding-left: 42px; }

    /* Select */
    select.form-control {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-color: #fafbfc;
      padding-right: 40px;
    }

    /* Textarea */
    textarea.form-control {
      min-height: 110px;
      resize: vertical;
      line-height: 1.6;
    }

    /* Severity selector */
    .severity-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }

    .severity-option {
      position: relative;
    }

    .severity-option input[type="radio"] {
      position: absolute;
      opacity: 0;
      width: 0; height: 0;
    }

    .severity-label {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      padding: 14px 10px;
      border: 1.5px solid #e2e8f0;
      border-radius: var(--radius-sm);
      cursor: pointer;
      transition: all .2s;
      background: #fafbfc;
      text-align: center;
    }

    .severity-label:hover { border-color: #cbd5e1; background: #fff; }

    .severity-option input:checked + .severity-label {
      border-color: var(--teal-light);
      background: rgba(38,102,127,.05);
      box-shadow: 0 0 0 3px rgba(38,102,127,.1);
    }

    .severity-option.ringan input:checked + .severity-label { border-color: var(--success); background: rgba(46,184,114,.05); box-shadow: 0 0 0 3px rgba(46,184,114,.1); }
    .severity-option.sedang input:checked + .severity-label { border-color: var(--accent); background: rgba(232,164,74,.05); box-shadow: 0 0 0 3px rgba(232,164,74,.1); }
    .severity-option.berat  input:checked + .severity-label { border-color: var(--danger); background: rgba(224,82,82,.05); box-shadow: 0 0 0 3px rgba(224,82,82,.1); }

    .severity-emoji { font-size: 22px; }

    .severity-text {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .severity-desc {
      font-size: 10px;
      color: var(--text-light);
      line-height: 1.3;
    }

    /* Divider */
    .divider {
      height: 1px;
      background: #eef2f7;
      margin: 28px 0;
    }

    /* Upload area */
    .upload-zone {
      border: 2px dashed #e2e8f0;
      border-radius: var(--radius-sm);
      padding: 24px;
      text-align: center;
      background: #fafbfc;
      transition: all .2s;
      cursor: pointer;
    }

    .upload-zone:hover { border-color: var(--teal-light); background: rgba(38,102,127,.03); }
    .upload-zone.drag-over { border-color: var(--teal-light); background: rgba(38,102,127,.06); }

    .upload-zone-icon {
      font-size: 32px;
      margin-bottom: 10px;
    }

    .upload-zone-text {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-mid);
      margin-bottom: 4px;
    }

    .upload-zone-sub {
      font-size: 11px;
      color: var(--text-light);
      margin-bottom: 14px;
    }

    .upload-btns {
      display: flex;
      gap: 10px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .upload-btn {
      padding: 9px 18px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      border: 1.5px solid;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .upload-btn.gallery {
      background: #fff;
      color: var(--teal-light);
      border-color: var(--teal-light);
    }

    .upload-btn.gallery:hover {
      background: var(--teal-light);
      color: #fff;
    }

    .upload-btn.camera {
      background: #fff;
      color: #6366f1;
      border-color: #6366f1;
    }

    .upload-btn.camera:hover {
      background: #6366f1;
      color: #fff;
    }

    /* Preview */
    .preview-box {
      display: none;
      margin-top: 16px;
      border-radius: var(--radius-sm);
      overflow: hidden;
      position: relative;
      border: 1.5px solid #e2e8f0;
    }

    .preview-box.show { display: block; }

    .preview-box img {
      width: 100%;
      max-height: 280px;
      object-fit: contain;
      display: block;
      background: #f1f5f9;
    }

    .preview-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
    }

    .preview-name {
      font-size: 12px;
      color: var(--text-mid);
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .btn-remove {
      background: none;
      border: none;
      color: var(--danger);
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 4px;
      font-family: 'DM Sans', sans-serif;
      padding: 4px 8px;
      border-radius: 6px;
      transition: background .2s;
    }

    .btn-remove:hover { background: rgba(224,82,82,.08); }

    /* Webcam */
    .webcam-box {
      display: none;
      margin-top: 16px;
      border-radius: var(--radius-sm);
      overflow: hidden;
      border: 1.5px solid var(--teal-light);
    }

    .webcam-box.show { display: block; }

    #webcam {
      width: 100%;
      display: block;
    }

    .webcam-controls {
      display: flex;
      gap: 10px;
      padding: 12px;
      background: #f8fafc;
    }

    .webcam-btn {
      flex: 1;
      padding: 10px;
      border: none;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: all .2s;
    }

    .webcam-btn.capture { background: var(--success); color: #fff; }
    .webcam-btn.capture:hover { background: #25a064; }
    .webcam-btn.cancel  { background: #fee2e2; color: var(--danger); }
    .webcam-btn.cancel:hover  { background: var(--danger); color: #fff; }

    /* Submit button */
    .btn-submit {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-light) 100%);
      color: #fff;
      border: none;
      border-radius: var(--radius-sm);
      font-size: 15px;
      font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      transition: all .25s;
      position: relative;
      overflow: hidden;
      letter-spacing: .02em;
    }

    .btn-submit::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.12), transparent);
      opacity: 0;
      transition: opacity .2s;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(26,95,115,.4);
    }

    .btn-submit:hover::before { opacity: 1; }
    .btn-submit:active { transform: translateY(0); }

    /* Back link */
    .back-link {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      margin-top: 16px;
      color: rgba(36, 55, 228, 0.75);
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      transition: color .2s;
    }

    .back-link:hover { color: #fff; }

    /* Hidden file input */
    #foto { display: none; }

    /* Responsive */
    @media (max-width: 576px) {
      body { padding: 20px 16px; align-items: flex-start; }
      .card-header { padding: 28px 24px 24px; }
      .card-header h1 { font-size: 22px; }
      .form-body { padding: 28px 24px 24px; }
      .steps { padding: 16px 24px; }
      .step-label { display: none; }
      .severity-grid { grid-template-columns: repeat(3,1fr); gap: 8px; }
      .severity-label { padding: 10px 6px; }
      .severity-desc { display: none; }
    }
  </style>
</head>
<body>
  <div class="page-wrap">

    <div class="card">

      <!-- Header -->
      <div class="card-header">
        <div class="header-badge">Sistem Inventaris</div>
        <h1>Form Pengaduan Kerusakan</h1>
        <p>Ditjen Cipta Karya — Silakan isi formulir di bawah ini dengan lengkap</p>
      </div>

      <!-- Step indicator -->
      <div class="steps">
        <div class="step active" id="step1">
          <div class="step-dot">1</div>
          <span class="step-label">Identitas</span>
        </div>
        <div class="step" id="step2">
          <div class="step-dot">2</div>
          <span class="step-label">Barang</span>
        </div>
        <div class="step" id="step3">
          <div class="step-dot">3</div>
          <span class="step-label">Detail</span>
        </div>
        <div class="step" id="step4">
          <div class="step-dot">4</div>
          <span class="step-label">Foto</span>
        </div>
      </div>

      <!-- Form -->
      <div class="form-body">

        @if(session('success'))
          <script>
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: '{{ session('success') }}',
              confirmButtonColor: '#26667F',
              confirmButtonText: 'OK'
            });
          </script>
        @endif

        @if($errors->any())
          <script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '{{ $errors->first() }}',
              confirmButtonColor: '#e05252',
              confirmButtonText: 'OK'
            });
          </script>
        @endif

        <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data" id="formPengaduan">
          @csrf

          <!-- Seksi 1: Identitas Pelapor -->
          <div class="section-title">Identitas Pelapor</div>

          <div class="form-group">
            <label class="form-label">
              Nama Pelapor <span class="req">*</span>
            </label>
            <div class="input-wrap">
              <span class="input-icon">👤</span>
              <input type="text" name="nama_pelapor" class="form-control"
                     placeholder="Masukkan nama lengkap Anda"
                     value="{{ old('nama_pelapor') }}" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">
              Email <span class="opt">Opsional</span>
            </label>
            <div class="input-wrap">
              <span class="input-icon">✉️</span>
              <input type="email" name="email_pelapor" class="form-control"
                     placeholder="contoh@email.com"
                     value="{{ old('email_pelapor') }}">
            </div>
          </div>

          <div class="divider"></div>

          <!-- Seksi 2: Info Barang -->
          <div class="section-title">Informasi Barang</div>

          <div class="form-group">
            <label class="form-label">
              Barang yang Rusak <span class="req">*</span>
            </label>
            <select name="id_item" class="form-control" required>
              <option value="">— Pilih Barang —</option>
              @foreach($items as $item)
                <option value="{{ $item->id_item }}" {{ old('id_item') == $item->id_item ? 'selected' : '' }}>
                  {{ $item->kode_barang }} — {{ $item->nama_item }} ({{ $item->merk }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">
              Tingkat Kerusakan <span class="req">*</span>
            </label>
            <div class="severity-grid">
              <div class="severity-option ringan">
                <input type="radio" name="tingkat_kerusakan" id="ringan" value="Ringan"
                       {{ old('tingkat_kerusakan') == 'Ringan' ? 'checked' : '' }} required>
                <label class="severity-label" for="ringan">
                  <span class="severity-emoji">🟢</span>
                  <span class="severity-text">Ringan</span>
                  <span class="severity-desc">Masih bisa digunakan</span>
                </label>
              </div>
              <div class="severity-option sedang">
                <input type="radio" name="tingkat_kerusakan" id="sedang" value="Sedang"
                       {{ old('tingkat_kerusakan') == 'Sedang' ? 'checked' : '' }}>
                <label class="severity-label" for="sedang">
                  <span class="severity-emoji">🟡</span>
                  <span class="severity-text">Sedang</span>
                  <span class="severity-desc">Perlu segera diperbaiki</span>
                </label>
              </div>
              <div class="severity-option berat">
                <input type="radio" name="tingkat_kerusakan" id="berat" value="Berat"
                       {{ old('tingkat_kerusakan') == 'Berat' ? 'checked' : '' }}>
                <label class="severity-label" for="berat">
                  <span class="severity-emoji">🔴</span>
                  <span class="severity-text">Berat</span>
                  <span class="severity-desc">Tidak bisa digunakan</span>
                </label>
              </div>
            </div>
          </div>

          <div class="divider"></div>

          <!-- Seksi 3: Deskripsi -->
          <div class="section-title">Detail Kerusakan</div>

          <div class="form-group">
            <label class="form-label">
              Deskripsi Kerusakan <span class="req">*</span>
            </label>
            <textarea name="deskripsi" class="form-control"
                      placeholder="Jelaskan secara detail kerusakan yang terjadi, kapan terjadi, dan dampaknya..."
                      required>{{ old('deskripsi') }}</textarea>
          </div>

          <div class="divider"></div>

          <!-- Seksi 4: Foto -->
          <div class="section-title">Foto Kerusakan</div>

          <div class="form-group">
            <input type="file" name="foto" id="foto"
                   accept="image/jpeg,image/png,image/jpg"
                   onchange="handleFileSelect(this)">

            <div class="upload-zone" id="uploadZone" onclick="document.getElementById('foto').click()">
              <div class="upload-zone-icon">🖼️</div>
              <div class="upload-zone-text">Tambahkan foto kerusakan</div>
              <div class="upload-zone-sub">JPG, JPEG, PNG — Maks. 2MB</div>
              <div class="upload-btns" onclick="event.stopPropagation()">
                <button type="button" class="upload-btn gallery"
                        onclick="document.getElementById('foto').click()">
                  📁 Pilih dari Galeri
                </button>
                <button type="button" class="upload-btn camera" onclick="openWebcam()">
                  📷 Ambil Foto
                </button>
              </div>
            </div>

            <!-- Preview -->
            <div class="preview-box" id="previewBox">
              <img id="previewImage" src="" alt="Preview">
              <div class="preview-bar">
                <span class="preview-name">
                  📎 <span id="previewName">foto-kerusakan.jpg</span>
                </span>
                <button type="button" class="btn-remove" onclick="removePhoto()">
                  ✕ Hapus
                </button>
              </div>
            </div>

            <!-- Webcam -->
            <div class="webcam-box" id="webcamBox">
              <video id="webcam" autoplay playsinline></video>
              <canvas id="canvas" style="display:none"></canvas>
              <div class="webcam-controls">
                <button type="button" class="webcam-btn capture" onclick="capturePhoto()">
                  📸 Ambil Foto
                </button>
                <button type="button" class="webcam-btn cancel" onclick="closeWebcam()">
                  ✕ Batal
                </button>
              </div>
            </div>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn-submit">
            🛠️ &nbsp;Kirim Pengaduan
          </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
          ← Kembali ke Halaman Login
        </a>

      </div>
    </div><!-- /card -->

  </div><!-- /page-wrap -->

  <script>
    let stream = null;

    // ── Step indicator update on scroll/focus ──
    const fields = [
      { el: document.querySelector('[name="nama_pelapor"]'), step: 'step1' },
      { el: document.querySelector('[name="id_item"]'),      step: 'step2' },
      { el: document.querySelector('[name="deskripsi"]'),    step: 'step3' },
    ];

    fields.forEach(({ el, step }) => {
      el?.addEventListener('focus', () => {
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        document.getElementById(step)?.classList.add('active');
      });
    });

    // ── File select ──
    function handleFileSelect(input) {
      if (!input.files || !input.files[0]) return;
      const file = input.files[0];

      if (file.size > 2 * 1024 * 1024) {
        Swal.fire({ icon:'error', title:'File Terlalu Besar', text:'Maksimal 2MB', confirmButtonColor:'#e05252' });
        input.value = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('previewImage').src = e.target.result;
        document.getElementById('previewName').textContent = file.name;
        document.getElementById('previewBox').classList.add('show');
        document.getElementById('uploadZone').style.display = 'none';
        document.getElementById('step4').classList.add('done');
      };
      reader.readAsDataURL(file);
    }

    // ── Remove photo ──
    function removePhoto() {
      document.getElementById('foto').value = '';
      document.getElementById('previewBox').classList.remove('show');
      document.getElementById('uploadZone').style.display = 'block';
      document.getElementById('step4').classList.remove('done');
    }

    // ── Webcam ──
    async function openWebcam() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode:'environment' } });
        document.getElementById('webcam').srcObject = stream;
        document.getElementById('webcamBox').classList.add('show');
        document.getElementById('uploadZone').style.display = 'none';
      } catch {
        Swal.fire({ icon:'error', title:'Gagal Membuka Kamera', text:'Berikan izin akses kamera', confirmButtonColor:'#e05252' });
      }
    }

    function closeWebcam() {
      stream?.getTracks().forEach(t => t.stop());
      stream = null;
      document.getElementById('webcamBox').classList.remove('show');
      document.getElementById('uploadZone').style.display = 'block';
    }

    function capturePhoto() {
      const video = document.getElementById('webcam');
      const canvas = document.getElementById('canvas');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      canvas.getContext('2d').drawImage(video, 0, 0);

      canvas.toBlob(blob => {
        const file = new File([blob], 'webcam-capture.jpg', { type:'image/jpeg' });
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('foto').files = dt.files;

        document.getElementById('previewImage').src = canvas.toDataURL('image/jpeg');
        document.getElementById('previewName').textContent = 'webcam-capture.jpg';
        document.getElementById('previewBox').classList.add('show');
        document.getElementById('step4').classList.add('done');
        closeWebcam();

        Swal.fire({ icon:'success', title:'Foto Berhasil Diambil!', timer:1500, showConfirmButton:false });
      }, 'image/jpeg', 0.9);
    }

    // ── Drag & drop ──
    const zone = document.getElementById('uploadZone');
    zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
      e.preventDefault();
      zone.classList.remove('drag-over');
      const file = e.dataTransfer.files[0];
      if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        const input = document.getElementById('foto');
        input.files = dt.files;
        handleFileSelect(input);
      }
    });

    // ── Form submit ──
    document.getElementById('formPengaduan').addEventListener('submit', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Kirim Pengaduan?',
        text: 'Pastikan semua data sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#26667F',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Periksa Lagi'
      }).then(result => {
        if (result.isConfirmed) {
          Swal.fire({ title:'Mengirim...', text:'Mohon tunggu', allowOutsideClick:false, didOpen:() => Swal.showLoading() });
          e.target.submit();
        }
      });
    });

    window.addEventListener('beforeunload', () => closeWebcam());
  </script>
</body>
</html>