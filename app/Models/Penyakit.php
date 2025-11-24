<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    protected $table = 'penyakit';
    protected $primaryKey = 'id_penyakit';
    protected $fillable = [
        'kode_penyakit',
        'nama_penyakit',
        'penyebab',
        'deskripsi',
        'pengendalian',
        'pencegahan',
        'gambar',
    ];

    // Relasi ke aturan (many-to-many via pivot 'aturan')
    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'aturan', 'penyakit_id', 'gejala_id')
            ->withPivot('cf_pakar')
            ->withTimestamps();
    }

    // Relasi ke konsultasi (hasil diagnosa)
    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'penyakit_diduga_id');
    }
}
