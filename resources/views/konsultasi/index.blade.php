<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NOKA | Konsultasi Gejala Kakao</title>
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
                <a href="#top" class="text-amber-700 font-semibold">Konsultasi</a>
                <a href="#tentang" class="hover:text-amber-700">Tentang</a>
            </nav>

            <span class="px-4 py-2 rounded-full bg-amber-300 text-stone-900 text-sm font-bold">
                Konsultasi
            </span>
        </div>
    </header>

    <main id="top" class="max-w-6xl mx-auto px-4 py-10 lg:py-12 space-y-8">
        <!-- Judul -->
        <section class="space-y-3">
            <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Konsultasi Gejala Tanaman Kakao</h1>
            <p class="text-sm md:text-base text-stone-600 max-w-2xl">
                Pilih gejala yang sesuai dengan kondisi tanaman kakao di kebunmu. 
                NOKA akan menggunakan gejala tersebut untuk memperkirakan penyakit yang paling mungkin 
                dan memberikan rekomendasi penanganan.
            </p>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-50 border border-lime-200 text-[11px] md:text-xs text-lime-700">
                <span class="w-2 h-2 rounded-full bg-lime-500"></span>
                Tidak perlu login &mdash; data hanya digunakan untuk proses diagnosa.
            </div>
        </section>

        <!-- Form Konsultasi -->
        <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 md:p-8 space-y-6">
            <form action="/konsultasi/proses" method="POST" class="space-y-6">
                <!-- Data umum (opsional) -->
                <div class="grid md:grid-cols-3 gap-4 text-sm">
                    <div class="md:col-span-2 space-y-1">
                        <label for="nama" class="font-medium text-stone-800">Nama (opsional)</label>
                        <input id="nama" name="nama" type="text" 
                               class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300"
                               placeholder="Isi jika ingin ditampilkan di hasil diagnosa">
                    </div>
                    <div class="space-y-1">
                        <label for="lokasi" class="font-medium text-stone-800">Lokasi kebun (opsional)</label>
                        <input id="lokasi" name="lokasi" type="text" 
                               class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300"
                               placeholder="Contoh: Lampung Timur">
                    </div>
                </div>

                <!-- Gejala daun -->
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-[11px] font-bold text-amber-700">1</span>
                        Gejala pada daun
                    </p>
                    <div class="grid md:grid-cols-2 gap-3 text-sm">
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G01" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Daun menguning secara tidak merata.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G02" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Terdapat bercak cokelat pada permukaan daun.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G03" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Daun layu dan menggantung meski tanah cukup basah.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G04" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Tepi daun mengering atau terbakar.</span>
                        </label>
                    </div>
                </div>

                <!-- Gejala batang -->
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-[11px] font-bold text-amber-700">2</span>
                        Gejala pada batang dan cabang
                    </p>
                    <div class="grid md:grid-cols-2 gap-3 text-sm">
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G05" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Terdapat luka cekung berwarna cokelat pada batang/cabang.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G06" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Batang mengeluarkan getah atau lendir.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G07" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Cabang mengering mulai dari ujung.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G08" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Terlihat garis atau bercak kehitaman memanjang di batang.</span>
                        </label>
                    </div>
                </div>

                <!-- Gejala buah -->
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-[11px] font-bold text-amber-700">3</span>
                        Gejala pada buah
                    </p>
                    <div class="grid md:grid-cols-2 gap-3 text-sm">
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G09" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Bercak kecil hijau tua/cokelat pada permukaan buah.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G10" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Bercak cepat melebar dan membuat buah busuk.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G11" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Buah mengering, menghitam, lalu menggantung di pohon.</span>
                        </label>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="gejala[]" value="G12" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                            <span>Terdapat jamur/kapang putih pada permukaan buah.</span>
                        </label>
                    </div>
                </div>

                <!-- Tingkat keparahan -->
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-[11px] font-bold text-amber-700">4</span>
                        Perkiraan tingkat keparahan
                    </p>
                    <div class="flex flex-col gap-2 text-sm max-w-md">
                        <input type="range" name="keparahan" min="1" max="5" value="3" 
                               class="w-full accent-amber-400">
                        <div class="flex justify-between text-[11px] text-stone-500">
                            <span>Ringan</span>
                            <span>Sedang</span>
                            <span>Berat</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between pt-2">
                    <p class="text-[11px] md:text-xs text-stone-500 max-w-md">
                        Setelah menekan tombol di bawah, sistem akan memproses gejala yang kamu pilih 
                        dan menampilkan kemungkinan penyakit beserta rekomendasi penanganan.
                    </p>
                    <div class="flex gap-3">
                        <button type="reset" class="px-4 py-2 rounded-full border border-stone-200 text-stone-600 text-sm hover:bg-stone-50">
                            Reset
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-full bg-amber-400 text-stone-900 text-sm font-semibold shadow-sm hover:bg-amber-300">
                            Proses Diagnosa
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <!-- Tentang singkat -->
        <section id="tentang" class="pb-6 text-xs md:text-sm text-stone-600">
            <p class="font-semibold text-stone-800 mb-1">Catatan</p>
            <p class="max-w-3xl">
                Hasil diagnosa NOKA bersifat pendukung keputusan dan tidak menggantikan 
                pemeriksaan langsung oleh pakar atau penyuluh pertanian. 
                Gunakan sebagai panduan awal untuk mengambil tindakan di kebun.
            </p>
        </section>
    </main>
</body>
</html>