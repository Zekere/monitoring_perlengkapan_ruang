<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 20px;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
        }
        
        .header h2 {
            margin: 5px 0;
            color: #1e3a8a;
            font-size: 18px;
        }
        
        .header h3 {
            margin: 5px 0;
            color: #334155;
            font-size: 14px;
            font-weight: normal;
        }
        
        .info {
            margin-bottom: 15px;
            font-size: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th {
            background-color: #1e3a8a;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            border: 1px solid #ddd;
        }
        
        table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #64748b;
            padding: 10px 0;
            border-top: 1px solid #e2e8f0;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>KEMENTERIAN PEKERJAAN UMUM</h2>
        <h3>{{ $title }}</h3>
    </div>
    
    <div class="info">
        <strong>Tanggal Cetak:</strong> {{ $date }}<br>
        <strong>Total Kategori:</strong> {{ $kategori->count() }} kategori
    </div>
    
    @if($kategori->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 40%;">Nama Kategori</th>
                <th style="width: 35%;">Keterangan</th>
                <th style="width: 15%; text-align: center;">Jumlah Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->nama_kategori }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td style="text-align: center;">{{ $item->barang_count ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data yang tersedia</p>
    </div>
    @endif
    
    <div class="footer">
        © {{ date('Y') }} Kementerian Pekerjaan Umum - Dicetak pada {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>