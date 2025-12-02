<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Dashboard Admin</title>
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
                    <span class="text-xl font-semibold tracking-wide text-stone-900">NOKA Dashboard</span>
                </div>
            </div>

            <nav class="hidden md:flex gap-4 text-sm font-medium">
                <a href="/admin" class="text-amber-700 font-semibold">Dashboard</a>
                <a href="/admin/penyakit" class="hover:text-amber-700">Penyakit</a>
                <a href="/admin/gejala" class="hover:text-amber-700">Gejala</a>
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
        <!-- Header section -->
        <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="space-y-2">
                <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Ringkasan Admin</h1>
                <p class="text-sm text-stone-600 max-w-2xl">Pantau data penyakit, gejala, dan aturan sistem pakar NOKA. Gunakan panel ini untuk memastikan basis pengetahuan selalu mutakhir.</p>
            </div>
            <div class="flex gap-2">
                <a href="/" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Beranda</a>
                <a href="/admin/penyakit/create" class="px-4 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Tambah Penyakit</a>
            </div>
        </section>

        <!-- Stats -->
        <section class="grid md:grid-cols-3 gap-4">
            <div class="p-5 rounded-2xl bg-white/80 border border-amber-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Penyakit</p>
                <div class="flex items-end justify-between mt-3">
                    <h2 class="text-3xl font-semibold text-stone-900">{{ $jumlahPenyakit ?? '0' }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800">Total data</span>
                </div>
                <p class="text-[11px] text-stone-500 mt-2">Jumlah entri penyakit dalam basis pengetahuan.</p>
            </div>
            <div class="p-5 rounded-2xl bg-white/80 border border-lime-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Gejala</p>
                <div class="flex items-end justify-between mt-3">
                    <h2 class="text-3xl font-semibold text-stone-900">{{ $jumlahGejala ?? '0' }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-lime-50 border border-lime-200 text-lime-800">Terverifikasi</span>
                </div>
                <p class="text-[11px] text-stone-500 mt-2">Data gejala yang dapat dipakai dalam konsultasi.</p>
            </div>
            <div class="p-5 rounded-2xl bg-white/80 border border-stone-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Aturan</p>
                <div class="flex items-end justify-between mt-3">
                    <h2 class="text-3xl font-semibold text-stone-900">{{ $jumlahAturan ?? '0' }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-stone-700">Rule aktif</span>
                </div>
                <p class="text-[11px] text-stone-500 mt-2">Aturan penalaran yang aktif pada mesin inferensi.</p>
            </div>
        </section>

        <!-- Quick actions + recent -->
        <section class="grid lg:grid-cols-[1.2fr,1.1fr] gap-6 items-start">
            <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-semibold text-stone-900">Aksi cepat</p>
                    <span class="text-xs text-stone-500">Perbarui data dalam sekali klik</span>
                </div>
                <div class="grid md:grid-cols-2 gap-3 text-sm">
                    <a href="/admin/penyakit/create" class="flex items-center justify-between rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 hover:bg-amber-100">
                        <span class="font-semibold text-amber-800">Tambah penyakit</span>
                        <span class="text-xs text-amber-700">+</span>
                    </a>
                    <a href="/admin/gejala/create" class="flex items-center justify-between rounded-2xl border border-lime-100 bg-lime-50 px-4 py-3 hover:bg-lime-100">
                        <span class="font-semibold text-lime-800">Tambah gejala</span>
                        <span class="text-xs text-lime-700">+</span>
                    </a>
                    <a href="/admin/aturan/create" class="flex items-center justify-between rounded-2xl border border-stone-100 bg-stone-50 px-4 py-3 hover:bg-stone-100">
                        <span class="font-semibold text-stone-800">Tambah aturan</span>
                        <span class="text-xs text-stone-700">+</span>
                    </a>
                    <a href="/konsultasi" class="flex items-center justify-between rounded-2xl border border-amber-100 bg-white px-4 py-3 hover:bg-amber-50">
                        <span class="font-semibold text-stone-800">Lihat simulasi</span>
                        <span class="text-xs text-amber-700">>></span>
                    </a>
                </div>
            </div>

            <div class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-semibold text-stone-900">Aktivitas terbaru</p>
                    <span class="text-xs text-stone-500">Log singkat</span>
                </div>
                <div class="space-y-3 text-sm text-stone-700">
                    <div class="flex items-start gap-3">
                        <span class="w-2 h-2 rounded-full bg-lime-500 mt-1"></span>
                        <div>
                            <p class="font-semibold text-stone-900">Aturan baru ditambahkan</p>
                            <p class="text-xs text-stone-500">5 menit lalu - oleh admin</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-2 h-2 rounded-full bg-amber-500 mt-1"></span>
                        <div>
                            <p class="font-semibold text-stone-900">2 gejala diperbarui</p>
                            <p class="text-xs text-stone-500">Hari ini, 09:20</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-2 h-2 rounded-full bg-stone-400 mt-1"></span>
                        <div>
                            <p class="font-semibold text-stone-900">Backup basis pengetahuan</p>
                            <p class="text-xs text-stone-500">Kemarin, 17:45</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Table preview -->
        <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-lg font-semibold text-stone-900">Penyakit terbaru</p>
                    <p class="text-xs text-stone-500">Cuplikan 5 data terakhir</p>
                </div>
                <a href="/admin/penyakit" class="text-sm font-semibold text-amber-700 hover:text-amber-600">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-stone-700">
                    <thead class="text-xs uppercase text-stone-500 bg-stone-50">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama penyakit</th>
                            <th class="px-4 py-3">Gejala terkait</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse (($penyakitTerbaru ?? []) as $penyakit)
                            <tr class="hover:bg-amber-50/40">
                                <td class="px-4 py-3 font-semibold text-stone-900">{{ $penyakit->kode_penyakit }}</td>
                                <td class="px-4 py-3">{{ $penyakit->nama_penyakit }}</td>
                                <td class="px-4 py-3 text-xs text-stone-500">{{ $penyakit->gejala_count ?? '0' }} gejala</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="/admin/penyakit/{{ $penyakit->id }}/edit" class="text-amber-700 font-semibold">Edit</a>
                                    <a href="/admin/penyakit/{{ $penyakit->id }}" class="text-stone-600">Detail</a>
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
    </main>
</body>
</html>