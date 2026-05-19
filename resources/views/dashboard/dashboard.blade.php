@extends('layouts.template')

@section('content')

<style>
/* ── Font ── */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

/* ── CSS Variables ── */
.dsh, .dsh * { box-sizing: border-box; margin: 0; padding: 0; }
.dsh {
  font-family: 'Outfit', 'Segoe UI', system-ui, sans-serif;
  --bg:        #F4F6FA;
  --surface:   #FFFFFF;
  --border:    #E8ECF2;
  --border-md: #D8DEE9;
  --text:      #1A2033;
  --muted:     #5B6A84;
  --hint:      #9AA3B5;
  --blue:      #2563EB;
  --blue-lt:   #EFF6FF;
  --blue-mid:  #BFDBFE;
  --teal:      #0D9488;
  --teal-lt:   #F0FDFA;
  --amber:     #D97706;
  --amber-lt:  #FFFBEB;
  --green:     #16A34A;
  --green-lt:  #F0FDF4;
  --red:       #DC2626;
  --red-lt:    #FEF2F2;
  --divider:   #F0F3F8;
  --r:         14px;
  --rsm:       9px;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
}

/* ════ NAV ════ */
.dsh-nav {
  height: 60px;
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 28px;
  position: sticky; top: 0; z-index: 50;
  box-shadow: 0 1px 4px rgba(0,0,0,.04);
}
.dsh-nav-l, .dsh-nav-r { display: flex; align-items: center; gap: 14px; }

.dsh-logo {
  width: 36px; height: 36px; border-radius: 10px;
  background: linear-gradient(135deg, #2563EB, #4F46E5);
  display: flex; align-items: center; justify-content: center;
  color: #fff; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(37,99,235,.25);
}
.dsh-brand  { font-size: 16px; font-weight: 700; letter-spacing: -.3px; color: var(--text); }
.dsh-npill  { font-size: 11px; font-weight: 500; padding: 3px 10px; border-radius: 20px; background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-mid); }

/* Hanya tanggal + hari — TIDAK ada jam */
.dsh-navdate { font-size: 13px; font-weight: 500; color: var(--muted); }

