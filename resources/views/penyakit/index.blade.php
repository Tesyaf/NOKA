@extends('layouts.app')
@section('title', 'Daftar Penyakit | NOKA')

@section('content')
    @php use Illuminate\Support\Str; @endphp
    <section class="space-y-3">
        <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Daftar Penyakit Tanaman Kakao</h1>
        <p class="text-sm md:text-base text-stone-600 max-w-2xl">
            Semua data di bawah ditarik langsung dari basis data NOKA dan dapat dibuka tanpa perlu login.
            Baca ringkasan gejala dan penanganan, lalu klik detail untuk informasi lengkap.
        </p>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-50 border border-lime-200 text-[11px] md:text-xs text-lime-700">
            <span class="w-2 h-2 rounded-full bg-lime-500"></span>
            Publik &mdash; tidak perlu akun untuk melihat.
        </div>
    </section>

    <section class="grid md:grid-cols-2 gap-6 lg:gap-7 mt-6">
        @forelse ($penyakit as $item)
            <article class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">{{ $item->kode_penyakit ?? 'KODE' }}</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            {{ $item->nama_penyakit }}
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[11px] font-medium text-amber-800 border border-amber-200">
                        {{ $item->penyebab ? Str::limit($item->penyebab, 26) : 'Data penyakit' }}
                    </span>
                </div>
                <p class="text-sm text-stone-600 leading-relaxed">
                    {{ Str::limit($item->deskripsi ?? 'Belum ada deskripsi untuk penyakit ini.', 220) }}
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>{{ $item->pengendalian ? 'Tersedia saran pengendalian.' : 'Belum ada catatan pengendalian.' }}</span>
                    <a href="{{ route('penyakit.public.show', $item) }}" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>
        @empty
            <div class="md:col-span-2 rounded-3xl border border-stone-200 bg-white/60 px-4 py-6 text-center text-stone-600">
                Belum ada data penyakit yang tersimpan.
            </div>
        @endforelse
    </section>

    <section class="text-xs md:text-sm text-stone-600 pt-6">
        <p class="font-semibold text-stone-800 mb-1">Catatan</p>
        <p class="max-w-3xl">
            Jika ada data baru atau koreksi, silakan tambahkan melalui panel admin agar daftar ini selalu mutakhir.
        </p>
    </section>
@endsection
