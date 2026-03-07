<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    // Metode untuk menampilkan halaman daftar ruangan
    public function index()
    {
        // Mengambil semua data ruangan tanpa pagination
        $ruangan = Ruangan::orderBy('created_at', 'desc')->get();

        // Mengirim data ruangan ke view
        return view('ruangan.index', compact('ruangan'));
    }

    // Menampilkan form untuk menambah ruangan baru
    public function create()
    {
        return view('ruangan.create');
    }

    // Menyimpan data ruangan baru
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Simpan data ruangan baru ke database
        Ruangan::create([
            'nama_ruangan' => $request->nama,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit ruangan
    public function edit($id)
    {
        // Mencari ruangan berdasarkan ID atau gagal jika tidak ditemukan
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

    // Mengupdate data ruangan
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Cari data ruangan berdasarkan ID
        $ruangan = Ruangan::findOrFail($id);

        // Update data ruangan
        $ruangan->update([
            'nama_ruangan' => $request->nama,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui!');
    }

    // Menghapus data ruangan
    public function destroy($id)
    {
        // Mencari ruangan berdasarkan ID atau gagal jika tidak ditemukan
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}