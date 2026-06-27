<div class="mb-6 flex items-center justify-between">
    <nav class="flex text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-secondary">Dashboard</a>
        @if(request()->path() !== 'dashboard')
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium capitalize">{{ str_replace('-', ' ', request()->segment(2)) }}</span>
        @endif
    </nav>
    <div class="text-sm text-gray-400">
        {{ now()->format('d F Y') }}
    </div>
</div>