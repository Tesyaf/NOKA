<?php

namespace App\Services;

use App\Models\Penyakit;
use Illuminate\Support\Collection;

class InferenceEngine
{
    /**
     * Fungsi keanggotaan triangular/trapesium untuk input 0-1 (Mamdani).
     * low/medium/high digunakan untuk fuzzifikasi cf_user.
     */
    private array $fuzzyMembership = [
        'low' => [
            [0.0, 0.0, 0.35],
            [0.0, 0.35, 0.5],
        ],
        'medium' => [
            [0.25, 0.5, 0.75],
        ],
        'high' => [
            [0.5, 0.75, 1.0],
            [0.65, 1.0, 1.0],
        ],
    ];

    /**
     * Titik representatif (centroid sederhana) untuk defuzzifikasi.
     */
    private array $fuzzyOutputCenters = [
        'low' => 0.25,
        'medium' => 0.55,
        'high' => 0.85,
    ];

    /**
     * Hybrid inference: rule-based CF + fuzzy Mamdani (fuzzifikasi + defuzzifikasi).
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
            $matched = [];
            $missing = [];
            $fuzzyAgg = [
                'low' => 0.0,
                'medium' => 0.0,
                'high' => 0.0,
            ];

            foreach ($penyakit->gejala as $gejalaRule) {
                $weight = $gejalaRule->pivot->cf_pakar;
                $userFact = $userGejalaIndex->get($gejalaRule->id_gejala);

                if ($userFact) {
                    $userCf = $userFact->pivot->cf_user ?? 1;
                    $ruleCf = $weight * $userCf;
                    $cf = $this->combineCf($cf, $ruleCf);
                    $membership = $this->fuzzifyValue($userCf);
                    $expectedLevel = $this->expectedLevelFromWeight($weight);
                    $fireExpected = $this->fuzzyFireStrength($expectedLevel, $membership, $weight);
                    $fuzzyAgg[$expectedLevel] = max($fuzzyAgg[$expectedLevel], $fireExpected);

                    // Tambahkan fallback ke label dominan user untuk mencegah semua fuzzy = 0 saat persepsi rendah
                    $bestLabel = $this->dominantLabel($membership);
                    $fireBest = 0.0;
                    if ($bestLabel !== $expectedLevel) {
                        $fireBest = min($membership[$bestLabel] ?? 0.0, $weight * 0.8);
                        $fuzzyAgg[$bestLabel] = max($fuzzyAgg[$bestLabel], $fireBest);
                    }
                    $fire = max($fireExpected, $fireBest);

                    $matched[] = [
                        'id' => $gejalaRule->id_gejala,
                        'kode' => $gejalaRule->kode_gejala,
                        'nama' => $gejalaRule->nama_gejala,
                        'cf_rule' => $weight,
                        'cf_user' => $userCf,
                        'cf_hasil' => $ruleCf,
                        'fuzzy_in' => $membership,
                        'fuzzy_expect' => $expectedLevel,
                        'fuzzy_fire' => round($fire, 4),
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

            $fuzzyScore = $this->defuzzify($fuzzyAgg);
            $combined = ($alpha * $cf) + ((1 - $alpha) * $fuzzyScore);

            $results[$penyakit->id_penyakit] = [
                'penyakit' => $penyakit,
                'cf' => round($cf, 4),
                'fuzzy_score' => round($fuzzyScore, 4),
                'combined' => round($combined, 4),
                'matched' => $matched,
                'missing' => $missing,
                'fuzzy_agg' => $fuzzyAgg,
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

    /**
     * Triangular membership function μ(x; a,b,c).
     */
    private function tri(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) {
            return 0.0;
        }
        if ($x === $b) {
            return 1.0;
        }
        return $x < $b
            ? ($x - $a) / ($b - $a)
            : ($c - $x) / ($c - $b);
    }

    /**
     * Hitung derajat keanggotaan untuk label tertentu.
     */
    private function mu(string $label, float $x): float
    {
        $triangles = $this->fuzzyMembership[$label] ?? [];
        $values = [];

        foreach ($triangles as $triangle) {
            [$a, $b, $c] = $triangle;
            $values[] = $this->tri($x, $a, $b, $c);
        }

        return count($values) ? max($values) : 0.0;
    }

    /**
     * Fuzzifikasi cf_user menjadi low/medium/high.
     */
    private function fuzzifyValue(float $value): array
    {
        return [
            'low' => $this->mu('low', $value),
            'medium' => $this->mu('medium', $value),
            'high' => $this->mu('high', $value),
        ];
    }

    /**
     * Map bobot pakar ke level keanggotaan yang diharapkan.
     */
    private function expectedLevelFromWeight(float $weight): string
    {
        if ($weight >= 0.7) {
            return 'high';
        }
        if ($weight >= 0.45) {
            return 'medium';
        }
        return 'low';
    }

    /**
     * Strength aturan: derajat input untuk level yang diharapkan dibatasi bobot pakar.
     */
    private function fuzzyFireStrength(string $expected, array $membership, float $weight): float
    {
        $degree = $membership[$expected] ?? 0.0;
        return min($degree, $weight);
    }

    /**
     * Defuzzifikasi Mamdani (centroid diskrit).
     */
    private function defuzzify(array $agg): float
    {
        $numerator = 0.0;
        $denominator = 0.0;

        foreach ($agg as $label => $degree) {
            $center = $this->fuzzyOutputCenters[$label] ?? 0.0;
            $numerator += $degree * $center;
            $denominator += $degree;
        }

        return $denominator > 0 ? $numerator / $denominator : 0.0;
    }

    /**
     * Ambil label dengan derajat keanggotaan tertinggi.
     */
    private function dominantLabel(array $membership): string
    {
        $bestLabel = 'low';
        $bestValue = -INF;
        foreach ($membership as $label => $value) {
            if ($value > $bestValue) {
                $bestValue = $value;
                $bestLabel = $label;
            }
        }
        return $bestLabel;
    }
}
