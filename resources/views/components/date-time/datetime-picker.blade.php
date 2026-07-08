{{--
    Posyandu DateTime Picker Component
    ────────────────────────────────────
    Input tanggal + waktu (type="datetime-local") dengan styling konsisten design token.

    Props:
        name        — string nama field (required)
        label       — string label input
        value       — string nilai default (format: Y-m-d\TH:i  contoh: '2026-04-25T08:00')
        required    — boolean (default: false)
        disabled    — boolean (default: false)
        min         — string datetime minimum (format: Y-m-d\TH:i)
        max         — string datetime maksimum (format: Y-m-d\TH:i)
        hint        — string teks bantuan di bawah input
        error       — string pesan error
        wireModel   — string wire:model binding (opsional)
        icon        — boolean tampilkan icon (default: true)

    Usage:
        {{-- Basic --}}
        <x-date-time.datetime-picker name="start_time" label="Waktu Mulai" :required="true" />

        {{-- Dengan value dari Carbon --}}
        <x-date-time.datetime-picker
            name="published_at"
            label="Tanggal Publikasi"
            :value="old('published_at', $article->published_at
                ? \Carbon\Carbon::parse($article->published_at)->format('Y-m-d\TH:i')
                : '')" />

        {{-- Dengan Livewire --}}
        <x-date-time.datetime-picker
            name="start_time"
            label="Waktu Mulai"
            wire-model="start_time" />
--}}

@props([
    'name'      => '',
    'label'     => '',
    'value'     => '',
    'required'  => false,
    'disabled'  => false,
    'min'       => '',
    'max'       => '',
    'hint'      => '',
    'error'     => '',
    'wireModel' => '',
    'icon'      => true,
])

@php
    $hasError   = !empty($error) || ($name && $errors->has($name));
    $errorMsg   = $error ?: ($name ? $errors->first($name) : '');
    $inputId    = 'datetimepicker-' . ($name ? str_replace(['[',']','.'], '-', $name) : uniqid());

    $baseInput  = 'w-full h-11 rounded-xl border text-[13px] font-medium text-on-surface
                   bg-surface-container-lowest
                   focus:outline-none focus:ring-2 transition-all duration-150
                   disabled:opacity-50 disabled:cursor-not-allowed';

    $stateInput = $hasError
        ? 'border-error focus:border-error focus:ring-error/20'
        : 'border-outline-variant focus:border-primary focus:ring-primary/20 hover:border-outline';

    $paddingInput = $icon ? 'pl-10 pr-4' : 'px-4';
@endphp

<div class="w-full space-y-1.5" style="font-family:'Public Sans', 'Public Sans Fallback', sans-serif;">

    {{-- Label --}}
    @if($label)
    <label for="{{ $inputId }}"
           class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">
        {{ $label }}
        @if($required)
            <span class="text-error ml-0.5">*</span>
        @endif
    </label>
    @endif

    {{-- Input wrapper --}}
    <div class="relative">

        {{-- Clock/schedule icon --}}
        @if($icon)
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2
                     text-[18px] pointer-events-none
                     {{ $hasError ? 'text-error' : 'text-on-surface-variant' }}">
            schedule
        </span>
        @endif

        {{-- Input --}}
        <input
            type="datetime-local"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required)  required @endif
            @if($disabled)  disabled @endif
            @if($min)       min="{{ $min }}" @endif
            @if($max)       max="{{ $max }}" @endif
            @if($wireModel) wire:model="{{ $wireModel }}" @endif
            {{ $attributes->except(['class'])->merge([
                'class' => "$baseInput $stateInput $paddingInput"
            ]) }}
            style="color-scheme: light;"
        />

        {{-- Error icon --}}
        @if($hasError)
        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2
                     text-[18px] text-error pointer-events-none">
            error
        </span>
        @endif

    </div>

    {{-- Hint --}}
    @if($hint && !$hasError)
    <p class="text-[11px] text-on-surface-variant">{{ $hint }}</p>
    @endif

    {{-- Error message --}}
    @if($hasError)
    <p class="text-[11px] text-error flex items-center gap-1">
        <i class="fas fa-circle-exclamation text-[10px]"></i>
        {{ $errorMsg }}
    </p>
    @endif

</div>
