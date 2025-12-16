<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PengecekanController;
use App\Http\Controllers\RuanganController;


/*
|--------------------------------------------------------------------------
| Guest Routes (Tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    /*
    |--------------------------------------------------------------------------
    | MASTER DATA Routes
    |--------------------------------------------------------------------------
    */
    
    // Barang (CRUD lengkap dengan resource route)
    Route::resource('barang', BarangController::class);
    Route::get('barang/export/pdf', [BarangController::class, 'exportPdf'])->name('barang.export-pdf');

    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    
    // Kategori (CRUD lengkap)
    // Route::resource('kategori', KategoriController::class);
    
    // // Lokasi/Ruangan (CRUD lengkap)
    // Route::resource('lokasi', LokasiController::class);
    // atau jika nama controller Anda RuanganController:
    // Route::resource('lokasi', RuanganController::class);
    
    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI Routes
    |--------------------------------------------------------------------------
    */
    
    // Pengecekan (CRUD lengkap)
    Route::resource('pengecekan', PengecekanController::class);
    
    // AJAX - Get items berdasarkan ruangan
    Route::get('/pengecekan/items/{id_ruangan}', 
        [PengecekanController::class, 'getItemsByRuangan']
    )->name('pengecekan.getItems');
    
    /*
    |--------------------------------------------------------------------------
    | LAPORAN Routes
    |--------------------------------------------------------------------------
    */
    
    // Laporan Pengecekan
    Route::get('/laporan/pengecekan', 
        [PengecekanController::class, 'laporan']
    )->name('pengecekan.laporan');
    
    // Laporan Barang (optional)
    Route::get('/laporan/barang', 
        [BarangController::class, 'laporan']
    )->name('laporan.barang');


    /*ruangannnnnnnnn*/
   //Route::resource('ruangan', RuanganController::class);
 // Menampilkan daftar ruangan
Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');

// Menampilkan form untuk menambah ruangan
Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');

// Menyimpan data ruangan baru
Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');

// Menampilkan form untuk mengedit ruangan
Route::get('/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');

// Mengupdate data ruangan
Route::put('/ruangan/{id}', [RuanganController::class, 'update'])->name('ruangan.update');

// Menghapus data ruangan
Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');



});