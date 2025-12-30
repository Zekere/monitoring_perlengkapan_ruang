<?php

namespace App\Http\Controllers;

use App\Models\PengaduanKerusakan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = PengaduanKerusakan::with(['item.kategori', 'item.ruangan']);
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tingkat kerusakan
        if ($request->has('tingkat') && $request->tingkat != '') {
            $query->where('tingkat_kerusakan', $request->tingkat);
        }
        
        // Sorting (terbaru dulu)
        $pengaduan = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Hitung statistik
        $stats = [
            'total' => PengaduanKerusakan::count(),
            'menunggu' => PengaduanKerusakan::where('status', 'Menunggu')->count(),
            'diproses' => PengaduanKerusakan::where('status', 'Diproses')->count(),
            'selesai' => PengaduanKerusakan::where('status', 'Selesai')->count(),
        ];
        
        return view('pengaduan.index', compact('pengaduan', 'stats'));
    }
    
    public function show($id)
    {
        $pengaduan = PengaduanKerusakan::with(['item.kategori', 'item.ruangan'])->findOrFail($id);
        
        return view('pengaduan.show', compact('pengaduan'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([    
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);
        
        $pengaduan = PengaduanKerusakan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();
        
        // Update kondisi barang jika pengaduan selesai
        if ($request->status == 'Selesai' && $request->has('update_kondisi')) {
            $pengaduan->item->kondisi = $request->kondisi_barang;
            $pengaduan->item->save();
        }
        
        return redirect()->route('pengaduan.show', $id)
            ->with('success', 'Status pengaduan berhasil diupdate!');
    }
}