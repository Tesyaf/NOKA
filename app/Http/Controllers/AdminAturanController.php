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
        $aturan = Aturan::with(['penyakit', 'gejala'])->latest()->get();
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
            'penyakit_id' => 'required|exists:penyakit,id_penyakit',
            'gejala_id'   => 'required|exists:gejala,id_gejala',
            'cf_pakar'    => 'required|numeric|min:0|max:1',
            'keterangan'  => 'nullable|string',
        ]);

        Aturan::create($request->only(['penyakit_id', 'gejala_id', 'cf_pakar', 'keterangan']));

        return redirect()->route('aturan.index')->with('success', 'Aturan berhasil ditambahkan!');
    }

    public function destroy(Aturan $aturan)
    {
        $aturan->delete();
        return back()->with('success', 'Aturan berhasil dihapus!');
    }
}
