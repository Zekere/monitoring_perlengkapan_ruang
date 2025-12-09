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

        // Kondisi barang dari tabel items (bukan dari pengecekan)
        $kondisiBarang = Item::select('kondisi', DB::raw('count(*) as total'))
            ->groupBy('kondisi')
            ->get();

        // Jika tabel detail_pengecekan kosong, gunakan data dari items
        if ($kondisiBarang->isEmpty()) {
            // Fallback: ambil semua barang dan hitung manual
            $kondisiBarang = collect([
                (object)['kondisi' => 'Baik', 'total' => Item::where('kondisi', 'Baik')->count()],
                (object)['kondisi' => 'Rusak Ringan', 'total' => Item::where('kondisi', 'Rusak Ringan')->count()],
                (object)['kondisi' => 'Rusak Berat', 'total' => Item::where('kondisi', 'Rusak Berat')->count()],
            ])->filter(function($item) {
                return $item->total > 0; // Hanya tampilkan yang ada datanya
            });
        }

        // Data kondisi untuk chart (1 bulan terakhir)
        // Karena detail_pengecekan kosong, kita gunakan data dari items berdasarkan created_at
        $startDate = Carbon::now()->subMonth()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $kondisiPerBulan = Item::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                'kondisi',
                DB::raw('count(*) as total')
            )
            ->groupBy('tanggal', 'kondisi')
            ->orderBy('tanggal')
            ->get();

        // Jika tidak ada data dalam 1 bulan terakhir, ambil semua data
        if ($kondisiPerBulan->isEmpty()) {
            $kondisiPerBulan = Item::select(
                    DB::raw('DATE(created_at) as tanggal'),
                    'kondisi',
                    DB::raw('count(*) as total')
                )
                ->groupBy('tanggal', 'kondisi')
                ->orderBy('tanggal')
                ->get();
        }

        // Distribusi per kategori
        $distribusiKategori = Item::join('kategori', 'items.id_kategori', '=', 'kategori.id_kategori')
            ->select('kategori.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
            ->get();

        // Jika tidak ada data, buat data default
        if ($distribusiKategori->isEmpty()) {
            $distribusiKategori = Kategori::leftJoin('items', 'kategori.id_kategori', '=', 'items.id_kategori')
                ->select('kategori.nama_kategori', DB::raw('COALESCE(count(items.id_item), 0) as total'))
                ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
                ->get();
        }

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