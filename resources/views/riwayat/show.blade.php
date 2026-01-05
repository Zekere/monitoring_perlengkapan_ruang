@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <!-- Info Barang -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-box"></i> Detail Barang
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" 
                             class="img-fluid rounded" alt="{{ $item->nama_item }}">
                    @else
                        <div class="bg-light p-5 text-center rounded">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <table class="table table-borderless">
                        <tr>
                            <th width="20%">Kode Barang</th>
                            <td>: <strong>{{ $item->kode_barang }}</strong></td>
                            <th width="20%">Kategori</th>
                            <td>: {{ $item->kategori->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Item</th>
                            <td>: {{ $item->nama_item }}</td>
                            <th>Merk</th>
                            <td>: {{ $item->merk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kondisi Saat Ini</th>
                            <td>: 
                                <span class="badge 
                                    @if($item->kondisi == 'Baik') badge-success
                                    @elseif($item->kondisi == 'Rusak Ringan') badge-warning
                                    @else badge-danger
                                    @endif">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <th>Ruangan</th>
                            <td>: {{ $item->ruangan->nama_ruangan ?? 'Belum ada ruangan' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Perubahan -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">
                <i class="fas fa-history"></i> Riwayat Perubahan Barang
            </h4>
        </div>
        <div class="card-body">
            @if($riwayat->count() > 0)
                <div class="timeline">
                    @foreach($riwayat as $r)
                    <div class="timeline-item mb-4">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <small class="text-muted">
                                    <strong>{{ $r->created_at->format('d M Y') }}</strong><br>
                                    {{ $r->created_at->format('H:i:s') }}<br>
                                    <em>{{ $r->created_at->diffForHumans() }}</em>
                                </small>
                            </div>
                            <div class="col-md-1 text-center">
                                <div class="timeline-icon">
                                    @if($r->jenis_perubahan == 'Kondisi')
                                        <i class="fas fa-tools fa-2x text-warning"></i>
                                    @elseif($r->jenis_perubahan == 'Ruangan')
                                        <i class="fas fa-door-open fa-2x text-info"></i>
                                    @elseif($r->jenis_perubahan == 'Semua')
                                        <i class="fas fa-sync fa-2x text-danger"></i>
                                    @else
                                        <i class="fas fa-plus-circle fa-2x text-success"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            @if($r->jenis_perubahan == 'Data' && !$r->kondisi_lama)
                                                <span class="badge badge-success">BARANG BARU</span>
                                            @else
                                                <span class="badge 
                                                    @if($r->jenis_perubahan == 'Kondisi') badge-warning
                                                    @elseif($r->jenis_perubahan == 'Ruangan') badge-info
                                                    @elseif($r->jenis_perubahan == 'Semua') badge-danger
                                                    @else badge-secondary
                                                    @endif">
                                                    {{ strtoupper($r->jenis_perubahan) }}
                                                </span>
                                            @endif
                                            
                                            <small class="float-right text-muted">
                                                <i class="fas fa-user"></i> {{ $r->updated_by }}
                                            </small>
                                        </h5>
                                        
                                        <div class="mt-3">
                                            @if($r->kondisi_lama !== $r->kondisi_baru)
                                                <div class="alert alert-light mb-2">
                                                    <strong><i class="fas fa-wrench"></i> Perubahan Kondisi:</strong><br>
                                                    <div class="mt-2">
                                                        <span class="badge badge-pill badge-light p-2">
                                                            {{ $r->kondisi_lama ?? 'Baru' }}
                                                        </span>
                                                        <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                                        <span class="badge badge-pill p-2
                                                            @if($r->kondisi_baru == 'Baik') badge-success
                                                            @elseif($r->kondisi_baru == 'Rusak Ringan') badge-warning
                                                            @else badge-danger
                                                            @endif">
                                                            {{ $r->kondisi_baru }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                                <div class="alert alert-light mb-2">
                                                    <strong><i class="fas fa-door-open"></i> Perpindahan Ruangan:</strong><br>
                                                    <div class="mt-2">
                                                        <span class="badge badge-pill badge-light p-2">
                                                            {{ $r->ruanganLama->nama_ruangan ?? 'Belum ada ruangan' }}
                                                        </span>
                                                        <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                                        <span class="badge badge-pill badge-info p-2">
                                                            {{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada ruangan' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($r->keterangan)
                                                <div class="alert alert-secondary mb-0">
                                                    <i class="fas fa-sticky-note"></i> <strong>Catatan:</strong><br>
                                                    {{ $r->keterangan }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $riwayat->links() }}
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <h5>Belum ada riwayat perubahan untuk barang ini</h5>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Riwayat
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline-item {
        position: relative;
    }
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 60px;
        height: calc(100% - 40px);
        width: 2px;
        background: #dee2e6;
        transform: translateX(-50%);
    }
    .timeline-icon {
        background: white;
        padding: 10px 0;
        position: relative;
        z-index: 1;
    }
</style>
@endpush