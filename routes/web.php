<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PengecekanController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PdfExportController;
use App\Http\Controllers\RiwayatPerbaikanController;
use App\Http\Controllers\RiwayatPerawatanController;
use App\Http\Controllers\RiwayatBarangController;
use App\Http\Controllers\UserManagementController;


/*
|--------------------------------------------------------------------------
| FIX STORAGE SYMLINK - Akses sekali lalu hapus route ini
| URL: https://domainanda.com/fix-storage
|--------------------------------------------------------------------------
*/
Route::get('/fix-storage', function () {
    $target = storage_path('app/public');
    $link   = public_path('storage');

    if (is_link($link)) {
        return '<h3 style="color:green">✅ Symlink sudah ada dan aktif.</h3><p>Hapus route ini dari web.php</p>';
    }

    if (file_exists($link) && !is_link($link)) {
        return '<h3 style="color:orange">⚠️ Folder storage sudah ada tapi bukan symlink.</h3><p>Hapus folder public/storage secara manual lalu akses URL ini lagi.</p>';
    }

    try {
        symlink($target, $link);
        return '<h3 style="color:green">✅ Symlink berhasil dibuat!</h3><p>Foto sekarang bisa tampil. <strong>Segera hapus route ini dari web.php</strong></p>';
    } catch (\Exception $e) {
        return '<h3 style="color:red">❌ Gagal membuat symlink: ' . $e->getMessage() . '</h3>
                <p>Coba cara manual: buat folder <code>public/storage/barang</code> lewat cPanel File Manager,
                lalu copy semua file dari <code>storage/app/public/barang/</code> ke sana.</p>';
    }
});

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
    
    // BARANG - SEMUA MENGGUNAKAN BarangController
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('barang/export/pdf', [BarangController::class, 'exportPdf'])
        ->name('barang.export-pdf');
    
    // KATEGORI
    Route::resource('kategori', KategoriController::class);
    
    // RUANGAN
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('/ruangan/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
    
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
    | PENGADUAN Management (Admin Only)
    |--------------------------------------------------------------------------
    */
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
    
    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PERAWATAN Routes
    |--------------------------------------------------------------------------
    */

    // ← TAMBAHAN: Statistik perawatan (WAJIB di atas resource agar tidak bentrok)
    Route::get('/riwayat-perawatan/statistik', [RiwayatPerawatanController::class, 'statistik'])
        ->name('riwayat-perawatan.statistik');

    Route::resource('riwayat-perawatan', RiwayatPerawatanController::class);
    
    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PENGECEKAN BARANG Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('riwayat-pengecekan')->name('riwayat.')->group(function () {
        // Halaman utama - daftar semua riwayat
        Route::get('/', [RiwayatBarangController::class, 'index'])
            ->name('index');
        
        // Detail riwayat per barang
        Route::get('/barang/{id_item}', [RiwayatBarangController::class, 'show'])
            ->name('show');
        
        // Export PDF
        Route::get('/export/pdf', [RiwayatBarangController::class, 'exportPdf'])
            ->name('export.pdf');
        
        // API endpoint untuk AJAX (opsional)
        Route::get('/api/get', [RiwayatBarangController::class, 'getRiwayat'])
            ->name('api.get');
        
        // Statistik (opsional)
        Route::get('/statistik', [RiwayatBarangController::class, 'statistics'])
            ->name('statistics');
    });
    
    /*
    |--------------------------------------------------------------------------
    | KELOLA ADMIN Routes (SuperAdmin Only)
    |--------------------------------------------------------------------------
    */
    Route::middleware('superadmin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/store', [UserManagementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });
    
    /*
    |--------------------------------------------------------------------------
    | LAPORAN Routes
    |--------------------------------------------------------------------------
    */
    
    // Laporan Pengecekan
    Route::get('/laporan/pengecekan', 
        [PengecekanController::class, 'laporan']
    )->name('pengecekan.laporan');
    
    // Laporan Barang
    Route::get('/laporan/barang', 
        [BarangController::class, 'laporan']
    )->name('laporan.barang');

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF Routes
    |--------------------------------------------------------------------------
    */
    
    // Export Barang
    Route::get('/export/barang', [PdfExportController::class, 'exportBarang'])
        ->name('export.barang');
    
    Route::get('/export/barang/kategori/{kategori}', [PdfExportController::class, 'exportBarangByKategori'])
        ->name('export.barang.kategori');
    
    Route::get('/export/barang/ruangan/{ruangan}', [PdfExportController::class, 'exportBarangByRuangan'])
        ->name('export.barang.ruangan');
    
    // Export Kategori
    Route::get('/export/kategori', [PdfExportController::class, 'exportKategori'])
        ->name('export.kategori');
    
    // Export Ruangan
    Route::get('/export/ruangan', [PdfExportController::class, 'exportRuangan'])
        ->name('export.ruangan');
    
    // Export Pengaduan
    Route::get('/export/pengaduan', [PdfExportController::class, 'exportPengaduan'])
        ->name('export.pengaduan');
    
    // Export Pengecekan
    Route::get('/export/pengecekan', [PdfExportController::class, 'exportPengecekan'])
        ->name('export.pengecekan');

    // Export Riwayat Perawatan
    Route::get('/export/riwayat-perawatan', [PdfExportController::class, 'exportRiwayatPerawatan'])
        ->name('export.riwayat-perawatan');

});