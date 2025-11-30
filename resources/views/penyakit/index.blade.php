<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Daftar Penyakit Kakao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #fef7e8, #f3fce9, #f7f5f2);
        }
    </style>
</head>
<body class="text-stone-800">

    <!-- NAVBAR -->
    <header class="w-full bg-white/70 backdrop-blur border-b border-amber-100">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-3">
                <img src="logo.png" class="w-10 h-10 object-contain" alt="Logo NOKA">
                <span class="text-xl font-semibold tracking-wide text-stone-900">NOKA</span>
            </div>

            <nav class="hidden md:flex gap-6 text-sm font-medium">
                <a href="noka_home.html" class="hover:text-amber-700">Beranda</a>
                <a href="noka_konsultasi.html" class="hover:text-amber-700">Konsultasi</a>
                <span class="text-amber-700 font-semibold">Daftar Penyakit</span>
            </nav>

            <a href="noka_konsultasi.html" class="px-4 py-2 rounded-full bg-amber-300 text-stone-900 text-sm font-bold hover:bg-amber-200">
                Mulai Diagnosa
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10 lg:py-12 space-y-8">
        <!-- Judul -->
        <section class="space-y-3">
            <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">
                Daftar Penyakit Tanaman Kakao
            </h1>
            <p class="text-sm md:text-base text-stone-600 max-w-2xl">
                Berikut beberapa penyakit utama pada tanaman kakao yang sering muncul di lapangan. 
                Setiap penyakit dilengkapi dengan gejala khas dan ringkasan penanganan singkat. 
                Kamu bisa membaca detailnya sebelum atau sesudah melakukan diagnosa dengan NOKA.
            </p>
        </section>

        <!-- Grid Penyakit -->
        <section class="grid md:grid-cols-2 gap-6 lg:gap-7">
            <!-- Penyakit 1 -->
            <article class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P01</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Busuk Buah Kakao
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[11px] font-medium text-amber-800 border border-amber-200">
                        Jamur
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Ditandai dengan munculnya bercak hijau tua atau cokelat pada permukaan buah 
                    yang cepat meluas hingga menyebabkan buah busuk, menghitam, dan sering diselimuti jamur putih.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: buah bercak, busuk cepat, kapang putih.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>

            <!-- Penyakit 2 -->
            <article class="bg-white/80 border border-lime-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P02</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Vascular Streak Dieback (VSD)
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-lime-50 text-[11px] font-medium text-lime-800 border border-lime-200">
                        Jamur
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Menyerang jaringan pembuluh pada cabang, menyebabkan daun menguning, 
                    gugur, dan cabang mengering dari ujung ke arah pangkal secara bertahap.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: daun gugur, cabang mati mundur.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>

            <!-- Penyakit 3 -->
            <article class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P03</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Kanker Batang Kakao
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-stone-50 text-[11px] font-medium text-stone-700 border border-stone-200">
                        Jamur
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Ditandai adanya luka cekung berwarna cokelat tua pada batang atau cabang, 
                    kadang mengeluarkan getah, dan jika berat dapat memutus aliran hara sehingga 
                    bagian di atasnya mengering.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: luka cekung pada batang, getah keluar.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>

            <!-- Penyakit 4 -->
            <article class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P04</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Hawar Daun Kakao
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[11px] font-medium text-amber-800 border border-amber-200">
                        Jamur/Bakteri
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Menyebabkan bercak-bercak pada daun yang dapat menyatu menjadi area 
                    nekrosis luas, membuat daun tampak terbakar dan akhirnya gugur.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: bercak meluas, daun seolah terbakar.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>

            <!-- Penyakit 5 -->
            <article class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P05</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Busuk Akar (Root Rot)
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[11px] font-medium text-amber-800 border border-amber-200">
                        Jamur
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Akar membusuk, tanaman tampak layu meski tanah lembap, daun menguning dan rontok, 
                    pertumbuhan terhambat, dan dalam kasus berat tanaman bisa mati mendadak.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: tanaman layu, akar cokelat/rapuh.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>

            <!-- Penyakit 6 -->
            <article class="bg-white/80 border border-lime-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P06</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Antraknosa Kakao
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-lime-50 text-[11px] font-medium text-lime-800 border border-lime-200">
                        Jamur
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Menyebabkan bercak kecil berwarna cokelat kehitaman pada daun dan buah muda, 
                    kadang membentuk pola melingkar, dan dapat mengakibatkan jaringan mengering dan rontok.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: bercak kecil hitam, jaringan mengering.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>

            <!-- Penyakit 7 -->
            <article class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P07</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Broom Broom (Witches' Broom)
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-stone-50 text-[11px] font-medium text-stone-700 border border-stone-200">
                        Jamur
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Pertumbuhan tunas tidak normal, membentuk kumpulan ranting kecil yang rapat seperti sapu, 
                    bunga dan buah abnormal, dan dapat menurunkan produktivitas kebun secara signifikan.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: tunas bergerombol, bentuk mirip sapu.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>

            <!-- Penyakit 8 (Hama besar tapi tetap dimasukkan) -->
            <article class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">P08</p>
                        <h2 class="text-lg md:text-xl font-semibold text-stone-900">
                            Serangan Penggerek Buah Kakao
                        </h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[11px] font-medium text-amber-800 border border-amber-200">
                        Hama
                    </span>
                </div>
                <p class="text-sm text-stone-600">
                    Menyebabkan adanya lubang kecil pada buah, biji rusak dimakan larva, 
                    dan kualitas panen turun. Dari luar kadang hanya tampak bercak kecil dan lubang masuk hama.
                </p>
                <div class="flex items-center justify-between text-xs text-stone-500 mt-auto">
                    <span>Gejala utama: lubang kecil di buah, biji rusak.</span>
                    <a href="#" class="text-amber-700 font-semibold hover:underline">
                        Lihat detail
                    </a>
                </div>
            </article>
        </section>

        <!-- Catatan -->
        <section class="text-xs md:text-sm text-stone-600 pt-4 pb-6">
            <p class="font-semibold text-stone-800 mb-1">Catatan</p>
            <p class="max-w-3xl">
                Daftar di atas bisa kamu jadikan acuan awal untuk mengisi tabel <em>penyakit</em> 
                pada basis data NOKA. Nama, kode, dan deskripsi masih bisa kamu sesuaikan lagi 
                dengan literatur atau data lapangan yang kamu gunakan dalam penelitian.
            </p>
        </section>
    </main>
</body>
</html>
