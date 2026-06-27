@props(['message' => null, 'field' => null])

<div 
    @if($message) 
        role="alert" 
        aria-live="polite"
        class="mt-1 text-sm text-error font-medium flex items-center gap-1"
    @endif
>
    @if($message)
        <span class="material-symbols-outlined text-xs">error</span>
        {{ $message }}
    @elseif($field && $errors->has($field))
        <span class="material-symbols-outlined text-xs">error</span>
        <span>{{ $errors->first($field) }}</span>
    @endif
</div>