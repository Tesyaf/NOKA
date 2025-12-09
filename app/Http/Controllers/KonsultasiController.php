<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\KonsultasiGejala;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Services\InferenceEngine;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        $penyakit = Penyakit::with('gejala:id_gejala')->orderBy('kode_penyakit')->get();
        $gejala = Gejala::orderBy('kode_gejala')->get();
        $gejalaPenyakitMap = [];

        foreach ($penyakit as $row) {
            foreach ($row->gejala as $gejalaPenyakit) {
                $gejalaPenyakitMap[$gejalaPenyakit->id_gejala][] = $row->id_penyakit;
            }
        }

        return view('konsultasi.index', [
            'gejala' => $gejala,
            'penyakit' => $penyakit,
            'gejalaPenyakitMap' => $gejalaPenyakitMap,
        ]);
    }

    public function proses(Request $request, InferenceEngine $engine)
    {
        $request->validate([
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'exists:gejala,id_gejala',
            'metode_deteksi' => 'required|in:backward,forward',
            'penyakit_id' => 'required_if:metode_deteksi,backward|exists:penyakit,id_penyakit',
            'cf_user' => 'nullable|array',
            'cf_user.*' => 'nullable|numeric|min:0|max:1',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500'
        ]);

        $metode = $request->input('metode_deteksi', 'backward');
        $selectedGejalaIds = collect($request->input('gejala', []))->map(fn ($id) => (int) $id)->unique();
        $cfUserInput = collect($request->input('cf_user', []));
        $penyakitDipilih = null;

        if ($metode === 'backward') {
            $penyakitDipilih = Penyakit::with('gejala')->findOrFail($request->input('penyakit_id'));
            $allowedGejala = $penyakitDipilih->gejala->pluck('id_gejala');
            $selectedGejalaIds = $selectedGejalaIds->intersect($allowedGejala);

            if ($selectedGejalaIds->isEmpty()) {
                return back()->withInput()->withErrors([
                    'gejala' => 'Pilih minimal satu gejala yang sesuai dengan penyakit yang dipilih.'
                ]);
            }
        }

        // Simpan sesi konsultasi
        $konsultasi = Konsultasi::create([
            'user_id'        => auth()->id(),
            'metode_deteksi' => $request->input('metode_deteksi', 'backward'),
            'lokasi'         => $request->input('lokasi'),
            'keterangan'     => $request->input('keterangan'),
        ]);

        foreach ($selectedGejalaIds as $id) {
            $cfUser = (float) $cfUserInput->get($id, 1);
            $cfUser = max(0, min(1, $cfUser));

            KonsultasiGejala::create([
                'konsultasi_id' => $konsultasi->id_konsultasi,
                'gejala_id'     => $id,
                'cf_user'       => $cfUser
            ]);
        }

        // Muat relasi gejala yang baru disimpan
        $konsultasi->load('gejala');

        if ($metode === 'forward') {
            // ---- Forward chaining: hitung semua penyakit ----
            $hasilInferensi = $engine->forward($konsultasi->gejala);
            $peringkat = collect($hasilInferensi)->sortByDesc('cf');
            $teratas = $peringkat->first();

            $hasil_id = data_get($teratas, 'penyakit.id_penyakit');
            $cf_hasil = data_get($teratas, 'cf', 0);
            $cf_forward = $cf_hasil;
            $cf_backward = null;
        } else {
            // ---- Backward chaining: mulai dari hipotesis penyakit yang dipilih ----
            $penyakitTarget = $penyakitDipilih ?? Penyakit::with('gejala')->find($request->input('penyakit_id'));
            $hasilBackward = $penyakitTarget ? $engine->backward($konsultasi->gejala, $penyakitTarget) : null;

            $hasil_id = $penyakitTarget?->id_penyakit;
            $cf_hasil = data_get($hasilBackward, 'cf', 0);
            $cf_backward = $cf_hasil;
            $cf_forward = null;
        }

        // Simpan; jika keyakinan nol/tidak ada hasil, kosongkan id penyakit
        if ($metode !== 'backward' && (!$hasil_id || $cf_hasil <= 0)) {
            $konsultasi->update([
                'penyakit_diduga_id' => null,
                'cf_hasil' => 0,
                'cf_backward' => $cf_backward,
                'cf_forward' => $cf_forward,
            ]);
        } else {
            $konsultasi->update([
                'penyakit_diduga_id' => $hasil_id,
                'cf_hasil' => $cf_hasil,
                'cf_backward' => $cf_backward,
                'cf_forward' => $cf_forward,
            ]);
        }

        return redirect()->route('konsultasi.hasil', $konsultasi->id_konsultasi);
    }

    public function hasil($id, InferenceEngine $engine)
    {
        $konsultasi = Konsultasi::with(['hasil', 'gejala'])->findOrFail($id);
        $metode = $konsultasi->metode_deteksi ?? 'backward';

        if ($metode === 'forward') {
            // ---- Forward chaining results ----
            $hasilInferensi = $engine->forward($konsultasi->gejala);
            $peringkat = collect($hasilInferensi)->sortByDesc('cf');
            $detailPenyakit = $konsultasi->penyakit_diduga_id
                ? ($hasilInferensi[$konsultasi->penyakit_diduga_id] ?? null)
                : null;
            if (!$detailPenyakit) {
                $detailPenyakit = $peringkat->first();
            }
            $backward = null;
            $lowConfidence = !$detailPenyakit || data_get($detailPenyakit, 'cf', 0) <= 0;
        } else {
            // ---- Backward chaining: tampilkan evaluasi hipotesis penyakit yang dipilih ----
            $penyakitTarget = $konsultasi->hasil;
            $hybrid = $engine->inferHybrid($konsultasi->gejala);
            $peringkat = collect($hybrid)->sortByDesc('combined');

            $backward = $penyakitTarget
                ? $engine->backward($konsultasi->gejala, $penyakitTarget)
                : null;

            $hybridDetail = ($penyakitTarget && isset($hybrid[$penyakitTarget->id_penyakit]))
                ? $hybrid[$penyakitTarget->id_penyakit]
                : null;

            if ($backward && $penyakitTarget) {
                $detailPenyakit = [
                    'penyakit' => $penyakitTarget,
                    'matched' => $backward['known'],
                    'missing' => $backward['questions'],
                    'cf_backward' => $backward['cf'],
                    'cf' => data_get($hybridDetail, 'cf', $backward['cf']),
                    'fuzzy_score' => data_get($hybridDetail, 'fuzzy_score'),
                    'combined' => data_get($hybridDetail, 'combined', $backward['cf']),
                ];
            } else {
                $detailPenyakit = $hybridDetail ?? $peringkat->first();
            }

            $lowConfidence = !$backward || data_get($backward, 'cf', 0) <= 0;
        }

        return view('konsultasi.hasil', [
            'konsultasi' => $konsultasi,
            'detailPenyakit' => $detailPenyakit,
            'backward' => $backward,
            'peringkat' => $peringkat,
            'lowConfidence' => $lowConfidence,
            'metode' => $metode,
        ]);
    }
}
