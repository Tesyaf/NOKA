<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Detail Penyakit Kakao</title>
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
                <a href="noka_penyakit.html" class="hover:text-amber-700">Daftar Penyakit</a>
                <span class="text-amber-700 font-semibold">Detail Penyakit</span>
            </nav>

            <a href="noka_konsultasi.html" class="px-4 py-2 rounded-full bg-amber-300 text-stone-900 text-sm font-bold hover:bg-amber-200">
                Mulai Diagnosa
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10 lg:py-12 space-y-8">
        <!-- Breadcrumb -->
        <nav class="text-[11px] md:text-xs text-stone-500 flex flex-wrap gap-1">
            <a href="noka_home.html" class="hover:text-amber-700">Beranda</a>
            <span>/</span>
            <a href="noka_penyakit.html" class="hover:text-amber-700">Daftar Penyakit</a>
            <span>/</span>
            <span class="text-stone-700 font-medium"><!-- ganti dengan nama penyakit -->Busuk Buah Kakao</span>
        </nav>

        <!-- Header penyakit -->
        <section class="grid lg:grid-cols-[2fr,1.2fr] gap-6 items-start">
            <div class="space-y-3">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-400">
                    <!-- ganti dengan kode penyakit -->P01
                </p>
                <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">
                    <!-- ganti dengan nama penyakit -->Busuk Buah Kakao
                </h1>
                <div class="flex flex-wrap gap-2 text-xs md:text-sm">
                    <span class="px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 font-medium">
                        <!-- ganti dengan tipe -->Penyakit akibat jamur
                    </span>
                    <span class="px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-stone-700">
                        <!-- ganti dengan kategori -->Menyerang: buah kakao
                    </span>
                </div>
                <p class="text-sm md:text-base text-stone-600 max-w-2xl">
                    <!-- ringkasan singkat -->
                    Busuk buah kakao adalah penyakit penting yang menyebabkan kerusakan serius pada buah, 
                    ditandai dengan bercak gelap yang cepat meluas hingga seluruh permukaan buah, 
                    mengurangi kualitas dan kuantitas hasil panen.
                </p>
            </div>

            <!-- Kartu info cepat -->
            <aside class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-3 text-sm">
                <p class="font-semibold text-stone-900">Ringkasan singkat</p>
                <div class="space-y-1 text-stone-600 text-xs md:text-sm">
                    <p><span class="font-medium text-stone-800">Nama lain:</span> <!-- optional -->Black pod disease</p>
                    <p><span class="font-medium text-stone-800">Organisme penyebab:</span> <em>Phytophthora spp.</em></p>
                    <p><span class="font-medium text-stone-800">Bagian terserang:</span> Buah kakao (kadang batang muda).</p>
                    <p><span class="font-medium text-stone-800">Dukungan kondisi:</span> Kebun lembap, drainase buruk, naungan terlalu rapat.</p>
                    <p><span class="font-medium text-stone-800">Tingkat ancaman:</span> Sedang–tinggi pada musim hujan.</p>
                </div>
            </aside>
        </section>

        <!-- Gejala, penyebab, kondisi -->
        <section class="grid md:grid-cols-3 gap-6 text-sm">
            <div class="md:col-span-2 bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-4">
                <div>
                    <p class="font-semibold text-stone-900 mb-1">Gejala khas</p>
                    <ul class="list-disc list-inside text-stone-600 space-y-1">
                        <li>Bercak kecil hijau tua atau cokelat pada kulit buah, biasanya dimulai dari ujung atau sisi buah.</li>
                        <li>Bercak cepat meluas hingga menutupi sebagian besar permukaan buah.</li>
                        <li>Warna buah berubah menjadi cokelat kehitaman dan jaringan mengempis.</li>
                        <li>Sering muncul lapisan jamur putih pada permukaan buah yang lembap.</li>
                        <li>Buah yang terinfeksi parah dapat menggantung kering di pohon.</li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold text-stone-900 mb-1">Penyebab dan siklus penyakit</p>
                    <p class="text-stone-600">
                        Penyakit ini disebabkan oleh jamur <em>Phytophthora</em> yang menyukai lingkungan lembap. 
                        Spora jamur tersebar melalui percikan air hujan, angin, atau kontak langsung antara buah sakit 
                        dengan buah sehat. Kondisi kebun yang rimbun dan drainase kurang baik mempercepat perkembangan penyakit.
                    </p>
                </div>
            </div>

            <div class="bg-white/80 border border-lime-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-3">
                <p class="font-semibold text-stone-900 mb-1">Kondisi yang mendukung</p>
                <ul class="list-disc list-inside text-stone-600 text-sm space-y-1">
                    <li>Curah hujan tinggi dan kelembapan kebun yang terus-menerus.</li>
                    <li>Penanaman terlalu rapat sehingga sirkulasi udara buruk.</li>
                    <li>Buah sakit dibiarkan tergantung di pohon atau dibiarkan di tanah.</li>
                    <li>Drainase buruk, genangan air di sekitar perakaran.</li>
                </ul>
            </div>
        </section>

        <!-- Dampak dan pengendalian -->
        <section class="grid md:grid-cols-2 gap-6 text-sm">
            <div class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-3">
                <p class="font-semibold text-stone-900 mb-1">Dampak terhadap kebun</p>
                <p class="text-stone-600">
                    Jika tidak dikendalikan, busuk buah kakao dapat menurunkan hasil panen secara signifikan, 
                    baik dari jumlah maupun kualitas buah. Buah yang terinfeksi berat tidak layak diolah, 
                    dan dalam jangka panjang kerugian ekonomi petani bisa cukup besar.
                </p>
            </div>

            <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-3">
                <p class="font-semibold text-stone-900 mb-1">Strategi pengendalian</p>
                <ul class="list-disc list-inside text-stone-600 space-y-1">
                    <li>Melakukan sanitasi kebun: mengumpulkan dan memusnahkan buah yang sakit.</li>
                    <li>Memangkas cabang yang terlalu rimbun untuk meningkatkan sirkulasi udara.</li>
                    <li>Menjaga drainase agar tidak terjadi genangan air di sekitar tanaman.</li>
                    <li>Menerapkan pemupukan seimbang untuk menguatkan tanaman.</li>
                    <li>Konsultasi dengan penyuluh untuk penggunaan fungisida yang tepat bila diperlukan.</li>
                </ul>
            </div>
        </section>

        <!-- Catatan & navigasi -->
        <section class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between pt-4 text-xs md:text-sm">
            <p class="text-stone-500 max-w-xl">
                Informasi di halaman ini dapat kamu sesuaikan dengan literatur dan hasil diskusi bersama pakar kakao. 
                Di dalam aplikasi NOKA sebenarnya data ini disimpan di tabel <em>penyakit</em> dan ditampilkan secara dinamis.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="noka_penyakit.html" class="px-4 py-2 rounded-full border border-stone-200 text-stone-700 hover:bg-stone-50">
                    Kembali ke Daftar Penyakit
                </a>
                <a href="noka_konsultasi.html" class="px-4 py-2 rounded-full bg-amber-400 text-stone-900 font-semibold hover:bg-amber-300">
                    Konsultasi dengan NOKA
                </a>
            </div>
        </section>
    </main>
</body>
</html>
