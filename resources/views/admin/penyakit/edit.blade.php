@extends('layouts.admin')
@section('title', 'Edit Penyakit | NOKA')

@section('content')
    <section class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-stone-900">Edit Penyakit</h1>
            <p class="text-sm text-stone-600">Perbarui data penyakit.</p>
        </div>
        <a href="{{ route('penyakit.index') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Kembali</a>
    </section>

    <form action="{{ route('penyakit.update', $penyakit) }}" method="POST" class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-5">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-sm font-semibold text-stone-800">Kode Penyakit</label>
                <input type="text" name="kode_penyakit" value="{{ old('kode_penyakit', $penyakit->kode_penyakit) }}" required
                       class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
            </div>
            <div class="space-y-1">
                <label class="text-sm font-semibold text-stone-800">Nama Penyakit</label>
                <input type="text" name="nama_penyakit" value="{{ old('nama_penyakit', $penyakit->nama_penyakit) }}" required
                       class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-stone-800">Penyebab</label>
            <textarea name="penyebab" rows="2" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">{{ old('penyebab', $penyakit->penyebab) }}</textarea>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-stone-800">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">{{ old('deskripsi', $penyakit->deskripsi) }}</textarea>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-stone-800">Pengendalian</label>
            <textarea name="pengendalian" rows="3" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">{{ old('pengendalian', $penyakit->pengendalian) }}</textarea>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-stone-800">Pencegahan</label>
            <textarea name="pencegahan" rows="3" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">{{ old('pencegahan', $penyakit->pencegahan) }}</textarea>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-stone-800">URL/Path Gambar (opsional)</label>
            <input type="text" name="gambar" value="{{ old('gambar', $penyakit->gambar) }}"
                   class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
        </div>

        <div class="flex justify-end gap-3 pt-3">
            <a href="{{ route('penyakit.index') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Batal</a>
            <button type="submit" class="px-5 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Update</button>
        </div>
    </form>
@endsection
