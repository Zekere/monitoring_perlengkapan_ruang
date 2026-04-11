@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <!-- Info Barang -->
    <div class="card mb-3 mb-md-4 shadow-sm">
        <div class="card-header bg-primary text-white p-2 p-md-3">
            <h4 class="mb-0 fs-5 fs-md-4">
                <i class="fas fa-box"></i> Detail Barang
            </h4>
        </div>
        <div class="card-body p-2 p-md-3">
            <div class="row g-2 g-md-3">
                <!-- Image Section -->
                <div class="col-12 col-md-3 col-lg-2">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}"
                             class="img-fluid rounded w-100"
                             alt="{{ $item->nama_item }}"
                             style="max-height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light p-4 text-center rounded">
                            <i class="fas fa-image fa-3x text-muted"></i>
                            <p class="small text-muted mt-2 mb-0">Tidak ada foto</p>
                        </div>
                    @endif
                </div>

                <!-- Info Section -->
                <div class="col-12 col-md-9 col-lg-10">
                    <!-- Desktop Table View -->
                    <div class="d-none d-md-block">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th class="small" width="20%">Kode Barang</th>
                                <td class="small">: <strong>{{ $item->kode_barang }}</strong></td>
                                <th class="small" width="20%">Kategori</th>
                                <td class="small">: {{ $item->kategori->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="small">Nama Item</th>
                                <td class="small">: {{ $item->nama_item }}</td>
                                <th class="small">Merk</th>
                                <td class="small">: {{ $item->merk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="small">Kondisi Saat Ini</th>
                                <td>:
                                    <span class="badge
                                        @if($item->kondisi == 'Baik') bg-success
                                        @elseif($item->kondisi == 'Rusak Ringan') bg-warning text-dark
                                        @else bg-danger
                                        @endif small">
                                        {{ $item->kondisi }}
                                    </span>
                                </td>
                                <th class="small">Ruangan</th>
                                <td class="small">: {{ $item->ruangan->nama_ruangan ?? 'Belum ada ruangan' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        <div class="mb-2">
                            <strong class="small d-block text-muted">Kode Barang</strong>
                            <strong>{{ $item->kode_barang }}</strong>
                        </div>
                        <div class="mb-2">
                            <strong class="small d-block text-muted">Nama Item</strong>
                            <span class="small">{{ $item->nama_item }}</span>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <strong class="small d-block text-muted">Kategori</strong>
                                <span class="small">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                            </div>
                            <div class="col-6">
                                <strong class="small d-block text-muted">Merk</strong>
                                <span class="small">{{ $item->merk ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <strong class="small d-block text-muted">Kondisi</strong>
                                <span class="badge
                                    @if($item->kondisi == 'Baik') bg-success
                                    @elseif($item->kondisi == 'Rusak Ringan') bg-warning text-dark
                                    @else bg-danger
                                    @endif" style="font-size: 0.7rem;">
                                    {{ $item->kondisi }}
                                </span>
                            </div>
                            <div class="col-6">
                                <strong class="small d-block text-muted">Ruangan</strong>
                                <span class="small">{{ $item->ruangan->nama_ruangan ?? 'Belum ada' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Perubahan -->
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white p-2 p-md-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fs-5 fs-md-4">
                <i class="fas fa-history"></i> Riwayat Perubahan Barang
            </h4>
            <span class="badge bg-white text-info">
                {{ $riwayat->count() }} data
            </span>
        </div>
        <div class="card-body p-2 p-md-3">
            @if($riwayat->count() > 0)
                <div class="timeline">
                    @foreach($riwayat as $r)
                    <div class="timeline-item mb-3 mb-md-4">

                        <!-- Desktop Timeline View -->
                        <div class="row d-none d-md-flex">
                            <div class="col-md-2 text-end">
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
                                    @elseif($r->jenis_perubahan == 'Foto')
                                        <i class="fas fa-image fa-2x" style="color: #6f42c1;"></i>
                                    @else
                                        <i class="fas fa-plus-circle fa-2x text-success"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title small">
                                            @if($r->jenis_perubahan == 'Data' && !$r->kondisi_lama)
                                                <span class="badge bg-success">BARANG BARU</span>
                                            @elseif($r->jenis_perubahan == 'Foto')
                                                <span class="badge" style="background-color: #6f42c1;">FOTO</span>
                                            @else
                                                <span class="badge
                                                    @if($r->jenis_perubahan == 'Kondisi') bg-warning text-dark
                                                    @elseif($r->jenis_perubahan == 'Ruangan') bg-info
                                                    @elseif($r->jenis_perubahan == 'Semua') bg-danger
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ strtoupper($r->jenis_perubahan) }}
                                                </span>
                                            @endif
                                            <small class="float-end text-muted">
                                                <i class="fas fa-user"></i> {{ $r->updated_by }}
                                            </small>
                                        </h5>

                                        <div class="mt-3">
                                            @if($r->kondisi_lama !== $r->kondisi_baru)
                                                <div class="alert alert-light mb-2">
                                                    <strong class="small"><i class="fas fa-wrench"></i> Perubahan Kondisi:</strong><br>
                                                    <div class="mt-2">
                                                        <span class="badge bg-light text-dark p-2 small">
                                                            {{ $r->kondisi_lama ?? 'Baru' }}
                                                        </span>
                                                        <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                                        <span class="badge p-2 small
                                                            @if($r->kondisi_baru == 'Baik') bg-success
                                                            @elseif($r->kondisi_baru == 'Rusak Ringan') bg-warning text-dark
                                                            @else bg-danger
                                                            @endif">
                                                            {{ $r->kondisi_baru }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                                <div class="alert alert-light mb-2">
                                                    <strong class="small"><i class="fas fa-door-open"></i> Perpindahan Ruangan:</strong><br>
                                                    <div class="mt-2">
                                                        <span class="badge bg-light text-dark p-2 small">
                                                            {{ $r->ruanganLama->nama_ruangan ?? 'Belum ada ruangan' }}
                                                        </span>
                                                        <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                                        <span class="badge bg-info p-2 small">
                                                            {{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada ruangan' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($r->jenis_perubahan == 'Foto')
                                                <div class="alert alert-light mb-2">
                                                    <strong class="small"><i class="fas fa-image"></i> Perubahan Foto:</strong><br>
                                                    <div class="mt-2 d-flex align-items-center gap-3">
                                                        <!-- Foto Lama -->
                                                        <div class="text-center">
                                                            @if($r->foto_lama)
                                                                <img src="{{ asset('storage/' . $r->foto_lama) }}"
                                                                     class="img-thumbnail foto-preview"
                                                                     style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;"
                                                                     alt="Foto Lama"
                                                                     data-foto-lama="{{ asset('storage/' . $r->foto_lama) }}"
                                                                     data-foto-baru="{{ $r->foto_baru ? asset('storage/' . $r->foto_baru) : '' }}"
                                                                     onclick="bukaModalFoto(this)">
                                                            @else
                                                                <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                                                     style="width: 80px; height: 60px;">
                                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <small class="d-block text-muted mt-1" style="font-size: 0.7rem;">Sebelum</small>
                                                        </div>

                                                        <i class="fas fa-long-arrow-alt-right fa-lg text-muted"></i>

                                                        <!-- Foto Baru -->
                                                        <div class="text-center">
                                                            @if($r->foto_baru)
                                                                <img src="{{ asset('storage/' . $r->foto_baru) }}"
                                                                     class="img-thumbnail foto-preview"
                                                                     style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;"
                                                                     alt="Foto Baru"
                                                                     data-foto-lama="{{ $r->foto_lama ? asset('storage/' . $r->foto_lama) : '' }}"
                                                                     data-foto-baru="{{ asset('storage/' . $r->foto_baru) }}"
                                                                     onclick="bukaModalFoto(this)">
                                                            @else
                                                                <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                                                     style="width: 80px; height: 60px;">
                                                                    <i class="fas fa-ban fa-2x text-danger"></i>
                                                                </div>
                                                            @endif
                                                            <small class="d-block text-muted mt-1" style="font-size: 0.7rem;">Sesudah</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($r->keterangan)
                                                <div class="alert alert-secondary mb-0">
                                                    <i class="fas fa-sticky-note"></i>
                                                    <strong class="small">Catatan:</strong><br>
                                                    <span class="small">{{ $r->keterangan }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Timeline View -->
                        <div class="d-md-none">
                            <div class="card shadow-sm border">
                                <div class="card-body p-2">
                                    <!-- Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            @if($r->jenis_perubahan == 'Data' && !$r->kondisi_lama)
                                                <span class="badge bg-success" style="font-size: 0.7rem;">BARANG BARU</span>
                                            @elseif($r->jenis_perubahan == 'Foto')
                                                <span class="badge" style="background-color: #6f42c1; font-size: 0.7rem;">FOTO</span>
                                            @else
                                                <span class="badge
                                                    @if($r->jenis_perubahan == 'Kondisi') bg-warning text-dark
                                                    @elseif($r->jenis_perubahan == 'Ruangan') bg-info
                                                    @elseif($r->jenis_perubahan == 'Semua') bg-danger
                                                    @else bg-secondary
                                                    @endif" style="font-size: 0.7rem;">
                                                    {{ strtoupper($r->jenis_perubahan) }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            @if($r->jenis_perubahan == 'Kondisi')
                                                <i class="fas fa-tools text-warning"></i>
                                            @elseif($r->jenis_perubahan == 'Ruangan')
                                                <i class="fas fa-door-open text-info"></i>
                                            @elseif($r->jenis_perubahan == 'Semua')
                                                <i class="fas fa-sync text-danger"></i>
                                            @elseif($r->jenis_perubahan == 'Foto')
                                                <i class="fas fa-image" style="color: #6f42c1;"></i>
                                            @else
                                                <i class="fas fa-plus-circle text-success"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Timestamp -->
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i>
                                            {{ $r->created_at->format('d M Y, H:i:s') }}
                                            <em class="d-block">({{ $r->created_at->diffForHumans() }})</em>
                                        </small>
                                    </div>

                                    <!-- Changes -->
                                    @if($r->kondisi_lama !== $r->kondisi_baru)
                                        <div class="mb-2 p-2 bg-light rounded">
                                            <strong class="small d-block"><i class="fas fa-wrench"></i> Kondisi:</strong>
                                            <div class="d-flex align-items-center gap-1 mt-1">
                                                <span class="badge bg-white text-dark border" style="font-size: 0.7rem;">
                                                    {{ $r->kondisi_lama ?? 'Baru' }}
                                                </span>
                                                <i class="fas fa-arrow-right small"></i>
                                                <span class="badge
                                                    @if($r->kondisi_baru == 'Baik') bg-success
                                                    @elseif($r->kondisi_baru == 'Rusak Ringan') bg-warning text-dark
                                                    @else bg-danger
                                                    @endif" style="font-size: 0.7rem;">
                                                    {{ $r->kondisi_baru }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($r->id_ruangan_lama !== $r->id_ruangan_baru)
                                        <div class="mb-2 p-2 bg-light rounded">
                                            <strong class="small d-block"><i class="fas fa-door-open"></i> Ruangan:</strong>
                                            <div class="d-flex align-items-center gap-1 mt-1">
                                                <span class="badge bg-white text-dark border" style="font-size: 0.7rem;">
                                                    {{ $r->ruanganLama->nama_ruangan ?? 'Belum ada' }}
                                                </span>
                                                <i class="fas fa-arrow-right small"></i>
                                                <span class="badge bg-info" style="font-size: 0.7rem;">
                                                    {{ $r->ruanganBaru->nama_ruangan ?? 'Tidak ada' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($r->jenis_perubahan == 'Foto')
                                        <div class="mb-2 p-2 bg-light rounded">
                                            <strong class="small d-block"><i class="fas fa-image"></i> Foto:</strong>
                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                <!-- Foto Lama -->
                                                <div class="text-center">
                                                    @if($r->foto_lama)
                                                        <img src="{{ asset('storage/' . $r->foto_lama) }}"
                                                             class="img-thumbnail foto-preview"
                                                             style="width: 60px; height: 45px; object-fit: cover; cursor: pointer;"
                                                             alt="Foto Lama"
                                                             data-foto-lama="{{ asset('storage/' . $r->foto_lama) }}"
                                                             data-foto-baru="{{ $r->foto_baru ? asset('storage/' . $r->foto_baru) : '' }}"
                                                             onclick="bukaModalFoto(this)">
                                                    @else
                                                        <div class="bg-white border rounded d-flex align-items-center justify-content-center"
                                                             style="width: 60px; height: 45px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <small class="d-block text-muted" style="font-size: 0.65rem;">Sebelum</small>
                                                </div>

                                                <i class="fas fa-arrow-right small text-muted"></i>

                                                <!-- Foto Baru -->
                                                <div class="text-center">
                                                    @if($r->foto_baru)
                                                        <img src="{{ asset('storage/' . $r->foto_baru) }}"
                                                             class="img-thumbnail foto-preview"
                                                             style="width: 60px; height: 45px; object-fit: cover; cursor: pointer;"
                                                             alt="Foto Baru"
                                                             data-foto-lama="{{ $r->foto_lama ? asset('storage/' . $r->foto_lama) : '' }}"
                                                             data-foto-baru="{{ asset('storage/' . $r->foto_baru) }}"
                                                             onclick="bukaModalFoto(this)">
                                                    @else
                                                        <div class="bg-white border rounded d-flex align-items-center justify-content-center"
                                                             style="width: 60px; height: 45px;">
                                                            <i class="fas fa-ban text-danger"></i>
                                                        </div>
                                                    @endif
                                                    <small class="d-block text-muted" style="font-size: 0.65rem;">Sesudah</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($r->keterangan)
                                        <div class="p-2 bg-secondary bg-opacity-10 rounded">
                                            <i class="fas fa-sticky-note"></i>
                                            <strong class="small">Catatan:</strong><br>
                                            <span class="small">{{ $r->keterangan }}</span>
                                        </div>
                                    @endif

                                    <!-- Footer -->
                                    <div class="border-top pt-2 mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> {{ $r->updated_by }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>

                {{-- Pagination dihapus karena sudah pakai get() --}}

            @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-3x fa-md-4x mb-3"></i>
                    <h5 class="fs-6 fs-md-5">Belum ada riwayat perubahan untuk barang ini</h5>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Riwayat
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Timeline Desktop */
@media (min-width: 768px) {
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
        margin-left: -7.5%;
    }
    .timeline-icon {
        background: white;
        padding: 10px 0;
        position: relative;
        z-index: 1;
    }
}

/* Responsive improvements */
@media (max-width: 576px) {
    .fs-5 { font-size: 0.95rem !important; }
    .small { font-size: 0.8rem !important; }
    .card-body { padding: 0.75rem !important; }
    .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.85rem; }
}

.badge { padding: 0.35em 0.65em; font-size: 0.75rem; }
@media (max-width: 576px) {
    .badge { font-size: 0.7rem; padding: 0.25em 0.5em; }
}

.alert { padding: 0.75rem; }
@media (max-width: 576px) {
    .alert { padding: 0.5rem; }
}

.gap-1 { gap: 0.25rem; }
.gap-2 { gap: 0.5rem; }
.gap-3 { gap: 1rem; }

@media (max-width: 576px) {
    .img-fluid { max-height: 150px !important; }
}

@media (max-width: 767px) {
    .timeline-item .card { transition: transform 0.2s; }
    .timeline-item .card:active { transform: scale(0.98); }
}

.border-top { border-top: 1px solid #dee2e6 !important; }
.fa-arrow-right { font-size: 0.7rem; opacity: 0.7; }
.bg-opacity-10 { --bs-bg-opacity: 0.1; }

/* Foto thumbnail hover effect */
.img-thumbnail[onclick] {
    transition: opacity 0.2s, transform 0.2s;
}
.img-thumbnail[onclick]:hover {
    opacity: 0.85;
    transform: scale(1.05);
}

/* Modal Foto */
#modalFoto .modal-dialog { max-width: 800px; }
#modalFoto .nav-tabs .nav-link { font-size: 0.85rem; }
#modalFoto .tab-pane img { max-height: 420px; object-fit: contain; }
#modalFoto .foto-kosong {
    height: 250px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 8px;
    color: #adb5bd;
}
</style>

<!-- Modal Preview Foto -->
<div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="modalFotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 px-3">
                <h6 class="modal-title" id="modalFotoLabel">
                    <i class="fas fa-image me-1"></i> Perbandingan Foto
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-3">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-3" id="fotoTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-sebelum" data-bs-toggle="tab"
                                data-bs-target="#panel-sebelum" type="button" role="tab">
                            <i class="fas fa-image me-1"></i> Sebelum
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-sesudah" data-bs-toggle="tab"
                                data-bs-target="#panel-sesudah" type="button" role="tab">
                            <i class="fas fa-image me-1"></i> Sesudah
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="fotoTabContent">
                    <!-- Panel Sebelum -->
                    <div class="tab-pane fade show active" id="panel-sebelum" role="tabpanel">
                        <div id="wrap-sebelum" class="text-center"></div>
                    </div>
                    <!-- Panel Sesudah -->
                    <div class="tab-pane fade" id="panel-sesudah" role="tabpanel">
                        <div id="wrap-sesudah" class="text-center"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2 px-3 justify-content-between">
                <div id="modal-keterangan" class="text-muted small"></div>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function bukaModalFoto(el) {
    const fotoLama = el.dataset.fotoLama;
    const fotoBaru = el.dataset.fotoBaru;

    // Render panel Sebelum
    const wrapSebelum = document.getElementById('wrap-sebelum');
    if (fotoLama) {
        wrapSebelum.innerHTML = `
            <img src="${fotoLama}" class="img-fluid rounded shadow-sm" style="max-height:420px; object-fit:contain;">
            <p class="small text-muted mt-2 mb-0">Foto sebelum diubah</p>`;
    } else {
        wrapSebelum.innerHTML = `
            <div class="foto-kosong">
                <i class="fas fa-image fa-3x mb-2"></i>
                <span class="small">Belum ada foto sebelumnya</span>
            </div>`;
    }

    // Render panel Sesudah
    const wrapSesudah = document.getElementById('wrap-sesudah');
    if (fotoBaru) {
        wrapSesudah.innerHTML = `
            <img src="${fotoBaru}" class="img-fluid rounded shadow-sm" style="max-height:420px; object-fit:contain;">
            <p class="small text-muted mt-2 mb-0">Foto setelah diubah</p>`;
    } else {
        wrapSesudah.innerHTML = `
            <div class="foto-kosong">
                <i class="fas fa-ban fa-3x mb-2 text-danger"></i>
                <span class="small">Foto dihapus</span>
            </div>`;
    }

    // Keterangan footer
    const keterangan = document.getElementById('modal-keterangan');
    if (fotoLama && fotoBaru) {
        keterangan.innerHTML = '<i class="fas fa-exchange-alt me-1"></i> Foto lama diganti dengan foto baru';
    } else if (!fotoLama && fotoBaru) {
        keterangan.innerHTML = '<i class="fas fa-plus-circle me-1 text-success"></i> Foto baru ditambahkan';
    } else {
        keterangan.innerHTML = '<i class="fas fa-trash me-1 text-danger"></i> Foto dihapus';
    }

    // Reset ke tab Sebelum, lalu buka modal
    const tabSebelum = document.getElementById('tab-sebelum');
    bootstrap.Tab.getOrCreateInstance(tabSebelum).show();

    const modal = new bootstrap.Modal(document.getElementById('modalFoto'));
    modal.show();
}
</script>
@endpush
@endpush