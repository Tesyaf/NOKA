<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\KonsultasiGejala;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        return view('konsultasi.index', [
            'gejala' => Gejala::all()
        ]);
    }

    public function proses(Request $request)
    {
        $request->validate([
            'gejala' => 'required|array'
        ]);

        // Simpan sesi konsultasi
        $konsultasi = Konsultasi::create([]);

        foreach ($request->gejala as $id) {
            KonsultasiGejala::create([
                'konsultasi_id' => $konsultasi->id_konsultasi,
                'gejala_id'     => $id,
                'cf_user'       => 1.0
            ]);
        }

        // ---- CF Calculation ----
        $penyakit_list = Penyakit::with('gejala')->get();
        $nilaiAkhir = [];

        foreach ($penyakit_list as $penyakit) {
            $cf_old = 0;

            foreach ($konsultasi->gejala as $g) {

                $rule = $penyakit->gejala->firstWhere('id_gejala', $g->id_gejala);

                if ($rule) {
                    $cf = $rule->pivot->cf_pakar * $g->pivot->cf_user;
                    $cf_old = $cf_old + $cf * (1 - $cf_old);
                }
            }

            $nilaiAkhir[$penyakit->id_penyakit] = $cf_old;
        }

        // tentukan hasil terbesar
        arsort($nilaiAkhir);
        $hasil_id = array_key_first($nilaiAkhir);

        // simpan
        $konsultasi->update([
            'penyakit_diduga_id' => $hasil_id,
            'cf_hasil'           => $nilaiAkhir[$hasil_id]
        ]);

        return redirect()->route('konsultasi.hasil', $konsultasi->id_konsultasi);
    }

    public function hasil($id)
    {
        $konsultasi = Konsultasi::with(['hasil', 'gejala'])->findOrFail($id);
        return view('konsultasi.hasil', compact('konsultasi'));
    }
}
