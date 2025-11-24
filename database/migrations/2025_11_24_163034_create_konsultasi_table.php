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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id('id_konsultasi');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('tanggal_konsultasi')->useCurrent();

            $table->foreignId('penyakit_diduga_id')
                ->nullable()
                ->constrained('penyakit', 'id_penyakit')
                ->nullOnDelete();

            $table->float('cf_hasil', 3, 2)->nullable(); // final CF

            $table->string('lokasi')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
