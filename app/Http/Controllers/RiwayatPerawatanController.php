<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPerawatan;
use App\Models\Item;
use Illuminate\Http\Request;

class RiwayatPerawatanController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatPerawatan::with('item.kategori', 'item.ruangan')
            ->orderBy('tanggal_perawatan', 'desc');

        // Filter berdasarkan item
        if ($request->has('id_item') && $request->id_item != '') {
            $query->where('id_item', $request->id_item);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis perawatan
        if ($request->has('jenis_perawatan') && $request->jenis_perawatan != '') {
            $query->where('jenis_perawatan', $request->jenis_perawatan);
        }

        $riwayat = $query->paginate(10);
        $items   = Item::orderBy('nama_item')->get();

        return view('riwayat_perawatan.index', compact('riwayat', 'items'));
    }

    public function create()
    {
        $items = Item::orderBy('nama_item')->get();
        return view('riwayat_perawatan.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_item'           => 'required|exists:items,id_item',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan'   => 'required|string|max:100',
            'deskripsi'         => 'required|string',
            'teknisi'           => 'required|string|max:100',
            'biaya'             => 'required|numeric|min:0',
            'status'            => 'required|in:Selesai,Dalam Proses,Ditunda',
            'catatan'           => 'nullable|string'
        ]);

        RiwayatPerawatan::create($validated);

        return redirect()->route('riwayat-perawatan.index')
            ->with('success', 'Riwayat perawatan berhasil ditambahkan');
    }

    public function show($id)
    {
        $riwayat = RiwayatPerawatan::with('item.kategori', 'item.ruangan')->findOrFail($id);
        return view('riwayat_perawatan.show', compact('riwayat'));
    }

    public function edit($id)
    {
        $riwayat = RiwayatPerawatan::findOrFail($id);
        $items   = Item::orderBy('nama_item')->get();
        return view('riwayat_perawatan.edit', compact('riwayat', 'items'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_item'           => 'required|exists:items,id_item',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan'   => 'required|string|max:100',
            'deskripsi'         => 'required|string',
            'teknisi'           => 'required|string|max:100',
            'biaya'             => 'required|numeric|min:0',
            'status'            => 'required|in:Selesai,Dalam Proses,Ditunda',
            'catatan'           => 'nullable|string'
        ]);

        $riwayat = RiwayatPerawatan::findOrFail($id);
        $riwayat->update($validated);

        return redirect()->route('riwayat-perawatan.index')
            ->with('success', 'Riwayat perawatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $riwayat = RiwayatPerawatan::findOrFail($id);
        $riwayat->delete();

        // Catatan: jumlah_perawatan di tabel items TIDAK dikurangi (by design)
        // agar indikator perawatan di halaman barang tetap tampil

        return redirect()->route('riwayat-perawatan.index')
            ->with('success', 'Riwayat perawatan berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | STATISTIK PERAWATAN
    | Route: GET /riwayat-perawatan/statistik
    | Name : riwayat-perawatan.statistik
    |--------------------------------------------------------------------------
    */
    public function statistik(Request $request)
    {
        // Top 10 barang paling sering dirawat (dari kolom permanen)
        $topBarang = Item::with(['kategori', 'ruangan'])
            ->where('jumlah_perawatan', '>', 0)
            ->orderBy('jumlah_perawatan', 'desc')
            ->take(10)
            ->get();

        // Summary cards
        $totalPerawatan     = RiwayatPerawatan::count();
        $totalBiaya         = RiwayatPerawatan::sum('biaya');
        $totalBarangDirawat = Item::where('jumlah_perawatan', '>', 0)->count();

        // Status
        $statusSelesai     = RiwayatPerawatan::where('status', 'Selesai')->count();
        $statusDalamProses = RiwayatPerawatan::where('status', 'Dalam Proses')->count();
        $statusDitunda     = RiwayatPerawatan::where('status', 'Ditunda')->count();

        // Perawatan per bulan tahun ini
        $perawatanPerBulan = RiwayatPerawatan::selectRaw(
                'MONTH(tanggal_perawatan) as bulan,
                 YEAR(tanggal_perawatan) as tahun,
                 COUNT(*) as jumlah'
            )
            ->whereYear('tanggal_perawatan', date('Y'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();

        // Distribusi jenis perawatan
        $jenisPerawatan = RiwayatPerawatan::selectRaw('jenis_perawatan, COUNT(*) as jumlah')
            ->groupBy('jenis_perawatan')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Maks untuk progress bar relatif
        $maxCount = $topBarang->max('jumlah_perawatan') ?: 1;

        return view('riwayat_perawatan.statistik', compact(
            'topBarang',
            'totalPerawatan',
            'totalBiaya',
            'totalBarangDirawat',
            'statusSelesai',
            'statusDalamProses',
            'statusDitunda',
            'perawatanPerBulan',
            'jenisPerawatan',
            'maxCount'
        ));
    }
}