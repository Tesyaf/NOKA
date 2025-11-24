<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejala';
    protected $primaryKey = 'id_gejala';

    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'deskripsi',
    ];

    public function penyakit()
    {
        return $this->belongsToMany(Penyakit::class, 'aturan', 'gejala_id', 'penyakit_id')
            ->withPivot('cf_pakar')
            ->withTimestamps();
    }

    public function konsultasi()
    {
        return $this->belongsToMany(Konsultasi::class, 'konsultasi_gejala', 'gejala_id', 'konsultasi_id')
            ->withPivot('cf_user')
            ->withTimestamps();
    }
}
