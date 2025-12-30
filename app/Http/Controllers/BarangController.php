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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::with(['kategori', 'ruangan']);

        // Filter search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_item', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter ruangan
        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $barang = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();

        return view('barang.index', compact('barang', 'kategori', 'ruangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();
        
        return view('barang.create', compact('kategori', 'ruangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:items,kode_barang',
            'nama_item' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_ruangan' => 'nullable|exists:ruangan,id_ruangan',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('barang', $namaFoto, 'public');
            $data['foto'] = $path;
        }

        Item::create($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barang = Item::with(['kategori', 'ruangan'])->findOrFail($id);
        
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = Item::findOrFail($id);
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();
        
        return view('barang.edit', compact('barang', 'kategori', 'ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $barang = Item::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|unique:items,kode_barang,' . $id . ',id_item',
            'nama_item' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_ruangan' => 'nullable|exists:ruangan,id_ruangan',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        // Handle upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('barang', $namaFoto, 'public');
            $data['foto'] = $path;
        }

        $barang->update($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Item::findOrFail($id);

        // Hapus foto jika ada
        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Export barang to PDF
     */
    public function exportPdf()
    {
        $barang = Item::with(['kategori', 'ruangan'])->get();
        
        $pdf = Pdf::loadView('barang.pdf', compact('barang'));
        
        return $pdf->download('daftar-barang-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Laporan barang (optional)
     */
    public function laporan(Request $request)
    {
        $query = Item::with(['kategori', 'ruangan']);

        // Filter untuk laporan
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $barang = $query->get();
        $kategori = Kategori::all();

        return view('barang.laporan', compact('barang', 'kategori'));
    }
}