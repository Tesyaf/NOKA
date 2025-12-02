@extends('layouts.admin')
@section('title', 'Manajemen Aturan | NOKA')

@section('content')
    @php use Illuminate\Support\Str; @endphp
    <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="space-y-2">
            <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Daftar Aturan</h1>
            <p class="text-sm text-stone-600 max-w-2xl">Kelola rule hubungan gejala dan penyakit beserta nilai CF pakar.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Dashboard</a>
            <a href="{{ route('aturan.create') }}" class="px-4 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Tambah Aturan</a>
        </div>
    </section>

    <section class="grid md:grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl bg-white/80 border border-amber-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Total aturan</p>
            <div class="flex items-end justify-between mt-3">
                <h2 class="text-3xl font-semibold text-stone-900">{{ $aturan->count() ?? 0 }}</h2>
                <span class="text-xs px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800">Data aktif</span>
            </div>
        </div>
        <div class="p-5 rounded-2xl bg-white/80 border border-lime-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Kelengkapan</p>
            <p class="text-sm text-stone-700 mt-3">Pastikan setiap aturan memiliki penyakit & gejala terhubung.</p>
        </div>
        <div class="p-5 rounded-2xl bg-white/80 border border-stone-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Catatan</p>
            <p class="text-sm text-stone-700 mt-3">Update CF berkala sesuai pakar.</p>
        </div>
    </section>

    <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-lg font-semibold text-stone-900">Aturan terdaftar</p>
                <p class="text-xs text-stone-500">Cuplikan hubungan penyakit-gejala dengan CF.</p>
            </div>
            <a href="{{ route('aturan.create') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-600">Tambah baru</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-stone-700">
                <thead class="text-xs uppercase text-stone-500 bg-stone-50">
                    <tr>
                        <th class="px-4 py-3">Penyakit</th>
                        <th class="px-4 py-3">Gejala</th>
                        <th class="px-4 py-3">CF Pakar</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($aturan as $rule)
                        <tr class="hover:bg-amber-50/40">
                            <td class="px-4 py-3 font-semibold text-stone-900">{{ $rule->penyakit->nama_penyakit ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $rule->gejala->nama_gejala ?? '-' }}</td>
                            <td class="px-4 py-3 text-xs text-stone-600">{{ number_format($rule->cf_pakar, 2) }}</td>
                            <td class="px-4 py-3 text-xs text-stone-500">{{ Str::limit($rule->keterangan ?? '-', 80) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <form action="{{ route('aturan.destroy', $rule) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-700" onclick="return confirm('Hapus aturan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-stone-500">Belum ada data aturan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
