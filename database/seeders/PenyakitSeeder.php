<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penyakit;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_penyakit' => 'P01',
                'nama_penyakit' => 'Busuk Buah',
                'penyebab' => 'Jamur Phytophthora spp.',
                'deskripsi' => 'Bercak cokelat tua pada buah yang cepat meluas dan sering muncul lapisan jamur putih.',
                'pengendalian' => 'Sanitasi buah sakit, panen sering, aplikasi fungisida kontak/sistemik sesuai rekomendasi, perbaiki drainase.',
                'pencegahan' => 'Kurangi kelembapan kebun, pangkas tajuk agar sirkulasi udara baik, buang buah sakit ke lubang bakar.',
            ],
            [
                'kode_penyakit' => 'P02',
                'nama_penyakit' => 'VSD (Vascular Streak Dieback)',
                'penyebab' => 'Jamur Ceratobasidium theobromae',
                'deskripsi' => 'Daun menguning berbintik hijau, gugur dari pucuk ke pangkal, xylem cokelat pada ranting.',
                'pengendalian' => 'Pangkas cabang terserang 20–30 cm di bawah gejala, sanitasi ranting, fungisida sistemik bila perlu.',
                'pencegahan' => 'Gunakan bibit sehat, atur naungan, pemupukan seimbang, drainase baik untuk kurangi kelembapan.',
            ],
            [
                'kode_penyakit' => 'P03',
                'nama_penyakit' => 'Kanker Batang',
                'penyebab' => 'Jamur (mis. Phytophthora, Botryodiplodia) menyerang batang/cabang',
                'deskripsi' => 'Kulit batang menghitam, basah, terkadang merah anggur saat dikupas; jaringan busuk melingkar bisa mematikan cabang.',
                'pengendalian' => 'Kerok jaringan sakit hingga sehat, oles fungisida pasta, pangkas cabang parah, sanitasi alat.',
                'pencegahan' => 'Hindari luka pada batang, jaga kebun kering dengan drainase baik, pilih klon tahan bila tersedia.',
            ],
            [
                'kode_penyakit' => 'P04',
                'nama_penyakit' => 'Antraknosa',
                'penyebab' => 'Jamur Colletotrichum spp.',
                'deskripsi' => 'Bintik nekrosis pada daun muda, bercak berlekuk pada buah; dapat menyebabkan layu atau buah keriput.',
                'pengendalian' => 'Buang daun/buah terinfeksi, semprot fungisida protektif, perbaiki aerasi tajuk.',
                'pencegahan' => 'Pemangkasan rutin, jarak tanam cukup, hindari percikan air ke tajuk, gunakan benih/bibit sehat.',
            ],
            [
                'kode_penyakit' => 'P05',
                'nama_penyakit' => 'Penyakit Akar (Root Rot)',
                'penyebab' => 'Jamur tanah (mis. Rigidoporus lignosus / Ganoderma)',
                'deskripsi' => 'Daun menguning lalu layu, tanaman mati bertahap; akar cokelat rapuh sering diselubungi miselium.',
                'pengendalian' => 'Cabut tanaman mati, bersihkan akar tersisa, parit isolasi, aplikasikan fungisida ke akar sehat di sekitarnya.',
                'pencegahan' => 'Gunakan lahan berdrainase baik, hindari genangan, tanam penutup tanah untuk kurangi kelembapan berlebih.',
            ],
        ];

        foreach ($data as $item) {
            Penyakit::updateOrCreate(
                ['kode_penyakit' => $item['kode_penyakit']],
                $item
            );
        }
    }
}
