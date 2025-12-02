<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NOKA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-gradient-to-b from-amber-50 via-lime-50 to-stone-50 text-stone-800">
    <header class="w-full bg-white/80 backdrop-blur border-b border-amber-100">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 object-contain" alt="Logo NOKA">
                <span class="text-xl font-semibold tracking-wide text-stone-900">NOKA</span>
            </a>
            <nav class="hidden md:flex gap-5 text-sm font-medium">
                <a href="{{ url('/') }}" class="hover:text-amber-700">Beranda</a>
                <a href="{{ route('konsultasi.index') }}" class="hover:text-amber-700">Konsultasi</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ url('/admin') }}" class="hover:text-amber-700">Admin</a>
                    @endif
                @endauth
            </nav>
            @auth
                <div class="flex items-center gap-3 text-xs md:text-sm">
                    <span class="text-stone-500">Hi, {{ auth()->user()->name }}</span>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-full border border-stone-200 text-stone-700 hover:bg-stone-50">Keluar</button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10 lg:py-12">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-lime-200 bg-lime-50 text-lime-800 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('status'))
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 text-amber-800 text-sm px-4 py-3">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 text-rose-800 text-sm px-4 py-3 space-y-1">
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
