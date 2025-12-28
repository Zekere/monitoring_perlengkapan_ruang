<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaduanKerusakan;
use App\Models\Item; // Ganti dari Barang ke Item

class PengaduanController extends Controller
{
    public function create()
    {
        // Ambil semua items untuk dropdown
        $items = Item::all();
        return view('pengaduan.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'email_pelapor' => 'nullable|email',
            'id_item' => 'required|exists:items,id_item', // Ubah dari barang_id ke id_item
            'tingkat_kerusakan' => 'required|in:Ringan,Sedang,Berat',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');
        $data['status'] = 'Menunggu';

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/pengaduan'), $namaFoto);
            $data['foto'] = 'uploads/pengaduan/' . $namaFoto;
        }

        PengaduanKerusakan::create($data);

        return redirect()->route('pengaduan.create')
                         ->with('success', 'Pengaduan berhasil dikirim! Kami akan segera menindaklanjuti laporan Anda.');
    }

    // Method untuk admin melihat daftar pengaduan
    public function index()
    {
        $pengaduans = PengaduanKerusakan::with('item')->latest()->get();
        return view('pengaduan.index', compact('pengaduans'));
    }

    // Method untuk admin melihat detail pengaduan
    public function show($id)
    {
        $pengaduan = PengaduanKerusakan::with('item')->findOrFail($id);
        return view('pengaduan.show', compact('pengaduan'));
    }

    // Method untuk update status pengaduan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai'
        ]);

        $pengaduan = PengaduanKerusakan::findOrFail($id);
        $pengaduan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diupdate');
    }
}