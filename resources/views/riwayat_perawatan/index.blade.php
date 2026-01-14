@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
        <h4 class="mb-0">Riwayat Perawatan Barang</h4>
        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
            <a href="{{ route('riwayat-perawatan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
            <a href="{{ route('export.riwayat-perawatan') }}" class="btn btn-danger btn-sm" target="_blank">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">
                <i class="fas fa-filter"></i> Filter Data
            </h6>
        </div>
        <div class="card-body p-3">
            <form method="GET" action="{{ route('riwayat-perawatan.index') }}">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label small fw-semibold">Filter Barang</label>
                        <select name="id_item" class="form-select form-select-sm">
                            <option value="">Semua Barang</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id_item }}" {{ request('id_item') == $item->id_item ? 'selected' : '' }}>
                                    {{ $item->nama_item }} ({{ $item->kode_barang }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="Ditunda" {{ request('status') == 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label small fw-semibold">Jenis Perawatan</label>
                        <select name="jenis_perawatan" class="form-select form-select-sm">
                            <option value="">Semua Jenis</option>
                            <option value="Perbaikan" {{ request('jenis_perawatan') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            <option value="Penggantian" {{ request('jenis_perawatan') == 'Penggantian' ? 'selected' : '' }}>Penggantian</option>
                            <option value="Pembersihan" {{ request('jenis_perawatan') == 'Pembersihan' ? 'selected' : '' }}>Pembersihan</option>
                            <option value="Kalibrasi" {{ request('jenis_perawatan') == 'Kalibrasi' ? 'selected' : '' }}>Kalibrasi</option>
                            <option value="Maintenance" {{ request('jenis_perawatan') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label small d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-info btn-sm w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="card shadow-sm d-none d-lg-block">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Barang</th>
                            <th class="py-3">Jenis Perawatan</th>
                            <th class="py-3">Teknisi</th>
                            <th class="py-3">Biaya</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $key => $data)
                            <tr>
                                <td>{{ $riwayat->firstItem() + $key }}</td>
                                <td>{{ $data->tanggal_perawatan->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $data->item->nama_item }}</strong><br>
                                    <small class="text-muted">{{ $data->item->kode_barang }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $data->jenis_perawatan }}</span>
                                </td>
                                <td>{{ $data->teknisi }}</td>
                                <td>{{ $data->formatted_biaya }}</td>
                                <td>
                                    @if($data->status == 'Selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($data->status == 'Dalam Proses')
                                        <span class="badge bg-warning text-dark">Dalam Proses</span>
                                    @else
                                        <span class="badge bg-secondary">Ditunda</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('riwayat-perawatan.show', $data->id_perawatan) }}" 
                                           class="btn btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('riwayat-perawatan.edit', $data->id_perawatan) }}" 
                                           class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="deleteData('{{ route('riwayat-perawatan.destroy', $data->id_perawatan) }}')" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Tidak ada data riwayat perawatan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="d-lg-none">
        @forelse($riwayat as $key => $data)
            <div class="card shadow-sm mb-3">
                <div class="card-body p-3">
                    <!-- Header Card -->
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1 fw-bold">{{ $data->item->nama_item }}</h6>
                            <small class="text-muted">{{ $data->item->kode_barang }}</small>
                        </div>
                        <div>
                            @if($data->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($data->status == 'Dalam Proses')
                                <span class="badge bg-warning text-dark">Dalam Proses</span>
                            @else
                                <span class="badge bg-secondary">Ditunda</span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-2">

                    <!-- Info Grid -->
                    <div class="row g-2 small">
                        <div class="col-6">
                            <div class="text-muted">Tanggal</div>
                            <div class="fw-semibold">{{ $data->tanggal_perawatan->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Jenis</div>
                            <div><span class="badge bg-info">{{ $data->jenis_perawatan }}</span></div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Teknisi</div>
                            <div class="fw-semibold">{{ $data->teknisi }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Biaya</div>
                            <div class="fw-semibold text-primary">{{ $data->formatted_biaya }}</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('riwayat-perawatan.show', $data->id_perawatan) }}" 
                           class="btn btn-info btn-sm flex-fill">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('riwayat-perawatan.edit', $data->id_perawatan) }}" 
                           class="btn btn-warning btn-sm flex-fill">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" 
                                onclick="deleteData('{{ route('riwayat-perawatan.destroy', $data->id_perawatan) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Tidak ada data riwayat perawatan</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($riwayat->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $riwayat->links() }}
        </div>
    @endif
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
/* Mobile Optimizations */
@media (max-width: 576px) {
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
    }
    
    h4 {
        font-size: 1.1rem;
    }
    
    h6 {
        font-size: 0.95rem;
    }
    
    .card-body {
        font-size: 0.9rem;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.5rem;
    }
}

/* Tablet Optimizations */
@media (min-width: 577px) and (max-width: 991px) {
    .table {
        font-size: 0.9rem;
    }
    
    .btn-sm {
        font-size: 0.85rem;
    }
}

/* Touch-friendly buttons */
@media (max-width: 991px) {
    .btn {
        min-height: 38px;
    }
    
    .form-select, .form-control {
        min-height: 38px;
    }
}

/* Card hover effect */
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

@media (hover: hover) {
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }
}

/* Improve table readability on mobile */
.table-responsive {
    border-radius: 0.375rem;
}

.table thead th {
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

/* Badge improvements */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Empty state */
.fa-inbox {
    opacity: 0.3;
}
</style>

<script>
function deleteData(url) {
    if (confirm('Yakin ingin menghapus data ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = url;
        form.submit();
    }
}
</script>
@endsection