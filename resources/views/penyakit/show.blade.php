@extends('layouts.app')
@section('title', $penyakit->nama_penyakit . ' | NOKA')

@section('content')
    @php
        use Illuminate\Support\Str;
        $gambar = $penyakit->gambar
            ? (Str::startsWith($penyakit->gambar, ['http://', 'https://', '//']) ? $penyakit->gambar : asset($penyakit->gambar))
            : null;
    @endphp

    <nav class="text-[11px] md:text-xs text-stone-500 flex flex-wrap gap-1 mb-5">
        <a href="{{ url('/') }}" class="hover:text-amber-700">Beranda</a>
        <span>/</span>
        <a href="{{ route('penyakit.public.index') }}" class="hover:text-amber-700">Daftar Penyakit</a>
        <span>/</span>
        <span class="text-stone-700 font-medium">{{ $penyakit->nama_penyakit }}</span>
    </nav>

    <section class="grid lg:grid-cols-[2fr,1.1fr] gap-6 items-start">
        <div class="space-y-3">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-400">{{ $penyakit->kode_penyakit ?? 'KODE' }}</p>
            <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">{{ $penyakit->nama_penyakit }}</h1>
            <div class="flex flex-wrap gap-2 text-xs md:text-sm">
                <span class="px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 font-medium">
                    {{ $penyakit->penyebab ? Str::limit($penyakit->penyebab, 80) : 'Penyebab belum diisi' }}
                </span>
                <span class="px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-stone-700">
                    {{ $penyakit->pengendalian ? 'Ada saran pengendalian' : 'Belum ada saran pengendalian' }}
                </span>
            </div>
            <p class="text-sm md:text-base text-stone-600 leading-relaxed">
                {!! nl2br(e($penyakit->deskripsi ?? 'Belum ada deskripsi untuk penyakit ini.')) !!}
            </p>
        </div>

        <aside class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-3 text-sm">
            <p class="font-semibold text-stone-900">Ringkasan singkat</p>
            <div class="space-y-1 text-stone-600">
                <p><span class="font-medium text-stone-800">Kode:</span> {{ $penyakit->kode_penyakit ?? '-' }}</p>
                <p><span class="font-medium text-stone-800">Penyebab:</span> {{ $penyakit->penyebab ?? 'Belum diisi' }}</p>
                <p><span class="font-medium text-stone-800">Pengendalian:</span> {{ $penyakit->pengendalian ? 'Sudah tersedia' : 'Belum tersedia' }}</p>
                <p><span class="font-medium text-stone-800">Pencegahan:</span> {{ $penyakit->pencegahan ? 'Sudah tersedia' : 'Belum tersedia' }}</p>
            </div>
            @if ($gambar)
                <div class="rounded-2xl overflow-hidden border border-stone-100">
                    <img src="{{ $gambar }}" alt="Ilustrasi {{ $penyakit->nama_penyakit }}" class="w-full h-44 object-cover">
                </div>
            @endif
        </aside>
    </section>

    <section class="grid md:grid-cols-3 gap-6 text-sm mt-6">
        <div class="md:col-span-2 bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-4">
            <div>
                <p class="font-semibold text-stone-900 mb-1">Gejala yang sering muncul</p>
                @if ($penyakit->gejala->count())
                    <ul class="list-disc list-inside text-stone-600 space-y-1">
                        @foreach ($penyakit->gejala as $gejala)
                            <li><span class="font-semibold text-stone-800">{{ $gejala->kode_gejala }}</span> - {{ $gejala->nama_gejala }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-stone-500">Belum ada gejala terkait yang tercatat.</p>
                @endif
            </div>

            <div>
                <p class="font-semibold text-stone-900 mb-1">Penyebab / catatan pakar</p>
                <p class="text-stone-600">
                    {!! nl2br(e($penyakit->penyebab ?? 'Belum ada catatan penyebab.')) !!}
                </p>
            </div>
        </div>

        <div class="bg-white/80 border border-lime-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-3">
            <p class="font-semibold text-stone-900 mb-1">Pengendalian & pencegahan</p>
            <div class="space-y-2 text-stone-600">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-1">Pengendalian</p>
                    <p>{!! nl2br(e($penyakit->pengendalian ?? 'Belum ada rekomendasi pengendalian.')) !!}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-1">Pencegahan</p>
                    <p>{!! nl2br(e($penyakit->pencegahan ?? 'Belum ada rekomendasi pencegahan.')) !!}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between pt-6 text-xs md:text-sm">
        <p class="text-stone-500 max-w-xl">
            Data ini ditarik langsung dari tabel <em>penyakit</em>. Perbarui melalui panel admin jika ada koreksi.
        </p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('penyakit.public.index') }}" class="px-4 py-2 rounded-full border border-stone-200 text-stone-700 hover:bg-stone-50">
                Kembali ke Daftar Penyakit
            </a>
            <a href="{{ route('konsultasi.index') }}" class="px-4 py-2 rounded-full bg-amber-400 text-stone-900 font-semibold hover:bg-amber-300">
                Konsultasi dengan NOKA
            </a>
        </div>
    </section>
@endsection
