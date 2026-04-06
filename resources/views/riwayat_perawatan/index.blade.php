@extends('layouts.template')

@section('content')
<style>
  body { font-family:'Times New Roman',Times,serif; background:#f7f8fc; }

  .pg-title { font-size:clamp(1.2rem,3vw,1.6rem); font-weight:700; color:#0f172a; margin:0 0 .2rem; letter-spacing:-.01em; }
  .pg-subtitle { font-size:.82rem; color:#94a3b8; margin:0; }

  .stat-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:.75rem; margin-bottom:1.5rem; }
  @media(min-width:768px){ .stat-grid { grid-template-columns:repeat(4,1fr); gap:1rem; } }
  .stat-card { background:#fff; border:1px solid #e8edf5; border-radius:14px; padding:1rem 1.1rem; display:flex; align-items:center; gap:.875rem; transition:box-shadow .2s,transform .2s; }
  .stat-card:hover { box-shadow:0 6px 24px rgba(15,23,42,.08); transform:translateY(-2px); }
  .stat-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0; }
  .stat-label { font-size:.7rem; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.15rem; }
  .stat-value { font-size:1.55rem; font-weight:700; line-height:1; color:#0f172a; }

  .pg-panel { background:#fff; border:1px solid #e8edf5; border-radius:18px; overflow:hidden; }
  .pg-panel__head { padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; gap:.75rem; flex-wrap:wrap; }
  .pg-panel__title { font-size:.95rem; font-weight:700; color:#0f172a; margin:0; }

  .pg-filter { padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; }
  .pg-select-f {
    font-family:'Times New Roman',Times,serif; font-size:.82rem;
    padding:.45rem .85rem; border:1px solid #e2e8f0; border-radius:9px;
    background:#f8fafc; color:#334155; outline:none; width:100%;
    transition:border-color .15s, box-shadow .15s;
  }
  .pg-select-f:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.1); }

  .pg-btn {
    font-family:'Times New Roman',Times,serif; font-size:.82rem; font-weight:700;
    padding:.45rem 1rem; border-radius:9px; border:none; cursor:pointer;
    display:inline-flex; align-items:center; gap:.35rem;
    transition:all .15s; text-decoration:none; white-space:nowrap;
  }
  .pg-btn-primary { background:#0f172a; color:#fff; }
  .pg-btn-primary:hover { background:#1e293b; color:#fff; box-shadow:0 4px 14px rgba(15,23,42,.2); }
  .pg-btn-ghost   { background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; }
  .pg-btn-ghost:hover { background:#e2e8f0; color:#334155; text-decoration:none; }
  .pg-btn-amber   { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; box-shadow:0 2px 8px rgba(245,158,11,.3); }
  .pg-btn-amber:hover { background:linear-gradient(135deg,#d97706,#b45309); color:#fff; box-shadow:0 4px 14px rgba(245,158,11,.4); }
  .pg-btn-pdf     { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }
  .pg-btn-pdf:hover { background:#b91c1c; color:#fff; border-color:#b91c1c; }

  .pg-table-wrap { overflow-x:auto; }
  .pg-table { width:100%; border-collapse:collapse; font-size:.86rem; }
  .pg-table thead th { padding:.8rem 1.1rem; font-size:.7rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#94a3b8; background:#f8fafc; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
  .pg-table tbody td { padding:.9rem 1.1rem; border-bottom:1px solid #f8fafc; vertical-align:middle; }
  .pg-table tbody tr:last-child td { border-bottom:none; }
  .pg-table tbody tr:hover { background:#fafbfe; }
  .cell-num  { font-size:.75rem; color:#cbd5e1; font-weight:600; }
  .cell-name { font-weight:600; color:#0f172a; }
  .cell-sub  { font-size:.75rem; color:#94a3b8; }
  .cell-code { font-family:'SF Mono','Fira Code',monospace; font-size:.72rem; color:#6366f1; background:#f5f3ff; padding:.15rem .4rem; border-radius:5px; border:1px solid #e0e7ff; display:inline-block; }
  .cell-money { font-weight:600; color:#0f172a; }

  .badge-pill { display:inline-flex; align-items:center; gap:.3rem; font-size:.71rem; font-weight:700; padding:.28rem .7rem; border-radius:999px; letter-spacing:.03em; white-space:nowrap; }
  .badge-pill::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }
  .bp-selesai  { background:#f0fdf4; color:#15803d; }
  .bp-proses   { background:#eff6ff; color:#1d4ed8; }
  .bp-ditunda  { background:#fffbeb; color:#b45309; }
  .bp-jenis    { background:#f5f3ff; color:#6366f1; border:1px solid #e0e7ff; font-size:.7rem; padding:.22rem .6rem; border-radius:999px; font-weight:600; display:inline-block; }

  .btn-act { width:30px; height:30px; border-radius:7px; display:inline-flex; align-items:center; justify-content:center; transition:all .15s; text-decoration:none; font-size:.8rem; cursor:pointer; border:1px solid transparent; }
  .btn-act-view  { background:#f8fafc; border-color:#e2e8f0; color:#64748b; }
  .btn-act-view:hover { background:#0f172a; color:#fff; border-color:#0f172a; }
  .btn-act-edit  { background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8; }
  .btn-act-edit:hover { background:#1d4ed8; color:#fff; border-color:#1d4ed8; }
  .btn-act-del   { background:#fef2f2; border-color:#fecaca; color:#b91c1c; }
  .btn-act-del:hover  { background:#b91c1c; color:#fff; border-color:#b91c1c; }

  .m-list { display:flex; flex-direction:column; gap:.625rem; padding:.875rem; }
  .m-card { border:1px solid #e8edf5; border-radius:12px; background:#fff; overflow:hidden; transition:box-shadow .2s; }
  .m-card:hover { box-shadow:0 4px 16px rgba(15,23,42,.07); }
  .m-card__head { padding:.8rem .95rem; display:flex; justify-content:space-between; align-items:flex-start; gap:.5rem; border-bottom:1px solid #f8fafc; }
  .m-card__body { padding:.65rem .95rem; display:flex; flex-direction:column; gap:.3rem; font-size:.81rem; color:#64748b; }
  .m-card__body-row { display:flex; align-items:center; gap:.4rem; }
  .m-card__footer { padding:.625rem .95rem; border-top:1px solid #f1f5f9; display:flex; gap:.5rem; align-items:center; }

  .pg-empty { text-align:center; padding:3.5rem 1rem; color:#cbd5e1; }
  .pg-empty i { font-size:2.5rem; display:block; margin-bottom:.75rem; }
  .pg-empty p { font-size:.875rem; margin:0; }

  .pg-pager { padding:1rem 1.25rem; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.75rem; }
  .pg-pager__info { font-size:.8rem; color:#94a3b8; }
  .pg-pager__info strong { color:#334155; }

  .pg-alert { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:.875rem 1.1rem; font-size:.85rem; color:#15803d; display:flex; align-items:center; gap:.6rem; margin-bottom:1.5rem; }
  .pg-alert .btn-close { margin-left:auto; opacity:.5; }

  /* Period filter bar */
  .period-bar { background:#fff; border:1px solid #e8edf5; border-radius:14px; padding:.875rem 1.1rem; margin-bottom:1.25rem; display:flex; flex-wrap:wrap; align-items:center; gap:.75rem; }
  .period-select { font-family:'Times New Roman',Times,serif; font-size:.82rem; padding:.4rem .8rem; border:1px solid #e2e8f0; border-radius:9px; background:#f8fafc; color:#334155; outline:none; cursor:pointer; }
  .period-select:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.1); }

  @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
  .anim { animation:fadeUp .4s ease both; }
  .a1{animation-delay:.04s} .a2{animation-delay:.08s}
  .a3{animation-delay:.12s} .a4{animation-delay:.16s} .a5{animation-delay:.22s}

  @media(max-width:575px){
    .pg-title { font-size:1.2rem; }
    .stat-grid { gap:.5rem; }
  }
</style>

@php
    $namaBulanFull = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
    ];
@endphp

<div class="container-fluid px-3 px-md-4 py-4">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-start gap-3 mb-4 anim">
    <div>
      <h1 class="pg-title">Riwayat <span style="color:#f59e0b">Perawatan</span></h1>
      <p class="pg-subtitle">Histori pemeliharaan seluruh barang inventaris</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('export.riwayat-perawatan') }}" target="_blank" class="pg-btn pg-btn-pdf">
        <i class="fas fa-file-pdf"></i>
        <span class="d-none d-sm-inline">Export PDF</span>
      </a>
      <a href="{{ route('riwayat-perawatan.create') }}" class="pg-btn pg-btn-amber">
        <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Tambah Data</span>
        <span class="d-sm-none">Tambah</span>
      </a>
    </div>
  </div>

  {{-- Alert --}}
  @if(session('success'))
  <div class="pg-alert anim" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

    {{-- Simpan bulan & tahun di filter barang juga --}}
    <input type="hidden" name="bulan" id="hiddenBulan" value="{{ $bulan }}">
    <input type="hidden" name="tahun" id="hiddenTahun" value="{{ $tahun }}">
  </form>

  {{-- Stats — dihitung dari data bulan yang dipilih --}}
  <div class="stat-grid">
    <div class="stat-card anim a1">
      <div class="stat-icon" style="background:#fff7ed;color:#f59e0b"><i class="fas fa-wrench"></i></div>
      <div>
        <div class="stat-label">Total</div>
        <div class="stat-value">{{ $riwayat->total() }}</div>
      </div>
    </div>
    <div class="stat-card anim a2">
      <div class="stat-icon" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-check-circle"></i></div>
      <div>
        <div class="stat-label">Selesai</div>
        <div class="stat-value" style="color:#15803d">{{ $riwayat->getCollection()->where('status','Selesai')->count() }}</div>
      </div>
    </div>
    <div class="stat-card anim a3">
      <div class="stat-icon" style="background:#eff6ff;color:#3b82f6"><i class="fas fa-cog"></i></div>
      <div>
        <div class="stat-label">Dalam Proses</div>
        <div class="stat-value" style="color:#1d4ed8">{{ $riwayat->getCollection()->where('status','Dalam Proses')->count() }}</div>
      </div>
    </div>
    <div class="stat-card anim a4">
      <div class="stat-icon" style="background:#fffbeb;color:#f59e0b"><i class="fas fa-pause-circle"></i></div>
      <div>
        <div class="stat-label">Ditunda</div>
        <div class="stat-value" style="color:#b45309">{{ $riwayat->getCollection()->where('status','Ditunda')->count() }}</div>
      </div>
    </div>
  </div>

  {{-- Panel --}}
  <div class="pg-panel anim a5">

    <div class="pg-panel__head">
      <p class="pg-panel__title">
        Daftar Riwayat Perawatan
        <span style="font-size:.78rem;font-weight:400;color:#94a3b8;margin-left:.5rem;">
          — {{ $namaBulanFull[$bulan] }} {{ $tahun }}
        </span>
      </p>
    </div>

    {{-- Filter Barang/Status/Jenis --}}
    <div class="pg-filter">
      <form method="GET" action="{{ route('riwayat-perawatan.index') }}">
        {{-- Simpan periode yang sedang aktif agar tidak hilang saat filter --}}
        <input type="hidden" name="bulan" value="{{ $bulan }}">
        <input type="hidden" name="tahun" value="{{ $tahun }}">

        <div class="row g-2 align-items-end">
          <div class="col-12 col-md-4 col-lg-3">
            <select name="id_item" class="pg-select-f">
              <option value="">Semua Barang</option>
              @foreach($items as $item)
              <option value="{{ $item->id_item }}" {{ request('id_item')==$item->id_item?'selected':'' }}>
                {{ $item->nama_item }} ({{ $item->kode_barang }})
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-6 col-md-3 col-lg-2">
            <select name="status" class="pg-select-f">
              <option value="">Semua Status</option>
              <option value="Selesai"      {{ request('status')=='Selesai'?'selected':'' }}>Selesai</option>
              <option value="Dalam Proses" {{ request('status')=='Dalam Proses'?'selected':'' }}>Dalam Proses</option>
              <option value="Ditunda"      {{ request('status')=='Ditunda'?'selected':'' }}>Ditunda</option>
            </select>
          </div>
          <div class="col-6 col-md-3 col-lg-2">
            <select name="jenis_perawatan" class="pg-select-f">
              <option value="">Semua Jenis</option>
              @foreach(['Perbaikan','Penggantian','Pembersihan','Kalibrasi','Maintenance'] as $j)
              <option value="{{ $j }}" {{ request('jenis_perawatan')==$j?'selected':'' }}>{{ $j }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 col-md-2 col-lg-2 d-flex gap-2">
            <button type="submit" class="pg-btn pg-btn-primary flex-fill">
              <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('riwayat-perawatan.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="pg-btn pg-btn-ghost flex-fill justify-content-center">Reset</a>
          </div>
        </div>
      </form>
    </div>

    {{-- Desktop Table --}}
    <div class="pg-table-wrap d-none d-lg-block">
      <table class="pg-table">
        <thead>
          <tr>
            <th width="44">#</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Jenis</th>
            <th>Teknisi</th>
            <th>Biaya</th>
            <th>Status</th>
            <th width="96">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($riwayat as $key => $data)
          @php
            $sc = match($data->status) {
              'Selesai'      => 'bp-selesai',
              'Dalam Proses' => 'bp-proses',
              default        => 'bp-ditunda',
            };
          @endphp
          <tr>
            <td><span class="cell-num">{{ $riwayat->firstItem() + $key }}</span></td>
            <td>
              <span style="font-size:.84rem;color:#334155">
                {{ $data->tanggal_perawatan->format('d M Y') }}
              </span>
            </td>
            <td>
              <div class="cell-name">{{ $data->item->nama_item }}</div>
              <span class="cell-code">{{ $data->item->kode_barang }}</span>
            </td>
            <td><span class="bp-jenis">{{ $data->jenis_perawatan }}</span></td>
            <td><span style="font-size:.84rem;color:#334155">{{ $data->teknisi }}</span></td>
            <td><span class="cell-money">{{ $data->formatted_biaya }}</span></td>
            <td><span class="badge-pill {{ $sc }}">{{ $data->status }}</span></td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('riwayat-perawatan.show', $data->id_perawatan) }}"
                   class="btn-act btn-act-view" title="Detail">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('riwayat-perawatan.edit', $data->id_perawatan) }}"
                   class="btn-act btn-act-edit" title="Edit">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                <button type="button" class="btn-act btn-act-del" title="Hapus"
                        onclick="deleteData('{{ route('riwayat-perawatan.destroy', $data->id_perawatan) }}')">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="8">
            <div class="pg-empty">
              <i class="fas fa-inbox"></i>
              <p>Tidak ada data perawatan di {{ $namaBulanFull[$bulan] }} {{ $tahun }}</p>
            </div>
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Mobile Cards --}}
    <div class="m-list d-lg-none">
      @forelse($riwayat as $data)
      @php
        $sc = match($data->status) {
          'Selesai'      => 'bp-selesai',
          'Dalam Proses' => 'bp-proses',
          default        => 'bp-ditunda',
        };
      @endphp
      <div class="m-card">
        <div class="m-card__head">
          <div>
            <div class="cell-name" style="font-size:.875rem">{{ $data->item->nama_item }}</div>
            <span class="cell-code">{{ $data->item->kode_barang }}</span>
          </div>
          <span class="badge-pill {{ $sc }}">{{ $data->status }}</span>
        </div>
        <div class="m-card__body">
          <div class="m-card__body-row">
            <i class="fas fa-calendar" style="font-size:.8rem;color:#6366f1"></i>
            {{ $data->tanggal_perawatan->format('d M Y') }}
          </div>
          <div class="m-card__body-row">
            <i class="fas fa-tools" style="font-size:.8rem;color:#f59e0b"></i>
            <span class="bp-jenis">{{ $data->jenis_perawatan }}</span>
          </div>
          <div class="m-card__body-row">
            <i class="fas fa-user" style="font-size:.8rem"></i>
            {{ $data->teknisi }}
          </div>
          <div class="m-card__body-row">
            <i class="fas fa-money-bill-wave" style="font-size:.8rem;color:#22c55e"></i>
            <strong style="color:#334155">{{ $data->formatted_biaya }}</strong>
          </div>
        </div>
        <div class="m-card__footer">
          <a href="{{ route('riwayat-perawatan.show', $data->id_perawatan) }}"
             class="btn-act btn-act-view" title="Detail"><i class="fas fa-eye"></i></a>
          <a href="{{ route('riwayat-perawatan.edit', $data->id_perawatan) }}"
             class="btn-act btn-act-edit" title="Edit"><i class="fas fa-pencil-alt"></i></a>
          <button type="button" class="btn-act btn-act-del" title="Hapus"
                  onclick="deleteData('{{ route('riwayat-perawatan.destroy', $data->id_perawatan) }}')">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
      @empty
      <div class="pg-empty">
        <i class="fas fa-inbox"></i>
        <p>Tidak ada data perawatan di {{ $namaBulanFull[$bulan] }} {{ $tahun }}</p>
      </div>
      @endforelse
    </div>

    {{-- Pagination --}}
    @if($riwayat->hasPages())
    <div class="pg-pager">
      <span class="pg-pager__info">
        Menampilkan <strong>{{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }}</strong>
        dari <strong>{{ $riwayat->total() }}</strong> data
      </span>
      {{ $riwayat->links() }}
    </div>
    @endif

  </div>
</div>

{{-- Delete form --}}
<form id="deleteForm" method="POST" style="display:none">
  @csrf @method('DELETE')
</form>

@push('scripts')
<script>
function deleteData(url) {
  if (confirm('Yakin ingin menghapus data perawatan ini?')) {
    const f = document.getElementById('deleteForm');
    f.action = url; f.submit();
  }
}
</script>
@endpush
@endsection