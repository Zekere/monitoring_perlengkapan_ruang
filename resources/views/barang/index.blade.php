@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">📦 Daftar Barang</h2>
            <p class="text-muted">Kelola semua barang inventaris</p>
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
                            <h3 class="mb-0">{{ $items->total() }}</h3>
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
                            <h3 class="mb-0">{{ $items->where('kondisi', 'Baik')->count() }}</h3>
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
                            <h3 class="mb-0">{{ $items->where('kondisi', 'Rusak Ringan')->count() }}</h3>
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
                            <h3 class="mb-0">{{ $items->where('kondisi', 'Rusak Berat')->count() }}</h3>
                        </div>
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="🔍 Cari kode/nama/merk..." id="searchInput">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="kategoriFilter">
                        <option value="">🏷️ Semua Kategori</option>
                        @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="lokasiFilter">
                        <option value="">📍 Semua Lokasi</option>
                        @foreach($ruangan as $ruang)
                        <option value="{{ $ruang->id }}">{{ $ruang->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="kondisiFilter">
                        <option value="">🔍 Semua Kondisi</option>
                        <option value="Baik">✅ Baik</option>
                        <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                        <option value="Rusak Berat">❌ Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-secondary" id="resetBtn">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="color: #000;">NO</th>
                            <th style="color: #000;">KODE</th>
                            <th style="color: #000;">NAMA BARANG</th>
                            <th style="color: #000;">KATEGORI</th>
                            <th style="color: #000;">LOKASI</th>
                            <th style="color: #000;">KONDISI</th>
                            <th style="color: #000;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                        <tr>
                            <td style="color: #000;">{{ $items->firstItem() + $index }}</td>
                            <td style="color: #000;">{{ $item->kode_barang }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                    <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-image text-white"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $item->nama_item }}</div>
                                        <small class="text-muted">{{ $item->merk ?: '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td style="color: #000;">{{ $item->kategori->nama_kategori ?? 'Tidak ada' }}</td>
                            <td style="color: #000;">{{ $item->ruangan->nama_ruangan ?? 'Tidak ada' }}</td>
                            <td>
                                @if($item->kondisi == 'Baik')
                                <span class="badge" style="background-color: #28a745; color: white;">Baik</span>
                                @elseif($item->kondisi == 'Rusak Ringan')
                                <span class="badge" style="background-color: #ffc107; color: #000;">Rusak Ringan</span>
                                @else
                                <span class="badge" style="background-color: #dc3545; color: white;">Rusak Berat</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('barang.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('barang.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
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

            @if($items->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }} data
                </div>
                <div>
                    {{ $items->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    // Script untuk filter dan search jika diperlukan
    document.getElementById('resetBtn')?.addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('kategoriFilter').value = '';
        document.getElementById('lokasiFilter').value = '';
        document.getElementById('kondisiFilter').value = '';
    });
</script>
@endpush
@endsection