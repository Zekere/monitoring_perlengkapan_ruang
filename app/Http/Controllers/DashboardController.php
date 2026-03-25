<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang      = Item::count();
        $totalKategori    = Kategori::count();
        $totalRuangan     = Ruangan::count();
        $totalNilaiBarang = Item::sum('harga_satuan'); // ← otomatis SUM semua harga_satuan

        $kondisiBarang = Item::select('kondisi', DB::raw('count(*) as total'))
            ->groupBy('kondisi')
            ->get();

        if ($kondisiBarang->isEmpty()) {
            $kondisiBarang = collect([
                (object)['kondisi' => 'Baik',         'total' => Item::where('kondisi', 'Baik')->count()],
                (object)['kondisi' => 'Rusak Ringan',  'total' => Item::where('kondisi', 'Rusak Ringan')->count()],
                (object)['kondisi' => 'Rusak Berat',   'total' => Item::where('kondisi', 'Rusak Berat')->count()],
            ])->filter(fn($i) => $i->total > 0);
        }

        $startDate = Carbon::now()->subMonth()->startOfDay();
        $endDate   = Carbon::now()->endOfDay();

        $kondisiPerBulan = Item::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as tanggal'), 'kondisi', DB::raw('count(*) as total'))
            ->groupBy('tanggal', 'kondisi')
            ->orderBy('tanggal')
            ->get();

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

        $distribusiKategori = Item::join('kategori', 'items.id_kategori', '=', 'kategori.id_kategori')
            ->select('kategori.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
            ->get();

        if ($distribusiKategori->isEmpty()) {
            $distribusiKategori = Kategori::leftJoin('items', 'kategori.id_kategori', '=', 'items.id_kategori')
                ->select('kategori.nama_kategori', DB::raw('COALESCE(count(items.id_item), 0) as total'))
                ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
                ->get();
        }

        $barangTerbaru = Item::with(['kategori'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pengecekanTerbaru = RiwayatBarang::with(['ruanganLama', 'ruanganBaru'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalRuangan',
            'totalNilaiBarang',
            'kondisiBarang',
            'kondisiPerBulan',
            'distribusiKategori',
            'barangTerbaru',
            'pengecekanTerbaru'
        ));
    }
}