{{--
    Posyandu Dashboard Card Widget
    ────────────────────────────────
    Card container serbaguna untuk section dashboard —
    dengan header (judul + subtitle + aksi), body, dan footer opsional.

    Props:
        title       — string judul section
        subtitle    — string teks kecil di bawah judul (opsional)
        icon        — string Material Symbols icon (opsional)
        iconColor   — string Tailwind color class untuk icon (default: 'text-primary')
        actionText  — string teks link aksi di kanan header (opsional)
        actionHref  — string URL link aksi (opsional)
        padding     — 'none' | 'sm' | 'md'  (default: 'md') — padding body
        headerBg    — boolean background abu di header (default: true)

    Slots:
        $slot   — konten body card
        $action — slot aksi custom di header (menggantikan actionText/actionHref)
        $footer — konten footer card (opsional)

    Usage:
        <x-widget.dashboard-card
            title="Daftar Perhatian Status Gizi"
            subtitle="Balita dengan status Stunting"
            icon="warning"
            icon-color="text-status-warning"
            action-text="Lihat Semua →"
            action-href="{{ route('admin.patients.index') }}">
            {{-- konten tabel --}}
        </x-widget.dashboard-card>

        {{-- Dengan slot action custom --}}
        <x-widget.dashboard-card title="Jadwal Terdekat">
            <x-slot:action>
                <x-button variant="outline" size="sm">+ Tambah</x-button>
            </x-slot:action>
            {{-- konten --}}
        </x-widget.dashboard-card>
--}}

@props([
    'title'      => '',
    'subtitle'   => '',
    'icon'       => '',
    'iconColor'  => 'text-primary',
    'actionText' => '',
    'actionHref' => '#',
    'padding'    => 'md',
    'headerBg'   => true,
])

@php
    $bodyPadding = match($padding) {
        'none' => '',
        'sm'   => 'p-4',
        default => 'p-6',
    };
@endphp

<div {{ $attributes->merge([
    'class' => 'bg-surface-container-lowest rounded-2xl border border-outline-variant shadow-sm overflow-hidden flex flex-col'
]) }}
     style="font-family:'Public Sans',sans-serif;">

    {{-- Header --}}
    @if($title || isset($action))
    <div class="px-6 py-4 border-b border-outline-variant flex items-center justify-between gap-4 flex-shrink-0
                {{ $headerBg ? 'bg-surface-container-low' : '' }}">
        <div class="flex items-start gap-2.5 min-w-0">
            @if($icon)
            <span class="material-symbols-outlined {{ $iconColor }} flex-shrink-0 mt-0.5"
                  style="font-size:20px; font-variation-settings:'FILL' 1;">
                {{ $icon }}
            </span>
            @endif
            <div class="min-w-0">
                <h3 class="text-[15px] font-bold text-on-surface leading-tight truncate">
                    {{ $title }}
                </h3>
                @if($subtitle)
                <p class="text-[11px] text-on-surface-variant font-medium mt-0.5 leading-snug">
                    {{ $subtitle }}
                </p>
                @endif
            </div>
        </div>

        {{-- Action --}}
        @if(isset($action))
            <div class="flex-shrink-0">{{ $action }}</div>
        @elseif($actionText)
            <a href="{{ $actionHref }}"
               class="text-[13px] font-semibold text-primary hover:text-primary-container
                      transition-colors flex-shrink-0 whitespace-nowrap">
                {{ $actionText }}
            </a>
        @endif
    </div>
    @endif

    {{-- Body --}}
    <div class="{{ $bodyPadding }} flex-1">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    @if(isset($footer))
    <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-low flex-shrink-0">
        {{ $footer }}
    </div>
    @endif

</div>
