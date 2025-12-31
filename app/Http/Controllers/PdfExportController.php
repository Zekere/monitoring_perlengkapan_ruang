<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Pengaduan;
use App\Models\Pengecekan;

class PdfExportController extends Controller
{
    /**
     * Export Barang ke PDF
     */
    public function exportBarang()
    {
        $barang = Barang::with(['kategori', 'ruangan'])->get();
        
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
        $barang = Barang::where('kategori_id', $kategoriId)
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
        $barang = Barang::where('ruangan_id', $ruanganId)
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
        $kategori = Kategori::withCount('barang')->get();
        
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
        $ruangan = Ruangan::withCount('barang')->get();
        
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
        $query = Pengaduan::with(['user', 'barang']);
        
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
        $query = Pengecekan::with(['user', 'barang']);
        
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
    
}