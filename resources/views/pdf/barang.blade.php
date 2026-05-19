<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 25px 20px 50px 20px;
            size: A4 landscape;
        }

        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            background: #fff;
        }

        /* ── HEADER ── */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 18px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 12px;
        }
        .header-left  { display: table-cell; vertical-align: middle; width: 70%; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; width: 30%; }
        .header h2    { margin: 0 0 3px 0; color: #1e3a8a; font-size: 17px; letter-spacing: .3px; }
        .header h3    { margin: 0 0 3px 0; color: #334155; font-size: 12px; font-weight: normal; }
        .header-badge {
            display: inline-block;
            background: #1e3a8a; color: #fff;
            font-size: 9px; font-weight: bold;
            padding: 3px 10px; border-radius: 20px; letter-spacing: .5px;
        }

        /* ── INFO BAR ── */
        .info-bar {
            display: table; width: 100%;
            margin-bottom: 14px;
            background: #f1f5f9; border-radius: 6px; padding: 8px 12px;
        }
        .info-bar-left  { display: table-cell; width: 60%; vertical-align: middle; }
        .info-bar-right { display: table-cell; width: 40%; vertical-align: middle; text-align: right; }
        .info-bar span  { color: #64748b; margin-right: 16px; font-size: 9.5px; }
        .info-bar strong { color: #1e293b; }

        /* ── SUMMARY BOXES ── */
        .summary { display: table; width: 100%; margin-bottom: 14px; }
        .summary-box {
            display: table-cell; padding: 8px 10px;
            border-radius: 8px; text-align: center; vertical-align: middle;
        }
        .summary-box .s-num { font-size: 18px; font-weight: bold; line-height: 1; }
        .summary-box .s-lbl { font-size: 8.5px; margin-top: 3px; }
        .box-total { background: #eff6ff; color: #1d4ed8; }
        .box-baik  { background: #f0fdf4; color: #15803d; }
        .box-rusak { background: #fffbeb; color: #b45309; }
        .box-berat { background: #fef2f2; color: #b91c1c; }
        .box-nilai { background: #f5f3ff; color: #6d28d9; }

        /* ── TABLE ── */
        table.main { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.main thead tr { background: #1e3a8a; }
        table.main thead th {
            color: #fff; padding: 7px 5px;
            text-align: left; font-size: 9px;
            border: 1px solid #1e3a8a; letter-spacing: .3px;
        }
        table.main thead th.center { text-align: center; }
        table.main thead th.right  { text-align: right; }

        table.main tbody tr:nth-child(even) { background: #f8fafc; }
        table.main tbody td {
            padding: 5px 5px; border: 1px solid #e2e8f0;
            font-size: 9px; vertical-align: middle;
        }
        table.main tbody td.center { text-align: center; }
        table.main tbody td.right  { text-align: right; }

        table.main tbody tr:nth-child(odd)  td:first-child { border-left: 3px solid #3b82f6; }
        table.main tbody tr:nth-child(even) td:first-child { border-left: 3px solid #93c5fd; }

        /* ── TFOOT ── */
        table.main tfoot td {
            padding: 7px 5px; font-size: 10px; font-weight: bold;
            background: #1e3a8a; color: #fff; border: 1px solid #1e3a8a;
        }
        table.main tfoot td.right { text-align: right; }

        /* ── TOTAL BOX BAWAH ── */
        .total-box {
            display: table; width: 100%;
            margin-bottom: 20px;
            border: 2px solid #6d28d9;
            border-radius: 8px; overflow: hidden;
        }
        .total-box-left {
            display: table-cell; width: 70%;
            background: #f5f3ff; padding: 12px 16px;
            vertical-align: middle;
        }
        .total-box-right {
            display: table-cell; width: 30%;
            background: #6d28d9; padding: 12px 16px;
            vertical-align: middle; text-align: right;
        }
        .total-box-left .t-label  { font-size: 10px; color: #6d28d9; font-weight: bold; letter-spacing: .3px; }
        .total-box-left .t-sublabel { font-size: 8.5px; color: #7c3aed; margin-top: 2px; }
        .total-box-right .t-amount { font-size: 14px; font-weight: bold; color: #fff; }
        .total-box-right .t-desc   { font-size: 8px; color: #ddd8fe; margin-top: 2px; }

        /* ── BADGES ── */
        .badge { display: inline-block; padding: 2px 6px; border-radius: 20px; font-size: 8px; font-weight: bold; }
        .badge-baik   { background: #dcfce7; color: #166534; }
        .badge-ringan { background: #fef9c3; color: #854d0e; }
        .badge-berat  { background: #fee2e2; color: #991b1b; }

        /* ── FOTO ── */
        .foto-img  { width: 44px; height: 44px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1; }
        .foto-none { font-size: 8px; color: #94a3b8; font-style: italic; }

        /* ── TANDA TANGAN ── */
        .ttd-table { width: 100%; border: none; margin-top: 20px; }
        .ttd-table td { border: none; padding: 8px 20px; vertical-align: top; text-align: center; width: 33.33%; }
        .ttd-line  { border-top: 1px solid #334155; display: inline-block; padding-top: 4px; min-width: 180px; font-size: 9.5px; }
        .ttd-title { font-weight: bold; margin-bottom: 4px; font-size: 9.5px; }
        .ttd-space { height: 65px; }
        .ttd-nip   { font-size: 9px; color: #64748b; margin-top: 4px; }

        /* ── FOOTER ── */
        .footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            text-align: center; font-size: 8.5px; color: #94a3b8;
            padding: 6px 0; border-top: 1px solid #e2e8f0; background: #fff;
        }

        .no-data { text-align: center; padding: 40px; color: #64748b; }
        .kode    { font-family: monospace; font-size: 8.5px; color: #3b82f6; }
    </style>
</head>
<body>

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="header-left">
            <h2>Ditjen Cipta Karya</h2>
            <h3>Kementerian Pekerjaan Umum dan Perumahan Rakyat</h3>
            <span class="header-badge">{{ $title }}</span>
        </div>
        <div class="header-right">
            <div style="font-size:9px;color:#64748b;">Dicetak&nbsp;oleh&nbsp;Sistem</div>
            <div style="font-size:11px;font-weight:bold;color:#1e3a8a;">{{ $date }}</div>
        </div>
    </div>

    {{-- ── INFO BAR ── --}}
    <div class="info-bar">
        <div class="info-bar-left">
            <span><strong>Tanggal Cetak:</strong> {{ $date }}</span>
            <span><strong>Total Item:</strong> {{ $barang->count() }} barang</span>
        </div>
        <div class="info-bar-right">
            <span style="font-size:9px;color:#64748b;">Dokumen resmi — harap simpan dengan baik</span>
        </div>
    </div>

    {{-- ── SUMMARY BOXES ── --}}
    @php
        $jmlBaik    = $barang->where('kondisi','Baik')->count();
        $jmlRingan  = $barang->where('kondisi','Rusak Ringan')->count();
        $jmlBerat   = $barang->where('kondisi','Rusak Berat')->count();
        $totalNilai = $barang->sum('harga_satuan');
    @endphp
    <div class="summary">
        <div class="summary-box box-total" style="width:20%;">
            <div class="s-num">{{ $barang->count() }}</div>
            <div class="s-lbl">Total Barang</div>
        </div>
        <div class="summary-box box-baik" style="width:20%;margin-left:6px;">
            <div class="s-num">{{ $jmlBaik }}</div>
            <div class="s-lbl">Kondisi Baik</div>
        </div>
        <div class="summary-box box-rusak" style="width:20%;margin-left:6px;">
            <div class="s-num">{{ $jmlRingan }}</div>
            <div class="s-lbl">Rusak Ringan</div>
        </div>
        <div class="summary-box box-berat" style="width:20%;margin-left:6px;">
            <div class="s-num">{{ $jmlBerat }}</div>
            <div class="s-lbl">Rusak Berat</div>
        </div>
        <div class="summary-box box-nilai" style="width:20%;margin-left:6px;">
            <div class="s-num" style="font-size:11px;">Rp {{ number_format($totalNilai,0,',','.') }}</div>
            <div class="s-lbl">Total Nilai Barang</div>
        </div>
    </div>

    {{-- ── TABLE ── --}}
    @if($barang->count() > 0)
    <table class="main">
        <thead>
            <tr>
                <th class="center" style="width:3%;">No</th>
                <th style="width:10%;">Kode Barang</th>
                <th style="width:16%;">Nama Barang</th>
                <th style="width:9%;">Kategori</th>
                <th style="width:10%;">Ruangan</th>
                <th style="width:8%;">Merk</th>
                <th class="center" style="width:6%;">Foto</th>
                <th class="center" style="width:9%;">Kondisi</th>
                <th class="right"  style="width:13%;">Harga Satuan</th>
                <th class="center" style="width:8%;">Tgl. Input</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td><span class="kode">{{ $item->kode_barang ?? '-' }}</span></td>
                <td><strong>{{ $item->nama_item }}</strong></td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                <td>{{ $item->merk ?? '-' }}</td>

                {{-- Foto --}}
                <td class="center">
                    @if($item->foto && file_exists(public_path('storage/' . $item->foto)))
                        <img src="{{ public_path('storage/' . $item->foto) }}" class="foto-img">
                    @else
                        <span class="foto-none">Tidak ada</span>
                    @endif
                </td>

                {{-- Kondisi --}}
                <td class="center">
                    @if($item->kondisi === 'Baik')
                        <span class="badge badge-baik">&#10003; Baik</span>
                    @elseif($item->kondisi === 'Rusak Ringan')
                        <span class="badge badge-ringan">&#9888; Rusak Ringan</span>
                    @elseif($item->kondisi === 'Rusak Berat')
                        <span class="badge badge-berat">&#10007; Rusak Berat</span>
                    @else
                        <span style="color:#94a3b8;font-size:8px;">-</span>
                    @endif
                </td>

                {{-- Harga Satuan --}}
                <td class="right">
                    @if(isset($item->harga_satuan) && $item->harga_satuan > 0)
                        <strong>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</strong>
                    @else
                        <span style="color:#94a3b8;">-</span>
                    @endif
                </td>

                {{-- Tanggal --}}
                <td class="center" style="color:#64748b;">
                    {{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align:right;letter-spacing:.3px;font-size:9.5px;">
                    TOTAL NILAI KESELURUHAN BARANG
                </td>
                <td class="right">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    {{-- ── TOTAL BOX BAWAH ── --}}
    <div class="total-box">
        <div class="total-box-left">
            <div class="t-label">&#128197; REKAPITULASI NILAI ASET BARANG</div>
            <div class="t-sublabel">
                Berdasarkan {{ $barang->count() }} item barang &nbsp;|&nbsp;
                Baik: {{ $jmlBaik }} &nbsp;·&nbsp;
                Rusak Ringan: {{ $jmlRingan }} &nbsp;·&nbsp;
                Rusak Berat: {{ $jmlBerat }}
            </div>
        </div>
        <div class="total-box-right">
            <div class="t-amount">Rp {{ number_format($totalNilai, 0, ',', '.') }}</div>
            <div class="t-desc">Total Nilai Seluruh Barang</div>
        </div>
    </div>

    @else
    <div class="no-data">
        <p>Tidak ada data yang tersedia</p>
    </div>
    @endif

 {{-- ── TANDA TANGAN ── --}}
<div style="page-break-inside:avoid; margin-top: 40px;">
    <table style="width:100%;">
        <tr>
            <td style="width:60%;"></td>
            <td style="width:40%; text-align:center;">
                <div style="margin-bottom: 4px;">Semarang, {{ $date }}</div>
                <div style="margin-bottom: 70px;">Mengetahui,</div>
                <div style="margin-bottom: 4px;">( _________________________ )</div>
                <div>NIP. ___________________</div>
            </td>
        </tr>
    </table>
</div>

    {{-- ── FOOTER ── --}}
    <div class="footer">
        &copy; {{ date('Y') }} Kementerian Pekerjaan Umum dan Perumahan Rakyat
        &nbsp;&middot;&nbsp;
        Dicetak pada {{ now()->format('d/m/Y H:i:s') }}
        &nbsp;&middot;&nbsp;
        Dokumen ini dicetak secara otomatis oleh sistem
    </div>

</body>
</html>