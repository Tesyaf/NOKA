<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Manajemen Gejala</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #fef7e8, #f3fce9, #f7f5f2);
        }
    </style>
</head>
<body class="min-h-screen text-stone-800">
    <!-- NAVBAR -->
    <header class="w-full bg-white/70 backdrop-blur border-b border-amber-100">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-3">
                <img src="/logo.png" class="w-10 h-10 object-contain" alt="Logo NOKA">
                <div>
                    <p class="text-xs text-amber-700 font-semibold tracking-[0.2em] uppercase">Panel Admin</p>
                    <span class="text-xl font-semibold tracking-wide text-stone-900">Manajemen Gejala</span>
                </div>
            </div>
            <nav class="hidden md:flex gap-4 text-sm font-medium">
                <a href="/admin" class="hover:text-amber-700">Dashboard</a>
                <a href="/admin/penyakit" class="hover:text-amber-700">Penyakit</a>
                <a href="/admin/gejala" class="text-amber-700 font-semibold">Gejala</a>
                <a href="/admin/aturan" class="hover:text-amber-700">Aturan</a>
            </nav>
            <div class="flex items-center gap-3">
                <span class="hidden md:inline text-xs text-stone-500">admin@noka.id</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10 lg:py-12 space-y-8">
        <!-- Header + actions -->
        <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="space-y-2">
                <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Daftar Gejala</h1>
                <p class="text-sm text-stone-600 max-w-2xl">Kelola data gejala yang digunakan pada proses konsultasi dan penarikan aturan.</p>
            </div>
            <div class="flex gap-2">
                <a href="/admin" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Dashboard</a>
                <a href="{{ route('gejala.create') }}" class="px-4 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Tambah Gejala</a>
            </div>
        </section>

        @if (session('success'))
            <div class="rounded-2xl border border-lime-200 bg-lime-50 text-lime-800 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Summary cards -->
        <section class="grid md:grid-cols-3 gap-4">
            <div class="p-5 rounded-2xl bg-white/80 border border-amber-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Total gejala</p>
                <div class="flex items-end justify-between mt-3">
                    <h2 class="text-3xl font-semibold text-stone-900">{{ $data->count() ?? 0 }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800">Data aktif</span>
                </div>
            </div>
            <div class="p-5 rounded-2xl bg-white/80 border border-lime-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Ketersediaan</p>
                <div class="flex items-end justify-between mt-3">
                    <h2 class="text-2xl font-semibold text-stone-900">Terhubung aturan</h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-lime-50 border border-lime-200 text-lime-800">Siap pakai</span>
                </div>
                <p class="text-[11px] text-stone-500 mt-2">Pastikan tiap gejala punya relasi ke aturan.</p>
            </div>
            <div class="p-5 rounded-2xl bg-white/80 border border-stone-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Catatan</p>
                <div class="flex items-center justify-between mt-3">
                    <p class="text-sm text-stone-700">Review ulang setelah update lapangan.</p>
                    <span class="text-xs px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-stone-700">Tips</span>
                </div>
            </div>
        </section>

        <!-- Table -->
        <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-lg font-semibold text-stone-900">Gejala terdaftar</p>
                    <p class="text-xs text-stone-500">Kelola daftar berikut sesuai kebutuhan.</p>
                </div>
                <a href="{{ route('gejala.create') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-600">Tambah baru</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-stone-700">
                    <thead class="text-xs uppercase text-stone-500 bg-stone-50">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama gejala</th>
                            <th class="px-4 py-3">Deskripsi singkat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($data as $gejala)
                            <tr class="hover:bg-amber-50/40">
                                <td class="px-4 py-3 font-semibold text-stone-900">{{ $gejala->kode_gejala }}</td>
                                <td class="px-4 py-3">{{ $gejala->nama_gejala }}</td>
                                <td class="px-4 py-3 text-xs text-stone-500">{{ Str::limit($gejala->deskripsi ?? '-', 80) }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('gejala.edit', $gejala) }}" class="text-amber-700 font-semibold">Edit</a>
                                    <form action="{{ route('gejala.destroy', $gejala) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-700" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-stone-500">Belum ada data gejala.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>