<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penyakit;

class GejalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_penyakit' => 'P01', 'nama_penyakit' => 'Busuk Buah'],
            ['kode_penyakit' => 'P02', 'nama_penyakit' => 'VSD (Vascular Streak Dieback)'],
            ['kode_penyakit' => 'P03', 'nama_penyakit' => 'Kanker Batang'],
            ['kode_penyakit' => 'P04', 'nama_penyakit' => 'Antraknosa'],
            ['kode_penyakit' => 'P05', 'nama_penyakit' => 'Penyakit Akar'],
        ];

        foreach ($data as $item) {
            Penyakit::firstOrCreate(['kode_penyakit' => $item['kode_penyakit']], $item);
        }
    }
}
