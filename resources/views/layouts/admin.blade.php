<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NOKA Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-gradient-to-b from-amber-50 via-lime-50 to-stone-50 text-stone-800">
    <header class="w-full bg-white/80 backdrop-blur border-b border-amber-100">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 object-contain" alt="Logo NOKA">
                <div>
                    <p class="text-[11px] tracking-[0.2em] uppercase text-amber-700 font-semibold">Panel Admin</p>
                    <span class="text-xl font-semibold tracking-wide text-stone-900">NOKA</span>
                </div>
            </a>
            <nav class="hidden md:flex gap-4 text-sm font-medium">
                <a href="{{ url('/admin') }}" class="{{ request()->is('admin') ? 'text-amber-700 font-semibold' : 'hover:text-amber-700' }}">Dashboard</a>
                <a href="{{ url('/admin/penyakit') }}" class="{{ request()->is('admin/penyakit*') ? 'text-amber-700 font-semibold' : 'hover:text-amber-700' }}">Penyakit</a>
                <a href="{{ url('/admin/gejala') }}" class="{{ request()->is('admin/gejala*') ? 'text-amber-700 font-semibold' : 'hover:text-amber-700' }}">Gejala</a>
                <a href="{{ url('/admin/aturan') }}" class="{{ request()->is('admin/aturan*') ? 'text-amber-700 font-semibold' : 'hover:text-amber-700' }}">Aturan</a>
            </nav>
            <div class="flex items-center gap-3 text-xs md:text-sm">
                <span class="hidden md:inline text-stone-500">{{ auth()->user()->email ?? '' }}</span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10 lg:py-12 space-y-8">
        @if (session('success'))
            <div class="rounded-2xl border border-lime-200 bg-lime-50 text-lime-800 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('status'))
            <div class="rounded-2xl border border-amber-200 bg-amber-50 text-amber-800 text-sm px-4 py-3">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 text-rose-800 text-sm px-4 py-3 space-y-1">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
