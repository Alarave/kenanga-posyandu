@props([
    'type' => 'text',
    'id' => null,
    'name' => null,
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'success' => false,
    'error' => false,
    'hint' => null,
])

@php
    $id = $id ?? $name;
    $error = $error || ($name && isset($errors) && $errors->has($name));
    
    $baseClasses = 'h-11 w-full rounded-lg border appearance-none px-4 py-2.5 text-sm shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-3 transition duration-150';
    
    if ($disabled) {
        $stateClasses = 'bg-gray-50 text-gray-500 border-gray-300 cursor-not-allowed dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700';
    } elseif ($error) {
        $stateClasses = 'bg-red-50/30 text-red-900 border-error focus:border-error focus:ring-red-500/10 dark:text-red-400 dark:border-error';
    } elseif ($success) {
        $stateClasses = 'bg-green-50/30 text-green-900 border-green-400 focus:border-green-400 focus:ring-green-500/10 dark:text-green-400 dark:border-green-500';
    } else {
        $stateClasses = 'bg-white text-gray-800 border-gray-300 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90';
    }
@endphp

<div class="relative w-full">
    <input 
        type="{{ $type }}" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}" 
        value="{{ $value }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $baseClasses . ' ' . $stateClasses]) }}
    >
    
    @if($hint || ($name && isset($errors) && $errors->has($name)))
        <p class="mt-1.5 text-xs {{ $error ? 'text-red-500' : ($success ? 'text-green-500' : 'text-gray-500') }}">
            {{ $name && isset($errors) && $errors->has($name) ? $errors->first($name) : $hint }}
        </p>
    @endif
</div>