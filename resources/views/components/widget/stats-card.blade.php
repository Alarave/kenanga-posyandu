{{--
    Posyandu Stats Card Widget
    ───────────────────────────
    Kartu statistik KPI untuk dashboard — menampilkan satu angka metrik
    dengan icon, label, badge, dan tren opsional.

    Props:
        label       — string label metrik (contoh: 'Total Balita')
        value       — int|string nilai utama
        icon        — string Material Symbols icon name (default: 'analytics')
        badge       — string teks badge kecil (contoh: 'Bulan Ini')
        iconBg      — string warna background icon (hex/tailwind, default: '#dbeafe')
        iconColor   — string warna icon (hex, default: '#2563eb')
        badgeClass  — string Tailwind classes untuk badge (default: 'bg-blue-50 text-secondary')
        trend       — string teks tren opsional (contoh: '+12%')
        trendUp     — boolean arah tren (default: true = hijau, false = merah)
        href        — string URL link opsional (membuat card bisa diklik)
        loading     — boolean tampilkan skeleton loader (default: false)

    Usage:
        <x-widget.stats-card
            label="Total Balita"
            :value="$totalBalita"
            icon="child_care"
            badge="Terdata"
            icon-bg="#dbeafe"
            icon-color="#2563eb"
            badge-class="bg-blue-50 text-secondary"
        />

        {{-- Dengan tren --}}
        <x-widget.stats-card
            label="Kunjungan Bulan Ini"
            :value="$kunjungan"
            icon="how_to_reg"
            badge="Bulan Ini"
            trend="+8%"
            :trend-up="true"
        />
--}}

@props([
    'label'      => '',
    'value'      => '0',
    'icon'       => 'analytics',
    'badge'      => '',
    'iconBg'     => '#dbeafe',
    'iconColor'  => '#2563eb',
    'badgeClass' => 'bg-blue-50 text-secondary',
    'trend'      => '',
    'trendUp'    => true,
    'href'       => null,
    'loading'    => false,
])

@php
    $tag = $href ? 'a' : 'div';
    $attrs = $href ? "href=\"{$href}\"" : '';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge([
        'class' => 'bg-surface-container-lowest rounded-2xl border border-outline-variant p-6 shadow-sm
                    hover:shadow-md transition-shadow flex flex-col gap-4'
        . ($href ? ' cursor-pointer hover:border-primary/30' : '')
    ]) }}
    style="font-family:'Public Sans',sans-serif;"
>
    @if($loading)
        {{-- Skeleton --}}
        <div class="animate-pulse space-y-3">
            <div class="flex justify-between">
                <div class="w-12 h-12 rounded-xl bg-surface-container"></div>
                <div class="w-16 h-6 rounded-lg bg-surface-container"></div>
            </div>
            <div class="w-20 h-3 rounded bg-surface-container"></div>
            <div class="w-16 h-9 rounded bg-surface-container"></div>
        </div>
    @else
        {{-- Top row: icon + badge --}}
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:{{ $iconBg }}; color:{{ $iconColor }};">
                <span class="material-symbols-outlined"
                      style="font-size:22px; font-variation-settings:'FILL' 1;">
                    {{ $icon }}
                </span>
            </div>
            @if($badge)
            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-lg {{ $badgeClass }}">
                {{ $badge }}
            </span>
            @endif
        </div>

        {{-- Label --}}
        <p class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">
            {{ $label }}
        </p>

        {{-- Value + trend --}}
        <div class="flex items-end justify-between gap-2">
            <h3 class="font-black text-on-surface leading-none"
                style="font-size:36px; letter-spacing:-0.03em;">
                {{ number_format((int) $value) }}
            </h3>
            @if($trend)
            <span class="text-[12px] font-bold flex items-center gap-1 mb-1
                         {{ $trendUp ? 'text-status-normal' : 'text-error' }}">
                <i class="fas {{ $trendUp ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-[11px]"></i>
                {{ $trend }}
            </span>
            @endif
        </div>
    @endif

</{{ $tag }}>
