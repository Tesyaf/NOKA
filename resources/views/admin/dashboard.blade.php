@extends('layouts.admin')
@section('title', 'Dashboard Admin | NOKA')

@section('content')
    <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="space-y-2">
            <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Ringkasan Admin</h1>
            <p class="text-sm text-stone-600 max-w-2xl">Pantau data penyakit, gejala, dan aturan sistem pakar NOKA.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Beranda</a>
            <a href="{{ route('penyakit.create') }}" class="px-4 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Tambah Penyakit</a>
        </div>
    </section>

    <section class="grid md:grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl bg-white/80 border border-amber-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Penyakit</p>
            <div class="flex items-end justify-between mt-3">
                <h2 class="text-3xl font-semibold text-stone-900">{{ $jumlahPenyakit ?? 0 }}</h2>
                <span class="text-xs px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800">Total data</span>
            </div>
        </div>
        <div class="p-5 rounded-2xl bg-white/80 border border-lime-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Gejala</p>
            <div class="flex items-end justify-between mt-3">
                <h2 class="text-3xl font-semibold text-stone-900">{{ $jumlahGejala ?? 0 }}</h2>
                <span class="text-xs px-3 py-1 rounded-full bg-lime-50 border border-lime-200 text-lime-800">Terverifikasi</span>
            </div>
        </div>
        <div class="p-5 rounded-2xl bg-white/80 border border-stone-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Aturan</p>
            <div class="flex items-end justify-between mt-3">
                <h2 class="text-3xl font-semibold text-stone-900">{{ $jumlahAturan ?? 0 }}</h2>
                <span class="text-xs px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-stone-700">Rule aktif</span>
            </div>
        </div>
    </section>

    <section class="grid lg:grid-cols-[1.2fr,1.1fr] gap-6 items-start">
        <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <p class="text-lg font-semibold text-stone-900">Aksi cepat</p>
                <span class="text-xs text-stone-500">Perbarui data</span>
            </div>
            <div class="grid md:grid-cols-2 gap-3 text-sm">
                <a href="{{ route('penyakit.create') }}" class="flex items-center justify-between rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 hover:bg-amber-100">
                    <span class="font-semibold text-amber-800">Tambah penyakit</span>
                    <span class="text-xs text-amber-700">+</span>
                </a>
                <a href="{{ route('gejala.create') }}" class="flex items-center justify-between rounded-2xl border border-lime-100 bg-lime-50 px-4 py-3 hover:bg-lime-100">
                    <span class="font-semibold text-lime-800">Tambah gejala</span>
                    <span class="text-xs text-lime-700">+</span>
                </a>
                <a href="{{ route('aturan.create') }}" class="flex items-center justify-between rounded-2xl border border-stone-100 bg-stone-50 px-4 py-3 hover:bg-stone-100">
                    <span class="font-semibold text-stone-800">Tambah aturan</span>
                    <span class="text-xs text-stone-700">+</span>
                </a>
                <a href="{{ route('konsultasi.index') }}" class="flex items-center justify-between rounded-2xl border border-amber-100 bg-white px-4 py-3 hover:bg-amber-50">
                    <span class="font-semibold text-stone-800">Lihat konsultasi</span>
                    <span class="text-xs text-amber-700">>></span>
                </a>
            </div>
        </div>

        <div class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <p class="text-lg font-semibold text-stone-900">Aktivitas singkat</p>
                <span class="text-xs text-stone-500">Log terbaru</span>
            </div>
            <div class="space-y-3 text-sm text-stone-700">
                <p>Tingkatkan basis data secara berkala setelah verifikasi lapangan.</p>
            </div>
        </div>
    </section>

    @php use Illuminate\Support\Str; @endphp
    <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-lg font-semibold text-stone-900">Penyakit terbaru</p>
                <p class="text-xs text-stone-500">Cuplikan 5 data terakhir</p>
            </div>
            <a href="{{ route('penyakit.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-600">Lihat semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-stone-700">
                <thead class="text-xs uppercase text-stone-500 bg-stone-50">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama penyakit</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($penyakitTerbaru as $penyakit)
                        <tr class="hover:bg-amber-50/40">
                            <td class="px-4 py-3 font-semibold text-stone-900">{{ $penyakit->kode_penyakit }}</td>
                            <td class="px-4 py-3">{{ $penyakit->nama_penyakit }}</td>
                            <td class="px-4 py-3 text-xs text-stone-500">{{ Str::limit($penyakit->deskripsi ?? '-', 80) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('penyakit.edit', $penyakit) }}" class="text-amber-700 font-semibold">Edit</a>
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
