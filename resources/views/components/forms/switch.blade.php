@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'checked' => false,
    'value' => '1',
    'disabled' => false,
])

@php
    $id = $id ?? $name ?? 'switch_' . uniqid();
@endphp

<label class="flex cursor-pointer select-none items-center gap-3 text-sm font-medium {{ $disabled ? 'text-gray-400 cursor-not-allowed opacity-60' : 'text-gray-700 dark:text-gray-400' }}">
    <div class="relative">
        <input 
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $checked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            class="peer sr-only"
        >
        <!-- Background -->
        <div class="block transition duration-150 ease-linear h-6 w-11 rounded-full bg-gray-200 dark:bg-white/10 peer-checked:bg-blue-500 {{ $disabled ? 'bg-gray-100 dark:bg-gray-800' : '' }}"></div>
        <!-- Knob -->
        <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition duration-150 ease-linear transform peer-checked:translate-x-[20px]"></div>
    </div>
    @if($label)
        <span>{{ $label }}</span>
    @endif
</label>
