@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'icon' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center font-bold transition-all active:scale-95 disabled:opacity-50 disabled:pointer-events-none min-h-[44px] min-w-[44px]';
    
    $variants = [
        'primary' => 'bg-primary text-on-primary hover:opacity-90 shadow-sm',
        'secondary' => 'bg-transparent border border-secondary text-secondary hover:bg-secondary-container hover:text-on-secondary-container shadow-sm',
        'outline' => 'bg-transparent border border-outline-variant text-on-surface-variant hover:bg-surface-container-low',
        'danger' => 'bg-error text-on-error hover:opacity-90 shadow-sm',
        'ghost' => 'bg-transparent text-on-surface-variant hover:bg-surface-container',
    ];
    
    $sizes = [
        'xs' => 'px-3 py-2 text-label-sm rounded-md',
        'sm' => 'px-4 py-2.5 text-label-md rounded-md',
        'md' => 'px-6 py-3 text-label-md rounded-lg',
        'lg' => 'px-8 py-4 text-body-lg rounded-lg',
    ];
    
    $classes = "{$baseClasses} {$variants[$variant]} {$sizes[$size]}";
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }} role="button" aria-label="{{ $slot }}">
        @if($icon)
            <span class="material-symbols-outlined mr-2" style="font-size: 1.25em;">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="material-symbols-outlined mr-2" style="font-size: 1.25em;">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </button>
@endif
