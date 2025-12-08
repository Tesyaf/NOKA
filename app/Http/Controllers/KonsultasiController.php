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
        return view('konsultasi.index', [
            'gejala' => Gejala::orderBy('kode_gejala')->get()
        ]);
    }

    public function proses(Request $request, InferenceEngine $engine)
    {
        $request->validate([
            'gejala' => 'required|array',
            'metode_deteksi' => 'required|in:backward,forward',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500'
        ]);

        // Simpan sesi konsultasi
        $konsultasi = Konsultasi::create([
            'user_id'        => auth()->id(),
            'metode_deteksi' => $request->input('metode_deteksi', 'backward'),
            'lokasi'         => $request->input('lokasi'),
            'keterangan'     => $request->input('keterangan'),
        ]);

        foreach ($request->gejala as $id) {
            KonsultasiGejala::create([
                'konsultasi_id' => $konsultasi->id_konsultasi,
                'gejala_id'     => $id,
                'cf_user'       => 1.0
            ]);
        }

        // Muat relasi gejala yang baru disimpan
        $konsultasi->load('gejala');

        $metode = $request->input('metode_deteksi', 'backward');

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
            // ---- Backward chaining (dengan hybrid untuk scoring) ----
            $hasilInferensi = $engine->inferHybrid($konsultasi->gejala);
            $peringkat = collect($hasilInferensi)->sortByDesc('combined');
            $teratas = $peringkat->first();

            $hasil_id = data_get($teratas, 'penyakit.id_penyakit');
            $cf_hasil = data_get($teratas, 'combined', 0);
            $cf_backward = $cf_hasil;
            $cf_forward = null;
        }

        // Simpan; jika keyakinan nol/tidak ada hasil, kosongkan id penyakit
        if (!$hasil_id || $cf_hasil <= 0) {
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
            // ---- Backward chaining with hybrid scoring ----
            $hybrid = $engine->inferHybrid($konsultasi->gejala);
            $peringkat = collect($hybrid)->sortByDesc('combined');
            $detailPenyakit = $konsultasi->penyakit_diduga_id
                ? ($hybrid[$konsultasi->penyakit_diduga_id] ?? null)
                : null;
            if (!$detailPenyakit) {
                $detailPenyakit = $peringkat->first();
            }
            $backward = $konsultasi->hasil
                ? $engine->backward($konsultasi->gejala, $konsultasi->hasil)
                : null;
            $lowConfidence = !$detailPenyakit || data_get($detailPenyakit, 'combined', 0) <= 0;
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
