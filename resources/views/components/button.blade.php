@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'icon' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center font-bold transition-all active:scale-95 disabled:opacity-50 disabled:pointer-events-none';
    
    $variants = [
        'primary' => 'bg-teal-600 text-white hover:bg-teal-700 shadow-sm',
        'secondary' => 'bg-slate-800 text-white hover:bg-slate-900 shadow-sm',
        'outline' => 'bg-transparent border border-slate-300 text-slate-700 hover:bg-slate-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100',
    ];
    
    $sizes = [
        'xs' => 'px-2 py-1 text-[10px] rounded-lg h-7',
        'sm' => 'px-3 py-1.5 text-xs rounded-lg h-9',
        'md' => 'px-5 py-2.5 text-sm rounded-xl h-11',
        'lg' => 'px-6 py-3 text-base rounded-2xl h-14',
    ];
    
    $classes = "{$baseClasses} {$variants[$variant]} {$sizes[$size]}";
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
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
