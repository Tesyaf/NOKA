<?php

namespace App\Services;

use App\Models\Penyakit;
use Illuminate\Support\Collection;

class InferenceEngine
{
    /**
     * Hybrid inference: rule-based CF + fuzzy-like weighted scoring.
     *
     * @param Collection $userGejala Koleksi Gejala dengan pivot cf_user (0-1)
     * @param float $alpha Bobot kombinasi untuk CF (0-1). Sisanya untuk skor fuzzy.
     * @return array daftar hasil per penyakit dengan metrik dan reasoning
     */
    public function inferHybrid(Collection $userGejala, float $alpha = 0.6): array
    {
        $penyakitList = Penyakit::with('gejala')->get();
        $userGejalaIndex = $userGejala->keyBy('id_gejala');
        $results = [];

        foreach ($penyakitList as $penyakit) {
            $cf = 0.0;
            $scoreWeighted = 0.0;
            $sumWeight = 0.0;
            $matched = [];
            $missing = [];

            foreach ($penyakit->gejala as $gejalaRule) {
                $weight = $gejalaRule->pivot->cf_pakar;
                $sumWeight += $weight;
                $userFact = $userGejalaIndex->get($gejalaRule->id_gejala);

                if ($userFact) {
                    $userCf = $userFact->pivot->cf_user ?? 1;
                    $ruleCf = $weight * $userCf;
                    $cf = $this->combineCf($cf, $ruleCf);
                    $scoreWeighted += $ruleCf;

                    $matched[] = [
                        'id' => $gejalaRule->id_gejala,
                        'kode' => $gejalaRule->kode_gejala,
                        'nama' => $gejalaRule->nama_gejala,
                        'cf_rule' => $weight,
                        'cf_user' => $userCf,
                        'cf_hasil' => $ruleCf,
                    ];
                } else {
                    $missing[] = [
                        'id' => $gejalaRule->id_gejala,
                        'kode' => $gejalaRule->kode_gejala,
                        'nama' => $gejalaRule->nama_gejala,
                        'cf_rule' => $weight,
                    ];
                }
            }

            $fuzzyScore = $sumWeight > 0 ? $scoreWeighted / $sumWeight : 0;
            $combined = ($alpha * $cf) + ((1 - $alpha) * $fuzzyScore);

            $results[$penyakit->id_penyakit] = [
                'penyakit' => $penyakit,
                'cf' => round($cf, 4),
                'fuzzy_score' => round($fuzzyScore, 4),
                'combined' => round($combined, 4),
                'matched' => $matched,
                'missing' => $missing,
            ];
        }

        return $results;
    }

    /**
     * Forward chaining: hitung keyakinan penyakit berdasarkan gejala yang diberikan.
     *
     * @param Collection $userGejala Koleksi Gejala dengan pivot cf_user (jika ada)
     * @return array keyed by penyakit_id dengan cf, gejala cocok, dan gejala belum terjawab
     */
    public function forward(Collection $userGejala): array
    {
        $penyakitList = Penyakit::with('gejala')->get();
        $userGejalaIndex = $userGejala->keyBy('id_gejala');

        $hasil = [];

        foreach ($penyakitList as $penyakit) {
            $cf = 0.0;
            $matched = [];
            $missing = [];

            foreach ($penyakit->gejala as $gejalaRule) {
                $userFact = $userGejalaIndex->get($gejalaRule->id_gejala);

                if ($userFact) {
                    $cfRule = $gejalaRule->pivot->cf_pakar * ($userFact->pivot->cf_user ?? 1);
                    $cf = $this->combineCf($cf, $cfRule);

                    $matched[] = [
                        'id' => $gejalaRule->id_gejala,
                        'kode' => $gejalaRule->kode_gejala,
                        'nama' => $gejalaRule->nama_gejala,
                        'cf_rule' => $gejalaRule->pivot->cf_pakar,
                        'cf_user' => $userFact->pivot->cf_user ?? 1,
                        'cf_hasil' => $cfRule,
                    ];
                } else {
                    $missing[] = [
                        'id' => $gejalaRule->id_gejala,
                        'kode' => $gejalaRule->kode_gejala,
                        'nama' => $gejalaRule->nama_gejala,
                        'cf_rule' => $gejalaRule->pivot->cf_pakar,
                    ];
                }
            }

            $hasil[$penyakit->id_penyakit] = [
                'penyakit' => $penyakit,
                'cf' => round($cf, 4),
                'matched' => $matched,
                'missing' => $missing,
            ];
        }

        return $hasil;
    }

    /**
     * Backward chaining: evaluasi satu hipotesis penyakit terhadap fakta yang ada.
     *
     * @param Collection $userGejala Koleksi gejala yang sudah diketahui
     * @param Penyakit   $penyakit   Hipotesis penyakit yang diuji
     * @return array ringkasan keyakinan dan gejala yang perlu ditanyakan lagi
     */
    public function backward(Collection $userGejala, Penyakit $penyakit): array
    {
        $userGejalaIndex = $userGejala->keyBy('id_gejala');
        $cf = 0.0;
        $known = [];
        $questions = [];

        foreach ($penyakit->gejala->sortByDesc(fn ($gejala) => $gejala->pivot->cf_pakar) as $gejalaRule) {
            $userFact = $userGejalaIndex->get($gejalaRule->id_gejala);

            if ($userFact) {
                $cfRule = $gejalaRule->pivot->cf_pakar * ($userFact->pivot->cf_user ?? 1);
                $cf = $this->combineCf($cf, $cfRule);
                $known[] = [
                    'id' => $gejalaRule->id_gejala,
                    'kode' => $gejalaRule->kode_gejala,
                    'nama' => $gejalaRule->nama_gejala,
                    'cf_rule' => $gejalaRule->pivot->cf_pakar,
                    'cf_user' => $userFact->pivot->cf_user ?? 1,
                    'cf_hasil' => $cfRule,
                ];
            } else {
                $questions[] = [
                    'id' => $gejalaRule->id_gejala,
                    'kode' => $gejalaRule->kode_gejala,
                    'nama' => $gejalaRule->nama_gejala,
                    'cf_rule' => $gejalaRule->pivot->cf_pakar,
                ];
            }
        }

        return [
            'penyakit' => $penyakit,
            'cf' => round($cf, 4),
            'known' => $known,
            'questions' => $questions,
        ];
    }

    private function combineCf(float $current, float $new): float
    {
        // Rumus kombinasi CF: CFold + CFnew * (1 - CFold)
        return $current + $new * (1 - $current);
    }
}
