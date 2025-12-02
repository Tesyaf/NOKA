<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Logout Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #fef7e8, #f3fce9, #f7f5f2);
        }
    </style>
</head>
<body class="min-h-screen text-stone-800 flex items-center justify-center px-4">
    <div class="w-full max-w-lg">
        <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-lg p-8 space-y-6">
            <div class="flex items-center gap-3">
                <img src="/images/logo.png" class="w-12 h-12 object-contain" alt="Logo NOKA">
                <div>
                    <p class="text-xs text-amber-700 font-semibold tracking-[0.2em] uppercase">Panel Admin</p>
                    <h1 class="text-2xl font-semibold text-stone-900">Keluar dari NOKA</h1>
                    <p class="text-sm text-stone-600">Konfirmasi untuk mengakhiri sesi admin saat ini.</p>
                </div>
            </div>

            <div class="rounded-2xl border border-amber-100 bg-amber-50/60 p-4 text-sm text-stone-700">
                <p class="font-semibold text-stone-900">Anda akan logout.</p>
                <p class="text-stone-600">Pastikan perubahan sudah disimpan sebelum keluar.</p>
            </div>

            <form action="/logout" method="POST" class="space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row gap-3 md:justify-end">
                    <a href="/admin" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50 text-center">Batal</a>
                    <button type="submit" class="px-5 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">Logout</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
