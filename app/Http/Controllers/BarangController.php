<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Item::with('kategori')->paginate(10);
        
        return view('barang.index', compact('barang'));
    }
}