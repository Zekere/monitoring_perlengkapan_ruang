@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-history"></i> Riwayat Pengecekan Barang
                    </h3>
                </div>
                
                <div class="card-body">
                    <!-- Filter Section -->
                    <form method="GET" action="{{ route('riwayat.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Filter Barang</label>
                                <select name="id_item" class="form-control">
                                    <option value="">Semua Barang</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id_item }}" 
                                            {{ request('id_item') == $item->id_item ? 'selected' : '' }}>
                                            {{ $item->kode_barang }} - {{ $item->nama_item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" 
                                    value="{{ request('start_date') }}">
                            </div>
                            
                            <div class="col-md-3">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control" 
                                    value="{{ request('end_date') }}">
                            </div>
                            
                            <div class="col-md-3">
                                <label>Jenis Perubahan</label>
                                <select name="jenis_perubahan" class="form-control">
                                    <option value="">Semua Jenis</option>
                                    <option value="Kondisi" {{ request('jenis_perubahan') == 'Kondisi' ? 'selected' : '' }}>
                                        Kondisi
                                    </option>
                                    <option value="Ruangan" {{ request('jenis_perubahan') == 'Ruangan' ? 'selected' : '' }}>
                                        Ruangan
                                    </option>
                                    <option value="Semua" {{ request('jenis_perubahan') == 'Semua' ? 'selected' : '' }}>
                                        Semua Perubahan
                                    </option>
                                    <option value="Data" {{ request('jenis_perubahan') == 'Data' ? 'selected' : '' }}>
                                        Data Barang
                                    </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                                <a href="{{ route('riwayat.export.pdf', request()->all()) }}" 
                                   class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="12%">Tanggal & Waktu</th>
                                    <th width="12%">Kode Barang</th>
                                    <th width="15%">Nama Barang</th>
                                    <th width="10%">Jenis</th>
                                    <th>Perubahan</th>
                                    <th width="12%">Diupdate Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $index => $r)
                                <tr>
                                    <td>{{ $riwayat->firstItem() + $index }}</td>
                                    <td>
                                        <small>
                                            <strong>{{ $r->created_at->format('d/m/Y') }}</strong><br>
                                            {{ $r->created_at->format('H:i:s') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('riwayat.show', $r->id_item) }}" 
                                           class="text-primary">
                                            <strong>{{ $r->kode_barang }}</strong>
                                        </a>
                                    </td>
                                    <td>{{ $r->nama_item }}</td>
                                    <td>
                                        @if($r->jenis_perubahan == 'Kondisi')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-tools"></i> Kondisi
                                            </span>
                                        @elseif($r->jenis_perubahan == 'Ruangan')
                                            <span class="badge badge-info">
                                                <i class="fas fa-door-open"></i> Ruangan
                                            </span>
                                        @elseif($r->jenis_perubahan == 'Semua')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-sync"></i> Semua
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-edit"></i> Data
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            @if($r->kondisi_lama !== $r->kondisi_baru)
                                                <div class="mb-1">
                                                    <strong>Kondisi:</strong>
                                                    <span class="badge badge-light">{{ $r->kondisi_lama ?? 'Baru' }}</span>
                                                    <i class="fas fa-arrow-right"></i>
                                                    <span class="badge 
                                                        @if($r->kondisi_baru == 'Baik') badge-success
                                                        @elseif($r->kondisi_baru == 'Rusak Ringan') badge-warning
                                                        @else badge-danger
                                                        @endif">
                                                        {{ $r->kondisi_baru }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                                <div>
                                                    <strong>Ruangan:</strong>
                                                    <span class="badge badge-light">
                                                        {{ $r->ruanganLama->nama_ruangan ?? 'Tidak ada' }}
                                                    </span>
                                                    <i class="fas fa-arrow-right"></i>
                                                    <span class="badge badge-info">
                                                        {{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada' }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($r->keterangan)
                                                <div class="mt-2 text-muted">
                                                    <i class="fas fa-info-circle"></i> {{ $r->keterangan }}
                                                </div>
                                            @endif
                                        </small>
                                    </td>
                                    <td>{{ $r->updated_by }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Tidak ada riwayat ditemukan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $riwayat->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.85em;
        padding: 0.3em 0.6em;
    }
    .table td small {
        font-size: 0.9em;
    }
</style>
@endpush