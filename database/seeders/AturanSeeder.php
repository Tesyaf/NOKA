<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Aturan;
use RuntimeException;

class AturanSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            'P01' => [
                ['G01', 0.9, 'Bercak cokelat kehitaman khas busuk buah'],
                ['G02', 0.85, 'Sporulasi putih pada permukaan buah'],
                ['G03', 0.8, 'Bercak busuk meluas cepat'],
                ['G04', 0.75, 'Infeksi muncul dari ujung/pangkal buah'],
            ],
            'P02' => [
                ['G05', 0.8, 'Mozaik kuning-hijau pada daun'],
                ['G06', 0.75, 'Daun gugur hingga ranting gundul'],
                ['G07', 0.9, 'Garis cokelat pada xylem saat dibelah'],
                ['G08', 0.7, 'Benang putih pada bekas dudukan daun'],
                ['G16', 0.45, 'Daun menguning/layu akibat stres akar (overlap)'],
            ],
            'P03' => [
                ['G09', 0.7, 'Kulit batang menghitam'],
                ['G10', 0.85, 'Kulit batang membusuk dan basah'],
                ['G11', 0.9, 'Lapisan dalam merah anggur saat dikupas'],
            ],
            'P04' => [
                ['G12', 0.7, 'Bintik nekrosis pada daun muda'],
                ['G13', 0.75, 'Bercak berlubang dengan halo kuning'],
                ['G14', 0.85, 'Buah muda layu dengan bintik berlekuk'],
                ['G15', 0.8, 'Buah tua busuk kering dan mengerut'],
                ['G01', 0.4, 'Bercak buah mirip busuk buah (overlap)'],
            ],
            'P05' => [
                ['G16', 0.8, 'Daun menguning lalu layu'],
                ['G17', 0.9, 'Tanaman mati bertahap'],
                ['G18', 0.85, 'Badan jamur pada akar'],
                ['G06', 0.45, 'Defoliasi akibat akar rusak (overlap)'],
            ],
        ];

        $penyakitMap = Penyakit::pluck('id_penyakit', 'kode_penyakit');
        $gejalaMap = Gejala::pluck('id_gejala', 'kode_gejala');

        foreach ($rules as $kodePenyakit => $gejalaList) {
            $penyakitId = $penyakitMap[$kodePenyakit] ?? null;
            if (!$penyakitId) {
                throw new RuntimeException("Penyakit {$kodePenyakit} tidak ditemukan.");
            }

            foreach ($gejalaList as $rule) {
                [$kodeGejala, $cf, $keterangan] = array_pad($rule, 3, null);

                $gejalaId = $gejalaMap[$kodeGejala] ?? null;
                if (!$gejalaId) {
                    throw new RuntimeException("Gejala {$kodeGejala} tidak ditemukan.");
                }

                Aturan::updateOrCreate(
                    ['penyakit_id' => $penyakitId, 'gejala_id' => $gejalaId],
                    ['cf_pakar' => $cf, 'keterangan' => $keterangan]
                );
            }
        }
    }
}
