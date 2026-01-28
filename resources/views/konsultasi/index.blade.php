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
                    <label class="flex items-start gap-3 rounded-xl border-2 border-stone-200 bg-stone-50/60 px-4 py-3 hover:border-blue-200 cursor-pointer transition">
                        <input type="radio" name="metode_deteksi" value="backward" class="mt-1 rounded border-stone-300 text-blue-500 focus:ring-blue-400"
                            {{ old('metode_deteksi', 'backward') === 'backward' ? 'checked' : '' }}>
                        <span>
                            <span class="font-semibold text-stone-900 block">Backward Chaining</span>
                            <span class="text-xs text-stone-500">Mulai dari pilihan penyakit, kemudian jawab gejala-gejala yang diminta.</span>
                        </span>
                    </label>
                    <label class="flex items-start gap-3 rounded-xl border-2 border-stone-200 bg-stone-50/60 px-4 py-3 hover:border-green-200 cursor-pointer transition">
                        <input type="radio" name="metode_deteksi" value="forward" class="mt-1 rounded border-stone-300 text-green-500 focus:ring-green-400"
                            {{ old('metode_deteksi') === 'forward' ? 'checked' : '' }}>
                        <span>
                            <span class="font-semibold text-stone-900 block">Forward Chaining</span>
                            <span class="text-xs text-stone-500">Deteksi berdasarkan penyakit. Cepat menemukan penyakit yang paling mungkin.</span>
                        </span>
                    </label>
                </div>
            </div>

            <div id="penyakit-wrapper" class="space-y-2 {{ old('metode_deteksi', 'backward') === 'backward' ? '' : 'hidden' }}">
                <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-sky-100 flex items-center justify-center text-[11px] font-bold text-sky-700">Pilih</span>
                    Pilih penyakit terlebih dahulu (khusus backward)
                </p>
                <select id="penyakit_id" name="penyakit_id"
                        class="w-full rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300">
                    <option value="">-- Pilih penyakit yang ingin diuji --</option>
                    @foreach ($penyakit as $row)
                        <option value="{{ $row->id_penyakit }}" {{ old('penyakit_id') == $row->id_penyakit ? 'selected' : '' }}>
                            {{ $row->kode_penyakit }} - {{ $row->nama_penyakit }}
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-stone-500">Pada backward chaining, gejala yang ditampilkan akan mengikuti penyakit yang dipilih.</p>
            </div>

            <div class="space-y-3">
                <p class="text-sm font-semibold text-stone-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-[11px] font-bold text-amber-700">Gejala</span>
                    Pilih gejala yang teramati & tingkat keyakinan
                </p>
                <p class="text-xs text-stone-500">Jika ragu, pilih opsi "Belum yakin / perlu cek lagi". Nilai terendah adalah 0.1 (tidak ada angka 0 supaya gejala tetap dipertimbangkan).</p>
                <div id="gejala-container" class="grid md:grid-cols-2 gap-3 text-sm">
                    <div id="gejala-placeholder" class="col-span-2 text-xs text-stone-500 bg-stone-50 border border-dashed border-stone-200 rounded-xl px-3 py-2 hidden">
                        Pilih penyakit terlebih dahulu untuk menampilkan daftar gejala yang relevan.
                    </div>
                    @foreach ($gejala as $item)
                        @php
                            $selected = in_array($item->id_gejala, old('gejala', []));
                            $cfValue = (float) old('cf_user.' . $item->id_gejala, '1');
                            $cfValue = $cfValue < 0.1 ? 0.1 : $cfValue;
                            $penyakitsForGejala = $gejalaPenyakitMap[$item->id_gejala] ?? [];
                        @endphp
                        <div data-gejala-id="{{ $item->id_gejala }}"
                             data-penyakit="{{ implode(',', $penyakitsForGejala) }}"
                             class="gejala-card flex items-start justify-between gap-3 rounded-xl border border-stone-200 bg-stone-50/60 px-3 py-2 hover:border-amber-200">
                            <label for="gejala-{{ $item->id_gejala }}" class="flex items-start gap-2 cursor-pointer">
                                <input id="gejala-{{ $item->id_gejala }}" type="checkbox" name="gejala[]" value="{{ $item->id_gejala }}"
                                       class="gejala-checkbox mt-1 rounded border-stone-300 text-amber-500 focus:ring-amber-400"
                                       data-cf-target="cf-{{ $item->id_gejala }}"
                                       {{ $selected ? 'checked' : '' }}>
                                <span>
                                    <span class="font-semibold text-stone-900">{{ $item->kode_gejala }}</span>
                                    <span class="block text-stone-700">{{ $item->nama_gejala }}</span>
                                </span>
                            </label>
                            <div class="flex flex-col items-end gap-1 text-[11px]">
                                <span class="text-stone-500">Seberapa yakin?</span>
                                <select id="cf-{{ $item->id_gejala }}" name="cf_user[{{ $item->id_gejala }}]"
                                        class="cf-select rounded-lg border border-stone-200 bg-white px-2 py-1 text-[11px] text-stone-700 focus:outline-none focus:ring-amber-300 {{ $selected ? '' : 'opacity-50' }}"
                                        {{ $selected ? '' : 'disabled' }}>
                                    <option value="1" {{ $cfValue == 1.0 ? 'selected' : '' }}>Sangat yakin</option>
                                    <option value="0.8" {{ $cfValue == 0.8 ? 'selected' : '' }}>Yakin</option>
                                    <option value="0.6" {{ $cfValue == 0.6 ? 'selected' : '' }}>Cukup yakin</option>
                                    <option value="0.4" {{ $cfValue == 0.4 ? 'selected' : '' }}>Kurang yakin</option>
                                    <option value="0.2" {{ $cfValue == 0.2 ? 'selected' : '' }}>Ragu-ragu</option>
                                    <option value="0.1" {{ $cfValue == 0.1 ? 'selected' : '' }}>Belum yakin / perlu cek lagi</option>
                                </select>
                            </div>
                        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const metodeInputs = document.querySelectorAll('input[name="metode_deteksi"]');
            const penyakitSelect = document.getElementById('penyakit_id');
            const gejalaCards = Array.from(document.querySelectorAll('[data-gejala-id]'));
            const placeholder = document.getElementById('gejala-placeholder');
            const penyakitWrapper = document.getElementById('penyakit-wrapper');
            const gejalaCheckboxes = Array.from(document.querySelectorAll('.gejala-checkbox'));

            const syncCfSelect = (checkbox) => {
                const targetId = checkbox.dataset.cfTarget;
                const select = document.getElementById(targetId);
                if (!select) return;
                const active = checkbox.checked;
                select.disabled = !active;
                select.classList.toggle('opacity-50', !active);
            };

            document.querySelectorAll('.gejala-checkbox').forEach((checkbox) => {
                checkbox.addEventListener('change', () => syncCfSelect(checkbox));
                syncCfSelect(checkbox);
            });

            const resetGejalaSelections = () => {
                gejalaCheckboxes.forEach((checkbox) => {
                    checkbox.checked = false;
                    const targetId = checkbox.dataset.cfTarget;
                    const select = document.getElementById(targetId);
                    if (select) {
                        select.value = '1';
                        select.disabled = true;
                        select.classList.add('opacity-50');
                    }
                });
            };

            const updateVisibility = () => {
                const metode = document.querySelector('input[name="metode_deteksi"]:checked')?.value;
                const backward = metode === 'backward';
                const selectedPenyakit = penyakitSelect?.value;

                if (penyakitWrapper) {
                    penyakitWrapper.classList.toggle('hidden', !backward);
                }

                gejalaCards.forEach((card) => {
                    const allowed = (card.dataset.penyakit || '').split(',').filter(Boolean);
                    const canShow = !backward || !selectedPenyakit || allowed.includes(selectedPenyakit);
                    card.classList.toggle('hidden', backward && selectedPenyakit && !canShow);
                    if (backward && !selectedPenyakit) {
                        card.classList.add('hidden');
                    }
                });

                if (placeholder) {
                    placeholder.classList.toggle('hidden', !backward || !!selectedPenyakit);
                }
            };

            metodeInputs.forEach((input) => input.addEventListener('change', () => {
                resetGejalaSelections();
                updateVisibility();
            }));

            penyakitSelect?.addEventListener('change', () => {
                resetGejalaSelections();
                updateVisibility();
            });
            updateVisibility();
        });
    </script>
@endsection
