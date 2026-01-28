@extends('layouts.app')
@section('title', 'Hasil Diagnosa | NOKA')

@section('content')
<section class="space-y-3">
    <h1 class="text-3xl md:text-4xl font-semibold text-stone-900">Hasil Diagnosa Tanaman Kakao</h1>
    <p class="text-sm md:text-base text-stone-600 max-w-2xl">
        Ringkasan hasil analisis berdasarkan gejala yang dipilih.
    </p>
    @if($metode === 'forward' && isset($severeList) && $severeList->count() > 1)
        <div class="rounded-2xl border-2 border-rose-300 bg-rose-50 text-rose-800 text-sm px-4 py-3">
            <p class="font-semibold">Peringatan: ada beberapa penyakit dengan risiko tinggi (≥60%).</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($severeList as $row)
                    <li>
                        <span class="font-semibold">{{ $row['penyakit']->nama_penyakit ?? '-' }}</span>
                        — kemungkinan {{ number_format(($row['cf'] ?? 0) * 100, 1) }}%
                    </li>
                @endforeach
            </ul>
            <p class="text-[11px] text-rose-700 mt-1">Lakukan langkah cepat: buang bagian sakit, pangkas, perbaiki drainase, dan konsultasi pakar jika gejala makin berat.</p>
        </div>
    @endif
    @if($lowConfidence ?? false)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 text-amber-800 text-sm px-4 py-3">
            Keyakinan sistem masih rendah (&lt; {{ number_format(($lowConfidenceThreshold ?? 0.3) * 100, 0) }}%). Tambahkan gejala lain atau pilih tingkat keyakinan yang lebih sesuai untuk meningkatkan hasil.
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
                    @if($metode === 'forward')
                        <p class="text-xs text-stone-500 mt-1">
                            Status: {{ ($lowConfidence ?? false) ? 'belum yakin' : 'cukup yakin' }} (forward chaining)
                        </p>
                        @if($forwardTie ?? false)
                            <p class="text-[11px] text-amber-700">
                                Nilai sama juga pada: {{ ($forwardTieNames ?? collect())->implode(', ') }}
                            </p>
                        @endif
                    @endif
                </div>
                <div class="text-right space-y-1">
                    <p class="text-xs text-stone-500">{{ $metode === 'forward' ? 'Confidence Forward' : 'Confidence Backward' }}</p>
                    <p class="text-lg font-semibold text-lime-700">
                        {{ $konsultasi->cf_hasil !== null ? number_format($konsultasi->cf_hasil * 100, 1) . '%' : '-' }}
                    </p>
                    @if($konsultasi->cf_backward !== null && $konsultasi->cf_forward !== null)
                        <p class="text-[11px] text-stone-500 space-y-0.5">
                            <span class="block">Backward: {{ number_format($konsultasi->cf_backward * 100, 1) }}%</span>
                            <span class="block">Forward: {{ number_format($konsultasi->cf_forward * 100, 1) }}%</span>
                        </p>
                    @elseif($detailPenyakit && $metode === 'backward')
                        <p class="text-[11px] text-stone-500">
                            Hybrid cek: {{ number_format(($detailPenyakit['combined'] ?? 0) * 100, 1) }}%
                            @if(isset($detailPenyakit['fuzzy_score']))
                                <span class="block">CF aturan {{ number_format(($detailPenyakit['cf'] ?? 0) * 100, 1) }}% / Fuzzy {{ number_format($detailPenyakit['fuzzy_score'] * 100, 1) }}%</span>
                            @endif
                        </p>
                    @endif
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-5 text-sm">
                <div class="space-y-2">
                    <p class="font-semibold text-stone-800">Gejala terpilih</p>
                    <ul class="list-disc list-inside text-stone-600 space-y-1">
                        @forelse ($konsultasi->gejala as $gejala)
                            <li>
                                <span class="font-semibold text-stone-800">{{ $gejala->kode_gejala }}</span>
                                - {{ $gejala->nama_gejala }}
                                <span class="text-xs text-stone-500">(Keyakinan Anda {{ number_format(($gejala->pivot->cf_user ?? 0) * 100, 0) }}%)</span>
                            </li>
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
                @if($metode === 'forward')
                    <li>
                        {{ ($lowConfidence ?? false) ? 'Sistem belum cukup yakin' : 'Sistem menilai paling mungkin' }}:
                        <span class="font-semibold text-stone-900">{{ $konsultasi->hasil->nama_penyakit ?? '-' }}</span>
                        ({{ $konsultasi->cf_hasil !== null ? number_format($konsultasi->cf_hasil * 100, 1) . '%' : '-' }} keyakinan)
                    </li>
                    @if(!empty($detailPenyakit['matched']))
                        <li>
                            Alasan: {{ count($detailPenyakit['matched']) }} gejala yang Anda pilih cocok dengan penyakit ini.
                        </li>
                    @else
                        <li>Belum ada gejala pendukung yang cukup. Tambahkan gejala yang lebih spesifik.</li>
                    @endif
                    @if($lowConfidence ?? false)
                        <li>Saran: tambahkan gejala lain atau tingkatkan keyakinan Anda pada gejala yang benar-benar terlihat.</li>
                    @else
                        <li>Saran: tetap pantau gejala pendukung dan catat perubahan untuk konsultasi berikutnya.</li>
                    @endif
                @else
                    <li>Fokus pada penyakit: <span class="font-semibold text-stone-900">{{ $konsultasi->hasil->nama_penyakit ?? '-' }}</span> (keyakinan {{ $konsultasi->cf_hasil !== null ? number_format($konsultasi->cf_hasil * 100, 1) . '%' : '-' }})</li>
                    @if(!empty($detailPenyakit['matched']))
                        <li>{{ count($detailPenyakit['matched']) }} gejala mendukung hasil ini; lanjutkan pemantauan gejala sejenis untuk validasi.</li>
                    @endif
                    @if($backward && !empty($backward['questions']))
                        <li>Konfirmasi gejala yang belum terjawab untuk meningkatkan kepastian.</li>
                    @endif
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

        @php
            $fuzzyChartData = null;
            if ($metode === 'backward' && isset($detailPenyakit['fuzzy_score'])) {
                $fuzzyChartData = [
                    'score' => round($detailPenyakit['fuzzy_score'] ?? 0, 4),
                    'agg' => $detailPenyakit['fuzzy_agg'] ?? [],
                ];
            }
        @endphp

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

        @if($fuzzyChartData)
            <section class="mt-4 bg-white/80 border border-blue-100 rounded-3xl shadow-sm p-5 space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-semibold text-stone-800">Membership function (trapesium) & crisp fuzzy</p>
                    <span class="text-xs text-stone-500">Fuzzy Mamdani</span>
                </div>
                <div class="w-full">
                    <canvas id="fuzzyMembershipChart" height="200"></canvas>
                </div>
                <p class="text-[11px] text-stone-500">
                    Garis rendah/sedang/tinggi adalah fungsi keanggotaan. Garis putus-putus menunjukkan nilai crisp hasil defuzzifikasi ({{ number_format(($fuzzyChartData['score'] ?? 0) * 100, 1) }}%). Titik biru pada 0.25/0.55/0.85 menampilkan agregasi fuzzy.
                </p>
            </section>
        @endif
    @endif
