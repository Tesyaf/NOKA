@extends('layouts.app')
@section('title', 'NOKA | Sistem Pakar Tanaman Kakao')

@section('content')
    <!-- HERO SECTION -->
    <section id="hero" class="grid lg:grid-cols-2 gap-10 items-center">
        <div class="space-y-5">
            <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-stone-900">
                Deteksi Penyakit Kakao <br>
                <span class="text-amber-600">Lebih Cepat & Akurat</span>
            </h1>

            <p class="text-stone-600 text-sm md:text-base max-w-lg">
                NOKA membantu petani mengenali penyakit tanaman kakao dengan memilih gejala.
                Sistem langsung menampilkan hasil analisis dan rekomendasi penanganan.
            </p>

            <div class="flex gap-3">
                <a href="{{ route('konsultasi.index') }}" class="px-5 py-2.5 rounded-full bg-amber-400 text-stone-900 text-sm font-semibold hover:bg-amber-300">
                    Mulai Diagnosa
                </a>
                <a href="#fitur" class="px-5 py-2.5 rounded-full border border-amber-200 text-amber-700 text-sm hover:bg-amber-50">
                    Lihat Fitur
                </a>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="bg-white/70 backdrop-blur-sm border border-stone-200 rounded-3xl p-10 shadow-lg">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo NOKA"
                     class="w-64 h-64 object-contain opacity-90">
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section id="fitur" class="px-0 py-12">
        <h2 class="text-2xl font-semibold text-stone-900 mb-6">
            Fitur Utama NOKA
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="p-5 rounded-2xl bg-amber-50 border border-amber-100 shadow-sm">
                <p class="font-semibold text-amber-800 mb-1">Diagnosa Gejala</p>
                <p class="text-sm text-stone-600">
                    Pilih gejala, sistem langsung memberikan prediksi penyakit.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-lime-50 border border-lime-100 shadow-sm">
                <p class="font-semibold text-lime-800 mb-1">Rekomendasi Penanganan</p>
                <p class="text-sm text-stone-600">
                    Setiap hasil diagnosa dilengkapi dengan langkah penanganan.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-stone-50 border border-stone-100 shadow-sm">
                <p class="font-semibold text-stone-800 mb-1">Tanpa Login</p>
                <p class="text-sm text-stone-600">
                    Bisa langsung digunakan oleh siapa saja tanpa akun.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="konsultasi" class="px-0 pb-14">
        <div class="p-6 rounded-3xl bg-white/70 border border-amber-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-xl font-semibold text-stone-900">
                    Siap mulai konsultasi?
                </h3>
                <p class="text-sm text-stone-600">
                    Klik tombol di samping untuk mulai analisis gejala tanaman kakao.
                </p>
            </div>

            <a href="{{ route('konsultasi.index') }}" class="px-5 py-2.5 rounded-full bg-amber-400 text-stone-900 text-sm font-semibold hover:bg-amber-300">
                Masuk ke Halaman Konsultasi
            </a>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="border-t border-stone-200 bg-white/70 -mx-4 lg:-mx-6 px-6 lg:px-8 py-10 text-sm text-stone-700 rounded-t-3xl">
        <p class="font-semibold text-stone-900 mb-1">Tentang NOKA</p>
        <p class="max-w-3xl">
            NOKA (Non-Destructive Kakao Analysis) adalah sistem pakar untuk membantu petani
            mengenali penyakit kakao secara cepat berdasarkan gejala visual. Sistem menggunakan
            basis aturan yang sudah divalidasi sehingga hasil lebih akurat.
        </p>
    </section>
@endsection
