{{--
    Posyandu Button Component
    ─────────────────────────
    Props:
        variant  — 'primary' | 'secondary' | 'outline' | 'ghost' | 'danger' | 'warning'
                   default: 'primary'
        size     — 'sm' | 'md' | 'lg'
                   default: 'md'
        type     — 'button' | 'submit' | 'reset'
                   default: 'button'
        href     — jika diisi, render sebagai <a> bukan <button>
        icon     — nama icon Font Awesome (tanpa 'fa-') atau Material Symbols
                   contoh: icon="save"  icon="trash"  icon="check"
        iconPos  — 'left' | 'right'  (default: 'left')
        disabled — boolean (default: false)

    Usage:
        <x-layouts.ui.button variant="primary" icon="save">Simpan</x-layouts.ui.button>
        <x-layouts.ui.button variant="danger"  icon="trash" type="submit">Hapus</x-layouts.ui.button>
        <x-layouts.ui.button variant="outline" href="{{ route('dashboard') }}">Kembali</x-layouts.ui.button>
        <x-button variant="secondary" size="sm">Tambah</x-button>
--}}

@props([
    'variant'  => 'primary',
    'size'     => 'md',
    'type'     => 'button',
    'href'     => null,
    'icon'     => null,
    'iconPos'  => 'left',
    'disabled' => false,
])

@php
    // ── Size classes ──────────────────────────────────────────────────
    $sizeClass = match($size) {
        'sm'    => 'h-9  px-5 text-[14px] gap-2 rounded-lg',
        'lg'    => 'h-14 px-8   text-[18px] gap-3 rounded-xl border-2',
        default => 'h-11 px-6   text-[15.5px] gap-2.5 rounded-xl',   // md
    };

    // ── Variant classes ───────────────────────────────────────────────
    $variantClass = match($variant) {
        // Filled — primary teal
        'primary'   => 'bg-primary text-on-primary border border-primary
                        hover:bg-primary-container hover:border-primary-container
                        focus-visible:ring-2 focus-visible:ring-primary/40
                        active:scale-[.97] shadow-sm',

        // Filled — secondary blue
        'secondary' => 'bg-secondary text-on-secondary border border-secondary
                        hover:opacity-90
                        focus-visible:ring-2 focus-visible:ring-secondary/40
                        active:scale-[.97] shadow-sm',

        // Outlined
        'outline'   => 'bg-surface-container-lowest text-on-surface border border-outline-variant
                        hover:bg-surface-container hover:border-outline
                        focus-visible:ring-2 focus-visible:ring-primary/30
                        active:scale-[.97]',

        // Ghost / text
        'ghost'     => 'bg-transparent text-on-surface-variant border border-transparent
                        hover:bg-surface-container hover:text-on-surface
                        focus-visible:ring-2 focus-visible:ring-primary/30
                        active:scale-[.97]',

        // Danger / destructive
        'danger'    => 'bg-error text-on-error border border-error
                        hover:opacity-90
                        focus-visible:ring-2 focus-visible:ring-error/40
                        active:scale-[.97] shadow-sm',

        // Warning
        'warning'   => 'bg-status-warning text-white border border-status-warning
                        hover:opacity-90
                        focus-visible:ring-2 focus-visible:ring-status-warning/40
                        active:scale-[.97] shadow-sm',

        default     => 'bg-primary text-on-primary border border-primary
                        hover:bg-primary-container
                        active:scale-[.97] shadow-sm',
    };

    // ── Disabled state ────────────────────────────────────────────────
    $disabledClass = $disabled
        ? 'opacity-40 cursor-not-allowed pointer-events-none'
        : '';

    // ── Base classes ──────────────────────────────────────────────────
    $base = 'inline-flex items-center justify-center font-semibold
             whitespace-nowrap select-none
             transition-all duration-150
             focus:outline-none focus-visible:outline-none
             min-h-[touch-target]';

    // ── Icon rendering ────────────────────────────────────────────────
    // Deteksi apakah icon adalah Material Symbols (mengandung underscore atau lebih dari 1 kata)
    // atau Font Awesome (pendek, satu kata)
    $isMaterial = $icon && (str_contains($icon, '_') || in_array($icon, [
        'save','check','add','edit','delete','search','close','menu',
        'arrow_back','arrow_forward','chevron_right','chevron_left',
        'download','upload','refresh','settings','person','group',
        'calendar_today','note_add','calendar_add_on','person_add',
        'health_and_safety','favorite','home','info','warning',
        'visibility','visibility_off','lock','lock_open',
    ]));

    $iconHtml = '';
    if ($icon) {
        $iconSize = match($size) {
            'sm'    => 'text-[16px]',
            'lg'    => 'text-[24px]',
            default => 'text-[18px]',
        };

        if ($isMaterial) {
            $iconHtml = '<span class="material-symbols-outlined ' . $iconSize . ' leading-none">' . e($icon) . '</span>';
        } else {
            // Font Awesome — map nama pendek ke class FA
            $faMap = [
                'save'       => 'fa-floppy-disk',
                'trash'      => 'fa-trash',
                'check'      => 'fa-check',
                'pencil'     => 'fa-pencil',
                'edit'       => 'fa-pen',
                'add'        => 'fa-plus',
                'plus'       => 'fa-plus',
                'arrow-left' => 'fa-arrow-left',
                'arrow-right'=> 'fa-arrow-right',
                'download'   => 'fa-download',
                'upload'     => 'fa-upload',
                'search'     => 'fa-magnifying-glass',
                'close'      => 'fa-xmark',
                'refresh'    => 'fa-rotate-right',
                'eye'        => 'fa-eye',
                'lock'       => 'fa-lock',
            ];
            $faClass = $faMap[$icon] ?? ('fa-' . $icon);
            $iconHtml = '<i class="fas ' . e($faClass) . ' ' . $iconSize . ' leading-none"></i>';
        }
    }

    $allClasses = trim("$base $sizeClass $variantClass $disabledClass");
@endphp

@if($href)
    {{-- Render as <a> --}}
    <a
        href="{{ $disabled ? '#' : $href }}"
        {{ $attributes->merge(['class' => $allClasses]) }}
        @if($disabled) aria-disabled="true" tabindex="-1" @endif
        style="font-family:'Public Sans',sans-serif;"
    >
        @if($icon && $iconPos === 'left')
            {!! $iconHtml !!}
        @endif

        {{ $slot }}

        @if($icon && $iconPos === 'right')
            {!! $iconHtml !!}
        @endif
    </a>
@else
    {{-- Render as <button> --}}
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $allClasses]) }}
        @if($disabled) disabled aria-disabled="true" @endif
        style="font-family:'Public Sans',sans-serif;"
    >
        @if($icon && $iconPos === 'left')
            {!! $iconHtml !!}
        @endif

        {{ $slot }}

        @if($icon && $iconPos === 'right')
            {!! $iconHtml !!}
        @endif
    </button>
@endif
