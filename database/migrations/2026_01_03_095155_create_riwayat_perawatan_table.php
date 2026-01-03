<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_perawatan', function (Blueprint $table) {
            $table->id('id_perawatan');
            $table->unsignedBigInteger('id_item');
            $table->date('tanggal_perawatan');
            $table->string('jenis_perawatan', 100);
            $table->text('deskripsi');
            $table->string('teknisi', 100);
            $table->decimal('biaya', 15, 2)->default(0);
            $table->enum('status', ['Selesai', 'Dalam Proses', 'Ditunda'])->default('Selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_perawatan');
    }
};