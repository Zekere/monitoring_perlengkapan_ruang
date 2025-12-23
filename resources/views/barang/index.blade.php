@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
            <i class="fas fa-box-open text-primary me-1"></i>
            Daftar Barang</h2>
            <p class="text-muted mb-0">Kelola seluruh data inventaris barang</p>
        </div>
       
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Barang</p>
                            <h3 class="mb-0">{{ $barang->count() }}</h3>
                        </div>
                        <i class="fas fa-box fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Kondisi Baik</p>
                            <h3 class="mb-0">{{ $barang->where('kondisi', 'Baik')->count() }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Rusak Ringan</p>
                            <h3 class="mb-0">{{ $barang->where('kondisi', 'Rusak Ringan')->count() }}</h3>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Rusak Berat</p>
                            <h3 class="mb-0">{{ $barang->where('kondisi', 'Rusak Berat')->count() }}</h3>
                        </div>
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Tabel -->
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Form Filter -->
            <form method="GET" action="{{ route('barang.index') }}" class="row g-2 mb-3 align-items-center">
    <div class="col-md-3">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="🔍 Cari barang..."
               value="{{ request('search') }}">
    </div>

    <div class="col-md-2">
        <select name="kategori" class="form-select form-select-sm">
            <option value="">🏷️ Semua Kategori</option>
            @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="ruangan" class="form-select form-select-sm">
            <option value="">📍 Semua Ruangan</option>
            @foreach($ruangan as $ruang)
                <option value="{{ $ruang->id_ruangan }}" {{ request('ruangan') == $ruang->id_ruangan ? 'selected' : '' }}>
                    {{ $ruang->nama_ruangan }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="kondisi" class="form-select form-select-sm">
            <option value="">⚙️ Semua Kondisi</option>
            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
        </select>
    </div>

    <div class="col-md-3 text-end">
        <button class="btn btn-primary btn-sm">
            <i class="fas fa-search"></i> Cari
        </button>
        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-rotate"></i> Reset
        </a>
    </div>
</form>


            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Barang</th>
            <th>Kategori</th>
            <th>Ruangan</th>
            <th class="text-center">Kondisi</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
  
                    <tbody>
                        @forelse($barang as $index => $item)
                            <tr>
                                <td style="color: #000;">{{ $index + 1 }}</td>
                                <td style="color: #000;">{{ $item->kode_barang }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="foto" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="color: #000;">{{ $item->nama_item }}</div>
                                            <small class="text-muted">{{ $item->merk }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="color: #000;">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td style="color: #000;">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                                <td>
                                    @if($item->kondisi == 'Baik')
                                        <span class="badge bg-success">{{ $item->kondisi }}</span>
                                    @elseif($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark">{{ $item->kondisi }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $item->kondisi }}</span>
                                    @endif
                                </td>
                                <td>
                                     <a href="{{ route('barang.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                           <form action="{{ route('barang.destroy', $item->id_item) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data barang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($barang, 'hasPages') && $barang->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $barang->firstItem() }} - {{ $barang->lastItem() }} dari {{ $barang->total() }} data
                </div>
                <div>
                    {{ $barang->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection