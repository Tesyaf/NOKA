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
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->string('metode_deteksi')->default('backward')->after('cf_hasil'); // 'backward', 'forward', 'hybrid'
            $table->float('cf_backward', 3, 2)->nullable()->after('metode_deteksi');
            $table->float('cf_forward', 3, 2)->nullable()->after('cf_backward');
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->dropColumn(['metode_deteksi', 'cf_backward', 'cf_forward']);
        });
    }
};
