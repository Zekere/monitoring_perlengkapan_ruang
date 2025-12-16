<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BarangFilterController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['kategori', 'ruangan']);

        if ($request->kondisi) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->ruangan) {
            $query->where('id_ruangan', $request->ruangan);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_item', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        return view('barang.index', [
            'barang' => $query->paginate(10),
            'kategori' => Kategori::all(),
            'ruangan' => Ruangan::all(),
        ]);
    }
}