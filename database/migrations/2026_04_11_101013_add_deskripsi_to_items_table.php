<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Jalankan dengan: php artisan migrate
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Tambah kolom deskripsi setelah kolom merk
            $table->text('deskripsi')->nullable()->after('merk')
                  ->comment('Deskripsi atau spesifikasi tambahan barang');
        });
    }

    /**
     * Reverse the migrations.
     * Rollback dengan: php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};