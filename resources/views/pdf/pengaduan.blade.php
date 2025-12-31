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
            font-size: 10px;
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
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            border: 1px solid #ddd;
        }
        
        table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 9px;
            vertical-align: top;
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
        
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
        }
        
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-proses {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-selesai {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-ditolak {
            background-color: #fee2e2;
            color: #991b1b;
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
        <strong>Total Pengaduan:</strong> {{ $pengaduan->count() }} pengaduan
        @if(isset($filter['status']))
            <br><strong>Filter Status:</strong> {{ ucfirst($filter['status']) }}
        @endif
        @if(isset($filter['start_date']) && isset($filter['end_date']))
            <br><strong>Periode:</strong> {{ $filter['start_date'] }} s/d {{ $filter['end_date'] }}
        @endif
    </div>
    
    @if($pengaduan->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">Pelapor</th>
                <th style="width: 15%;">Barang</th>
                <th style="width: 25%;">Deskripsi</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 19%;">Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduan as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                <td>{{ Str::limit($item->deskripsi, 80) }}</td>
                <td>
                    @if($item->status == 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @elseif($item->status == 'proses')
                        <span class="badge badge-proses">Proses</span>
                    @elseif($item->status == 'selesai')
                        <span class="badge badge-selesai">Selesai</span>
                    @else
                        <span class="badge badge-ditolak">Ditolak</span>
                    @endif
                </td>
                <td>{{ $item->tindak_lanjut ? Str::limit($item->tindak_lanjut, 60) : '-' }}</td>
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