@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Pengaduan Kerusakan Inventaris</h4>
            <p class="text-muted">Kelola dan pantau pengaduan kerusakan barang</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Menunggu</p>
                            <h3 class="mb-0">{{ $stats['menunggu'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-gear text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Diproses</p>
                            <h3 class="mb-0">{{ $stats['diproses'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Selesai</p>
                            <h3 class="mb-0">{{ $stats['selesai'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-file-text text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Pengaduan</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Tabel -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Daftar Pengaduan</h5>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <form method="GET" action="{{ route('pengaduan.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tingkat Kerusakan</label>
                                <select name="tingkat" class="form-select">
                                    <option value="">Semua Tingkat</option>
                                    <option value="Ringan" {{ request('tingkat') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="Sedang" {{ request('tingkat') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="Berat" {{ request('tingkat') == 'Berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Tanggal</th>
                                    <th>Pelapor</th>
                                    <th>Barang</th>
                                    <th>Tingkat</th>
                                    <th>Status</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengaduan as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($pengaduan->currentPage() - 1) * $pengaduan->perPage() }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $item->nama_pelapor }}</strong><br>
                                        <small class="text-muted">{{ $item->email_pelapor ?: '-' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $item->item->nama_item }}</strong><br>
                                        <small class="text-muted">{{ $item->item->kode_barang }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->tingkat_badge }}">
                                            {{ $item->tingkat_kerusakan }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->status_badge }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pengaduan.show', $item->id_pengaduan) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <p class="text-muted mb-0">Tidak ada data pengaduan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $pengaduan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection