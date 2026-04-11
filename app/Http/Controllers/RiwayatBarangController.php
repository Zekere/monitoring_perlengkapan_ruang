<?php

namespace App\Http\Controllers;

use App\Models\RiwayatBarang;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatBarangController extends Controller
{
    // Menampilkan semua riwayat (tanpa limit/paginate)
    public function index(Request $request)
    {
        $query = RiwayatBarang::with(['item', 'ruanganLama', 'ruanganBaru'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan barang
        if ($request->filled('id_item')) {
            $query->where('id_item', $request->id_item);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter berdasarkan jenis perubahan
        if ($request->filled('jenis_perubahan')) {
            $query->where('jenis_perubahan', $request->jenis_perubahan);
        }

        $riwayat = $query->get(); // ← ganti paginate(20) dengan get()
        $items   = Item::orderBy('nama_item')->get();

        return view('riwayat.index', compact('riwayat', 'items'));
    }

    // Menampilkan riwayat untuk barang tertentu
    public function show($id_item)
    {
        $item = Item::with(['kategori', 'ruangan'])->findOrFail($id_item);

        $riwayat = RiwayatBarang::where('id_item', $id_item)
            ->with(['ruanganLama', 'ruanganBaru'])
            ->orderBy('created_at', 'desc')
            ->get(); // ← ganti paginate(15) dengan get()

        return view('riwayat.show', compact('item', 'riwayat'));
    }

    // Export PDF riwayat
    public function exportPdf(Request $request)
    {
        $query = RiwayatBarang::with(['item', 'ruanganLama', 'ruanganBaru'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('id_item')) {
            $query->where('id_item', $request->id_item);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $riwayat = $query->get();

        $pdf = Pdf::loadView('pdf.riwayat', compact('riwayat'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('riwayat-barang-' . date('Y-m-d') . '.pdf');
    }

    // API endpoint untuk mendapatkan riwayat via AJAX
    public function getRiwayat(Request $request)
    {
        $query = RiwayatBarang::with(['item', 'ruanganLama', 'ruanganBaru'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('id_item')) {
            $query->where('id_item', $request->id_item);
        }

        $riwayat = $query->limit(10)->get();

        return response()->json([
            'success' => true,
            'data'    => $riwayat
        ]);
    }

    // Statistik riwayat
    public function statistics()
    {
        $stats = [
            'total_perubahan'      => RiwayatBarang::count(),
            'perubahan_hari_ini'   => RiwayatBarang::whereDate('created_at', today())->count(),
            'perubahan_bulan_ini'  => RiwayatBarang::whereMonth('created_at', now()->month)
                                          ->whereYear('created_at', now()->year)
                                          ->count(),
            'per_jenis'            => RiwayatBarang::selectRaw('jenis_perubahan, COUNT(*) as total')
                                          ->groupBy('jenis_perubahan')
                                          ->get()
                                          ->pluck('total', 'jenis_perubahan'),
            'barang_paling_sering' => RiwayatBarang::selectRaw('id_item, COUNT(*) as total')
                                          ->with('item')
                                          ->groupBy('id_item')
                                          ->orderBy('total', 'desc')
                                          ->limit(5)
                                          ->get()
        ];

        return view('riwayat.statistics', compact('stats'));
    }

    // =========================================================
    // METHOD HELPER — dipanggil dari ItemController
    // =========================================================

    /**
     * Catat riwayat perubahan foto barang.
     *
     * Panggil method ini dari ItemController saat foto diupdate atau dihapus:
     *
     *   RiwayatBarangController::catatPerubahanFoto(
     *       $item,           // object Item setelah disave
     *       $fotoLama,       // string|null  — path foto lama
     *       $fotoBaruPath,   // string|null  — path foto baru (null jika dihapus)
     *       auth()->user()->name
     *   );
     */
    public static function catatPerubahanFoto(
        Item    $item,
        ?string $fotoLama,
        ?string $fotoBaru,
        string  $updatedBy,
        string  $keterangan = 'Foto barang diperbarui'
    ): void {
        RiwayatBarang::create([
            'id_item'         => $item->id_item,
            'kode_barang'     => $item->kode_barang,
            'nama_item'       => $item->nama_item,
            'jenis_perubahan' => 'Foto',
            'kondisi_lama'    => $item->kondisi,
            'kondisi_baru'    => $item->kondisi,
            'id_ruangan_lama' => $item->id_ruangan,
            'id_ruangan_baru' => $item->id_ruangan,
            'foto_lama'       => $fotoLama,
            'foto_baru'       => $fotoBaru,
            'keterangan'      => $keterangan,
            'updated_by'      => $updatedBy,
        ]);
    }
}