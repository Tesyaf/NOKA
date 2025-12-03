<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakit = Penyakit::orderBy('kode_penyakit')->get();

        return view('penyakit.index', compact('penyakit'));
    }

    public function show(Penyakit $penyakit)
    {
        $penyakit->load('gejala');

        return view('penyakit.show', compact('penyakit'));
    }
}
