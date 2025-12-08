@extends('layouts.app')
@section('title', 'Hasil Diagnosa | NOKA')

@section('content')
<section class="space-y-3">
    <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Hasil Diagnosa Tanaman Kakao</h1>
    <p class="text-sm md:text-base text-stone-600 max-w-2xl">
        Ringkasan hasil analisis berdasarkan gejala yang dipilih.
    </p>
    @if($lowConfidence ?? false)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 text-amber-800 text-sm px-4 py-3">
            Sistem belum bisa menentukan penyakit karena keyakinan 0%. Tambahkan gejala lain atau pilih gejala yang lebih spesifik untuk meningkatkan kepastian.
        </div>
    @endif
    <div class="flex flex-wrap gap-3 text-xs md:text-sm text-stone-600">
        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-stone-50 border border-stone-200">
            <span class="font-semibold text-stone-800">Lokasi:</span>
            <span>{{ $konsultasi->lokasi ?? '-' }}</span>
        </div>
        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-stone-50 border border-stone-200">
            <span class="font-semibold text-stone-800">Tanggal:</span>
            <span>{{ $konsultasi->tanggal_konsultasi?->format('d M Y H:i') }}</span>
        </div>
        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-stone-50 border border-stone-200">
            <span class="font-semibold text-stone-800">Catatan:</span>
            <span>{{ $konsultasi->keterangan ?? '-' }}</span>
        </div>
        <div class="flex items-center gap-2 px-3 py-1 rounded-full {{ $metode === 'forward' ? 'bg-green-50 border-green-200' : 'bg-blue-50 border-blue-200' }} border">
            <span class="font-semibold {{ $metode === 'forward' ? 'text-green-700' : 'text-blue-700' }}">Metode:</span>
            <span class="{{ $metode === 'forward' ? 'text-green-600' : 'text-blue-600' }}">
                @if($metode === 'forward')
                    Forward Chaining
                @else
                    Backward Chaining
                @endif
            </span>
        </div>
    </div>
    </section>

    <section class="grid lg:grid-cols-[2fr,1.2fr] gap-6 items-start mt-6">
        <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-6 md:p-7 space-y-5">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-400">Penyakit utama</p>
                    <h2 class="text-xl md:text-2xl font-semibold text-stone-900">
                        {{ $konsultasi->hasil->nama_penyakit ?? 'Belum terdeteksi' }}
                    </h2>
                </div>
                <div class="text-right space-y-1">
                    <p class="text-xs text-stone-500">
                        @if($metode === 'forward')
                            Confidence Forward
                        @else
                            Confidence Backward
                        @endif
                    </p>
                    <p class="text-lg font-semibold text-lime-700">
                        {{ $konsultasi->cf_hasil ? number_format($konsultasi->cf_hasil * 100, 1) . '%' : '-' }}
                    </p>
                    @if($konsultasi->cf_backward && $konsultasi->cf_forward)
                        <p class="text-[11px] text-stone-500 space-y-0.5">
                            <span class="block">Backward: {{ number_format($konsultasi->cf_backward * 100, 1) }}%</span>
                            <span class="block">Forward: {{ number_format($konsultasi->cf_forward * 100, 1) }}%</span>
                        </p>
                    @elseif($detailPenyakit && $metode === 'backward')
                        <p class="text-[11px] text-stone-500">
                            CF: {{ number_format($detailPenyakit['cf'] * 100, 1) }}% · Fuzzy: {{ number_format($detailPenyakit['fuzzy_score'] * 100, 1) }}%
                        </p>
                    @endif
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-5 text-sm">
                <div class="space-y-2">
                    <p class="font-semibold text-stone-800">Gejala terpilih</p>
                    <ul class="list-disc list-inside text-stone-600 space-y-1">
                        @forelse ($konsultasi->gejala as $gejala)
                            <li><span class="font-semibold text-stone-800">{{ $gejala->kode_gejala }}</span> - {{ $gejala->nama_gejala }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ul>
                </div>
                <div class="space-y-2">
                    <p class="font-semibold text-stone-800">Deskripsi penyakit</p>
                    <p class="text-stone-600 text-sm">
                        {{ $konsultasi->hasil->deskripsi ?? 'Belum ada deskripsi.' }}
                    </p>
                </div>
            </div>
        </div>

        <aside class="bg-white/80 border border-lime-100 rounded-3xl shadow-sm p-5 md:p-6 space-y-4 text-sm text-stone-700">
            <p class="text-sm font-semibold text-lime-800 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-lime-100 flex items-center justify-center text-[11px] font-bold text-lime-700">Tip</span>
                Langkah penanganan
            </p>
            <div class="space-y-3 text-sm text-stone-700">
                <p class="font-semibold text-stone-800">Pengendalian</p>
                <p>{{ $konsultasi->hasil->pengendalian ?? '-' }}</p>
            </div>
            <div class="space-y-3 text-sm text-stone-700">
                <p class="font-semibold text-stone-800">Pencegahan</p>
                <p>{{ $konsultasi->hasil->pencegahan ?? '-' }}</p>
            </div>
        </aside>
    </section>

    <section class="mt-4 grid md:grid-cols-[1.2fr,1fr] gap-4">
        <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 space-y-3">
            <p class="text-sm font-semibold text-stone-800">Rekomendasi utama</p>
            <ul class="list-disc list-inside text-stone-700 text-sm space-y-1">
                <li>Fokus pada penyakit: <span class="font-semibold text-stone-900">{{ $konsultasi->hasil->nama_penyakit ?? '-' }}</span> (keyakinan {{ $konsultasi->cf_hasil ? number_format($konsultasi->cf_hasil * 100, 1) . '%' : '-' }})</li>
                @if(!empty($detailPenyakit['matched']))
                    <li>{{ count($detailPenyakit['matched']) }} gejala mendukung hasil ini; lanjutkan pemantauan gejala sejenis untuk validasi.</li>
                @endif
                @if($backward && !empty($backward['questions']))
                    <li>Konfirmasi gejala yang belum terjawab untuk meningkatkan kepastian.</li>
                @endif
            </ul>
        </div>
        <div class="bg-white/80 border border-lime-100 rounded-3xl shadow-sm p-5 space-y-2 text-sm text-stone-700">
            <p class="text-sm font-semibold text-stone-800">Langkah penanganan ringkas</p>
            <p class="text-stone-600">{{ $konsultasi->hasil->pengendalian ?? 'Belum ada catatan pengendalian.' }}</p>
            <p class="text-sm font-semibold text-stone-800 pt-1">Saran tambahan</p>
            <p class="text-stone-600">{{ $konsultasi->hasil->pencegahan ?? 'Belum ada catatan pencegahan.' }}</p>
        </div>
    </section>

    @if($detailPenyakit)
        <section class="mt-6 grid md:grid-cols-2 gap-4">
            <div class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 space-y-3">
                <p class="text-sm font-semibold text-stone-800">Gejala yang mendukung hasil</p>
                <ul class="list-disc list-inside text-stone-600 text-sm space-y-1">
                    @forelse($detailPenyakit['matched'] as $gejala)
                        <li>
                            <span class="font-semibold text-stone-800">{{ $gejala['kode'] }}</span>
                            - {{ $gejala['nama'] }}
                            <span class="text-xs text-stone-500">(CF pakar {{ $gejala['cf_rule'] }})</span>
                        </li>
                    @empty
                        <li>Belum ada gejala yang cocok.</li>
                    @endforelse
                </ul>
            </div>

            @if($backward && !empty($backward['questions']))
                <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 space-y-3">
                    <p class="text-sm font-semibold text-stone-800">Gejala yang masih perlu dikonfirmasi</p>
                    <ul class="list-disc list-inside text-stone-600 text-sm space-y-1">
                        @foreach($backward['questions'] as $gejala)
                            <li>
                                <span class="font-semibold text-stone-800">{{ $gejala['kode'] }}</span>
                                - {{ $gejala['nama'] }}
                                <span class="text-xs text-stone-500">(CF pakar {{ $gejala['cf_rule'] }})</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-[11px] text-stone-500">Pertimbangkan menambahkan gejala ini pada konsultasi berikutnya untuk meningkatkan keyakinan sistem.</p>
                </div>
            @endif
        </section>
    @endif

        <section class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between pt-2">
            <p class="text-[11px] md:text-xs text-stone-500 max-w-xl">
                Hasil diagnosa dari NOKA hanyalah alat bantu. Keputusan akhir tetap perlu dipertimbangkan bersama pengalaman petani dan saran pakar lapangan.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('konsultasi.index') }}" class="px-4 py-2 rounded-full border border-stone-200 text-sm text-stone-700 hover:bg-stone-50">
                    Konsultasi Ulang
                </a>
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-full bg-amber-400 text-sm font-semibold text-stone-900 hover:bg-amber-300">
                    Kembali ke Beranda
                </a>
            </div>
        </section>

    @if($detailPenyakit)
        <section class="mt-6 grid lg:grid-cols-[1.4fr,1fr] gap-4">
            <div class="bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-semibold text-stone-800">Rule aktif (gejala cocok)</p>
                    <span class="text-xs text-stone-500">Total: {{ count($detailPenyakit['matched'] ?? []) }}</span>
                </div>
                <ul class="list-disc list-inside text-stone-600 text-sm space-y-1">
                    @forelse($detailPenyakit['matched'] as $gejala)
                        <li>
                            <span class="font-semibold text-stone-800">{{ $gejala['kode'] }}</span>
                            - {{ $gejala['nama'] }}
                            <span class="text-xs text-stone-500">(rule {{ $gejala['cf_rule'] }}, user {{ $gejala['cf_user'] }})</span>
                        </li>
                    @empty
                        <li>Belum ada gejala yang cocok.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white/80 border border-amber-100 rounded-3xl shadow-sm p-5 space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-semibold text-stone-800">Gejala yang masih perlu dikonfirmasi</p>
                    <span class="text-xs text-stone-500">Total: {{ count($detailPenyakit['missing'] ?? []) }}</span>
                </div>
                @if($backward && !empty($backward['questions']))
                    <ul class="list-disc list-inside text-stone-600 text-sm space-y-1">
                        @foreach($backward['questions'] as $gejala)
                            <li>
                                <span class="font-semibold text-stone-800">{{ $gejala['kode'] }}</span>
                                - {{ $gejala['nama'] }}
                                <span class="text-xs text-stone-500">(rule {{ $gejala['cf_rule'] }})</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-[11px] text-stone-500">Tambahkan gejala ini pada konsultasi berikutnya untuk meningkatkan keyakinan.</p>
                @else
                    <p class="text-sm text-stone-600">Tidak ada gejala lain yang perlu dikonfirmasi.</p>
                @endif
            </div>
        </section>

        @if(isset($peringkat) && $peringkat->count())
            <section class="mt-4 bg-white/80 border border-stone-100 rounded-3xl shadow-sm p-5 space-y-3">
                <p class="text-sm font-semibold text-stone-800">
                    Peringkat hasil
                    @if($metode === 'forward')
                        (Forward Chaining)
                    @else
                        (Backward - Hybrid)
                    @endif
                </p>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-stone-700">
                        <thead class="text-xs uppercase text-stone-500 bg-stone-50">
                            <tr>
                                <th class="px-3 py-2">Penyakit</th>
                                @if($metode === 'forward')
                                    <th class="px-3 py-2 text-right">CF Score</th>
                                @else
                                    <th class="px-3 py-2 text-right">Combined</th>
                                    <th class="px-3 py-2 text-right">CF</th>
                                    <th class="px-3 py-2 text-right">Fuzzy</th>
                                @endif
                                <th class="px-3 py-2 text-center">Rules aktif</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach($peringkat->take(5) as $row)
                                <tr>
                                    <td class="px-3 py-2 font-semibold text-stone-900">{{ $row['penyakit']->nama_penyakit ?? '-' }}</td>
                                    @if($metode === 'forward')
                                        <td class="px-3 py-2 text-right text-lime-700 font-semibold">{{ number_format($row['cf'] * 100, 1) }}%</td>
                                    @else
                                        <td class="px-3 py-2 text-right text-lime-700 font-semibold">{{ number_format($row['combined'] * 100, 1) }}%</td>
                                        <td class="px-3 py-2 text-right text-stone-600">{{ number_format($row['cf'] * 100, 1) }}%</td>
                                        <td class="px-3 py-2 text-right text-stone-600">{{ number_format($row['fuzzy_score'] * 100, 1) }}%</td>
                                    @endif
                                    <td class="px-3 py-2 text-center text-stone-600">{{ count($row['matched'] ?? []) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    @endif
@endsection
