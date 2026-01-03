@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Riwayat Perawatan</h2>
        <div>
            <a href="{{ route('riwayat-perawatan.edit', $riwayat->id_perawatan) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('riwayat-perawatan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Perawatan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Tanggal Perawatan:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $riwayat->tanggal_perawatan->format('d F Y') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Jenis Perawatan:</strong>
                        </div>
                        <div class="col-md-8">
                            <span class="badge bg-info">{{ $riwayat->jenis_perawatan }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Teknisi:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $riwayat->teknisi }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Biaya:</strong>
                        </div>
                        <div class="col-md-8">
                            <span class="text-success fw-bold">{{ $riwayat->formatted_biaya }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-md-8">
                            @if($riwayat->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($riwayat->status == 'Dalam Proses')
                                <span class="badge bg-warning">Dalam Proses</span>
                            @else
                                <span class="badge bg-secondary">Ditunda</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <strong>Deskripsi Perawatan:</strong>
                        <p class="mt-2 text-muted">{{ $riwayat->deskripsi }}</p>
                    </div>

                    @if($riwayat->catatan)
                        <div class="mb-3">
                            <strong>Catatan Tambahan:</strong>
                            <p class="mt-2 text-muted">{{ $riwayat->catatan }}</p>
                        </div>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus"></i> Dibuat: {{ $riwayat->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="fas fa-calendar-check"></i> Diperbarui: {{ $riwayat->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Barang</h5>
                </div>
                <div class="card-body">
                    @if($riwayat->item->foto)
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/' . $riwayat->item->foto) }}" 
                                 alt="{{ $riwayat->item->nama_item }}" 
                                 class="img-fluid rounded"
                                 style="max-height: 200px;">
                        </div>
                    @endif

                    <div class="mb-2">
                        <strong>Kode Barang:</strong>
                        <p class="mb-0">{{ $riwayat->item->kode_barang }}</p>
                    </div>

                    <div class="mb-2">
                        <strong>Nama Barang:</strong>
                        <p class="mb-0">{{ $riwayat->item->nama_item }}</p>
                    </div>

                    <div class="mb-2">
                        <strong>Merk:</strong>
                        <p class="mb-0">{{ $riwayat->item->merk }}</p>
                    </div>

                    <div class="mb-2">
                        <strong>Kategori:</strong>
                        <p class="mb-0">{{ $riwayat->item->kategori->nama_kategori ?? '-' }}</p>
                    </div>

                    <div class="mb-2">
                        <strong>Ruangan:</strong>
                        <p class="mb-0">{{ $riwayat->item->ruangan->nama_ruangan ?? '-' }}</p>
                    </div>

                    <div class="mb-2">
                        <strong>Kondisi Saat Ini:</strong>
                        <p class="mb-0">
                            @if($riwayat->item->kondisi == 'Baik')
                                <span class="badge bg-success">Baik</span>
                            @elseif($riwayat->item->kondisi == 'Rusak Ringan')
                                <span class="badge bg-warning">Rusak Ringan</span>
                            @else
                                <span class="badge bg-danger">Rusak Berat</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection