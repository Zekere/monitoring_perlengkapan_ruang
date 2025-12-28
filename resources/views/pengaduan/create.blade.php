<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pengaduan Kerusakan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 40px 20px;
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      background: linear-gradient(135deg, #26667F 0%, #1a4d5f 100%);
      padding: 40px 30px;
      text-align: center;
      color: white;
    }

    .header h1 {
      font-size: 28px;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .header p {
      font-size: 14px;
      opacity: 0.9;
      font-weight: 300;
    }

    .form-wrapper {
      padding: 40px 30px;
    }

    .alert {
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 25px;
      font-size: 14px;
      animation: fadeIn 0.5s ease;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-label {
      display: block;
      font-weight: 500;
      margin-bottom: 8px;
      color: #333;
      font-size: 14px;
    }

    .form-label .required {
      color: #e74c3c;
      margin-left: 3px;
    }

    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      font-family: 'Poppins', sans-serif;
    }

    .form-control:focus {
      outline: none;
      border-color: #26667F;
      box-shadow: 0 0 0 3px rgba(38, 102, 127, 0.1);
    }

    select.form-control {
      cursor: pointer;
      appearance: none;
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E") no-repeat right 16px center;
      background-color: white;
      padding-right: 40px;
    }

    textarea.form-control {
      min-height: 120px;
      resize: vertical;
    }

    .file-input-wrapper {
      position: relative;
    }

    .file-input-wrapper input[type="file"] {
      display: none;
    }

    .upload-options {
      display: flex;
      gap: 15px;
      margin-bottom: 15px;
    }

    .upload-btn {
      flex: 1;
      padding: 12px 16px;
      border: 2px solid #26667F;
      border-radius: 10px;
      background: white;
      color: #26667F;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .upload-btn:hover {
      background: #26667F;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(38, 102, 127, 0.3);
    }

    .upload-btn.active {
      background: #26667F;
      color: white;
    }

    .preview-container {
      margin-top: 15px;
      display: none;
      position: relative;
    }

    .preview-container.show {
      display: block;
    }

    .preview-image {
      width: 100%;
      max-height: 300px;
      object-fit: contain;
      border-radius: 10px;
      border: 2px solid #e0e0e0;
    }

    .remove-photo {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #e74c3c;
      color: white;
      border: none;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      cursor: pointer;
      font-size: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .remove-photo:hover {
      background: #c0392b;
      transform: scale(1.1);
    }

    .webcam-container {
      display: none;
      margin-top: 15px;
    }

    .webcam-container.show {
      display: block;
    }

    #webcam {
      width: 100%;
      border-radius: 10px;
      border: 2px solid #26667F;
    }

    .webcam-controls {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .webcam-btn {
      flex: 1;
      padding: 10px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .webcam-btn.capture {
      background: #27ae60;
      color: white;
    }

    .webcam-btn.capture:hover {
      background: #229954;
    }

    .webcam-btn.cancel {
      background: #e74c3c;
      color: white;
    }

    .webcam-btn.cancel:hover {
      background: #c0392b;
    }

    .btn-submit {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #26667F 0%, #1a4d5f 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(38, 102, 127, 0.3);
    }

    .btn-submit:active {
      transform: translateY(0);
    }

    .btn-back {
      display: inline-block;
      margin-top: 20px;
      color: #26667F;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.3s ease;
      text-align: center;
      width: 100%;
    }

    .btn-back:hover {
      color: #1a4d5f;
    }

    @media (max-width: 576px) {
      .header h1 {
        font-size: 24px;
      }
      
      .form-wrapper {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>📋 Form Pengaduan Kerusakan</h1>
      <p>Inventaris Barang - Ditjen Cipta Karya</p>
    </div>

    <div class="form-wrapper">
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
            confirmButtonColor: '#e74c3c',
            confirmButtonText: 'OK'
          });
        </script>
      @endif

      <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label class="form-label">
            Nama Pelapor <span class="required">*</span>
          </label>
          <input 
            type="text" 
            name="nama_pelapor" 
            class="form-control" 
            placeholder="Masukkan nama Anda"
            value="{{ old('nama_pelapor') }}"
            required
          >
        </div>

        <div class="form-group">
          <label class="form-label">Email (Opsional)</label>
          <input 
            type="email" 
            name="email_pelapor" 
            class="form-control" 
            placeholder="contoh@email.com"
            value="{{ old('email_pelapor') }}"
          >
        </div>

        <div class="form-group">
          <label class="form-label">
            Pilih Barang yang Rusak <span class="required">*</span>
          </label>
          <select name="id_item" class="form-control" required>
            <option value="">-- Pilih Barang --</option>
            @foreach($items as $item)
              <option value="{{ $item->id_item }}" {{ old('id_item') == $item->id_item ? 'selected' : '' }}>
                {{ $item->kode_barang }} - {{ $item->nama_item }} ({{ $item->merk }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">
            Tingkat Kerusakan <span class="required">*</span>
          </label>
          <select name="tingkat_kerusakan" class="form-control" required>
            <option value="">-- Pilih Tingkat Kerusakan --</option>
            <option value="Ringan" {{ old('tingkat_kerusakan') == 'Ringan' ? 'selected' : '' }}>
              🟢 Ringan - Masih bisa digunakan dengan sedikit perbaikan
            </option>
            <option value="Sedang" {{ old('tingkat_kerusakan') == 'Sedang' ? 'selected' : '' }}>
              🟡 Sedang - Memerlukan perbaikan segera
            </option>
            <option value="Berat" {{ old('tingkat_kerusakan') == 'Berat' ? 'selected' : '' }}>
              🔴 Berat - Tidak dapat digunakan sama sekali
            </option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">
            Deskripsi Kerusakan <span class="required">*</span>
          </label>
          <textarea 
            name="deskripsi" 
            class="form-control" 
            placeholder="Jelaskan detail kerusakan yang terjadi..."
            required
          >{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Foto Kerusakan (Opsional)</label>
          
          <div class="upload-options">
            <button type="button" class="upload-btn" onclick="chooseFromGallery()">
              📁 Pilih dari Galeri
            </button>
            <button type="button" class="upload-btn" onclick="openWebcam()">
              📷 Ambil Foto
            </button>
          </div>

          <div class="file-input-wrapper">
            <input 
              type="file" 
              name="foto" 
              id="foto" 
              accept="image/jpeg,image/png,image/jpg"
              onchange="handleFileSelect(this)"
            >
          </div>

          <!-- Preview Container -->
          <div class="preview-container" id="previewContainer">
            <img id="previewImage" class="preview-image" src="" alt="Preview">
            <button type="button" class="remove-photo" onclick="removePhoto()">✕</button>
          </div>

          <!-- Webcam Container -->
          <div class="webcam-container" id="webcamContainer">
            <video id="webcam" autoplay playsinline></video>
            <canvas id="canvas" style="display: none;"></canvas>
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

        <button type="submit" class="btn-submit">
          🛠️ Kirim Pengaduan
        </button>

        <a href="{{ route('login') }}" class="btn-back">
          ← Kembali ke Halaman Login
        </a>
      </form>
    </div>
  </div>

  <script>
    let stream = null;
    let capturedImageData = null;

    // Pilih dari Galeri
    function chooseFromGallery() {
      document.getElementById('foto').click();
    }

    // Handle file selection dari galeri
    function handleFileSelect(input) {
      if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validasi ukuran file (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
          Swal.fire({
            icon: 'error',
            title: 'File Terlalu Besar',
            text: 'Ukuran file maksimal 2MB',
            confirmButtonColor: '#e74c3c'
          });
          input.value = '';
          return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('previewImage').src = e.target.result;
          document.getElementById('previewContainer').classList.add('show');
          capturedImageData = null;
        };
        reader.readAsDataURL(file);
      }
    }

    // Buka Webcam
    async function openWebcam() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({ 
          video: { facingMode: 'environment' } 
        });
        
        const video = document.getElementById('webcam');
        video.srcObject = stream;
        
        document.getElementById('webcamContainer').classList.add('show');
        document.getElementById('previewContainer').classList.remove('show');
        
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal Membuka Kamera',
          text: 'Pastikan Anda memberikan izin akses kamera',
          confirmButtonColor: '#e74c3c'
        });
      }
    }

    // Tutup Webcam
    function closeWebcam() {
      if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
      }
      document.getElementById('webcamContainer').classList.remove('show');
    }

    // Capture Foto dari Webcam
    function capturePhoto() {
      const video = document.getElementById('webcam');
      const canvas = document.getElementById('canvas');
      const context = canvas.getContext('2d');
      
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0);
      
      // Convert to blob
      canvas.toBlob(function(blob) {
        // Create file from blob
        const file = new File([blob], 'webcam-capture.jpg', { type: 'image/jpeg' });
        
        // Create FileList-like object
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById('foto').files = dataTransfer.files;
        
        // Show preview
        const imageUrl = canvas.toDataURL('image/jpeg');
        document.getElementById('previewImage').src = imageUrl;
        document.getElementById('previewContainer').classList.add('show');
        
        // Close webcam
        closeWebcam();
        
        Swal.fire({
          icon: 'success',
          title: 'Foto Berhasil Diambil!',
          timer: 1500,
          showConfirmButton: false
        });
        
      }, 'image/jpeg', 0.9);
    }

    // Hapus Foto
    function removePhoto() {
      document.getElementById('foto').value = '';
      document.getElementById('previewContainer').classList.remove('show');
      capturedImageData = null;
    }

    // Form Submit Validation
    document.querySelector('form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      Swal.fire({
        title: 'Kirim Pengaduan?',
        text: 'Pastikan semua data sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#26667F',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Periksa Lagi'
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading
          Swal.fire({
            title: 'Mengirim...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
          
          // Submit form
          e.target.submit();
        }
      });
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
      closeWebcam();
    });
  </script>
</body>
</html>