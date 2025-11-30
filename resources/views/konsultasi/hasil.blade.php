<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Hasil Diagnosa</title>
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
                <span class="text-amber-700 font-semibold">Hasil</span>
            </nav>

            <span class="px-4 py-2 rounded-full bg-amber-300 text-stone-900 text-sm font-bold">
                Hasil Diagnosa
            </span>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10 lg:py-12 space-y-8">
        <!-- Judul & info umum -->
        <section class="space-y-3">
            <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">
                Hasil Diagnosa Tanaman Kakao
            </h1>
            <p class="text-sm md:text-base text-stone-600 max-w-2xl">
                Ringkasan hasil analisis berdasarkan gejala yang kamu pilih di halaman konsultasi.
                Gunakan informasi ini sebagai panduan awal untuk mengambil tindakan di kebun.
            </p>

            <div class="flex flex-wrap gap-3 text-xs md:text-sm text-stone-600">
                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-stone-50 border border-stone-200">
                    <span class="font-semibold text-stone-800">Nama:</span>
                    <span><!-- ganti dengan nama pengguna -->Petani Kakao</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-stone-50 border border-stone-200">
                    <span class="font-semibold text-stone-800">Lokasi kebun:</span>
                    <span><!-- ganti dengan lokasi -->Lampung Timur</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-stone-50 border border-stone-200">
                    <span class="font-semibold text-stone-800">Tanggal:</span>
                    <span><!-- ganti dengan tanggal -->25 November 2025</span>
                </div>
            </div>
        </section>

        <!-- Kartu hasil utama -->
        <section class="grid lg:grid-cols-[2fr,1.2fr] gap-6 items-start">
            <!-- Detail hasil -->
            <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 md:p-7 space-y-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Penyakit utama</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-stone-900">
                            <!-- ganti dengan nama penyakit -->Busuk Buah Kakao
                        </h2>
                    </div>
                    <div class="text-right space-y-1">
                        <p class="text-xs text-stone-500">Tingkat keyakinan</p>
                        <p class="text-lg font-semibold text-lime-700">
                            <!-- ganti dengan persentase -->82%
                        </p>
                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[11px] font-medium text-amber-800">
                            <!-- ganti dengan label keparahan -->Kategori: Sedang
                        </span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-5 text-sm">
                    <div class="space-y-2">
                        <p class="font-semibold text-stone-800">Ringkasan gejala terpilih</p>
                        <ul class="list-disc list-inside text-stone-600 space-y-1">
                            <!-- looping gejala di sini -->
                            <li>Daun terdapat bercak cokelat.</li>
                            <li>Muncul bercak hijau tua/cokelat pada permukaan buah.</li>
                            <li>Bercak pada buah meluas dan menyebabkan busuk.</li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <p class="font-semibold text-stone-800">Interpretasi sistem</p>
                        <p class="text-stone-600 text-sm">
                            Pola gejala yang muncul mirip dengan kasus busuk buah kakao 
                            yang disebabkan oleh serangan jamur <em>Phytophthora</em>. 
                            Penyakit ini biasanya berkembang pada kondisi kebun yang lembap 
                            dan drainase kurang baik.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Saran cepat -->
            <aside class="bg-white/80 border border-lime-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-4">
                <p class="text-sm font-semibold text-lime-800 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-lime-100 flex items-center justify-center text-[11px] font-bold text-lime-700">Tip</span>
                    Langkah awal yang disarankan
                </p>
                <ol class="list-decimal list-inside text-xs md:text-sm text-stone-700 space-y-1.5">
                    <li>Segera pisahkan dan buang buah yang sudah terinfeksi dari kebun.</li>
                    <li>Bersihkan gulma dan jaga kebun tetap rapi agar sirkulasi udara baik.</li>
                    <li>Pastikan drainase tidak tergenang air setelah hujan.</li>
                    <li>Konsultasikan ke penyuluh atau pakar untuk rekomendasi fungisida yang sesuai.</li>
                </ol>
                <p class="text-[11px] text-stone-500">
                    Rekomendasi di atas bersifat umum. Sesuaikan dengan kondisi kebun dan arahan pakar setempat.
                </p>
            </aside>
        </section>

        <!-- Detail rekomendasi -->
        <section class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-6 md:p-7 space-y-4 text-sm">
            <p class="font-semibold text-stone-900">Rincian rekomendasi penanganan</p>
            <p class="text-stone-600">
                <!-- ganti dengan teks dari basis pengetahuan -->
                Untuk mengurangi penyebaran busuk buah kakao, lakukan sanitasi kebun secara rutin 
                (pengambilan buah sakit, ranting mati, dan daun gugur), tingkatkan pencahayaan dengan 
                pemangkasan cabang yang terlalu rimbun, dan perhatikan jadwal pemupukan agar tanaman 
                tetap kuat menghadapi serangan penyakit.
            </p>
            <p class="text-stone-600">
                Jika gejala tetap muncul atau semakin berat setelah tindakan awal, sebaiknya lakukan 
                konsultasi lanjutan dengan pakar atau penyuluh pertanian di wilayahmu.
            </p>
        </section>

        <!-- Tombol navigasi -->
        <section class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between pt-2">
            <p class="text-[11px] md:text-xs text-stone-500 max-w-xl">
                Hasil diagnosa dari NOKA hanyalah alat bantu. Keputusan akhir tetap perlu dipertimbangkan 
                bersama pengalaman petani dan saran pakar lapangan.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="noka_konsultasi.html" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">
                    Konsultasi Ulang
                </a>
                <a href="noka_home.html" class="px-4 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">
                    Kembali ke Beranda
                </a>
            </div>
        </section>
    </main>
</body>
</html>