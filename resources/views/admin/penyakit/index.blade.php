@extends('layouts.admin')
@section('title', 'Manajemen Penyakit | NOKA')

@section('content')
    @php use Illuminate\Support\Str; @endphp
    <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="space-y-2">
            <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Daftar Penyakit</h1>
            <p class="text-sm text-stone-600 max-w-2xl">Kelola data penyakit untuk basis pengetahuan NOKA.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Dashboard</a>
            <a href="{{ route('penyakit.create') }}" class="px-4 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Tambah Penyakit</a>
        </div>
    </section>

    <section class="grid md:grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl bg-white/80 border border-amber-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Total penyakit</p>
            <div class="flex items-end justify-between mt-3">
                <h2 class="text-3xl font-semibold text-stone-900">{{ $data->count() ?? 0 }}</h2>
                <span class="text-xs px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800">Data aktif</span>
            </div>
        </div>
        <div class="p-5 rounded-2xl bg-white/80 border border-lime-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Basis aturan</p>
            <p class="text-sm text-stone-700 mt-3">Pastikan data ini sinkron dengan aturan yang berlaku.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white/80 border border-stone-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Catatan</p>
            <p class="text-sm text-stone-700 mt-3">Review data minimal 1x per bulan.</p>
        </div>
    </section>

    <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-lg font-semibold text-stone-900">Penyakit terdaftar</p>
                <p class="text-xs text-stone-500">Kelola daftar berikut sesuai kebutuhan.</p>
            </div>
            <a href="{{ route('penyakit.create') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-600">Tambah baru</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-stone-700">
                <thead class="text-xs uppercase text-stone-500 bg-stone-50">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama penyakit</th>
                        <th class="px-4 py-3">Deskripsi singkat</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($data as $penyakit)
                        <tr class="hover:bg-amber-50/40">
                            <td class="px-4 py-3 font-semibold text-stone-900">{{ $penyakit->kode_penyakit }}</td>
                            <td class="px-4 py-3">{{ $penyakit->nama_penyakit }}</td>
                            <td class="px-4 py-3 text-xs text-stone-500">{{ Str::limit($penyakit->deskripsi ?? '-', 80) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('penyakit.edit', $penyakit) }}" class="text-amber-700 font-semibold">Edit</a>
                                <form action="{{ route('penyakit.destroy', $penyakit) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-700" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-stone-500">Belum ada data penyakit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
