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
            $table->float('cf_pakar', 3, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['penyakit_id', 'gejala_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan');
    }
};
