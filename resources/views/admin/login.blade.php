<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #fef7e8, #f3fce9, #f7f5f2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-stone-800">
    <div class="w-full max-w-md px-4 py-10">
        <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-xl px-8 py-10 space-y-8 backdrop-blur-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                    <img src="/logo.png" alt="Logo NOKA" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <p class="text-[11px] tracking-[0.2em] uppercase text-amber-700 font-semibold">Panel Admin</p>
                    <h1 class="text-2xl font-semibold text-stone-900 leading-tight">Masuk ke NOKA</h1>
                    <p class="text-sm text-stone-500">Autentikasi diperlukan untuk mengelola data.</p>
                </div>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-lime-200 bg-lime-50 text-lime-800 text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 text-rose-800 text-sm px-4 py-3 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="/admin/login" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-stone-800">Email</label>
                    <input id="email" name="email" type="email" required autofocus class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300 placeholder:text-stone-400" placeholder="admin@noka.id">
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-sm font-medium text-stone-800">Kata sandi</label>
                        <a href="#" class="text-xs font-semibold text-amber-700 hover:text-amber-600">Lupa kata sandi?</a>
                    </div>
                    <input id="password" name="password" type="password" required class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300 placeholder:text-stone-400" placeholder="********">
                </div>

                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input type="checkbox" name="remember" class="rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                    <span>Ingat saya di perangkat ini</span>
                </label>

                <button type="submit" class="w-full rounded-full bg-amber-400 text-stone-900 font-semibold text-sm py-3 shadow-sm hover:bg-amber-300 transition">
                    Masuk
                </button>
            </form>

            <div class="text-center text-xs text-stone-500">
                <a href="/" class="font-semibold text-amber-700 hover:text-amber-600">Kembali ke beranda</a>
            </div>
        </div>
    </div>
</body>
</html>