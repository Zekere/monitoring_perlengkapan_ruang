<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengecekan', function (Blueprint $table) {
            $table->id('id_pengecekan'); // Primary key

            $table->unsignedBigInteger('id_ruangan');
            $table->date('tanggal_cek');
            $table->string('petugas', 100);
            $table->text('catatan')->nullable();

            $table->timestamps();

            // FK ke ruangan
            $table->foreign('id_ruangan')
                ->references('id_ruangan')
                ->on('ruangan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengecekan');
    }
};
