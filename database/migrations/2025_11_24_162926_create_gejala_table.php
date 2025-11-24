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
        Schema::create('aturan', function (Blueprint $table) {
            $table->id('id_aturan');
            $table->foreignId('penyakit_id')->constrained('penyakit', 'id_penyakit')->cascadeOnDelete();
            $table->foreignId('gejala_id')->constrained('gejala', 'id_gejala')->cascadeOnDelete();
            $table->float('cf_pakar', 3, 2); // ex: 0.95 format
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Prevent duplicate rule combinations
            $table->unique(['penyakit_id', 'gejala_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan');
    }
};
