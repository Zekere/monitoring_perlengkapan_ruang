<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pengecekan', function (Blueprint $table) {
            $table->id('id_detail'); // PK detail

            $table->unsignedBigInteger('id_pengecekan');
            $table->unsignedBigInteger('id_item');

            $table->string('kondisi');       // contoh kolom
            $table->text('catatan')->nullable();

            $table->timestamps();

            // FK ke pengecekan
            $table->foreign('id_pengecekan')
                ->references('id_pengecekan')
                ->on('pengecekan')
                ->onDelete('cascade');

            // FK ke items
            $table->foreign('id_item')
                ->references('id_item')
                ->on('items')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pengecekan');
    }
};
