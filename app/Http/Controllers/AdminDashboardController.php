<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Penyakit;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jumlahPenyakit' => Penyakit::count(),
            'jumlahGejala' => Gejala::count(),
            'jumlahAturan' => Aturan::count(),
            'penyakitTerbaru' => Penyakit::latest()->take(5)->get(),
        ]);
    }
}
