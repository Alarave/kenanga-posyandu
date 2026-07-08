{{--
    Posyandu Card Component
    ───────────────────────
    Props:
        padding  — 'none' | 'sm' | 'md' | 'lg'  (default: 'md')
        shadow   — 'none' | 'sm' | 'md'          (default: 'sm')
        border   — boolean                        (default: true)

    Usage:
        <x-card>konten</x-card>
        <x-card padding="lg" shadow="md">konten</x-card>
        <x-card padding="none">konten dengan padding sendiri</x-card>
--}}

@props([
    'padding' => 'md',
    'shadow'  => 'sm',
    'border'  => true,
])

@php
    $paddingClass = match($padding) {
        'none' => '',
        'sm'   => 'p-4',
        'lg'   => 'p-8',
        default => 'p-6',   // md
    };

    $shadowClass = match($shadow) {
        'none' => '',
        'md'   => 'shadow-md',
        default => 'shadow-sm',
    };

    $borderClass = $border ? 'border border-outline-variant' : '';
@endphp

<div {{ $attributes->merge([
    'class' => "bg-surface-container-lowest rounded-xl $paddingClass $shadowClass $borderClass"
]) }}
     style="font-family:'Public Sans', 'Public Sans Fallback', sans-serif;">
    {{ $slot }}
</div>
