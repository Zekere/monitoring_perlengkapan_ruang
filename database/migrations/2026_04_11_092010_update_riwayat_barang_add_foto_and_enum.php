<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Jalankan dengan: php artisan migrate
     */
    public function up(): void
    {
        // 1. Tambah nilai 'Foto' ke ENUM jenis_perubahan
        DB::statement("
            ALTER TABLE riwayat_barang
            MODIFY COLUMN jenis_perubahan
            ENUM('Kondisi', 'Ruangan', 'Semua', 'Data', 'Foto') NOT NULL
        ");

        // 2. Tambah kolom foto_lama dan foto_baru
        Schema::table('riwayat_barang', function (Blueprint $table) {
            if (!Schema::hasColumn('riwayat_barang', 'foto_lama')) {
                $table->string('foto_lama')->nullable()->after('id_ruangan_baru')
                      ->comment('Path foto sebelum diubah');
            }
            if (!Schema::hasColumn('riwayat_barang', 'foto_baru')) {
                $table->string('foto_baru')->nullable()->after('foto_lama')
                      ->comment('Path foto setelah diubah');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Rollback dengan: php artisan migrate:rollback
     */
    public function down(): void
    {
        // Kembalikan ENUM tanpa 'Foto'
        DB::statement("
            ALTER TABLE riwayat_barang
            MODIFY COLUMN jenis_perubahan
            ENUM('Kondisi', 'Ruangan', 'Semua', 'Data') NOT NULL
        ");

        // Hapus kolom foto
        Schema::table('riwayat_barang', function (Blueprint $table) {
            $table->dropColumn(['foto_lama', 'foto_baru']);
        });
    }
};