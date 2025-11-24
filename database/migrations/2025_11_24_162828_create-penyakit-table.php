<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyakit', function (Blueprint $table) {
            $table->id('id_penyakit');
            $table->string('kode_penyakit', 10)->unique();
            $table->string('nama_penyakit');
            $table->text('penyebab')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('pengendalian')->nullable();
            $table->text('pencegahan')->nullable();
            $table->string('gambar')->nullable(); // optional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyakit');
    }
};
