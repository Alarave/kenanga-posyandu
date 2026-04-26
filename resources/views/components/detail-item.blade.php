@props(['label'])

<div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 last:border-0 hover:bg-gray-50 transition duration-150 ease-in-out">
    <dt class="text-sm font-medium text-gray-500">
        {{ $label }}
    </dt>
    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium">
        {{ $slot }}
    </dd>
</div>
