<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\RiwayatBarang;
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
            'harga_satuan' => 'nullable|integer|min:0',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['foto', 'camera_photo']);
        $data['harga_satuan'] = $request->input('harga_satuan', 0);

        // Cek foto dari kamera (base64) atau upload file biasa
        $hasCameraPhoto = $request->filled('camera_photo') && str_starts_with($request->camera_photo, 'data:image');

        if ($request->hasFile('foto')) {
            $foto     = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $path     = $foto->storeAs('barang', $namaFoto, 'public');
            $data['foto'] = $path;

        } elseif ($hasCameraPhoto) {
            // Foto dari kamera — decode base64 lalu simpan sebagai file
            $base64Data = $request->camera_photo;
            $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
            $imageData  = base64_decode($base64Data);

            Storage::disk('public')->makeDirectory('barang');
            $namaFoto     = time() . '_camera.jpg';
            $path         = 'barang/' . $namaFoto;
            Storage::disk('public')->put($path, $imageData);
            $data['foto'] = $path;
        }

        $item = Item::create($data);

        // Catat riwayat: barang baru ditambahkan
        RiwayatBarang::create([
            'id_item'         => $item->id_item,
            'kode_barang'     => $item->kode_barang,
            'nama_item'       => $item->nama_item,
            'jenis_perubahan' => 'Data',
            'kondisi_lama'    => null,
            'kondisi_baru'    => $item->kondisi,
            'id_ruangan_lama' => null,
            'id_ruangan_baru' => $item->id_ruangan,
            'foto_lama'       => null,
            'foto_baru'       => $item->foto ?? null,
            'keterangan'      => 'Barang baru ditambahkan',
            'updated_by'      => auth()->user()->name,
        ]);

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
            'harga_satuan' => 'nullable|integer|min:0',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan nilai lama sebelum diupdate
        $kondisiLama     = $barang->kondisi;
        $ruanganLama     = $barang->id_ruangan;
        $fotoLama        = $barang->foto;
        $fotoLamaSalinan = $fotoLama; // path yang dicatat ke riwayat

        $data = $request->except(['foto', 'camera_photo']);
        $data['harga_satuan'] = $request->input('harga_satuan', 0);

        // Cek sumber foto: upload file biasa atau kamera (base64)
        $hasCameraPhoto = $request->filled('camera_photo') && str_starts_with($request->camera_photo, 'data:image');
        $hasUploadFoto  = $request->hasFile('foto');

        $fotoBaruPath = null;
        $fotoChanged  = false;

        if ($hasUploadFoto || $hasCameraPhoto) {
            // ── SALIN foto lama ke folder riwayat SEBELUM dihapus ──
            if ($fotoLama && Storage::disk('public')->exists($fotoLama)) {
                $namaFile    = basename($fotoLama);
                $pathSalinan = 'riwayat/' . time() . '_' . $namaFile;

                Storage::disk('public')->makeDirectory('riwayat');
                Storage::disk('public')->copy($fotoLama, $pathSalinan);

                $fotoLamaSalinan = $pathSalinan;
                Storage::disk('public')->delete($fotoLama);
            }

            if ($hasUploadFoto) {
                // Foto dari file upload biasa
                $foto         = $request->file('foto');
                $namaFoto     = time() . '_' . $foto->getClientOriginalName();
                $fotoBaruPath = $foto->storeAs('barang', $namaFoto, 'public');

            } elseif ($hasCameraPhoto) {
                // Foto dari kamera — decode base64 lalu simpan sebagai file
                $base64Data = $request->camera_photo;
                $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
                $imageData  = base64_decode($base64Data);

                Storage::disk('public')->makeDirectory('barang');
                $namaFoto     = time() . '_camera.jpg';
                $fotoBaruPath = 'barang/' . $namaFoto;
                Storage::disk('public')->put($fotoBaruPath, $imageData);
            }

            $data['foto'] = $fotoBaruPath;
            $fotoChanged  = true;
        }

        $barang->update($data);

        $updatedBy      = auth()->user()->name;
        $kondisiChanged = $kondisiLama !== $barang->kondisi;
        $ruanganChanged = (string) $ruanganLama !== (string) $barang->id_ruangan;

        // Tentukan jenis perubahan dan catat riwayat
        if ($kondisiChanged && $ruanganChanged) {
            RiwayatBarang::create([
                'id_item'         => $barang->id_item,
                'kode_barang'     => $barang->kode_barang,
                'nama_item'       => $barang->nama_item,
                'jenis_perubahan' => 'Semua',
                'kondisi_lama'    => $kondisiLama,
                'kondisi_baru'    => $barang->kondisi,
                'id_ruangan_lama' => $ruanganLama,
                'id_ruangan_baru' => $barang->id_ruangan,
                'foto_lama'       => null,
                'foto_baru'       => null,
                'keterangan'      => 'Kondisi dan ruangan diperbarui',
                'updated_by'      => $updatedBy,
            ]);
        } elseif ($kondisiChanged) {
            RiwayatBarang::create([
                'id_item'         => $barang->id_item,
                'kode_barang'     => $barang->kode_barang,
                'nama_item'       => $barang->nama_item,
                'jenis_perubahan' => 'Kondisi',
                'kondisi_lama'    => $kondisiLama,
                'kondisi_baru'    => $barang->kondisi,
                'id_ruangan_lama' => $ruanganLama,
                'id_ruangan_baru' => $barang->id_ruangan,
                'foto_lama'       => null,
                'foto_baru'       => null,
                'keterangan'      => 'Kondisi barang diperbarui',
                'updated_by'      => $updatedBy,
            ]);
        } elseif ($ruanganChanged) {
            RiwayatBarang::create([
                'id_item'         => $barang->id_item,
                'kode_barang'     => $barang->kode_barang,
                'nama_item'       => $barang->nama_item,
                'jenis_perubahan' => 'Ruangan',
                'kondisi_lama'    => $kondisiLama,
                'kondisi_baru'    => $barang->kondisi,
                'id_ruangan_lama' => $ruanganLama,
                'id_ruangan_baru' => $barang->id_ruangan,
                'foto_lama'       => null,
                'foto_baru'       => null,
                'keterangan'      => 'Ruangan barang diperbarui',
                'updated_by'      => $updatedBy,
            ]);
        }

        // Catat riwayat foto
        if ($fotoChanged) {
            RiwayatBarangController::catatPerubahanFoto(
                $barang,
                $fotoLamaSalinan,
                $fotoBaruPath,
                $updatedBy
            );
        }

        // Catat riwayat data umum jika tidak ada perubahan kondisi/ruangan/foto
        if (!$kondisiChanged && !$ruanganChanged && !$fotoChanged) {
            RiwayatBarang::create([
                'id_item'         => $barang->id_item,
                'kode_barang'     => $barang->kode_barang,
                'nama_item'       => $barang->nama_item,
                'jenis_perubahan' => 'Data',
                'kondisi_lama'    => $kondisiLama,
                'kondisi_baru'    => $barang->kondisi,
                'id_ruangan_lama' => $ruanganLama,
                'id_ruangan_baru' => $barang->id_ruangan,
                'foto_lama'       => null,
                'foto_baru'       => null,
                'keterangan'      => 'Data barang diperbarui',
                'updated_by'      => $updatedBy,
            ]);
        }

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