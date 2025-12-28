<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PengecekanController;
use App\Http\Controllers\BarangFilterController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\PengaduanController;

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
| PUBLIC Routes - Pengaduan (TANPA LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/pengaduan/create', [PengaduanController::class, 'create'])
    ->name('pengaduan.create');
Route::post('/pengaduan/store', [PengaduanController::class, 'store'])
    ->name('pengaduan.store');

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
    
    // BARANG
    Route::get('/barang', [BarangFilterController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('barang/export/pdf', [BarangController::class, 'exportPdf'])
        ->name('barang.export-pdf');
    
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

    // Fitur Filter  (optional)
    Route::get('/barang', [BarangFilterController::class, 'index'])
     ->name('barang.index');

    /*
    |--------------------------------------------------------------------------
    | RUANGAN Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('/ruangan/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
    
    /*
    |--------------------------------------------------------------------------
    | PENGADUAN Management (Hanya untuk Admin/Staff yang login)
    |--------------------------------------------------------------------------
    */
    // Route untuk melihat daftar pengaduan (hanya admin)
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
});