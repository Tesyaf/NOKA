<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;

class AdminGejalaController extends Controller
{
    public function index()
    {
        $data = Gejala::all();
        return view('admin.gejala.index', compact('data'));
    }

    public function create()
    {
        return view('admin.gejala.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|unique:gejala',
            'nama_gejala' => 'required'
        ]);

        Gejala::create($request->all());

        return redirect()->route('gejala.index')
            ->with('success', 'Data gejala berhasil ditambahkan.');
    }

    public function edit(Gejala $gejala)
    {
        return view('admin.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, Gejala $gejala)
    {
        $request->validate([
            'nama_gejala' => 'required'
        ]);

        $gejala->update($request->all());

        return redirect()->route('gejala.index')
            ->with('success', 'Data gejala diperbarui.');
    }

    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return back()->with('success', 'Data gejala dihapus.');
    }
}
