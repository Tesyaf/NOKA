@extends('layouts.app')
@section('title', 'Konsultasi Gejala | NOKA')

@section('content')
    <section class="space-y-3">
        <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Konsultasi Gejala Tanaman Kakao</h1>
        <p class="text-sm md:text-base text-stone-600 max-w-2xl">
            Pilih gejala yang sesuai dengan kondisi tanaman kakao. NOKA akan memperkirakan penyakit paling mungkin dan memberikan rekomendasi penanganan.
        </p>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-50 border border-lime-200 text-[11px] md:text-xs text-lime-700">
            <span class="w-2 h-2 rounded-full bg-lime-500"></span>
            Tidak perlu login &mdash; data hanya digunakan untuk proses diagnosa.
        </div>
    </section>

    <section class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 md:p-8 space-y-6 mt-6">
        <form action="{{ route('konsultasi.proses') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-3 gap-4 text-sm">
                <div class="md:col-span-2 space-y-1">
                    <label for="lokasi" class="font-medium text-stone-800">Lokasi kebun (opsional)</label>
                    <input id="lokasi" name="lokasi" type="text"
                           value="{{ old('lokasi') }}"
                           class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300"
                           placeholder="Contoh: Lampung Timur">
                </div>
                <div class="space-y-1">
                    <label for="keterangan" class="font-medium text-stone-800">Catatan (opsional)</label>
                    <input id="keterangan" name="keterangan" type="text"
                           value="{{ old('keterangan') }}"
                           class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300"
                           placeholder="Ringkas kondisi tanaman">
                </div>
            </div>

            <div class="space-y-3">
                <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-[11px] font-bold text-blue-700">Metode</span>
                    Pilih metode deteksi penyakit
                </p>
                <div class="grid md:grid-cols-2 gap-3 text-sm">
                    <label class="flex items-start gap-3 rounded-xl border-2 border-stone-200 bg-stone-50/60 px-4 py-3 hover:border-blue-200 cursor-pointer transition"
                           onclick="this.classList.add('border-blue-300'); document.querySelector('input[value=backward]').checked && this.classList.remove('border-stone-200')">
                        <input type="radio" name="metode_deteksi" value="backward" class="mt-1 rounded border-stone-300 text-blue-500 focus:ring-blue-400"
                            {{ old('metode_deteksi', 'backward') === 'backward' ? 'checked' : '' }}>
                        <span>
                            <span class="font-semibold text-stone-900 block">Backward Chaining</span>
                            <span class="text-xs text-stone-500">Deteksi berdasarkan gejala yang dipilih. Cocok untuk diagnosis spesifik.</span>
                        </span>
                    </label>
                    <label class="flex items-start gap-3 rounded-xl border-2 border-stone-200 bg-stone-50/60 px-4 py-3 hover:border-green-200 cursor-pointer transition"
                           onclick="this.classList.add('border-green-300'); document.querySelector('input[value=forward]').checked && this.classList.remove('border-stone-200')">
                        <input type="radio" name="metode_deteksi" value="forward" class="mt-1 rounded border-stone-300 text-green-500 focus:ring-green-400"
                            {{ old('metode_deteksi') === 'forward' ? 'checked' : '' }}>
                        <span>
                            <span class="font-semibold text-stone-900 block">Forward Chaining</span>
                            <span class="text-xs text-stone-500">Deteksi berdasarkan penyakit. Cepat menemukan penyakit yang paling mungkin.</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="space-y-3">
                <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-[11px] font-bold text-amber-700">Gejala</span>
                    Pilih gejala yang teramati
                </p>
                <div class="grid md:grid-cols-2 gap-3 text-sm">
                    @foreach ($gejala as $item)
                        <label class="flex items-start gap-2 rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 hover:border-amber-200">
                            <input type="checkbox" name="gejala[]" value="{{ $item->id_gejala }}" class="mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400"
                                {{ in_array($item->id_gejala, old('gejala', [])) ? 'checked' : '' }}>
                            <span><span class="font-semibold text-stone-900">{{ $item->kode_gejala }}</span> - {{ $item->nama_gejala }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between pt-2">
                <p class="text-[11px] md:text-xs text-stone-500 max-w-md">
                    Sistem akan memproses gejala yang dipilih dan menampilkan kemungkinan penyakit beserta rekomendasi penanganan.
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

    <section id="tentang" class="pb-6 text-xs md:text-sm text-stone-600">
        <p class="font-semibold text-stone-800 mb-1">Catatan</p>
        <p class="max-w-3xl">
            Hasil diagnosa NOKA bersifat pendukung keputusan dan tidak menggantikan pemeriksaan langsung oleh pakar atau penyuluh pertanian.
        </p>
    </section>
@endsection
