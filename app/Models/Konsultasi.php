<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';
    protected $primaryKey = 'id_konsultasi';

    protected $fillable = [
        'user_id',
        'tanggal_konsultasi',
        'penyakit_diduga_id',
        'cf_hasil',
        'lokasi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_konsultasi' => 'datetime',
        'cf_hasil' => 'float',
    ];

    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'konsultasi_gejala', 'konsultasi_id', 'gejala_id')
            ->withPivot('cf_user')
            ->withTimestamps();
    }

    public function hasil()
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_diduga_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
