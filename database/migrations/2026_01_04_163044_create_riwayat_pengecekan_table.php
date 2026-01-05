<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_barang', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('id_item');
            $table->string('kode_barang', 50)->nullable();
            $table->string('nama_item', 255)->nullable();
            $table->enum('kondisi_lama', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->nullable();
            $table->enum('kondisi_baru', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->unsignedBigInteger('id_ruangan_lama')->nullable();
            $table->unsignedBigInteger('id_ruangan_baru')->nullable();
            $table->enum('jenis_perubahan', ['Kondisi', 'Ruangan', 'Data', 'Semua']);
            $table->text('keterangan')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();

            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');
            
            $table->index('created_at');
            $table->index(['id_item', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_barang');
    }
};