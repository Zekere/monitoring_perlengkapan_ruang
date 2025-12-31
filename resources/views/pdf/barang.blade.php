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
        
        .logo {
            width: 60px;
            margin-bottom: 10px;
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
            font-size: 10px;
            border: 1px solid #ddd;
        }
        
        table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 10px;
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
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-baik {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-rusak {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .badge-hilang {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-baik {
    background-color: #dcfce7;
    color: #166534;
}

.badge-rusak {
    background-color: #fef3c7;
    color: #92400e;
}

.badge-hilang {
    background-color: #fee2e2;
    color: #991b1b;
}

    </style>
</head>
<body>
    <div class="header">
        <h2>Ditjen Cipta Karya</h2>
        <h3>{{ $title }}</h3>
    </div>
    
    <div class="info">
        <strong>Tanggal Cetak:</strong> {{ $date }}<br>
        <strong>Total Data:</strong> {{ $barang->count() }} item
    </div>
    
    @if($barang->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Barang</th>
                <th style="width: 25%;">Nama Barang</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 15%;">Ruangan</th>
                <th width="12%">Merk</th>
                <th width="12%">Foto</th>
                <th style="width: 15%;">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang ?? '-' }}</td>
                <td>{{ $item->nama_item }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                <td>{{ $item->merk ?? '-' }}</td>
                <!-- FOTO BARANG -->
         <td align="center">
    @if($item->foto && file_exists(public_path('storage/' . $item->foto)))
        <img 
            src="{{ public_path('storage/' . $item->foto) }}"
            style="
                width:60px;
                height:60px;
                object-fit:cover;
                border:1px solid #ccc;
            "
        >
    @else
        <span style="font-size:9px;color:#999;">Tidak ada foto</span>
    @endif
</td>


            
                <td>
                    @if($item->kondisi === 'Baik')
                        <span class="badge badge-baik">Baik</span>

                    @elseif($item->kondisi === 'Rusak Ringan')
                        <span class="badge badge-rusak">Rusak Ringan</span>

                    @elseif($item->kondisi === 'Rusak Berat')
                        <span class="badge badge-hilang">Rusak Berat</span>

                    @else
                        <span style="font-size:9px;color:#999;">Tidak diketahui</span>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data yang tersedia</p>
    </div>
    @endif
    
    <!-- Tanda Tangan -->
    <div style="margin-top: 40px; page-break-inside: avoid;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 50%; border: none; padding: 10px; vertical-align: top;">
                    <div style="text-align: center;">
                        <p style="margin-bottom: 5px;">Mengetahui,</p>
                        <p style="margin-bottom: 5px; font-weight: bold;">Kepala Bagian Perlengkapan</p>
                        <div style="height: 80px; margin: 10px 0;"></div>
                        <p style="border-top: 1px solid #000; display: inline-block; padding-top: 5px; min-width: 200px;">
                            ( _________________________ )
                        </p>
                        <p style="margin-top: 5px; font-size: 10px;">NIP. ___________________</p>
                    </div>
                </td>
                <td style="width: 50%; border: none; padding: 10px; vertical-align: top;">
                    <div style="text-align: center;">
                        <p style="margin-bottom: 5px;">Semarang, {{ $date }}</p>
                        <p style="margin-bottom: 5px; font-weight: bold;">Penanggung Jawab</p>
                        <div style="height: 80px; margin: 10px 0;"></div>
                        <p style="border-top: 1px solid #000; display: inline-block; padding-top: 5px; min-width: 200px;">
                            ( _________________________ )
                        </p>
                        <p style="margin-top: 5px; font-size: 10px;">NIP. ___________________</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        © {{ date('Y') }} Kementerian Pekerjaan Umum - Dicetak pada {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>