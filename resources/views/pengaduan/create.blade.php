<!DOCTYPE html>
<html>
<head>
    <title>Form Pengaduan Kerusakan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            min-height: 100px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <h2>🛠️ Form Pengaduan Kerusakan Inventaris</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama Pelapor *</label>
            <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" required>
        </div>

        <div class="form-group">
            <label>Email Pelapor (Opsional)</label>
            <input type="email" name="email_pelapor" value="{{ old('email_pelapor') }}">
        </div>

        <div class="form-group">
            <label>Pilih Barang *</label>
            <select name="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id_item }}" {{ old('barang_id') == $barang->id_item ? 'selected' : '' }}>
                        {{ $barang->nama_item }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Tingkat Kerusakan *</label>
            <select name="tingkat_kerusakan" required>
                <option value="">-- Pilih Tingkat Kerusakan --</option>
                <option value="Ringan" {{ old('tingkat_kerusakan') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                <option value="Sedang" {{ old('tingkat_kerusakan') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="Berat" {{ old('tingkat_kerusakan') == 'Berat' ? 'selected' : '' }}>Berat</option>
            </select>
        </div>

        <div class="form-group">
            <label>Deskripsi Kerusakan *</label>
            <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Foto Kerusakan (Opsional)</label>
            <input type="file" name="foto" accept="image/*">
        </div>

        <button type="submit">Kirim Pengaduan</button>
    </form>

    <br>
    <a href="{{ url('/') }}">⬅ Kembali</a>
</body>
</html>