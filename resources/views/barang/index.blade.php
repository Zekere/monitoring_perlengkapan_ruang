@extends('layouts.template')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

.pb, .pb * { box-sizing: border-box; margin: 0; padding: 0; }
.pb {
  font-family: 'Outfit', 'Segoe UI', system-ui, sans-serif;
  --bg:       #F4F6FA;
  --surface:  #FFFFFF;
  --border:   #E8ECF2;
  --bmd:      #D8DEE9;
  --text:     #1A2033;
  --muted:    #5B6A84;
  --hint:     #9AA3B5;
  --blue:     #2563EB;
  --blue-lt:  #EFF6FF;
  --blue-mid: #BFDBFE;
  --green:    #16A34A;
  --green-lt: #F0FDF4;
  --amber:    #D97706;
  --amber-lt: #FFFBEB;
  --red:      #DC2626;
  --red-lt:   #FEF2F2;
  --divider:  #F0F3F8;
  --r: 12px; --rsm: 8px;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  padding: 24px 24px 56px;
}

/* HEAD */
.pb-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:22px; gap:14px; flex-wrap:wrap; animation:pbFu .4s ease both; }
.pb-htitle { display:flex; align-items:center; gap:10px; font-size:20px; font-weight:700; letter-spacing:-.35px; }
.pb-hicon  { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#2563EB,#4F46E5); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 12px rgba(37,99,235,.25); }
.pb-hsub   { font-size:13px; color:var(--muted); margin-top:4px; }

/* BUTTONS */
.pb-btn { display:inline-flex; align-items:center; gap:7px; padding:8px 16px; border-radius:var(--rsm); font-size:13px; font-weight:500; font-family:inherit; cursor:pointer; text-decoration:none; white-space:nowrap; transition:all .18s ease; }
.pb-btn--ghost  { background:var(--surface); border:1px solid var(--bmd); color:var(--muted); }
.pb-btn--ghost:hover { border-color:#B0BAD0; color:var(--text); background:var(--bg); }
.pb-btn--prime  { background:linear-gradient(135deg,#2563EB,#4F46E5); border:1px solid transparent; color:#fff; box-shadow:0 4px 14px rgba(37,99,235,.28); }
.pb-btn--prime:hover { box-shadow:0 6px 22px rgba(37,99,235,.4); transform:translateY(-1px); }
.pb-btn--warn   { background:#FFFBEB; border:1px solid #FCD34D; color:#B45309; }
.pb-btn--warn:hover { background:#FEF3C7; }
.pb-btn--danger { background:var(--red-lt); border:1px solid #FECACA; color:var(--red); }
.pb-btn--danger:hover { background:#FEE2E2; }

/* ALERT */
.pb-alert { display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:var(--r); background:var(--green-lt); border:1px solid #BBF7D0; color:#15803D; font-size:13px; font-weight:500; margin-bottom:18px; animation:pbFu .4s ease both; }
.pb-alert-x { margin-left:auto; cursor:pointer; opacity:.6; font-size:18px; background:none; border:none; color:inherit; line-height:1; }
.pb-alert-x:hover { opacity:1; }

/* STAT CARDS */
.pb-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:13px; margin-bottom:20px; }
.pb-sc    { background:var(--surface); border:1px solid var(--border); border-radius:var(--r); padding:16px 18px; display:flex; align-items:center; gap:14px; position:relative; overflow:hidden; transition:box-shadow .2s,transform .2s; animation:pbFu .4s ease both; cursor:default; }
.pb-sc:hover { box-shadow:0 6px 20px rgba(0,0,0,.07); transform:translateY(-2px); }
.pb-sc-stripe { position:absolute; top:0; left:0; width:100%; height:3px; border-radius:var(--r) var(--r) 0 0; }
.pb-sc-glow   { position:absolute; top:-24px; right:-16px; width:72px; height:72px; border-radius:50%; filter:blur(24px); opacity:.12; pointer-events:none; }
.pb-sc-icon   { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pb-sc-lbl    { font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; margin-bottom:4px; }
.pb-sc-num    { font-size:26px; font-weight:700; letter-spacing:-.5px; line-height:1; }

/* MAIN CARD */
.pb-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--r); overflow:hidden; animation:pbFu .4s .1s ease both; }

/* FILTER */
.pb-filter { padding:16px 20px; border-bottom:1px solid var(--divider); display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end; }
.pb-fg     { display:flex; flex-direction:column; gap:4px; flex:1; min-width:130px; }
.pb-flbl   { font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:var(--hint); }
.pb-inp, .pb-sel {
  height:36px; padding:0 11px; border:1px solid var(--bmd); border-radius:var(--rsm);
  font-size:13px; font-family:inherit; background:var(--bg); color:var(--text);
  transition:border-color .15s,box-shadow .15s; width:100%;
}
.pb-inp:focus, .pb-sel:focus { outline:none; border-color:var(--blue); box-shadow:0 0 0 3px rgba(37,99,235,.1); background:#fff; }
.pb-fbtns { display:flex; gap:7px; align-self:flex-end; }

/* INFOBAR */
.pb-infobar { padding:10px 20px; border-bottom:1px solid var(--divider); display:flex; align-items:center; gap:16px; flex-wrap:wrap; background:var(--bg); }
.pb-icount  { font-size:12px; color:var(--muted); }
.pb-legend  { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.pb-leg-lbl { font-size:11px; color:var(--hint); }
.pb-lchip   { display:inline-flex; align-items:center; gap:4px; font-size:10px; font-weight:600; padding:2px 8px; border-radius:20px; }

/* TABLE */
.pb-tw   { overflow-x:auto; }
.pb-tbl  { width:100%; border-collapse:collapse; font-size:13px; }
.pb-tbl thead th { padding:10px 16px; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:.07em; color:var(--hint); background:var(--bg); border-bottom:1px solid var(--border); text-align:left; white-space:nowrap; }
.pb-tbl thead th.tc { text-align:center; }
.pb-tbl tbody td  { padding:12px 16px; border-bottom:1px solid var(--divider); vertical-align:middle; }
.pb-tbl tbody tr:last-child td { border-bottom:none; }
.pb-tbl tbody tr:hover { background:#FAFBFD; }

.pb-thumb    { width:40px; height:40px; border-radius:8px; object-fit:cover; border:1px solid var(--border); flex-shrink:0; }
.pb-thumb-ph { width:40px; height:40px; border-radius:8px; background:#F1F5F9; border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--hint); }
.pb-iname    { font-size:13px; font-weight:500; color:var(--text); }
.pb-ibrand   { font-size:11px; color:var(--hint); margin-top:1px; }
.pb-code     { font-family:'Consolas',monospace; font-size:11px; background:var(--blue-lt); color:var(--blue); padding:2px 7px; border-radius:5px; }
.pb-dim      { color:var(--hint); }

/* BADGES */
.pb-bdg      { display:inline-block; font-size:11px; font-weight:500; padding:3px 9px; border-radius:20px; white-space:nowrap; }
.pb-bdg--gn  { background:var(--green-lt); color:#15803D; }
.pb-bdg--am  { background:var(--amber-lt); color:#B45309; }
.pb-bdg--rd  { background:var(--red-lt);   color:#B91C1C; }
.pb-bdg--gy  { background:#F8FAFC; color:#475569; border:1px solid #E2E8F0; }

/* MAINTENANCE */
.pb-mnt     { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:600; padding:3px 9px; border-radius:20px; }
.pb-mnt--y  { background:#fef3c7; color:#92400e; }
.pb-mnt--o  { background:#fed7aa; color:#9a3412; }
.pb-mnt--r  { background:#fecaca; color:#991b1b; animation:pbPulse 1.8s ease-in-out infinite; }

/* ACTION BTNS */
.pb-acts   { display:flex; align-items:center; justify-content:center; gap:6px; }
.pb-ibtn   { width:32px; height:32px; border-radius:7px; border:1px solid; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; text-decoration:none; transition:all .15s; background:transparent; font-size:13px; }
.pb-ibtn--w { border-color:#FCD34D; color:#B45309; background:#FFFBEB; }
.pb-ibtn--w:hover { background:#FEF3C7; }
.pb-ibtn--d { border-color:#FECACA; color:var(--red); background:var(--red-lt); }
.pb-ibtn--d:hover { background:#FEE2E2; }

/* MOBILE */
.pb-mob { display:none; padding:12px; }
.pb-mc  { background:var(--surface); border:1px solid var(--border); border-radius:var(--r); padding:14px; margin-bottom:10px; position:relative; overflow:hidden; transition:box-shadow .2s; }
.pb-mc:hover { box-shadow:0 4px 14px rgba(0,0,0,.06); }
.pb-mc-acc  { position:absolute; top:0; left:0; width:3px; height:100%; border-radius:var(--r) 0 0 var(--r); }
.pb-mc-body { display:flex; gap:12px; align-items:flex-start; padding-left:8px; }
.pb-mc-info { flex:1; min-width:0; }
.pb-mc-name { font-size:14px; font-weight:600; color:var(--text); margin-bottom:1px; }
.pb-mc-code { font-family:monospace; font-size:11px; color:var(--hint); }
.pb-mc-meta { display:flex; flex-wrap:wrap; gap:6px; margin-top:8px; }
.pb-mc-row  { font-size:12px; color:var(--muted); display:flex; align-items:center; gap:4px; }
.pb-mc-acts { display:flex; gap:7px; margin-top:12px; }

/* EMPTY */
.pb-empty { text-align:center; padding:48px 20px; color:var(--hint); }
.pb-empty svg { opacity:.3; margin-bottom:10px; }
.pb-empty p   { font-size:14px; }

/* ANIMATIONS */
@keyframes pbFu     { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
@keyframes pbPulse  { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:.8; transform:scale(1.05); } }

/* RESPONSIVE */
@media (max-width:1100px) { .pb-stats { grid-template-columns:repeat(2,1fr); } }
@media (max-width:768px) {
  .pb { padding:16px 14px 40px; }
  .pb-tw  { display:none; }
  .pb-mob { display:block; }
  .pb-filter { padding:13px 14px; }
  .pb-infobar { padding:9px 14px; }
  .pb-fg { min-width:100%; flex:none; }
}
@media (max-width:480px) {
  .pb-stats { gap:9px; }
  .pb-sc    { padding:13px 12px; gap:10px; }
  .pb-sc-num { font-size:22px; }
  .pb-head  { flex-direction:column; }
  .pb-htitle { font-size:17px; }
}
</style>

<div class="pb">

  {{-- ── HEADER ── --}}
  <div class="pb-head">
    <div>
      <div class="pb-htitle">
        <div class="pb-hicon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
            <path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
          </svg>
        </div>
        Daftar Barang
      </div>
      <p class="pb-hsub">Kelola seluruh data inventaris barang</p>
    </div>
    <a href="{{ route('riwayat-perawatan.statistik') }}" class="pb-btn pb-btn--ghost">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
      </svg>
      Statistik Perawatan
    </a>
  </div>

  {{-- ── ALERT ── --}}
  @if(session('success'))
  <div class="pb-alert" id="pbAlert">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
    <button class="pb-alert-x" onclick="document.getElementById('pbAlert').remove()">×</button>
  </div>
  @endif

  {{-- ── STAT CARDS ── --}}
  <div class="pb-stats">

    <div class="pb-sc" style="animation-delay:.04s">
      <div class="pb-sc-stripe" style="background:linear-gradient(90deg,#2563EB,#4F46E5)"></div>
      <div class="pb-sc-glow" style="background:#2563EB"></div>
      <div class="pb-sc-icon" style="background:#EFF6FF">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8">
          <path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
        </svg>
      </div>
      <div><div class="pb-sc-lbl">Total</div><div class="pb-sc-num">{{ $barang->count() }}</div></div>
    </div>

    <div class="pb-sc" style="animation-delay:.08s">
      <div class="pb-sc-stripe" style="background:linear-gradient(90deg,#16A34A,#10B981)"></div>
      <div class="pb-sc-glow" style="background:#16A34A"></div>
      <div class="pb-sc-icon" style="background:#F0FDF4">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.8">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <div><div class="pb-sc-lbl">Baik</div><div class="pb-sc-num" style="color:var(--green)">{{ $barang->where('kondisi','Baik')->count() }}</div></div>
    </div>

    <div class="pb-sc" style="animation-delay:.12s">
      <div class="pb-sc-stripe" style="background:linear-gradient(90deg,#D97706,#F59E0B)"></div>
      <div class="pb-sc-glow" style="background:#D97706"></div>
      <div class="pb-sc-icon" style="background:#FFFBEB">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="1.8">
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
          <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
      </div>
      <div><div class="pb-sc-lbl">Rusak Ringan</div><div class="pb-sc-num" style="color:var(--amber)">{{ $barang->where('kondisi','Rusak Ringan')->count() }}</div></div>
    </div>

    <div class="pb-sc" style="animation-delay:.16s">
      <div class="pb-sc-stripe" style="background:linear-gradient(90deg,#DC2626,#EF4444)"></div>
      <div class="pb-sc-glow" style="background:#DC2626"></div>
      <div class="pb-sc-icon" style="background:#FEF2F2">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="1.8">
          <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
      </div>
      <div><div class="pb-sc-lbl">Rusak Berat</div><div class="pb-sc-num" style="color:var(--red)">{{ $barang->where('kondisi','Rusak Berat')->count() }}</div></div>
    </div>

  </div>

  {{-- ── MAIN CARD ── --}}
  <div class="pb-card">

    {{-- Filter --}}
    <form method="GET" action="{{ route('barang.index') }}" class="pb-filter">
      <div class="pb-fg" style="max-width:230px">
        <label class="pb-flbl">Cari Barang</label>
        <input type="text" name="search" class="pb-inp" placeholder="Nama atau kode…" value="{{ request('search') }}">
      </div>
      <div class="pb-fg" style="max-width:160px">
        <label class="pb-flbl">Kategori</label>
        <select name="kategori" class="pb-sel">
          <option value="">Semua</option>
          @foreach($kategori as $kat)
            <option value="{{ $kat->id_kategori }}" {{ request('kategori')==$kat->id_kategori?'selected':'' }}>{{ $kat->nama_kategori }}</option>
          @endforeach
        </select>
      </div>
      <div class="pb-fg" style="max-width:160px">
        <label class="pb-flbl">Ruangan</label>
        <select name="ruangan" class="pb-sel">
          <option value="">Semua</option>
          @foreach($ruangan as $ruang)
            <option value="{{ $ruang->id_ruangan }}" {{ request('ruangan')==$ruang->id_ruangan?'selected':'' }}>{{ $ruang->nama_ruangan }}</option>
          @endforeach
        </select>
      </div>
      <div class="pb-fg" style="max-width:140px">
        <label class="pb-flbl">Kondisi</label>
        <select name="kondisi" class="pb-sel">
          <option value="">Semua</option>
          <option value="Baik"         {{ request('kondisi')=='Baik'?'selected':'' }}>Baik</option>
          <option value="Rusak Ringan" {{ request('kondisi')=='Rusak Ringan'?'selected':'' }}>Rusak Ringan</option>
          <option value="Rusak Berat"  {{ request('kondisi')=='Rusak Berat'?'selected':'' }}>Rusak Berat</option>
        </select>
      </div>
      <div class="pb-fbtns">
        <button type="submit" class="pb-btn pb-btn--prime">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Cari
        </button>
        <a href="{{ route('barang.index') }}" class="pb-btn pb-btn--ghost">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4"/></svg>
          Reset
        </a>
      </div>
    </form>

    {{-- Infobar --}}
    <div class="pb-infobar">
      <span class="pb-icount">Menampilkan <strong>{{ $barang->count() }}</strong> barang</span>
      <div class="pb-legend">
        <span class="pb-leg-lbl">Indikator perawatan:</span>
        <span class="pb-lchip" style="background:#fef3c7;color:#92400e;">
          <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
          1–2x
        </span>
        <span class="pb-lchip" style="background:#fed7aa;color:#9a3412;">
          <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
          3–5x
        </span>
        <span class="pb-lchip" style="background:#fecaca;color:#991b1b;">
          <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2c0 6-5 8-5 13a5 5 0 0 0 10 0c0-5-5-7-5-13z"/></svg>
          6x+
        </span>
        <span style="font-size:10px;color:var(--hint);font-style:italic;">*tidak berkurang meski riwayat dihapus</span>
      </div>
    </div>

    {{-- ── DESKTOP TABLE ── --}}
    <div class="pb-tw">
      <table class="pb-tbl">
        <thead>
          <tr>
            <th style="width:48px">No</th>
            <th style="width:120px">Kode</th>
            <th>Barang</th>
            <th>Kategori</th>
            <th>Ruangan</th>
            <th class="tc" style="width:110px">Kondisi</th>
            <th class="tc" style="width:110px">Perawatan</th>
            <th class="tc" style="width:96px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($barang as $index => $item)
          @php $cnt = $item->jumlah_perawatan ?? 0; @endphp
          <tr>
            <td class="pb-dim">{{ $index + 1 }}</td>
            <td><code class="pb-code">{{ $item->kode_barang }}</code></td>
            <td>
              <div style="display:flex;align-items:center;gap:11px;">
                @if($item->foto)
                  <img src="{{ asset('storage/'.$item->foto) }}" class="pb-thumb" alt="foto">
                @else
                  <div class="pb-thumb-ph">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                  </div>
                @endif
                <div>
                  <div class="pb-iname">{{ $item->nama_item }}</div>
                  @if($item->merk)<div class="pb-ibrand">{{ $item->merk }}</div>@endif
                </div>
              </div>
            </td>
            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
            <td class="tc">
              @if($item->kondisi=='Baik')       <span class="pb-bdg pb-bdg--gn">Baik</span>
              @elseif($item->kondisi=='Rusak Ringan') <span class="pb-bdg pb-bdg--am">Rusak Ringan</span>
              @else                             <span class="pb-bdg pb-bdg--rd">Rusak Berat</span>
              @endif
            </td>
            <td class="tc">
              @if($cnt==0)
                <span class="pb-dim">—</span>
              @elseif($cnt<=2)
                <span class="pb-mnt pb-mnt--y" data-bs-toggle="tooltip" title="{{ $cnt }}x perawatan">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                  {{ $cnt }}x
                </span>
              @elseif($cnt<=5)
                <span class="pb-mnt pb-mnt--o" data-bs-toggle="tooltip" title="{{ $cnt }}x perawatan — perhatikan!">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                  {{ $cnt }}x
                </span>
              @else
                <span class="pb-mnt pb-mnt--r" data-bs-toggle="tooltip" title="{{ $cnt }}x — sering rusak!">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2c0 6-5 8-5 13a5 5 0 0 0 10 0c0-5-5-7-5-13z"/></svg>
                  {{ $cnt }}x
                </span>
              @endif
            </td>
            <td>
              <div class="pb-acts">
                <a href="{{ route('barang.edit', $item) }}" class="pb-ibtn pb-ibtn--w" title="Edit">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <form action="{{ route('barang.destroy', $item->id_item) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="pb-ibtn pb-ibtn--d" title="Hapus">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8">
              <div class="pb-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                <p>Tidak ada data barang</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- ── MOBILE CARDS ── --}}
    <div class="pb-mob">
      @forelse($barang as $item)
      @php $cnt = $item->jumlah_perawatan ?? 0; @endphp
      <div class="pb-mc">
        <div class="pb-mc-acc" style="background:{{ $cnt >= 6 ? '#DC2626' : ($cnt >= 3 ? '#D97706' : '#3B82F6') }}"></div>
        <div class="pb-mc-body">
          @if($item->foto)
            <img src="{{ asset('storage/'.$item->foto) }}" class="pb-thumb" style="width:52px;height:52px;" alt="foto">
          @else
            <div class="pb-thumb-ph" style="width:52px;height:52px;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
          @endif
          <div class="pb-mc-info">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
              <div>
                <div class="pb-mc-name">{{ $item->nama_item }}</div>
                <code class="pb-mc-code">{{ $item->kode_barang }}</code>
              </div>
              <div style="display:flex;flex-direction:column;align-items:flex-end;gap:5px;flex-shrink:0;">
                @if($item->kondisi=='Baik')       <span class="pb-bdg pb-bdg--gn" style="font-size:10px">Baik</span>
                @elseif($item->kondisi=='Rusak Ringan') <span class="pb-bdg pb-bdg--am" style="font-size:10px">Rusak Ringan</span>
                @else                             <span class="pb-bdg pb-bdg--rd" style="font-size:10px">Rusak Berat</span>
                @endif
                @if($cnt>0)
                  @if($cnt<=2)      <span class="pb-mnt pb-mnt--y" style="font-size:10px">{{ $cnt }}x</span>
                  @elseif($cnt<=5)  <span class="pb-mnt pb-mnt--o" style="font-size:10px">{{ $cnt }}x</span>
                  @else             <span class="pb-mnt pb-mnt--r" style="font-size:10px">{{ $cnt }}x</span>
                  @endif
                @endif
              </div>
            </div>
            <div class="pb-mc-meta">
              <span class="pb-mc-row">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                {{ $item->kategori->nama_kategori ?? '-' }}
              </span>
              <span class="pb-mc-row">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                {{ $item->ruangan->nama_ruangan ?? '-' }}
              </span>
              @if($item->merk)
              <span class="pb-mc-row">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $item->merk }}
              </span>
              @endif
            </div>
            <div class="pb-mc-acts">
              <a href="{{ route('barang.edit', $item) }}" class="pb-btn pb-btn--warn" style="flex:1;justify-content:center;padding:7px 12px;font-size:12px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
              </a>
              <form action="{{ route('barang.destroy', $item->id_item) }}" method="POST" style="flex:1" onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf @method('DELETE')
                <button type="submit" class="pb-btn pb-btn--danger" style="width:100%;justify-content:center;padding:7px 12px;font-size:12px;">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                  Hapus
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="pb-empty">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        <p>Tidak ada data barang</p>
      </div>
      @endforelse
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    .forEach(function (el) { new bootstrap.Tooltip(el); });
});
</script>

@endsection