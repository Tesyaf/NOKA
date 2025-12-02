<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Feedback Pengguna</title>
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
                <img src="/images/logo.png" class="w-10 h-10 object-contain" alt="Logo NOKA">
                <div>
                    <p class="text-xs text-amber-700 font-semibold tracking-[0.2em] uppercase">Panel Admin</p>
                    <span class="text-xl font-semibold tracking-wide text-stone-900">Feedback Pengguna</span>
                </div>
            </div>
            <nav class="hidden md:flex gap-4 text-sm font-medium">
                <a href="/admin" class="hover:text-amber-700">Dashboard</a>
                <a href="/admin/penyakit" class="hover:text-amber-700">Penyakit</a>
                <a href="/admin/gejala" class="hover:text-amber-700">Gejala</a>
                <a href="/admin/aturan" class="hover:text-amber-700">Aturan</a>
                <a href="/admin/log-konsultasi" class="hover:text-amber-700">Log</a>
                <a href="/admin/feedback" class="text-amber-700 font-semibold">Feedback</a>
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
                <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Feedback Pengguna</h1>
                <p class="text-sm text-stone-600 max-w-2xl">Pantau masukan pengguna untuk meningkatkan akurasi dan pengalaman konsultasi NOKA.</p>
            </div>
            <div class="flex gap-2">
                <a href="/admin" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Dashboard</a>
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
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Total feedback</p>
                <div class="flex items-end justify-between mt-3">
                    <h2 class="text-3xl font-semibold text-stone-900">{{ $feedbacks->count() ?? 0 }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800">Tercatat</span>
                </div>
            </div>
            <div class="p-5 rounded-2xl bg-white/80 border border-lime-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Rating rata-rata</p>
                <div class="flex items-end justify-between mt-3">
                    <h2 class="text-3xl font-semibold text-stone-900">{{ number_format($ratingRata ?? 0, 2) }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-lime-50 border border-lime-200 text-lime-800">/ 5</span>
                </div>
            </div>
            <div class="p-5 rounded-2xl bg-white/80 border border-stone-100 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Terakhir diterima</p>
                <div class="flex items-center justify-between mt-3">
                    <p class="text-sm text-stone-700">{{ $terakhir ?? '—' }}</p>
                    <span class="text-xs px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-stone-700">Waktu</span>
                </div>
            </div>
        </section>

        <!-- Table -->
        <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-lg font-semibold text-stone-900">Daftar feedback</p>
                    <p class="text-xs text-stone-500">Catatan pengguna beserta rating dan kontak opsional.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-stone-700">
                    <thead class="text-xs uppercase text-stone-500 bg-stone-50">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Rating</th>
                            <th class="px-4 py-3">Pesan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($feedbacks as $fb)
                            <tr class="hover:bg-amber-50/40 align-top">
                                <td class="px-4 py-3 text-xs text-stone-600">{{ $fb->created_at ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-stone-900">{{ $fb->nama ?? 'Anonim' }}</td>
                                <td class="px-4 py-3 text-xs text-stone-600">{{ $fb->email ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-stone-700">{{ $fb->rating ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-stone-600">{{ \Illuminate\Support\Str::limit($fb->pesan ?? '-', 160) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-stone-500">Belum ada feedback.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
