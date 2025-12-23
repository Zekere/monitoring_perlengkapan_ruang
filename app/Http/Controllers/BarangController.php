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
    public function index()
    {
        $items = Item::with(['kategori', 'ruangan'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();

        return view('barang.index', compact('items', 'kategori', 'ruangan'));
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
        $validated = $request->validate([
            'kode_barang' => 'required|unique:items,kode_barang|max:50',
            'nama_item' => 'required|max:255',
            'merk' => 'nullable|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'kode_barang.required' => 'Kode barang wajib diisi',
            'kode_barang.unique' => 'Kode barang sudah digunakan',
            'nama_item.required' => 'Nama barang wajib diisi',
            'id_kategori.required' => 'Kategori wajib dipilih',
            'id_ruangan.required' => 'Ruangan wajib dipilih',
            'kondisi.required' => 'Kondisi wajib dipilih',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Item::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $barang)
    {
        $barang->load(['kategori', 'ruangan']);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $barang)
    {
        $item = $barang;
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();

        return view('barang.edit', compact('item', 'kategori', 'ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|max:50|unique:items,kode_barang,' . $barang->id_item . ',id_item',
            'nama_item' => 'required|max:255',
            'merk' => 'nullable|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'nilai' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'kode_barang.required' => 'Kode barang wajib diisi',
            'kode_barang.unique' => 'Kode barang sudah digunakan',
            'nama_item.required' => 'Nama barang wajib diisi',
            'id_kategori.required' => 'Kategori wajib dipilih',
            'id_ruangan.required' => 'Ruangan wajib dipilih',
            'kondisi.required' => 'Kondisi wajib dipilih',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }
            
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate');
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

    // Hapus data barang
    $barang->delete();

    return redirect()->route('barang.index')
        ->with('success', 'Barang berhasil dihapus');
}

    /**
     * Export to PDF
     */
    // public function exportPdf()
    // {
    //     $items = Item::with(['kategori', 'ruangan'])
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     $pdf = Pdf::loadView('barang.pdf', compact('items'));
    //     return $pdf->download('daftar-barang-' . date('Y-m-d') . '.pdf');
    // }
}