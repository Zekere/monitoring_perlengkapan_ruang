<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ruangan; // Pastikan model Ruangan diimport

class RuanganController extends Controller
{
    // Metode untuk menampilkan halaman daftar ruangan
    public function index()
    {
        // Mengambil semua data ruangan dan mengirimkannya ke view
      $ruangan = Ruangan::paginate(10); // Menggunakan pagination untuk membatasi jumlah data per halaman

    // Mengirim data ruangan ke view
    return view('ruangan.index', compact('ruangan')); // Kirim data ruangan ke view
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
        'nama' => 'required|string|max:255', // Pastikan nama ruangan tidak kosong
    ]);

    // Simpan data ruangan baru ke database
    Ruangan::create([
        'nama_ruangan' => $request->nama,  // Kolom yang akan diisi di database
    ]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan!');
}


    // Menampilkan form untuk mengedit ruangan
    public function edit($id)
    {
        // Mencari ruangan berdasarkan ID atau gagal jika tidak ditemukan
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan')); // Kirim data ruangan ke form edit
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
        'nama_ruangan' => $request->nama,  // Perbarui kolom yang sesuai
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
