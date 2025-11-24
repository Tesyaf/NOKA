<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use App\Models\Penyakit;
use App\Models\Gejala;
use Illuminate\Http\Request;

class AdminAturanController extends Controller
{
    public function index()
    {
        $aturan = Aturan::with(['penyakit', 'gejala'])->get();
        return view('admin.aturan.index', compact('aturan'));
    }

    public function create()
    {
        return view('admin.aturan.create', [
            'penyakit' => Penyakit::all(),
            'gejala'   => Gejala::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyakit_id' => 'required',
            'gejala_id'   => 'required',
            'cf_pakar'    => 'required|numeric'
        ]);

        Aturan::create($request->all());

        return redirect()->route('aturan.index')->with('success', 'Aturan berhasil ditambahkan!');
    }

    public function destroy(Aturan $aturan)
    {
        $aturan->delete();
        return back()->with('success', 'Aturan berhasil dihapus!');
    }
}
