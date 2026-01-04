<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
            text-transform: uppercase;
            color: #2c3e50;
        }
        
        .header h2 {
            font-size: 16px;
            color: #34495e;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #7f8c8d;
        }
        
        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
        }
        
        .info-section p {
            margin: 5px 0;
            font-size: 10px;
        }
        
        .info-section strong {
            color: #2c3e50;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        table thead {
            background-color: #34495e;
            color: white;
        }
        
        table th {
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #2c3e50;
        }
        
        table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 10px;
            vertical-align: top;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        table tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        
        .badge-preventif {
            background-color: #3498db;
            color: white;
        }
        
        .badge-korektif {
            background-color: #e74c3c;
            color: white;
        }
        
        .badge-prediktif {
            background-color: #f39c12;
            color: white;
        }
        
        .badge-rutin {
            background-color: #27ae60;
            color: white;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
        }
        
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #ecf0f1;
            border-radius: 5px;
        }
        
        .summary h3 {
            font-size: 12px;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        
        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 3px;
            border: 1px solid #bdc3c7;
        }
        
        .summary-item .label {
            font-size: 9px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }
        
        .summary-item .value {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $title }}</h1>
        <h2>Sistem Monitoring Perlengkapan Ruang</h2>
        <p>Dicetak pada: {{ $date }}</p>
    </div>

    <!-- Info Filter -->
    @if(!empty($filter))
    <div class="info-section">
        <p><strong>Filter yang Diterapkan:</strong></p>
        @if(isset($filter['jenis_perawatan']) && $filter['jenis_perawatan'] != '')
            <p>• Jenis Perawatan: <strong>{{ ucfirst($filter['jenis_perawatan']) }}</strong></p>
        @endif
        @if(isset($filter['start_date']) && isset($filter['end_date']))
            <p>• Periode: <strong>{{ date('d/m/Y', strtotime($filter['start_date'])) }} - {{ date('d/m/Y', strtotime($filter['end_date'])) }}</strong></p>
        @endif
        @if(isset($filter['id_item']) && $filter['id_item'] != '')
            <p>• Item ID: <strong>#{{ $filter['id_item'] }}</strong></p>
        @endif
        @if(isset($filter['status']) && $filter['status'] != '')
            <p>• Status: <strong>{{ $filter['status'] }}</strong></p>
        @endif
    </div>
    @endif

    <!-- Summary Statistics -->
    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total Perawatan</div>
                <div class="value">{{ $riwayatPerawatan->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Selesai</div>
                <div class="value">{{ $riwayatPerawatan->where('status', 'Selesai')->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Dalam Proses</div>
                <div class="value">{{ $riwayatPerawatan->where('status', 'Dalam Proses')->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Total Biaya</div>
                <div class="value">Rp {{ number_format($riwayatPerawatan->sum('biaya'), 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    @if($riwayatPerawatan->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Tanggal</th>
                <th width="18%">Nama Item</th>
                <th width="10%">Kode Item</th>
                <th width="10%">Jenis</th>
                <th width="17%">Deskripsi</th>
                <th width="10%">Teknisi</th>
                <th width="10%">Biaya</th>
                <th width="12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatPerawatan as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_perawatan)->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $item->item->nama_item ?? '-' }}</strong><br>
                    <small style="color: #7f8c8d;">{{ $item->item->kategori->nama_kategori ?? '-' }}</small>
                </td>
                <td>{{ $item->item->kode_item ?? '-' }}</td>
                <td>
                    <span class="badge badge-preventif">{{ $item->jenis_perawatan }}</span>
                </td>
                <td>{{ $item->deskripsi ?? '-' }}</td>
                <td>{{ $item->teknisi ?? '-' }}</td>
                <td style="text-align: right;">
                    @if($item->biaya)
                        Rp {{ number_format($item->biaya, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td style="text-align: center;">
                    @if($item->status == 'Selesai')
                        <span class="badge badge-rutin">Selesai</span>
                    @elseif($item->status == 'Dalam Proses')
                        <span class="badge badge-prediktif">Dalam Proses</span>
                    @else
                        <span class="badge badge-korektif">Ditunda</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #34495e; color: white; font-weight: bold;">
                <td colspan="8" style="text-align: right; padding: 10px;">TOTAL BIAYA:</td>
                <td style="text-align: right; padding: 10px;">
                    Rp {{ number_format($riwayatPerawatan->sum('biaya'), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data riwayat perawatan yang tersedia.</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Monitoring Perlengkapan Ruang</p>
        <p>© {{ date('Y') }} - Semua hak dilindungi</p>
    </div>
</body>
</html>