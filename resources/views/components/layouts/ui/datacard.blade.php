{{--
    Posyandu Datacard / Stats Card Component
    ─────────────────────────────────────────
    Props:
        label   — string label/judul kartu
        value   — string|int nilai utama
        icon    — string nama icon Material Symbols (default: 'analytics')
        trend   — string opsional: '+12%' atau '-3%'
        trendUp — boolean (default: true) — warna trend hijau/merah
        color   — 'primary' | 'secondary' | 'tertiary' | 'success' | 'warning' | 'error'
                  (default: 'primary')
        sub     — string teks kecil di bawah value (opsional)

    Usage:
        <x-datacard label="Total Balita" value="128" icon="child_care" color="primary" />
        <x-datacard label="Stunting" value="12" icon="warning" color="error" trend="+2" :trendUp="false" />
--}}

@props([
    'label'   => '',
    'value'   => '0',
    'icon'    => 'analytics',
    'trend'   => '',
    'trendUp' => true,
    'color'   => 'primary',
    'sub'     => '',
])

@php
    $colorConfig = match($color) {
        'secondary' => ['bg' => 'bg-secondary/10',  'icon' => 'text-secondary',       'ring' => 'ring-secondary/20'],
        'tertiary'  => ['bg' => 'bg-tertiary/10',   'icon' => 'text-tertiary',        'ring' => 'ring-tertiary/20'],
        'success'   => ['bg' => 'bg-emerald-50',    'icon' => 'text-status-normal',   'ring' => 'ring-emerald-200'],
        'warning'   => ['bg' => 'bg-amber-50',      'icon' => 'text-status-warning',  'ring' => 'ring-amber-200'],
        'error'     => ['bg' => 'bg-red-50',        'icon' => 'text-error',           'ring' => 'ring-red-200'],
        default     => ['bg' => 'bg-primary/10',    'icon' => 'text-primary',         'ring' => 'ring-primary/20'],
    };
@endphp

<div {{ $attributes->merge([
    'class' => 'bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-5 flex items-start gap-4'
]) }}
     style="font-family:'Public Sans', 'Public Sans Fallback', sans-serif;">

    {{-- Icon badge --}}
    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 ring-1
                {{ $colorConfig['bg'] }} {{ $colorConfig['ring'] }}">
        <span class="material-symbols-outlined text-[22px] {{ $colorConfig['icon'] }}"
              style="font-variation-settings:'FILL' 1;">
            {{ $icon }}
        </span>
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-on-surface-variant mb-1">
            {{ $label }}
        </p>
        <p class="text-[28px] font-black text-on-surface leading-none">
            {{ $value }}
        </p>

        @if($sub || $trend)
        <div class="flex items-center gap-2 mt-1.5">
            @if($sub)
                <span class="text-[11px] text-on-surface-variant">{{ $sub }}</span>
            @endif
            @if($trend)
                <span class="text-[11px] font-bold {{ $trendUp ? 'text-status-normal' : 'text-error' }}
                             flex items-center gap-0.5">
                    <i class="fas {{ $trendUp ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-[10px]"></i>
                    {{ $trend }}
                </span>
            @endif
        </div>
        @endif
    </div>

</div>
