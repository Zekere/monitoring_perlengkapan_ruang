@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pengaduan Kerusakan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Pengaduan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengaduan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengaduan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $menunggu }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diproses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $diproses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selesai Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $selesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengaduan Kerusakan</h6>
            <div>
                <button class="btn btn-sm btn-primary" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Email</th>
                            <th>Barang</th>
                            <th>Tingkat Kerusakan</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                            <td>{{ $item->nama_pelapor }}</td>
                            <td>{{ $item->email_pelapor ?? '-' }}</td>
                            <td>
                                <strong>{{ $item->barang->nama_item }}</strong><br>
                                <small class="text-muted">{{ $item->barang->kode_barang }}</small><br>
                                <small class="text-muted">Merk: {{ $item->barang->merk }}</small>
                            </td>
                            <td>
                                @if($item->tingkat_kerusakan == 'Ringan')
                                    <span class="badge badge-warning">Ringan</span>
                                @elseif($item->tingkat_kerusakan == 'Sedang')
                                    <span class="badge badge-orange">Sedang</span>
                                @else
                                    <span class="badge badge-danger">Berat</span>
                                @endif
                            </td>
                            <td>
                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ Str::limit($item->deskripsi, 50) }}
                                </div>
                            </td>
                            <td>
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" 
                                         alt="Foto Kerusakan" 
                                         class="img-thumbnail"
                                         style="max-width: 80px; cursor: pointer;"
                                         data-toggle="modal" 
                                         data-target="#fotoModal{{ $item->id_pengaduan }}">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'Menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($item->status == 'Diproses')
                                    <span class="badge badge-info">Diproses</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal{{ $item->id_pengaduan }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#statusModal{{ $item->id_pengaduan }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.pengaduan.destroy', $item->id_pengaduan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $item->id_pengaduan }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pengaduan #{{ $item->id_pengaduan }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="font-weight-bold">Informasi Pelapor</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td width="40%">Nama</td>
                                                        <td>: {{ $item->nama_pelapor }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>: {{ $item->email_pelapor ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Lapor</td>
                                                        <td>: {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="font-weight-bold">Informasi Barang</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td width="40%">Kode Barang</td>
                                                        <td>: {{ $item->barang->kode_barang }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Barang</td>
                                                        <td>: {{ $item->barang->nama_item }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Merk</td>
                                                        <td>: {{ $item->barang->merk }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ruangan</td>
                                                        <td>: {{ $item->barang->ruangan->nama_ruangan ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <hr>
                                        <h6 class="font-weight-bold">Detail Kerusakan</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <td width="20%">Tingkat Kerusakan</td>
                                                <td>: 
                                                    @if($item->tingkat_kerusakan == 'Ringan')
                                                        <span class="badge badge-warning">Ringan</span>
                                                    @elseif($item->tingkat_kerusakan == 'Sedang')
                                                        <span class="badge badge-orange">Sedang</span>
                                                    @else
                                                        <span class="badge badge-danger">Berat</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deskripsi</td>
                                                <td>: {{ $item->deskripsi }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>: 
                                                    @if($item->status == 'Menunggu')
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    @elseif($item->status == 'Diproses')
                                                        <span class="badge badge-info">Diproses</span>
                                                    @else
                                                        <span class="badge badge-success">Selesai</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                        @if($item->foto)
                                        <div class="mt-3">
                                            <h6 class="font-weight-bold">Foto Kerusakan</h6>
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Kerusakan" class="img-fluid" style="max-height: 400px;">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Update Status -->
                        <div class="modal fade" id="statusModal{{ $item->id_pengaduan }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Status Pengaduan</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.pengaduan.updateStatus', $item->id_pengaduan) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Status Saat Ini</label>
                                                <input type="text" class="form-control" value="{{ $item->status }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Status Baru <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                    <option value="Diproses" {{ $item->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Foto -->
                        @if($item->foto)
                        <div class="modal fade" id="fotoModal{{ $item->id_pengaduan }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Foto Kerusakan</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Kerusakan" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data pengaduan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .badge-orange {
        background-color: #ff6600;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "order": [[1, "desc"]]
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush