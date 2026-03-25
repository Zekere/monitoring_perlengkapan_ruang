<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['kategori', 'ruangan']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_item', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $barang   = $query->orderBy('created_at', 'desc')->get();
        $kategori = Kategori::all();
        $ruangan  = Ruangan::all();

        return view('barang.index', compact('barang', 'kategori', 'ruangan'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $ruangan  = Ruangan::all();

        return view('barang.create', compact('kategori', 'ruangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'  => 'required|unique:items,kode_barang',
            'nama_item'    => 'required|string|max:255',
            'merk'         => 'nullable|string|max:100',
            'id_kategori'  => 'required|exists:kategori,id_kategori',
            'id_ruangan'   => 'nullable|exists:ruangan,id_ruangan',
            'kondisi'      => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'harga_satuan' => 'nullable|integer|min:0',   // ← TAMBAHAN
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');
        $data['harga_satuan'] = $request->input('harga_satuan', 0);

        if ($request->hasFile('foto')) {
            $foto     = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $path     = $foto->storeAs('barang', $namaFoto, 'public');
            $data['foto'] = $path;
        }

        Item::create($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show($id)
    {
        $barang = Item::with(['kategori', 'ruangan'])->findOrFail($id);

        return view('barang.show', compact('barang'));
    }

    public function edit($id)
    {
        $item     = Item::findOrFail($id);
        $kategori = Kategori::all();
        $ruangan  = Ruangan::all();

        return view('barang.edit', compact('item', 'kategori', 'ruangan'));
    }

    public function update(Request $request, $id)
    {
        $barang = Item::findOrFail($id);

        $request->validate([
            'kode_barang'  => 'required|unique:items,kode_barang,' . $id . ',id_item',
            'nama_item'    => 'required|string|max:255',
            'merk'         => 'nullable|string|max:100',
            'id_kategori'  => 'required|exists:kategori,id_kategori',
            'id_ruangan'   => 'nullable|exists:ruangan,id_ruangan',
            'kondisi'      => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'harga_satuan' => 'nullable|integer|min:0',   // ← TAMBAHAN
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');
        $data['harga_satuan'] = $request->input('harga_satuan', 0);

        if ($request->hasFile('foto')) {
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            $foto     = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $path     = $foto->storeAs('barang', $namaFoto, 'public');
            $data['foto'] = $path;
        }

        $barang->update($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy($id)
    {
        $barang = Item::findOrFail($id);

        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }

    public function exportPdf()
    {
        $barang = Item::with(['kategori', 'ruangan'])->get();

        $pdf = Pdf::loadView('barang.pdf', compact('barang'));

        return $pdf->download('daftar-barang-' . date('Y-m-d') . '.pdf');
    }

    public function laporan(Request $request)
    {
        $query = Item::with(['kategori', 'ruangan']);

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $barang   = $query->get();
        $kategori = Kategori::all();

        return view('barang.laporan', compact('barang', 'kategori'));
    }
}