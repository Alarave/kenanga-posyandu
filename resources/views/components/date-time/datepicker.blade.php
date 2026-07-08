{{--
    Posyandu Datepicker Component
    ──────────────────────────────
    Input tanggal (type="date") dengan styling konsisten design token.

    Props:
        name        — string nama field (required)
        label       — string label input
        value       — string nilai default (format: Y-m-d)
        required    — boolean (default: false)
        disabled    — boolean (default: false)
        placeholder — string placeholder (default: 'Pilih tanggal')
        min         — string tanggal minimum (format: Y-m-d)
        max         — string tanggal maksimum (format: Y-m-d)
        hint        — string teks bantuan di bawah input
        error       — string pesan error (dari $errors->first('name'))
        wireModel   — string wire:model binding (opsional)
        icon        — boolean tampilkan icon kalender (default: true)

    Usage:
        {{-- Basic --}}
        <x-date-time.datepicker name="birth_date" label="Tanggal Lahir" :required="true" />

        {{-- Dengan value --}}
        <x-date-time.datepicker
            name="visit_date"
            label="Tanggal Periksa"
            :value="old('visit_date', date('Y-m-d'))"
            :required="true" />

        {{-- Dengan Livewire --}}
        <x-date-time.datepicker
            name="birth_date"
            label="Tanggal Lahir"
            wire-model="birth_date" />

        {{-- Dengan error --}}
        <x-date-time.datepicker
            name="birth_date"
            label="Tanggal Lahir"
            :error="$errors->first('birth_date')" />
--}}

@props([
    'name'        => '',
    'label'       => '',
    'value'       => '',
    'required'    => false,
    'disabled'    => false,
    'placeholder' => 'Pilih tanggal',
    'min'         => '',
    'max'         => '',
    'hint'        => '',
    'error'       => '',
    'wireModel'   => '',
    'icon'        => true,
])

@php
    $hasError   = !empty($error) || ($name && $errors->has($name));
    $errorMsg   = $error ?: ($name ? $errors->first($name) : '');
    $inputId    = 'datepicker-' . ($name ? str_replace(['[',']','.'], '-', $name) : uniqid());

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

        {{-- Calendar icon --}}
        @if($icon)
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2
                     text-[18px] pointer-events-none
                     {{ $hasError ? 'text-error' : 'text-on-surface-variant' }}">
            calendar_today
        </span>
        @endif

        {{-- Input --}}
        <input
            type="date"
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
