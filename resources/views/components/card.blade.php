<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-outline-variant shadow-sm overflow-hidden']) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-slate-100 bg-surface-container-low/50">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 border-t border-slate-100 bg-surface-container-low/50">
            {{ $footer }}
        </div>
    @endif
</div>
