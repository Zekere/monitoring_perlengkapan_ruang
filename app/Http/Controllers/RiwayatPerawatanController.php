<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPerawatan;
use App\Models\Item;
use Illuminate\Http\Request;

class RiwayatPerawatanController extends Controller
{
    public function index(Request $request)
    {
        // Default: bulan & tahun berjalan
        $bulan = (int) $request->get('bulan', date('n'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $query = RiwayatPerawatan::with('item.kategori', 'item.ruangan')
            ->orderBy('tanggal_perawatan', 'desc')
            ->whereMonth('tanggal_perawatan', $bulan)
            ->whereYear('tanggal_perawatan', $tahun);

        if ($request->has('id_item') && $request->id_item != '') {
            $query->where('id_item', $request->id_item);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('jenis_perawatan') && $request->jenis_perawatan != '') {
            $query->where('jenis_perawatan', $request->jenis_perawatan);
        }

        $riwayat = $query->paginate(10)->withQueryString();
        $items   = Item::orderBy('nama_item')->get();

        // Daftar tahun yang tersedia untuk dropdown
        $daftarTahun = RiwayatPerawatan::selectRaw('YEAR(tanggal_perawatan) as tahun')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('riwayat_perawatan.index', compact(
            'riwayat', 'items', 'bulan', 'tahun', 'daftarTahun'
        ));
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
        $this->updateKondisiBarang($validated['id_item'], $validated['status']);

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
        $this->updateKondisiBarang($validated['id_item'], $validated['status']);

        return redirect()->route('riwayat-perawatan.index')
            ->with('success', 'Riwayat perawatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $riwayat = RiwayatPerawatan::findOrFail($id);
        $riwayat->delete();

        return redirect()->route('riwayat-perawatan.index')
            ->with('success', 'Riwayat perawatan berhasil dihapus');
    }

    private function updateKondisiBarang(int $idItem, string $status): void
    {
        if ($status === 'Selesai') {
            Item::where('id_item', $idItem)->update(['kondisi' => 'Baik']);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | STATISTIK — dengan filter bulan & tahun
    |--------------------------------------------------------------------------
    */
    public function statistik(Request $request)
    {
        // Default: bulan & tahun berjalan
        $bulan = (int) $request->get('bulan', date('n'));
        $tahun = (int) $request->get('tahun', date('Y'));

        // Query dasar difilter per bulan yang dipilih
        $baseQuery = RiwayatPerawatan::whereMonth('tanggal_perawatan', $bulan)
                                     ->whereYear('tanggal_perawatan', $tahun);

        $totalPerawatan     = (clone $baseQuery)->count();
        $totalBiaya         = (clone $baseQuery)->sum('biaya');
        $totalBarangDirawat = (clone $baseQuery)->distinct('id_item')->count('id_item');

        $statusSelesai     = (clone $baseQuery)->where('status', 'Selesai')->count();
        $statusDalamProses = (clone $baseQuery)->where('status', 'Dalam Proses')->count();
        $statusDitunda     = (clone $baseQuery)->where('status', 'Ditunda')->count();

        // Top 10 barang berdasarkan jumlah perawatan di bulan yang dipilih
        $topBarang = RiwayatPerawatan::with(['item.ruangan'])
            ->whereMonth('tanggal_perawatan', $bulan)
            ->whereYear('tanggal_perawatan', $tahun)
            ->selectRaw('id_item, COUNT(*) as jumlah_bulan_ini')
            ->groupBy('id_item')
            ->orderByDesc('jumlah_bulan_ini')
            ->take(10)
            ->get()
            ->map(function ($r) {
                $item = Item::with(['ruangan'])->find($r->id_item);
                if ($item) {
                    $item->jumlah_perawatan = $r->jumlah_bulan_ini;
                }
                return $item;
            })
            ->filter();

        // Jenis perawatan di bulan yang dipilih
        $jenisPerawatan = (clone $baseQuery)
            ->selectRaw('jenis_perawatan, COUNT(*) as jumlah')
            ->groupBy('jenis_perawatan')
            ->orderByDesc('jumlah')
            ->get();

        // Chart bar — tetap tampil semua bulan dalam tahun yang dipilih
        $perawatanPerBulan = RiwayatPerawatan::selectRaw(
                'MONTH(tanggal_perawatan) as bulan,
                 YEAR(tanggal_perawatan) as tahun,
                 COUNT(*) as jumlah'
            )
            ->whereYear('tanggal_perawatan', $tahun)
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();

        $maxCount = $topBarang->max('jumlah_perawatan') ?: 1;

        // Daftar tahun yang tersedia untuk dropdown
        $daftarTahun = RiwayatPerawatan::selectRaw('YEAR(tanggal_perawatan) as tahun')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

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
            'maxCount',
            'bulan',
            'tahun',
            'daftarTahun'
        ));
    }
}