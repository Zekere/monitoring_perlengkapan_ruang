<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Item;  // Ganti dari Barang ke Item
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Pengaduan;
use App\Models\Pengecekan;
use App\Models\RiwayatPerawatan;

class PdfExportController extends Controller
{
    /**
     * Export Barang (Item) ke PDF
     */
    public function exportBarang()
    {
        $barang = Item::with(['kategori', 'ruangan'])->get();
        
        $pdf = Pdf::loadView('pdf.barang', [
            'barang' => $barang,
            'title' => 'Laporan Data Barang',
            'date' => now()->format('d F Y')
        ]);
        
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-barang-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Barang berdasarkan Kategori
     */
    public function exportBarangByKategori($kategoriId)
    {
        $kategori = Kategori::findOrFail($kategoriId);
        $barang = Item::where('id_kategori', $kategoriId)
                        ->with(['kategori', 'ruangan'])
                        ->get();
        
        $pdf = Pdf::loadView('pdf.barang', [
            'barang' => $barang,
            'title' => 'Laporan Data Barang - Kategori: ' . $kategori->nama_kategori,
            'date' => now()->format('d F Y')
        ]);
        
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-barang-kategori-' . $kategori->nama_kategori . '-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Barang berdasarkan Ruangan
     */
    public function exportBarangByRuangan($ruanganId)
    {
        $ruangan = Ruangan::findOrFail($ruanganId);
        $barang = Item::where('id_ruangan', $ruanganId)
                        ->with(['kategori', 'ruangan'])
                        ->get();
        
        $pdf = Pdf::loadView('pdf.barang', [
            'barang' => $barang,
            'title' => 'Laporan Data Barang - Ruangan: ' . $ruangan->nama_ruangan,
            'date' => now()->format('d F Y')
        ]);
        
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-barang-ruangan-' . $ruangan->nama_ruangan . '-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Kategori ke PDF
     */
    public function exportKategori()
    {
        // Sesuaikan dengan nama relasi di model Kategori
        $kategori = Kategori::withCount('items')->get(); // atau tetap 'barang' tergantung nama relasi
        
        $pdf = Pdf::loadView('pdf.kategori', [
            'kategori' => $kategori,
            'title' => 'Laporan Data Kategori',
            'date' => now()->format('d F Y')
        ]);
        
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('laporan-kategori-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Ruangan ke PDF
     */
    public function exportRuangan()
    {
        // Sesuaikan dengan nama relasi di model Ruangan
        $ruangan = Ruangan::withCount('items')->get(); // atau tetap 'barang' tergantung nama relasi
        
        $pdf = Pdf::loadView('pdf.ruangan', [
            'ruangan' => $ruangan,
            'title' => 'Laporan Data Ruangan',
            'date' => now()->format('d F Y')
        ]);
        
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('laporan-ruangan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Pengaduan ke PDF
     */
    public function exportPengaduan(Request $request)
    {
        // Sesuaikan relasi 'barang' menjadi 'item' jika perlu
        $query = Pengaduan::with(['user', 'item']); // atau tetap 'barang' tergantung nama relasi
        
        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        $pengaduan = $query->get();
        
        $pdf = Pdf::loadView('pdf.pengaduan', [
            'pengaduan' => $pengaduan,
            'title' => 'Laporan Data Pengaduan',
            'date' => now()->format('d F Y'),
            'filter' => $request->all()
        ]);
        
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-pengaduan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Pengecekan ke PDF
     */
    public function exportPengecekan(Request $request)
    {
        // Sesuaikan relasi 'barang' menjadi 'item' jika perlu
        $query = Pengecekan::with(['user', 'item']); // atau tetap 'barang' tergantung nama relasi
        
        // Filter berdasarkan kondisi jika ada
        if ($request->has('kondisi') && $request->kondisi != '') {
            $query->where('kondisi', $request->kondisi);
        }
        
        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_cek', [$request->start_date, $request->end_date]);
        }
        
        $pengecekan = $query->get();
        
        $pdf = Pdf::loadView('pdf.pengecekan', [
            'pengecekan' => $pengecekan,
            'title' => 'Laporan Data Pengecekan',
            'date' => now()->format('d F Y'),
            'filter' => $request->all()
        ]);
        
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-pengecekan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Riwayat Perawatan ke PDF
     */
   public function exportRiwayatPerawatan(Request $request)
{
    // Gunakan bulan & tahun dari request, default ke bulan/tahun berjalan
    $bulan = (int) $request->get('bulan', date('n'));
    $tahun = (int) $request->get('tahun', date('Y'));

    $query = RiwayatPerawatan::with(['item.kategori', 'item.ruangan'])
        ->whereMonth('tanggal_perawatan', $bulan)
        ->whereYear('tanggal_perawatan', $tahun);

    // Filter opsional tambahan
    if ($request->filled('jenis_perawatan')) {
        $query->where('jenis_perawatan', $request->jenis_perawatan);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    if ($request->filled('id_item')) {
        $query->where('id_item', $request->id_item);
    }

    $riwayatPerawatan = $query->orderBy('tanggal_perawatan', 'desc')->get();

    $namaBulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
    ];

    $pdf = Pdf::loadView('pdf.riwayat-perawatan', [
        'riwayatPerawatan' => $riwayatPerawatan,
        'title'            => 'Laporan Riwayat Perawatan',
        'date'             => now()->format('d F Y'),
        'filter'           => $request->all(),
        'bulan'            => $bulan,
        'tahun'            => $tahun,
        'namaBulan'        => $namaBulan[$bulan],
    ]);

    $pdf->setPaper('a4', 'landscape');

    return $pdf->download(
        'laporan-riwayat-perawatan-' . $namaBulan[$bulan] . '-' . $tahun . '.pdf'
    );
}
}