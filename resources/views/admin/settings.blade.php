<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Settings Admin</title>
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
                    <span class="text-xl font-semibold tracking-wide text-stone-900">Settings</span>
                </div>
            </div>
            <nav class="hidden md:flex gap-4 text-sm font-medium">
                <a href="/admin" class="hover:text-amber-700">Dashboard</a>
                <a href="/admin/penyakit" class="hover:text-amber-700">Penyakit</a>
                <a href="/admin/gejala" class="hover:text-amber-700">Gejala</a>
                <a href="/admin/aturan" class="hover:text-amber-700">Aturan</a>
                <a href="/admin/log-konsultasi" class="hover:text-amber-700">Log</a>
                <a href="/admin/feedback" class="hover:text-amber-700">Feedback</a>
                <a href="/admin/admins" class="hover:text-amber-700">Admin</a>
                <a href="/admin/settings" class="text-amber-700 font-semibold">Settings</a>
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
                <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Pengaturan Sistem</h1>
                <p class="text-sm text-stone-600 max-w-2xl">Konfigurasi identitas aplikasi, konsultasi, dan keamanan akun admin.</p>
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

        <form action="/admin/settings" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Identitas aplikasi -->
            <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-semibold text-stone-900">Identitas aplikasi</p>
                    <span class="text-xs text-stone-500">Brand & info kontak</span>
                </div>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="app_name">Nama aplikasi</label>
                        <input id="app_name" name="app_name" type="text" value="{{ $settings['app_name'] ?? 'NOKA' }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="support_email">Email dukungan</label>
                        <input id="support_email" name="support_email" type="email" value="{{ $settings['support_email'] ?? '' }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="support_phone">Nomor kontak</label>
                        <input id="support_phone" name="support_phone" type="text" value="{{ $settings['support_phone'] ?? '' }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="address">Alamat</label>
                        <input id="address" name="address" type="text" value="{{ $settings['address'] ?? '' }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                </div>
            </section>

            <!-- Konsultasi -->
            <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-semibold text-stone-900">Konsultasi</p>
                    <span class="text-xs text-stone-500">Batasan & preferensi</span>
                </div>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="max_gejala">Maksimum gejala per konsultasi</label>
                        <input id="max_gejala" name="max_gejala" type="number" min="1" value="{{ $settings['max_gejala'] ?? 10 }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="default_threshold">Threshold CF hasil</label>
                        <input id="default_threshold" name="default_threshold" type="number" step="0.01" value="{{ $settings['default_threshold'] ?? 0.5 }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="font-medium text-stone-800" for="disclaimer">Disclaimer hasil</label>
                        <textarea id="disclaimer" name="disclaimer" rows="3" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">{{ $settings['disclaimer'] ?? 'Hasil bersifat pendukung keputusan dan tidak menggantikan pemeriksaan pakar.' }}</textarea>
                    </div>
                </div>
            </section>

            <!-- Keamanan -->
            <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-semibold text-stone-900">Keamanan</p>
                    <span class="text-xs text-stone-500">Kebijakan login</span>
                </div>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="session_timeout">Durasi sesi (menit)</label>
                        <input id="session_timeout" name="session_timeout" type="number" min="5" value="{{ $settings['session_timeout'] ?? 60 }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                    <div class="space-y-2">
                        <label class="font-medium text-stone-800" for="login_attempts">Batas percobaan login</label>
                        <input id="login_attempts" name="login_attempts" type="number" min="1" value="{{ $settings['login_attempts'] ?? 5 }}" class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-stone-700 md:col-span-2">
                        <input type="checkbox" name="force_strong_password" value="1" @checked(($settings['force_strong_password'] ?? false)) class="rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                        <span>Wajibkan password kuat untuk admin</span>
                    </label>
                </div>
            </section>

            <div class="flex justify-end gap-3 pt-2">
                <a href="/admin" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Batal</a>
                <button type="submit" class="px-5 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Simpan perubahan</button>
            </div>
        </form>
    </main>
</body>
</html>
