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
        Schema::create('konsultasi_gejala', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konsultasi_id')->constrained('konsultasi', 'id_konsultasi')->cascadeOnDelete();
            $table->foreignId('gejala_id')->constrained('gejala', 'id_gejala')->cascadeOnDelete();
            $table->float('cf_user', 3, 2)->default(1.00); // default percaya penuh
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi_gejala');
    }
};
