@extends('layouts.template')

@section('content')

<style>
/* ══════════════════════════════════════
   BASE
══════════════════════════════════════ */
.pg-page { padding: 1.5rem 1rem 3rem; }
@media (min-width: 768px) { .pg-page { padding: 2rem 1.5rem 4rem; } }

/* ══════════════════════════════════════
   HEADER
══════════════════════════════════════ */
.pg-header { margin-bottom: 1.75rem; }
.pg-header h1 {
    font-size: clamp(1.2rem, 3vw, 1.6rem);
    font-weight: 700; color: #0f172a;
    margin: 0 0 .25rem; letter-spacing: -.01em;
}
.pg-header p { font-size: .82rem; color: #94a3b8; margin: 0; }

/* ══════════════════════════════════════
   STAT CARDS
══════════════════════════════════════ */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: .75rem;
    margin-bottom: 1.5rem;
}
@media (min-width: 768px) {
    .stat-grid { grid-template-columns: repeat(4, 1fr); gap: 1rem; }
}

.stat-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 14px;
    padding: 1rem 1.1rem;
    display: flex; align-items: center; gap: .875rem;
    transition: box-shadow .2s, transform .2s;
}
.stat-card:hover { box-shadow: 0 6px 24px rgba(15,23,42,.08); transform: translateY(-2px); }

