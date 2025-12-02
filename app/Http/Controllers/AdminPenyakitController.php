<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;

class AdminPenyakitController extends Controller
{
    public function index()
    {
        $data = Penyakit::all();
        return view('admin.penyakit.index', compact('data'));
    }

    public function create()
    {
        return view('admin.penyakit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_penyakit' => 'required|unique:penyakit',
            'nama_penyakit' => 'required'
        ]);

        Penyakit::create($request->only([
            'kode_penyakit',
            'nama_penyakit',
            'penyebab',
            'deskripsi',
            'pengendalian',
            'pencegahan',
            'gambar',
        ]));

        return redirect()->route('penyakit.index')
            ->with('success', 'Data penyakit berhasil ditambahkan.');
    }

    public function edit(Penyakit $penyakit)
    {
        return view('admin.penyakit.edit', compact('penyakit'));
    }

    public function update(Request $request, Penyakit $penyakit)
    {
        $request->validate([
            'kode_penyakit' => 'required|unique:penyakit,kode_penyakit,' . $penyakit->id_penyakit . ',id_penyakit',
            'nama_penyakit' => 'required'
        ]);

        $penyakit->update($request->only([
            'kode_penyakit',
            'nama_penyakit',
            'penyebab',
            'deskripsi',
            'pengendalian',
            'pencegahan',
            'gambar',
        ]));

        return redirect()->route('penyakit.index')
            ->with('success', 'Data penyakit berhasil diperbarui.');
    }

    public function destroy(Penyakit $penyakit)
    {
        $penyakit->delete();

        return back()->with('success', 'Data penyakit berhasil dihapus.');
    }
}
