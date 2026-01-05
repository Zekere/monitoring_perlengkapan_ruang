<?php

namespace App\Http\Controllers;

use App\Models\Item; // ← GANTI dari Barang ke Item
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BarangFilterController extends Controller
{
    public function index(Request $request)
    {
        // Ganti Barang menjadi Item
        $query = Item::with(['kategori', 'ruangan']);

        // Filter berdasarkan kondisi
        if ($request->kondisi) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter berdasarkan kategori
        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter berdasarkan ruangan
        if ($request->ruangan) {
            $query->where('id_ruangan', $request->ruangan);
        }

        // Filter berdasarkan search/pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_item', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        // Return dengan nama variable 'barang' sesuai view
        return view('barang.index', [
            'barang' => $query->paginate(10),
            'kategori' => Kategori::all(),
            'ruangan' => Ruangan::all(),
        ]);
    }
}