.dsh-nsep  { width: 1px; height: 22px; background: var(--border); }
.dsh-prof  { display: flex; align-items: center; gap: 10px; }
.dsh-av    { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #2563EB, #7C3AED); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #fff; flex-shrink: 0; }
.dsh-pname { display: block; font-size: 13px; font-weight: 500; color: var(--text); line-height: 1.2; }
.dsh-prole { display: block; font-size: 11px; color: var(--hint); }

/* ════ BODY ════ */
.dsh-body { padding: 26px 28px 56px; }

/* Page header */
.dsh-ph    { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; animation: dsh-fu .45s ease both; }
.dsh-pt    { font-size: 21px; font-weight: 700; letter-spacing: -.35px; color: var(--text); }
.dsh-ps    { font-size: 13px; color: var(--muted); margin-top: 4px; }
.dsh-pbtns { display: flex; gap: 10px; }

.dsh-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border-radius: var(--rsm); font-size: 13px; font-weight: 500; font-family: inherit; cursor: pointer; text-decoration: none; white-space: nowrap; transition: all .18s ease; }
.dsh-btn--ghost { background: var(--surface); border: 1px solid var(--border-md); color: var(--muted); }
.dsh-btn--ghost:hover { border-color: #B0BAD0; color: var(--text); background: var(--bg); }
.dsh-btn--prime { background: linear-gradient(135deg, #2563EB, #4F46E5); border: 1px solid transparent; color: #fff; box-shadow: 0 4px 14px rgba(37,99,235,.3); }
.dsh-btn--prime:hover { box-shadow: 0 6px 22px rgba(37,99,235,.4); transform: translateY(-1px); }

/* ════ STAT CARDS ════ */
.dsh-sg { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
.dsh-sc {
  background: var(--surface); border: 1px solid var(--border); border-radius: var(--r);
  padding: 20px 18px; display: flex; align-items: center; gap: 16px;
  position: relative; overflow: hidden;
  transition: box-shadow .2s, transform .2s, border-color .2s;
  animation: dsh-fu .45s ease both; cursor: default;
}
.dsh-sc:hover { box-shadow: 0 6px 24px rgba(0,0,0,.07); transform: translateY(-2px); border-color: var(--border-md); }
.dsh-sc-stripe { position: absolute; top: 0; left: 0; width: 100%; height: 3px; border-radius: var(--r) var(--r) 0 0; }
.dsh-sc-glow   { position: absolute; top: -24px; right: -16px; width: 72px; height: 72px; border-radius: 50%; filter: blur(24px); opacity: .12; pointer-events: none; }
.dsh-sc-icon   { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.dsh-sc-lbl    { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 5px; }
.dsh-sc-num    { font-size: 28px; font-weight: 700; letter-spacing: -.5px; line-height: 1; color: var(--text); }
.dsh-sc-num--sm { font-size: 15px !important; color: var(--green); font-weight: 600; }

/* ════ CARDS ════ */
.dsh-g2   { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; }
.dsh-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; display: flex; flex-direction: column; animation: dsh-fu .45s ease both; transition: box-shadow .2s; }
.dsh-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.05); }
.dsh-ch   { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--divider); flex-shrink: 0; }
.dsh-ct   { font-size: 14px; font-weight: 600; color: var(--text); }
.dsh-ca   { display: flex; align-items: center; gap: 10px; }
.dsh-cb   { padding: 20px; flex: 1; }

.dsh-lnk      { font-size: 12px; color: var(--blue); text-decoration: none; font-weight: 500; }
.dsh-lnk:hover { text-decoration: underline; }
.dsh-tag-pdf  { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 500; padding: 4px 10px; border-radius: 7px; text-decoration: none; background: var(--red-lt); color: var(--red); border: 1px solid #FECACA; }
.dsh-tag-pdf:hover { background: #FEE2E2; }

/* ════ DONUT ════ */
.dsh-dlayout { display: flex; align-items: center; gap: 28px; }
.dsh-dwrap   { position: relative; width: 160px; height: 160px; flex-shrink: 0; }
.dsh-dmid    { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }
.dsh-dn { font-size: 26px; font-weight: 700; color: var(--text); line-height: 1; }
.dsh-dl { font-size: 11px; color: var(--hint); margin-top: 3px; }
.dsh-leg { flex: 1; display: flex; flex-direction: column; gap: 11px; }
.dsh-lr  { display: flex; align-items: center; gap: 9px; }
.dsh-ld  { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.dsh-ln  { font-size: 13px; color: var(--muted); flex: 1; }
.dsh-lv  { font-size: 15px; font-weight: 700; }
.dsh-lsep { height: 1px; background: var(--divider); margin: 2px 0; }

/* ════ BARS ════ */
.dsh-bars { display: flex; flex-direction: column; gap: 14px; }
.dsh-br   { display: flex; align-items: center; gap: 10px; }
.dsh-bn   { font-size: 12px; color: var(--muted); width: 88px; flex-shrink: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.dsh-btr  { flex: 1; height: 8px; background: var(--bg); border-radius: 4px; overflow: hidden; border: 1px solid var(--border); }
.dsh-bfi  { height: 100%; border-radius: 4px; transition: width .5s ease; }
.dsh-bct  { font-size: 12px; font-weight: 600; color: var(--text); min-width: 22px; text-align: right; }

/* ════ TABLE ════ */
.dsh-tw   { overflow-x: auto; flex: 1; }
.dsh-tbl  { width: 100%; border-collapse: collapse; font-size: 13px; }
.dsh-tbl thead th { padding: 10px 18px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: var(--hint); background: var(--bg); border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap; }
.dsh-tbl thead th.ta-r { text-align: right; }
.dsh-tbl tbody td { padding: 12px 18px; border-bottom: 1px solid var(--divider); vertical-align: middle; }
.dsh-tbl tbody tr:last-child td { border-bottom: none; }
.dsh-tbl tbody tr:hover { background: #FAFBFD; }

.dsh-code  { font-family: 'Consolas', monospace; font-size: 11px; background: var(--blue-lt); color: var(--blue); padding: 2px 7px; border-radius: 5px; white-space: nowrap; }
.dsh-ell   { max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--text); }
.dsh-price { font-weight: 600; color: var(--green); text-align: right; white-space: nowrap; }
.dsh-dim   { color: var(--hint); }
.dsh-nw    { white-space: nowrap; }
.dsh-ds    { display: block; font-size: 12px; font-weight: 500; color: var(--text); }
.dsh-dt    { display: block; font-size: 11px; color: var(--hint); }
.dsh-al    { display: block; font-size: 12px; font-weight: 600; color: var(--blue); text-decoration: none; }
.dsh-al:hover { text-decoration: underline; }
.dsh-asub  { display: block; font-size: 11px; color: var(--hint); max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.dsh-chg   { display: flex; align-items: center; gap: 5px; }
.ta-r      { text-align: right; }

/* ════ BADGES ════ */
.dsh-badge      { display: inline-block; font-size: 11px; font-weight: 500; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
.dsh-badge--bl  { background: #EFF6FF; color: #1D4ED8; }
.dsh-badge--te  { background: #F0FDFA; color: #0F766E; }
.dsh-badge--am  { background: #FFFBEB; color: #B45309; }
.dsh-badge--gn  { background: #F0FDF4; color: #15803D; }
.dsh-badge--rd  { background: #FEF2F2; color: #B91C1C; }
.dsh-badge--gy  { background: #F8FAFC; color: #475569; border: 1px solid #E2E8F0; }

/* ════ ANIMATION ════ */
@keyframes dsh-fu { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

/* ════ RESPONSIVE ════ */
@media (max-width: 1100px) {
  .dsh-sg    { grid-template-columns: repeat(2, 1fr); }
  .dsh-pname, .dsh-prole { display: none; }
}
@media (max-width: 860px) {
  .dsh-body  { padding: 18px 16px 40px; }
  .dsh-g2    { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
  .dsh-nav   { padding: 0 16px; height: 54px; }
  .dsh-nsep  { display: none; }
  .dsh-body  { padding: 14px 12px 36px; }
  .dsh-sg    { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .dsh-sc    { padding: 14px 12px; gap: 10px; }
  .dsh-sc-num { font-size: 22px; }
  .dsh-sc-num--sm { font-size: 13px !important; }
  .dsh-ph    { flex-direction: column; }
  .dsh-pbtns { width: 100%; }
  .dsh-btn   { flex: 1; justify-content: center; }
  .dsh-pt    { font-size: 18px; }
  .dsh-dlayout { flex-direction: column; align-items: center; }
  .dsh-leg   { width: 100%; }
  .dsh-ch    { padding: 12px 14px; }
  .dsh-cb    { padding: 14px; }
  .dsh-tbl thead th, .dsh-tbl tbody td { padding: 9px 12px; }
}
@media (max-width: 400px) {
  .dsh-sc-num { font-size: 19px; }
  .dsh-sg { gap: 8px; }
}
</style>

<div class="dsh">

  {{-- ══ TOPBAR ══ --}}
  <header class="dsh-nav">
    <div class="dsh-nav-l">
      <div class="dsh-logo">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
          <path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
        </svg>
      </div>
      <span class="dsh-brand">Inventaris</span>
      <span class="dsh-npill">Dashboard</span>
    </div>
    <div class="dsh-nav-r">
      {{-- Hanya tanggal + hari, tanpa jam --}}
      <span class="dsh-navdate" id="dshNavDate">—</span>
      <div class="dsh-nsep"></div>
      <div class="dsh-prof">
      </div>
    </div>
  </header>

  {{-- ══ BODY ══ --}}
  <div class="dsh-body">

    {{-- Page Header --}}
    <div class="dsh-ph">
      <div>
        <h1 class="dsh-pt">Ringkasan Inventaris</h1>
        <p class="dsh-ps">Pantau kondisi, nilai, dan distribusi aset secara real-time</p>
      </div>
    </div>

    {{-- Stat Cards --}}
    <div class="dsh-sg">

      {{-- Total Barang --}}
      <div class="dsh-sc" style="animation-delay:.04s">
        <div class="dsh-sc-stripe" style="background:linear-gradient(90deg,#2563EB,#4F46E5)"></div>
        <div class="dsh-sc-glow"   style="background:#2563EB"></div>
        <div class="dsh-sc-icon"   style="background:#EFF6FF">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8">
            <path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
          </svg>
        </div>
        <div>
          <div class="dsh-sc-lbl">Total Barang</div>
          <div class="dsh-sc-num">{{ $totalBarang }}</div>
        </div>
      </div>

      {{-- Kategori --}}
      <div class="dsh-sc" style="animation-delay:.08s">
        <div class="dsh-sc-stripe" style="background:linear-gradient(90deg,#0D9488,#06B6D4)"></div>
        <div class="dsh-sc-glow"   style="background:#0D9488"></div>
        <div class="dsh-sc-icon"   style="background:#F0FDFA">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="1.8">
            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
            <line x1="7" y1="7" x2="7.01" y2="7"/>
          </svg>
        </div>
        <div>
          <div class="dsh-sc-lbl">Kategori</div>
          <div class="dsh-sc-num">{{ $totalKategori }}</div>
        </div>
      </div>

      {{-- Ruangan — IKON GEDUNG --}}
      <div class="dsh-sc" style="animation-delay:.12s">
        <div class="dsh-sc-stripe" style="background:linear-gradient(90deg,#D97706,#F59E0B)"></div>
        <div class="dsh-sc-glow"   style="background:#D97706"></div>
        <div class="dsh-sc-icon"   style="background:#FFFBEB">
          {{-- Gedung / Office Building --}}
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="1.8">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <path d="M3 9h18"/>
            <path d="M9 21V9"/>
            <rect x="12" y="12" width="2.5" height="2.5" rx=".4"/>
            <rect x="16" y="12" width="2.5" height="2.5" rx=".4"/>
            <rect x="12" y="16" width="2.5" height="2.5" rx=".4"/>
            <rect x="16" y="16" width="2.5" height="2.5" rx=".4"/>
            <rect x="5.5" y="14" width="2" height="4" rx=".4"/>
          </svg>
        </div>
        <div>
          <div class="dsh-sc-lbl">Ruangan</div>
          <div class="dsh-sc-num">{{ $totalRuangan }}</div>
        </div>
      </div>

      {{-- Total Nilai --}}
      <div class="dsh-sc" style="animation-delay:.16s">
        <div class="dsh-sc-stripe" style="background:linear-gradient(90deg,#16A34A,#10B981)"></div>
        <div class="dsh-sc-glow"   style="background:#16A34A"></div>
        <div class="dsh-sc-icon"   style="background:#F0FDF4">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.8">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
          </svg>
        </div>
        <div>
          <div class="dsh-sc-lbl">Total Nilai Aset</div>
          <div class="dsh-sc-num dsh-sc-num--sm">Rp {{ number_format($totalNilaiBarang, 0, ',', '.') }}</div>
        </div>
      </div>

    </div>

    {{-- Charts --}}
    <div class="dsh-g2">

      {{-- Kondisi Barang --}}
      <div class="dsh-card" style="animation-delay:.22s">
        <div class="dsh-ch"><span class="dsh-ct">Kondisi Barang</span></div>
        <div class="dsh-cb">
          @php
            $totalBaik=0;$totalRusakRingan=0;$totalRusakBerat=0;
            if(isset($kondisiBarang)){foreach($kondisiBarang as $k){
              if($k->kondisi=='Baik') $totalBaik=$k->total;
              elseif($k->kondisi=='Rusak Ringan') $totalRusakRingan=$k->total;
              elseif($k->kondisi=='Rusak Berat')  $totalRusakBerat=$k->total;
            }}
            $gt = $totalBaik + $totalRusakRingan + $totalRusakBerat;
          @endphp
          <div class="dsh-dlayout">
            <div class="dsh-dwrap">
              <canvas id="kondisiChart" width="160" height="160"></canvas>
              <div class="dsh-dmid">
                <span class="dsh-dn">{{ $gt }}</span>
                <span class="dsh-dl">unit</span>
              </div>
            </div>
            <div class="dsh-leg">
              <div class="dsh-lr">
                <span class="dsh-ld" style="background:#16A34A"></span>
                <span class="dsh-ln">Baik</span>
                <span class="dsh-lv" style="color:#16A34A">{{ $totalBaik }}</span>
              </div>
              <div class="dsh-lr">
                <span class="dsh-ld" style="background:#D97706"></span>
                <span class="dsh-ln">Rusak Ringan</span>
                <span class="dsh-lv" style="color:#D97706">{{ $totalRusakRingan }}</span>
              </div>
              <div class="dsh-lr">
                <span class="dsh-ld" style="background:#DC2626"></span>
                <span class="dsh-ln">Rusak Berat</span>
                <span class="dsh-lv" style="color:#DC2626">{{ $totalRusakBerat }}</span>
              </div>
              @if($gt > 0)
              <div class="dsh-lsep"></div>
              <div class="dsh-lr">
                <span class="dsh-ln" style="color:var(--hint)">Kondisi baik</span>
                <span class="dsh-lv" style="color:#16A34A;font-size:17px">{{ round(($totalBaik/$gt)*100) }}%</span>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Distribusi Kategori --}}
      <div class="dsh-card" style="animation-delay:.27s">
        <div class="dsh-ch"><span class="dsh-ct">Distribusi Kategori</span></div>
        <div class="dsh-cb">
          @php
            $maxT = collect($distribusiKategori??[])->max('total') ?: 1;
            $palette = ['#3B82F6','#0D9488','#D97706','#7C3AED','#EC4899','#10B981'];
          @endphp
          <div class="dsh-bars">
            @foreach($distribusiKategori??[] as $idx=>$k)
            @php $col = $palette[$idx % count($palette)]; @endphp
            <div class="dsh-br">
              <span class="dsh-bn">{{ $k->nama_kategori }}</span>
              <div class="dsh-btr">
                <div class="dsh-bfi" style="width:{{ round(($k->total/$maxT)*100) }}%;background:{{ $col }};"></div>
              </div>
              <span class="dsh-bct">{{ $k->total }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>

    {{-- Tables --}}
    <div class="dsh-g2">

      {{-- Barang Terbaru --}}
      <div class="dsh-card" style="animation-delay:.32s">
        <div class="dsh-ch">
          <span class="dsh-ct">Barang Terbaru</span>
          <div class="dsh-ca">
            <a href="{{ route('barang.index') }}" class="dsh-lnk">Lihat semua →</a>
            <a href="{{ route('export.barang') }}" class="dsh-tag-pdf" target="_blank">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              PDF
            </a>
          </div>
        </div>
        <div class="dsh-tw">
          <table class="dsh-tbl">
            <thead><tr><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th class="ta-r">Harga</th></tr></thead>
            <tbody>
              @forelse($barangTerbaru as $b)
              <tr>
                <td><code class="dsh-code">{{ $b->kode_barang??'-' }}</code></td>
                <td class="dsh-ell">{{ $b->nama_item }}</td>
                <td><span class="dsh-badge dsh-badge--bl">{{ $b->kategori->nama_kategori??'-' }}</span></td>
                <td class="ta-r dsh-price">
                  @if($b->harga_satuan>0) Rp {{ number_format($b->harga_satuan,0,',','.') }}
                  @else <span class="dsh-dim">—</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr><td colspan="4" style="text-align:center;color:var(--hint);padding:32px;">Belum ada data barang</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Riwayat Pengecekan --}}
      <div class="dsh-card" style="animation-delay:.37s">
        <div class="dsh-ch">
          <span class="dsh-ct">Riwayat Pengecekan</span>
          <a href="{{ route('riwayat.index') }}" class="dsh-lnk">Lihat semua →</a>
        </div>
        <div class="dsh-tw">
          <table class="dsh-tbl">
            <thead><tr><th>Waktu</th><th>Barang</th><th>Jenis</th><th>Perubahan</th></tr></thead>
            <tbody>
              @forelse($pengecekanTerbaru as $r)
              <tr>
                <td class="dsh-nw">
                  <span class="dsh-ds">{{ $r->created_at->format('d M Y') }}</span>
                  <span class="dsh-dt">{{ $r->created_at->format('H:i') }}</span>
                </td>
                <td>
                  <a href="{{ route('riwayat.show',$r->id_item) }}" class="dsh-al">{{ $r->kode_barang }}</a>
                  <span class="dsh-asub">{{ $r->nama_item }}</span>
                </td>
                <td>
                  @if($r->jenis_perubahan=='Kondisi')     <span class="dsh-badge dsh-badge--am">Kondisi</span>
                  @elseif($r->jenis_perubahan=='Ruangan') <span class="dsh-badge dsh-badge--bl">Ruangan</span>
                  @elseif($r->jenis_perubahan=='Semua')   <span class="dsh-badge dsh-badge--rd">Semua</span>
                  @else                                   <span class="dsh-badge dsh-badge--gy">Data</span>
                  @endif
                </td>
                <td>
                  @if($r->kondisi_lama !== $r->kondisi_baru)
                  <div class="dsh-chg">
                    <span class="dsh-badge dsh-badge--gy" style="font-size:10px">{{ $r->kondisi_lama??'Baru' }}</span>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#9AA3B5" stroke-width="2" style="flex-shrink:0"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    <span class="dsh-badge @if($r->kondisi_baru=='Baik') dsh-badge--gn @elseif($r->kondisi_baru=='Rusak Ringan') dsh-badge--am @else dsh-badge--rd @endif" style="font-size:10px">{{ $r->kondisi_baru }}</span>
                  </div>
                  @elseif($r->id_ruangan_lama !== $r->id_ruangan_baru)
                  <div class="dsh-chg">
                    <span class="dsh-badge dsh-badge--gy" style="font-size:10px">{{ $r->ruanganLama->nama_ruangan??'—' }}</span>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#9AA3B5" stroke-width="2" style="flex-shrink:0"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    <span class="dsh-badge dsh-badge--te" style="font-size:10px">{{ $r->ruanganBaru->nama_ruangan??'—' }}</span>
                  </div>
                  @else
                  <span class="dsh-dim">—</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr><td colspan="4" style="text-align:center;color:var(--hint);padding:32px;">Belum ada riwayat</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
  /* ── Donut ── */
  const raw    = @json($kondisiBarang ?? []);
  const canvas = document.getElementById('kondisiChart');
  if (canvas) {
    const g = k => (raw.find(r => r.kondisi === k) || {}).total || 0;
    const vals   = [g('Baik'), g('Rusak Ringan'), g('Rusak Berat')];
    const labels = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
    const colors = ['#16A34A', '#D97706', '#DC2626'];
    const data = vals.filter(v => v > 0);
    const fl   = labels.filter((_, i) => vals[i] > 0);
    const fc   = colors.filter((_, i) => vals[i] > 0);
    if (data.length > 0) {
      new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: { labels: fl, datasets: [{ data, backgroundColor: fc, borderWidth: 3, borderColor: '#ffffff', hoverOffset: 5 }] },
        options: { responsive: false, cutout: '72%', plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => '  ' + c.label + ': ' + c.parsed + ' item' } } } }
      });
    } else { canvas.style.display = 'none'; }
  }

  /* ── Tanggal + hari saja (tanpa jam) ── */
  const D = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const M = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  const n = new Date();
  const el = document.getElementById('dshNavDate');
  if (el) el.textContent = D[n.getDay()] + ', ' + n.getDate() + ' ' + M[n.getMonth()] + ' ' + n.getFullYear();
})();
</script>
@endpush