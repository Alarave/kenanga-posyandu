@props(['type' => 'info', 'message' => ''])

<div class="mb-6 p-4 rounded-lg border-l-4 shadow-sm animate-fade-in-down" 
     class="{{ $type === 'success' ? 'bg-green-50 border-green-500 text-green-700' : '' }}
            {{ $type === 'error' ? 'bg-red-50 border-error text-red-700' : '' }}
            {{ $type === 'warning' ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : '' }}
            {{ $type === 'info' ? 'bg-blue-50 border-blue-500 text-blue-700' : '' }}">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            @if($type === 'success') <i class="fas fa-check-circle"></i>
            @elseif($type === 'error') <i class="fas fa-exclamation-circle"></i>
            @elseif($type === 'warning') <i class="fas fa-exclamation-triangle"></i>
            @else <i class="fas fa-info-circle"></i>
            @endif
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium">{{ $message }}</p>
        </div>
    </div>
</div>