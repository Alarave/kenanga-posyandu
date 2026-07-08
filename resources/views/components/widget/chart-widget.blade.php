{{--
    Posyandu Chart Widget
    ──────────────────────
    Widget wrapper untuk Chart.js — menampilkan grafik dengan header
    dan canvas yang siap dipakai.

    Props:
        title       — string judul chart
        subtitle    — string teks kecil di bawah judul (opsional)
        chartId     — string ID unik canvas (WAJIB, untuk Chart.js init)
        height      — string tinggi canvas (default: '260px')
        minWidth    — string min-width untuk responsif (default: '0')
                      set ke '600px' untuk chart yang butuh scroll horizontal
        type        — 'line' | 'bar' | 'doughnut' | 'pie' | 'radar'
                      (hanya sebagai data-attr, inisialisasi tetap di JS)
        loading     — boolean tampilkan skeleton (default: false)
        empty       — boolean tampilkan empty state (default: false)
        emptyText   — string teks empty state (default: 'Belum ada data')

    Slots:
        $slot   — konten tambahan di bawah chart (opsional, misal: legend custom)
        $action — aksi di header (opsional)

    Usage:
        {{-- Donut chart --}}
        <x-widget.chart-widget
            title="Distribusi Status Gizi"
            subtitle="Rekam medis terkini per balita"
            chart-id="nutritionStatusChart"
            height="180px"
            type="doughnut"
        />

        {{-- Line chart dengan scroll horizontal --}}
        <x-widget.chart-widget
            title="Tren Penimbangan Bulanan"
            subtitle="12 bulan terakhir"
            chart-id="monthlyWeighingChart"
            height="260px"
            min-width="600px"
        />

    Inisialisasi Chart.js di @push('scripts'):
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('nutritionStatusChart');
            new Chart(ctx, { type: 'doughnut', data: {...}, options: {...} });
        });
        </script>
--}}

@props([
    'title'     => '',
    'subtitle'  => '',
    'chartId'   => 'chart-' . uniqid(),
    'height'    => '260px',
    'minWidth'  => '0',
    'type'      => 'line',
    'loading'   => false,
    'empty'     => false,
    'emptyText' => 'Belum ada data untuk ditampilkan',
])

<div {{ $attributes->merge([
    'class' => 'bg-surface-container-lowest rounded-2xl border border-outline-variant shadow-sm overflow-hidden'
]) }}
     style="font-family:'Public Sans', 'Public Sans Fallback', sans-serif;">

    {{-- Header --}}
    @if($title || isset($action))
    <div class="px-6 py-4 border-b border-outline-variant bg-surface-container-low
                flex items-center justify-between gap-4">
        <div class="min-w-0">
            @if($title)
            <h3 class="text-[15px] font-bold text-on-surface leading-tight">{{ $title }}</h3>
            @endif
            @if($subtitle)
            <p class="text-[11px] text-on-surface-variant font-medium mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
        @if(isset($action))
        <div class="flex-shrink-0">{{ $action }}</div>
        @endif
    </div>
    @endif

    {{-- Chart area --}}
    <div class="p-6">
        @if($loading)
            {{-- Skeleton --}}
            <div class="animate-pulse">
                <div class="w-full rounded-xl bg-surface-container" style="height:{{ $height }};"></div>
            </div>

        @elseif($empty)
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center text-center py-8"
                 style="height:{{ $height }};">
                <span class="material-symbols-outlined text-outline text-[48px] mb-3">
                    bar_chart_off
                </span>
                <p class="text-[13px] font-medium text-on-surface-variant">{{ $emptyText }}</p>
            </div>

        @else
            {{-- Canvas wrapper (overflow-x untuk chart lebar) --}}
            <div class="w-full @if($minWidth !== '0') overflow-x-auto @endif">
                <div style="min-width:{{ $minWidth }}; height:{{ $height }}; position:relative;">
                    <canvas
                        id="{{ $chartId }}"
                        data-chart-type="{{ $type }}"
                        style="width:100%; height:100%;">
                    </canvas>
                </div>
            </div>
        @endif

        {{-- Optional slot below chart --}}
        @if($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
        @endif
    </div>

</div>
