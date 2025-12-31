    @extends('layouts.template')

    @section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Detail Pengaduan Kerusakan</h4>
                <p class="text-muted">Informasi lengkap pengaduan #{{ $pengaduan->id_pengaduan }}</p>
            </div>
            <div>
                <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <!-- Informasi Pengaduan -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Informasi Pengaduan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Tanggal Pengaduan:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $pengaduan->created_at->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Nama Pelapor:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $pengaduan->nama_pelapor }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Email Pelapor:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $pengaduan->email_pelapor ?: '-' }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge bg-{{ $pengaduan->status_badge }} px-3 py-2">
                                    {{ $pengaduan->status }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Tingkat Kerusakan:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge bg-{{ $pengaduan->tingkat_badge }} px-3 py-2">
                                    {{ $pengaduan->tingkat_kerusakan }}
                                </span>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong class="d-block mb-2">Deskripsi Kerusakan:</strong>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0">{{ $pengaduan->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($pengaduan->foto)
                        <div class="row">
                            <div class="col-12">
                                <strong class="d-block mb-2">Foto Kerusakan:</strong>
                                <div class="text-center">
                                    <img src="{{ asset($pengaduan->foto) }}" 
                                        alt="Foto Kerusakan" 
                                        class="img-fluid rounded border"
                                        style="max-height: 400px; cursor: pointer;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#fotoModal">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Barang -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Informasi Barang</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Kode Barang:</strong>
                            </div>
                            <div class="col-md-8">
                                <code>{{ $pengaduan->item->kode_barang }}</code>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Nama Barang:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $pengaduan->item->nama_item }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Merk:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $pengaduan->item->merk ?: '-' }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Kategori:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge bg-info">{{ $pengaduan->item->kategori->nama_kategori ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Ruangan:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $pengaduan->item->ruangan->nama_ruangan ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Kondisi Barang Saat Ini:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge 
                                    @if($pengaduan->item->kondisi == 'Baik') bg-success
                                    @elseif($pengaduan->item->kondisi == 'Rusak Ringan') bg-warning
                                    @else bg-danger
                                    @endif
                                    px-3 py-2">
                                    {{ $pengaduan->item->kondisi }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Update Status</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengaduan.updateStatus', $pengaduan->id_pengaduan) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label">Status Pengaduan</label>
                                <select name="status" class="form-select" id="statusSelect" required>
                                    <option value="Menunggu" {{ $pengaduan->status == 'Menunggu' ? 'selected' : '' }}>
                                        Menunggu
                                    </option>
                                    <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>
                                        Diproses
                                    </option>
                                    <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_kondisi" id="updateKondisi" value="1">
                                    <label class="form-check-label" for="updateKondisi">
                                        Update kondisi barang
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3" id="kondisiBarangDiv" style="display: none;">
                                <label class="form-label">Kondisi Barang</label>
                                <select name="kondisi_barang" class="form-select">
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline-item d-flex mb-3">
                            <div class="timeline-badge bg-primary rounded-circle p-2 me-3">
                                <i class="bi bi-file-earmark-plus text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ $pengaduan->created_at->format('d M Y, H:i') }}</small>
                                <p class="mb-0"><strong>Pengaduan dibuat</strong></p>
                            </div>
                        </div>
                        
                        @if($pengaduan->updated_at != $pengaduan->created_at)
                        <div class="timeline-item d-flex">
                            <div class="timeline-badge bg-info rounded-circle p-2 me-3">
                                <i class="bi bi-arrow-repeat text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ $pengaduan->updated_at->format('d M Y, H:i') }}</small>
                                <p class="mb-0"><strong>Status diupdate:</strong> {{ $pengaduan->status }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk zoom foto -->
    @if($pengaduan->foto)
    <div class="modal fade" id="fotoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto Kerusakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset($pengaduan->foto) }}" 
                        alt="Foto Kerusakan" 
                        class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    @endif

    @endsection

    @push('scripts')
    <script>
        // Toggle kondisi barang field
        document.getElementById('updateKondisi').addEventListener('change', function() {
            document.getElementById('kondisiBarangDiv').style.display = this.checked ? 'block' : 'none';
        });
    </script>
    @endpush