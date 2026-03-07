<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Kolom untuk menyimpan total perawatan secara permanen
            // Default 0, tidak akan berkurang meski riwayat dihapus
            $table->unsignedInteger('jumlah_perawatan')->default(0)->after('kondisi');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('jumlah_perawatan');
        });
    }
};