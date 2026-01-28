@extends('layouts.admin')
@section('title', 'Tambah Aturan | NOKA')

@section('content')
    <section class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-stone-900">Tambah Aturan</h1>
            <p class="text-sm text-stone-600">Hubungkan penyakit dan gejala dengan nilai CF pakar.</p>
        </div>
        <a href="{{ route('aturan.index') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Kembali</a>
    </section>

    <form action="{{ route('aturan.store') }}" method="POST" class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-5">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-sm font-semibold text-stone-800">Penyakit</label>
                <select name="penyakit_id" required class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    <option value="">-- Pilih penyakit --</option>
                    @foreach ($penyakit as $p)
                        <option value="{{ $p->id_penyakit }}" {{ old('penyakit_id') == $p->id_penyakit ? 'selected' : '' }}>
                            {{ $p->kode_penyakit }} - {{ $p->nama_penyakit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-sm font-semibold text-stone-800">Gejala</label>
                <select name="gejala_id" required class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    <option value="">-- Pilih gejala --</option>
                    @foreach ($gejala as $g)
                        <option value="{{ $g->id_gejala }}" {{ old('gejala_id') == $g->id_gejala ? 'selected' : '' }}>
                            {{ $g->kode_gejala }} - {{ $g->nama_gejala }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-sm font-semibold text-stone-800">CF Pakar</label>
                <input type="number" name="cf_pakar" step="0.01" min="0.1" max="1" value="{{ old('cf_pakar', 0.8) }}" required
                       class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300"
                       aria-describedby="cf-help">
                <p id="cf-help" class="text-xs text-stone-500">Gunakan rentang 0.1 - 1 (0.1 = sangat ragu, 1 = sangat yakin).</p>
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-stone-800">Keterangan (opsional)</label>
            <textarea name="keterangan" rows="3" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex justify-end gap-3 pt-3">
            <a href="{{ route('aturan.index') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Batal</a>
            <button type="submit" class="px-5 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Simpan</button>
        </div>
    </form>
@endsection
