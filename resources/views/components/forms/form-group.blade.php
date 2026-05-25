@props([
    'label' => null,
    'for' => null,
    'required' => false,
])

<div class="space-y-1.5 w-full">
    @if($label)
        <label for="{{ $for }}" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif
    {{ $slot }}
</div>