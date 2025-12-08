<?php

namespace App\Http\Controllers;

use App\Models\Pengecekan;
use App\Models\DetailPengecekan;
use App\Models\Ruangan;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengecekanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengecekan = Pengecekan::with([
            'ruangan',
            'detailPengecekan.item'
        ])
        ->orderBy('tanggal_cek', 'desc')
        ->paginate(10);

        return view('pengecekan.index', compact('pengecekan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ruangan = Ruangan::all();
        $items = Item::with('kategori')->get();

        return view('pengecekan.create', compact('ruangan', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'tanggal_cek' => 'required|date',
            'petugas' => 'required|string|max:100',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id_item' => 'required|exists:items,id_item',
            'items.*.kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'items.*.catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $pengecekan = Pengecekan::create([
                'id_ruangan' => $request->id_ruangan,
                'tanggal_cek' => $request->tanggal_cek,
                'petugas' => $request->petugas,
                'catatan' => $request->catatan,
            ]);

            foreach ($request->items as $item) {
                DetailPengecekan::create([
                    'id_pengecekan' => $pengecekan->id_pengecekan,
                    'id_item' => $item['id_item'],
                    'kondisi' => $item['kondisi'],
                    'catatan' => $item['catatan'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('pengecekan.index')
                ->with('success', 'Data pengecekan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengecekan = Pengecekan::with(['ruangan', 'detailPengecekan.item.kategori'])
            ->findOrFail($id);

        return view('pengecekan.show', compact('pengecekan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengecekan = Pengecekan::with('detailPengecekan')
            ->findOrFail($id);

        $ruangan = Ruangan::all();
        $items = Item::with('kategori')->get();

        return view('pengecekan.edit', compact('pengecekan', 'ruangan', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'tanggal_cek' => 'required|date',
            'petugas' => 'required|string|max:100',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id_item' => 'required|exists:items,id_item',
            'items.*.kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'items.*.catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $pengecekan = Pengecekan::findOrFail($id);

            $pengecekan->update([
                'id_ruangan' => $request->id_ruangan,
                'tanggal_cek' => $request->tanggal_cek,
                'petugas' => $request->petugas,
                'catatan' => $request->catatan,
            ]);

            DetailPengecekan::where('id_pengecekan', $id)->delete();

            foreach ($request->items as $item) {
                DetailPengecekan::create([
                    'id_pengecekan' => $pengecekan->id_pengecekan,
                    'id_item' => $item['id_item'],
                    'kondisi' => $item['kondisi'],
                    'catatan' => $item['catatan'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('pengecekan.index')
                ->with('success', 'Data pengecekan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pengecekan = Pengecekan::findOrFail($id);
            $pengecekan->delete();

            return redirect()->route('pengecekan.index')
                ->with('success', 'Data pengecekan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get items by ruangan (AJAX)
     */
    public function getItemsByRuangan($id_ruangan)
    {
        $items = Item::with('kategori')->get();

        return response()->json($items);
    }

    /**
     * Export Laporan Pengecekan
     */
    public function laporan(Request $request)
    {
        $query = Pengecekan::with(['ruangan', 'detailPengecekan.item.kategori']);

        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_cek', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->where('tanggal_cek', '<=', $request->tanggal_selesai);
        }

        if ($request->filled('id_ruangan')) {
            $query->where('id_ruangan', $request->id_ruangan);
        }

        if ($request->filled('kondisi')) {
            $query->whereHas('detailPengecekan', function($q) use ($request) {
                $q->where('kondisi', $request->kondisi);
            });
        }

        $pengecekan = $query->orderBy('tanggal_cek', 'desc')->get();
        $ruangan = Ruangan::all();

        return view('pengecekan.laporan', compact('pengecekan', 'ruangan'));
    }
}
