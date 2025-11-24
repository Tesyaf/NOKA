<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gejala;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_gejala' => 'G01', 'nama_gejala' => 'Buah cokelat kehitaman dengan batas tegas'],
            ['kode_gejala' => 'G02', 'nama_gejala' => 'Permukaan buah muncul serbuk putih'],
            ['kode_gejala' => 'G03', 'nama_gejala' => 'Bercak busuk berkembang cepat'],
            ['kode_gejala' => 'G04', 'nama_gejala' => 'Infeksi dimulai dari ujung/pangkal/tengah buah'],

            ['kode_gejala' => 'G05', 'nama_gejala' => 'Daun menguning dengan bercak hijau'],
            ['kode_gejala' => 'G06', 'nama_gejala' => 'Daun gugur sehingga ranting gundul'],
            ['kode_gejala' => 'G07', 'nama_gejala' => 'Garis cokelat pada xylem saat ranting dibelah'],
            ['kode_gejala' => 'G08', 'nama_gejala' => 'Benang putih pada bekas dudukan daun'],

            ['kode_gejala' => 'G09', 'nama_gejala' => 'Kulit batang menghitam'],
            ['kode_gejala' => 'G10', 'nama_gejala' => 'Kulit batang membusuk dan basah'],
            ['kode_gejala' => 'G11', 'nama_gejala' => 'Lapisan dalam merah anggur saat dikupas'],

            ['kode_gejala' => 'G12', 'nama_gejala' => 'Bintik nekrosis cokelat pada daun muda'],
            ['kode_gejala' => 'G13', 'nama_gejala' => 'Bercak berlubang dengan halo kuning'],
            ['kode_gejala' => 'G14', 'nama_gejala' => 'Buah muda layu dengan bintik coklat berlekuk'],
            ['kode_gejala' => 'G15', 'nama_gejala' => 'Buah tua busuk kering dan mengerut'],

            ['kode_gejala' => 'G16', 'nama_gejala' => 'Daun menguning lalu layu'],
            ['kode_gejala' => 'G17', 'nama_gejala' => 'Tanaman mati bertahap'],
            ['kode_gejala' => 'G18', 'nama_gejala' => 'Terdapat badan jamur merah/coklat/putih pada akar'],
        ];

        foreach ($data as $item) {
            Gejala::firstOrCreate(['kode_gejala' => $item['kode_gejala']], $item);
        }
    }
}