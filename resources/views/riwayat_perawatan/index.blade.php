@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Perawatan</h2>
        <a href="{{ route('riwayat-perawatan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Perawatan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('riwayat-perawatan.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>Filter Barang</label>
                        <select name="id_item" class="form-select">
                            <option value="">Semua Barang</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id_item }}" {{ request('id_item') == $item->id_item ? 'selected' : '' }}>
                                    {{ $item->nama_item }} ({{ $item->kode_barang }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="Ditunda" {{ request('status') == 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Jenis Perawatan</label>
                        <select name="jenis_perawatan" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="Perbaikan" {{ request('jenis_perawatan') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            <option value="Penggantian" {{ request('jenis_perawatan') == 'Penggantian' ? 'selected' : '' }}>Penggantian</option>
                            <option value="Pembersihan" {{ request('jenis_perawatan') == 'Pembersihan' ? 'selected' : '' }}>Pembersihan</option>
                            <option value="Kalibrasi" {{ request('jenis_perawatan') == 'Kalibrasi' ? 'selected' : '' }}>Kalibrasi</option>
                            <option value="Maintenance" {{ request('jenis_perawatan') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jenis Perawatan</th>
                            <th>Teknisi</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th>Aksi</th>
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
                                        <span class="badge bg-warning">Dalam Proses</span>
                                    @else
                                        <span class="badge bg-secondary">Ditunda</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('riwayat-perawatan.show', $data->id_perawatan) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('riwayat-perawatan.edit', $data->id_perawatan) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('riwayat-perawatan.destroy', $data->id_perawatan) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus?')" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data riwayat perawatan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $riwayat->links() }}
            </div>
        </div>
    </div>
</div>
@endsection