.stat-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.05rem; flex-shrink: 0;
}
.stat-icon--warning { background: #fffbeb; color: #f59e0b; }
.stat-icon--info    { background: #eff6ff; color: #3b82f6; }
.stat-icon--success { background: #f0fdf4; color: #22c55e; }
.stat-icon--primary { background: #f5f3ff; color: #6366f1; }

.stat-label { font-size: .72rem; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .2rem; }
.stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; color: #0f172a; }

/* ══════════════════════════════════════
   PANEL
══════════════════════════════════════ */
.pg-panel {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 18px;
    overflow: hidden;
}
.pg-panel__head {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between; gap: .75rem; flex-wrap: wrap;
}
.pg-panel__title { font-size: .95rem; font-weight: 700; color: #0f172a; margin: 0; }

/* ══════════════════════════════════════
   FILTER
══════════════════════════════════════ */
.pg-filter { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; }
.pg-filter .row { --bs-gutter-x: .5rem; --bs-gutter-y: .5rem; }

.pg-select {
    font-size: .82rem; padding: .45rem .85rem;
    border: 1px solid #e2e8f0; border-radius: 9px;
    background: #f8fafc; color: #334155;
    outline: none; width: 100%;
    transition: border-color .15s, box-shadow .15s;
}
.pg-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }

.pg-btn {
    font-size: .82rem; font-weight: 600;
    padding: .45rem 1rem; border-radius: 9px;
    border: none; cursor: pointer;
    display: inline-flex; align-items: center; gap: .35rem;
    transition: all .15s; text-decoration: none; white-space: nowrap;
}
.pg-btn-primary { background: #0f172a; color: #fff; }
.pg-btn-primary:hover { background: #1e293b; color: #fff; box-shadow: 0 4px 14px rgba(15,23,42,.2); }
.pg-btn-ghost { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
.pg-btn-ghost:hover { background: #e2e8f0; color: #334155; text-decoration: none; }

/* ══════════════════════════════════════
   TABLE
══════════════════════════════════════ */
.pg-table-wrap { overflow-x: auto; }
.pg-table { width: 100%; border-collapse: collapse; font-size: .86rem; }
.pg-table thead th {
    padding: .8rem 1.1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: #94a3b8;
    background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    white-space: nowrap;
}
.pg-table tbody td {
    padding: .9rem 1.1rem;
    border-bottom: 1px solid #f8fafc;
    vertical-align: middle; color: #0f172a;
}
.pg-table tbody tr:last-child td { border-bottom: none; }
.pg-table tbody tr { transition: background .12s; }
.pg-table tbody tr:hover { background: #fafbfe; }

.cell-num { font-size: .75rem; color: #cbd5e1; font-weight: 600; }
.cell-date { font-size: .84rem; color: #334155; }
.cell-date small { font-size: .73rem; color: #94a3b8; display: block; }
.cell-name { font-weight: 600; color: #0f172a; }
.cell-sub  { font-size: .75rem; color: #94a3b8; }
.cell-code {
    font-family: 'SF Mono', 'Fira Code', monospace;
    font-size: .72rem; color: #6366f1;
    background: #f5f3ff; padding: .15rem .4rem;
    border-radius: 5px; border: 1px solid #e0e7ff;
    display: inline-block; margin-top: .15rem;
}

/* ══════════════════════════════════════
   BADGES
══════════════════════════════════════ */
.badge-pill {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .71rem; font-weight: 600;
    padding: .28rem .7rem; border-radius: 999px; letter-spacing: .03em;
    white-space: nowrap;
}
.badge-pill::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }
.badge-menunggu { background:#fffbeb; color:#b45309; }
.badge-diproses  { background:#eff6ff; color:#1d4ed8; }
.badge-selesai   { background:#f0fdf4; color:#15803d; }
.badge-ringan    { background:#f0fdf4; color:#15803d; }
.badge-sedang    { background:#fffbeb; color:#b45309; }
.badge-berat     { background:#fef2f2; color:#b91c1c; }

/* ══════════════════════════════════════
   EYE BUTTON
══════════════════════════════════════ */
.btn-eye {
    width: 32px; height: 32px; border-radius: 8px;
    background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b;
    display: inline-flex; align-items: center; justify-content: center;
    transition: all .15s; text-decoration: none; font-size: .85rem;
}
.btn-eye:hover { background: #0f172a; color: #fff; border-color: #0f172a; }

/* ══════════════════════════════════════
   MOBILE CARDS
══════════════════════════════════════ */
.m-list { display: flex; flex-direction: column; gap: .625rem; padding: .875rem; }
.m-card {
    border: 1px solid #e8edf5; border-radius: 12px;
    background: #fff; overflow: hidden;
    transition: box-shadow .2s;
}
.m-card:hover { box-shadow: 0 4px 16px rgba(15,23,42,.07); }
.m-card__head {
    padding: .8rem .95rem;
    display: flex; justify-content: space-between; align-items: flex-start; gap: .5rem;
    border-bottom: 1px solid #f8fafc;
}
.m-card__body { padding: .65rem .95rem; font-size: .81rem; color: #64748b; display: flex; flex-direction: column; gap: .3rem; }
.m-card__body-row { display: flex; align-items: center; gap: .4rem; }
.m-card__cta {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .65rem; font-size: .82rem; font-weight: 600;
    color: #0f172a; background: #f8fafc;
    border-top: 1px solid #f1f5f9; text-decoration: none;
    transition: background .15s, color .15s;
}
.m-card__cta:hover { background: #0f172a; color: #fff; }

/* ══════════════════════════════════════
   EMPTY STATE
══════════════════════════════════════ */
.pg-empty { text-align: center; padding: 3.5rem 1rem; color: #cbd5e1; }
.pg-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; }
.pg-empty p { font-size: .875rem; margin: 0; }

/* ══════════════════════════════════════
   PAGINATION
══════════════════════════════════════ */
.pg-pager {
    padding: 1rem 1.25rem; border-top: 1px solid #f1f5f9;
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: .75rem;
}
.pg-pager__info { font-size: .8rem; color: #94a3b8; }
.pg-pager__info strong { color: #334155; }

/* ══════════════════════════════════════
   ANIMATE
══════════════════════════════════════ */
@keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
.anim   { animation: fadeUp .4s ease both; }
.a1 { animation-delay:.04s; } .a2 { animation-delay:.08s; }
.a3 { animation-delay:.12s; } .a4 { animation-delay:.16s; }
.a5 { animation-delay:.22s; }
</style>

<div class="pg-page">

    {{-- Header --}}
    <div class="pg-header anim">
        <h1>Pengaduan Kerusakan <span style="color:#6366f1">Inventaris</span></h1>
        <p>Kelola dan pantau pengaduan kerusakan barang</p>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-grid">
        <div class="stat-card anim a1">
            <div class="stat-icon stat-icon--warning"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="stat-label">Menunggu</div>
                <div class="stat-value">{{ $stats['menunggu'] }}</div>
            </div>
        </div>
        <div class="stat-card anim a2">
            <div class="stat-icon stat-icon--info"><i class="bi bi-gear"></i></div>
            <div>
                <div class="stat-label">Diproses</div>
                <div class="stat-value">{{ $stats['diproses'] }}</div>
            </div>
        </div>
        <div class="stat-card anim a3">
            <div class="stat-icon stat-icon--success"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $stats['selesai'] }}</div>
            </div>
        </div>
        <div class="stat-card anim a4">
            <div class="stat-icon stat-icon--primary"><i class="bi bi-file-text"></i></div>
            <div>
                <div class="stat-label">Total</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
        </div>
    </div>

    {{-- Panel --}}
    <div class="pg-panel anim a5">

        {{-- Panel Head --}}
        <div class="pg-panel__head">
            <p class="pg-panel__title">Daftar Pengaduan</p>
        </div>

        {{-- Filter --}}
        <div class="pg-filter">
            <form method="GET" action="{{ route('pengaduan.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-12 col-sm-5 col-md-4">
                        <label class="stat-label d-block mb-1">Status</label>
                        <select name="status" class="pg-select">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ request('status')=='Menunggu'?'selected':'' }}>Menunggu</option>
                            <option value="Diproses" {{ request('status')=='Diproses'?'selected':'' }}>Diproses</option>
                            <option value="Selesai"  {{ request('status')=='Selesai' ?'selected':'' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-5 col-md-4">
                        <label class="stat-label d-block mb-1">Tingkat Kerusakan</label>
                        <select name="tingkat" class="pg-select">
                            <option value="">Semua Tingkat</option>
                            <option value="Ringan" {{ request('tingkat')=='Ringan'?'selected':'' }}>Ringan</option>
                            <option value="Sedang" {{ request('tingkat')=='Sedang'?'selected':'' }}>Sedang</option>
                            <option value="Berat"  {{ request('tingkat')=='Berat' ?'selected':'' }}>Berat</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2 col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="pg-btn pg-btn-primary flex-fill">
                                <i class="bi bi-funnel-fill"></i>
                                <span class="d-none d-sm-inline">Filter</span>
                                <span class="d-sm-none">Filter</span>
                            </button>
                            <a href="{{ route('pengaduan.index') }}" class="pg-btn pg-btn-ghost flex-fill justify-content-center">
                                Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Desktop Table --}}
        <div class="pg-table-wrap d-none d-md-block">
            <table class="pg-table">
                <thead>
                    <tr>
                        <th width="48">#</th>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Barang</th>
                        <th>Tingkat</th>
                        <th>Status</th>
                        <th width="60">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $item)
                    @php
                        $no = $loop->iteration + ($pengaduan->currentPage()-1) * $pengaduan->perPage();
                        $tk = strtolower($item->tingkat_kerusakan);
                        $sk = strtolower($item->status);
                    @endphp
                    <tr>
                        <td><span class="cell-num">{{ $no }}</span></td>
                        <td>
                            <span class="cell-date">
                                {{ $item->created_at->format('d M Y') }}
                                <small>{{ $item->created_at->format('H:i') }}</small>
                            </span>
                        </td>
                        <td>
                            <div class="cell-name">{{ $item->nama_pelapor }}</div>
                            <div class="cell-sub">{{ $item->email_pelapor ?: '—' }}</div>
                        </td>
                        <td>
                            <div class="cell-name">{{ $item->item->nama_item }}</div>
                            <span class="cell-code">{{ $item->item->kode_barang }}</span>
                        </td>
                        <td><span class="badge-pill badge-{{ $tk }}">{{ $item->tingkat_kerusakan }}</span></td>
                        <td><span class="badge-pill badge-{{ $sk }}">{{ $item->status }}</span></td>
                        <td>
                            <a href="{{ route('pengaduan.show', $item->id_pengaduan) }}" class="btn-eye" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="pg-empty">
                                <i class="bi bi-inbox"></i>
                                <p>Tidak ada data pengaduan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="m-list d-md-none">
            @forelse($pengaduan as $item)
            @php
                $tk = strtolower($item->tingkat_kerusakan);
                $sk = strtolower($item->status);
            @endphp
            <div class="m-card">
                <div class="m-card__head">
                    <div>
                        <div class="cell-name" style="font-size:.875rem">{{ $item->nama_pelapor }}</div>
                        <div class="cell-sub">{{ $item->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="d-flex flex-column gap-1 align-items-end">
                        <span class="badge-pill badge-{{ $sk }}">{{ $item->status }}</span>
                        <span class="badge-pill badge-{{ $tk }}">{{ $item->tingkat_kerusakan }}</span>
                    </div>
                </div>
                <div class="m-card__body">
                    <div class="m-card__body-row">
                        <i class="bi bi-box" style="color:#6366f1;font-size:.8rem"></i>
                        <strong style="color:#334155">{{ $item->item->nama_item }}</strong>
                        <span class="cell-code">{{ $item->item->kode_barang }}</span>
                    </div>
                    @if($item->email_pelapor)
                    <div class="m-card__body-row">
                        <i class="bi bi-envelope" style="font-size:.8rem"></i>
                        {{ $item->email_pelapor }}
                    </div>
                    @endif
                </div>
                <a href="{{ route('pengaduan.show', $item->id_pengaduan) }}" class="m-card__cta">
                    Lihat Detail <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @empty
            <div class="pg-empty">
                <i class="bi bi-inbox"></i>
                <p>Tidak ada data pengaduan</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($pengaduan->hasPages())
        <div class="pg-pager">
            <span class="pg-pager__info">
                Menampilkan <strong>{{ $pengaduan->firstItem() }}–{{ $pengaduan->lastItem() }}</strong>
                dari <strong>{{ $pengaduan->total() }}</strong> data
            </span>
            {{ $pengaduan->links() }}
        </div>
        @endif

    </div>{{-- /pg-panel --}}

</div>
@endsection