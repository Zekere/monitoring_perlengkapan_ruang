@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">✏️ Edit Ruangan</h2>
            <p class="text-muted">Ubah informasi ruangan</p>
        </div>
    </div>

    <!-- Menampilkan Pesan Error jika ada -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Edit Ruangan -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('ruangan.update', $ruangan->id_ruangan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Ruangan</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $ruangan->nama_ruangan) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Ruangan</button>
            </form>
        </div>
    </div>
</div>
@endsection
