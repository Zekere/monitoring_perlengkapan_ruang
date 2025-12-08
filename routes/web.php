<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController; // ✅ Ganti ini
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PengecekanController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']); // ✅ Ganti
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // ✅ Ganti
    
    Route::get('/barang', [DashboardController::class, 'barang'])->name('barang');
    Route::get('/kategori', [DashboardController::class, 'kategori'])->name('kategori');
    Route::get('/lokasi', [DashboardController::class, 'lokasi'])->name('lokasi');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // ✅ Gunakan resource route (otomatis buat route index, create, store, show, edit, update, destroy)
    Route::resource('barang', BarangController::class);
    
    Route::get('/kategori', [DashboardController::class, 'kategori'])->name('kategori');
    Route::get('/lokasi', [DashboardController::class, 'lokasi'])->name('lokasi');
});


// Resource utama (index, create, store, show, edit, update, delete)
Route::resource('pengecekan', PengecekanController::class);

// AJAX get items by ruangan
Route::get('/pengecekan/items/{id_ruangan}', 
    [PengecekanController::class, 'getItemsByRuangan']
)->name('pengecekan.getItems');

// Laporan pengecekan (filter + generate view)
Route::get('/laporan/pengecekan', 
    [PengecekanController::class, 'laporan']
)->name('pengecekan.laporan');
