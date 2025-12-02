@extends('layouts.app')
@section('title', 'Login Admin | NOKA')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-xl px-8 py-10 space-y-8 backdrop-blur-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo NOKA" class="w-9 h-9 object-contain">
            </div>
            <div>
                <p class="text-[11px] tracking-[0.2em] uppercase text-amber-700 font-semibold">Panel Admin</p>
                <h1 class="text-2xl font-semibold text-stone-900 leading-tight">Masuk ke NOKA</h1>
                <p class="text-sm text-stone-500">Autentikasi diperlukan untuk mengelola data.</p>
            </div>
        </div>

        <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-5">
            @csrf
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-stone-800">Email</label>
                <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                       class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300 placeholder:text-stone-400"
                       placeholder="admin@noka.id">
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-medium text-stone-800">Kata sandi</label>
                <input id="password" name="password" type="password" required
                       class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300 placeholder:text-stone-400"
                       placeholder="********">
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
            <a href="{{ route('home') }}" class="font-semibold text-amber-700 hover:text-amber-600">Kembali ke beranda</a>
        </div>
    </div>
</div>
@endsection
