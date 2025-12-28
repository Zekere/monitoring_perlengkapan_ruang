<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan_kerusakan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nama_pelapor');
            $table->string('email_pelapor')->nullable();
            $table->unsignedBigInteger('id_item'); // Sesuaikan dengan tabel items
            $table->enum('tingkat_kerusakan', ['Ringan', 'Sedang', 'Berat']);
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->timestamps();

            // Foreign key ke tabel items
            $table->foreign('id_item')
                  ->references('id_item')
                  ->on('items')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_kerusakan');
    }
};