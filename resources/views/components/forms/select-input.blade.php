@props([
    'placeholder' => 'Pilih opsi',
    'id' => null,
    'name' => null,
    'value' => '',
    'required' => false,
    'disabled' => false,
    'error' => false,
    'placeholderDisabled' => true,
])

@php
    $id = $id ?? $name;
    $error = $error || ($name && isset($errors) && $errors->has($name));
    
    $baseClasses = 'h-11 w-full appearance-none rounded-xl border px-4 py-2.5 pr-11 text-sm shadow-xs focus:outline-none focus:ring-4 transition-all duration-300 cursor-pointer';
    
    if ($disabled) {
        $stateClasses = 'bg-slate-50 text-slate-400 border-slate-200 cursor-not-allowed dark:bg-slate-800 dark:text-slate-500 dark:border-slate-700';
    } elseif ($error) {
        $stateClasses = 'bg-red-50/10 text-red-900 border-red-400 focus:border-red-500 focus:ring-red-500/10 dark:bg-red-950/10 dark:text-red-400 dark:border-red-500/50';
    } else {
        $stateClasses = 'bg-white text-slate-800 border-slate-200 focus:border-primary focus:ring-primary/10 dark:border-slate-800 dark:bg-slate-900 dark:text-white/90';
    }
@endphp

<div class="relative w-full">
    <select 
        id="{{ $id }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $baseClasses . ' ' . $stateClasses]) }}
    >
        @if($placeholder)
            <option value="" {{ $placeholderDisabled ? 'disabled' : '' }} {{ empty($value) ? 'selected' : '' }}>
                {{ $placeholder }}
            </option>
        @endif
        {{ $slot }}
    </select>
    
    <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 dark:text-slate-500">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"></path>
        </svg>
    </div>
</div>