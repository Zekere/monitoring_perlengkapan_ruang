<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPerawatan;
use App\Models\Item;
use Illuminate\Http\Request;

class RiwayatPerawatanController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatPerawatan::with('item.kategori', 'item.ruangan')
            ->orderBy('tanggal_perawatan', 'desc');

        // Filter berdasarkan item
        if ($request->has('id_item') && $request->id_item != '') {
            $query->where('id_item', $request->id_item);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis perawatan
        if ($request->has('jenis_perawatan') && $request->jenis_perawatan != '') {
            $query->where('jenis_perawatan', $request->jenis_perawatan);
        }

        $riwayat = $query->paginate(10);
        $items = Item::orderBy('nama_item')->get();

        return view('riwayat_perawatan.index', compact('riwayat', 'items'));
    }

    public function create()
    {
        $items = Item::orderBy('nama_item')->get();
        return view('riwayat_perawatan.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_item' => 'required|exists:items,id_item',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'teknisi' => 'required|string|max:100',
            'biaya' => 'required|numeric|min:0',
            'status' => 'required|in:Selesai,Dalam Proses,Ditunda',
            'catatan' => 'nullable|string'
        ]);

        RiwayatPerawatan::create($validated);

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
        $items = Item::orderBy('nama_item')->get();
        return view('riwayat_perawatan.edit', compact('riwayat', 'items'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_item' => 'required|exists:items,id_item',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'teknisi' => 'required|string|max:100',
            'biaya' => 'required|numeric|min:0',
            'status' => 'required|in:Selesai,Dalam Proses,Ditunda',
            'catatan' => 'nullable|string'
        ]);

        $riwayat = RiwayatPerawatan::findOrFail($id);
        $riwayat->update($validated);

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
}