<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Pengecekan;
use App\Models\DetailPengecekan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total statistik
        $totalBarang = Item::count();
        $totalKategori = Kategori::count();
        $totalRuangan = Ruangan::count();

        // Kondisi barang saat ini (dari pengecekan terakhir)
        $kondisiBarang = DetailPengecekan::select('kondisi', DB::raw('count(*) as total'))
            ->whereIn('id_detail', function($query) {
                $query->select(DB::raw('MAX(id_detail)'))
                      ->from('detail_pengecekan')
                      ->groupBy('id_item');
            })
            ->groupBy('kondisi')
            ->get();

        // Data kondisi untuk chart (1 bulan terakhir)
        $startDate = Carbon::now()->subMonth()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $kondisiPerBulan = DetailPengecekan::join('pengecekan', 'detail_pengecekan.id_pengecekan', '=', 'pengecekan.id_pengecekan')
            ->whereBetween('pengecekan.tanggal_cek', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(pengecekan.tanggal_cek) as tanggal'),
                'detail_pengecekan.kondisi',
                DB::raw('count(*) as total')
            )
            ->groupBy('tanggal', 'kondisi')
            ->orderBy('tanggal')
            ->get();

        // Distribusi per kategori
        $distribusiKategori = Item::join('kategori', 'items.id_kategori', '=', 'kategori.id_kategori')
            ->select('kategori.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
            ->get();

        // Barang terbaru
        $barangTerbaru = Item::with(['kategori'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Riwayat pengecekan terbaru
        $pengecekanTerbaru = Pengecekan::with(['ruangan', 'detailPengecekan.item'])
            ->orderBy('tanggal_cek', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalRuangan',
            'kondisiBarang',
            'kondisiPerBulan',
            'distribusiKategori',
            'barangTerbaru',
            'pengecekanTerbaru'
        ));
    }
}