@endsection

@push('scripts')
@if($fuzzyChartData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (() => {
        @if($fuzzyChartData)
        const fuzzyCtx = document.getElementById('fuzzyMembershipChart');
        if (fuzzyCtx) {
            const membership = {
                low: [
                    [0.0, 0.0, 0.35],
                    [0.0, 0.35, 0.5],
                ],
                medium: [
                    [0.25, 0.5, 0.75],
                ],
                high: [
                    [0.5, 0.75, 1.0],
                    [0.65, 1.0, 1.0],
                ],
            };
            const outputCenters = { low: 0.25, medium: 0.55, high: 0.85 };
            const agg = @json($fuzzyChartData['agg'] ?? []);
            const crisp = Number(@json($fuzzyChartData['score'] ?? 0));

            const tri = (x, a, b, c) => {
                if (x <= a || x >= c) return 0;
                if (x === b) return 1;
                return x < b ? (x - a) / (b - a) : (c - x) / (c - b);
            };
            const mu = (triangles, x) => triangles.reduce((m, t) => Math.max(m, tri(x, t[0], t[1], t[2])), 0);
            const xs = Array.from({ length: 21 }, (_, i) => i / 20);
            const buildSeries = (label) => xs.map((x) => ({ x, y: mu(membership[label] || [], x) }));

            const datasetsFuzzy = [
                {
                    label: 'Low',
                    data: buildSeries('low'),
                    parsing: { xAxisKey: 'x', yAxisKey: 'y' },
                    borderColor: 'rgba(59, 130, 246, 0.8)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: false,
                    tension: 0,
                },
                {
                    label: 'Medium',
                    data: buildSeries('medium'),
                    parsing: { xAxisKey: 'x', yAxisKey: 'y' },
                    borderColor: 'rgba(234, 179, 8, 0.9)',
                    backgroundColor: 'rgba(234, 179, 8, 0.1)',
                    fill: false,
                    tension: 0,
                },
                {
                    label: 'High',
                    data: buildSeries('high'),
                    parsing: { xAxisKey: 'x', yAxisKey: 'y' },
                    borderColor: 'rgba(34, 197, 94, 0.8)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    fill: false,
                    tension: 0,
                },
                {
                    label: 'Crisp (defuzzifikasi)',
                    data: [
                        { x: crisp, y: 0 },
                        { x: crisp, y: 1 },
                    ],
                    parsing: { xAxisKey: 'x', yAxisKey: 'y' },
                    borderColor: 'rgba(239, 68, 68, 0.9)',
                    borderDash: [6, 6],
                    pointRadius: 0,
                    fill: false,
                    tension: 0,
                },
                {
                    type: 'scatter',
                    label: 'Agregasi fuzzy',
                    data: Object.entries(agg || {}).map(([label, val]) => ({
                        x: outputCenters[label] ?? 0,
                        y: Number(val ?? 0),
                    })),
                    parsing: { xAxisKey: 'x', yAxisKey: 'y' },
                    backgroundColor: 'rgba(37, 99, 235, 0.9)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    pointRadius: 4,
                },
            ];

            new Chart(fuzzyCtx, {
                type: 'line',
                data: { datasets: datasetsFuzzy },
                options: {
                    responsive: true,
                    interaction: { mode: 'nearest', intersect: false },
                    scales: {
                        x: {
                            type: 'linear',
                            min: 0,
                            max: 1,
                            ticks: { callback: (v) => v.toFixed(1) },
                            title: { display: true, text: 'Nilai (0 - 1)' },
                        },
                        y: {
                            min: 0,
                            max: 1,
                            ticks: { callback: (v) => v.toFixed(1) },
                            title: { display: true, text: 'Derajat keanggotaan' },
                        },
                    },
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    const val = ctx.parsed.y ?? ctx.raw?.y ?? 0;
                                    return `${ctx.dataset.label}: ${val.toFixed(2)}`;
                                }
                            }
                        }
                    }
                }
            });
        }
        @endif
    })();
</script>
@endif
@endpush
