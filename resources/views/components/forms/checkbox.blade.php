@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'checked' => false,
    'value' => '1',
    'disabled' => false,
])

@php
    $id = $id ?? $name ?? 'checkbox_' . uniqid();
@endphp

<label class="flex items-center space-x-3 group cursor-pointer {{ $disabled ? 'cursor-not-allowed opacity-60' : '' }}">
    <div class="relative w-5 h-5 flex items-center justify-center">
        <input 
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $checked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => 'peer w-5 h-5 appearance-none cursor-pointer border border-gray-300 dark:border-gray-700 checked:border-transparent rounded-md checked:bg-blue-500 disabled:opacity-60 transition duration-150 focus:ring-2 focus:ring-blue-500/10 focus:outline-none']) }}
        >
        <svg class="absolute pointer-events-none w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" fill="none">
            <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    
    @if($label)
        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
            {{ $label }}
        </span>
    @endif
</label>