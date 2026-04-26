@props(['title'])

<div class="mb-4">
    @if(isset($title))
    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2 px-4 pt-3">
        {{ $title }}
    </h4>
    @endif
    <dl class="divide-y divide-gray-100 border border-gray-200 rounded-lg overflow-hidden">
        {{ $slot }}
    </dl>
</div>
