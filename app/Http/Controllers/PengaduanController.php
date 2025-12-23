<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaduanKerusakan;
use App\Models\Barang; // Tambahkan ini untuk dropdown barang

class PengaduanController extends Controller
{
    public function create()
    {
        // Ambil semua barang untuk dropdown
        $barangs = Barang::all();
        return view('pengaduan.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'email_pelapor' => 'nullable|email',
            'barang_id' => 'required|exists:barang,id_item',
            'tingkat_kerusakan' => 'required|in:Ringan,Sedang,Berat',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');
        $data['status'] = 'Menunggu'; // Set status default

        // Handle upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/pengaduan'), $namaFoto);
            $data['foto'] = 'uploads/pengaduan/' . $namaFoto;
        }

        PengaduanKerusakan::create($data);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim');
    }
}