{{--
    Posyandu Progress Bar Component
    ─────────────────────────────────
    Props:
        value   — int 0–100 (persentase)
        label   — string label opsional
        color   — 'primary' | 'success' | 'warning' | 'error' | 'secondary'
                  (default: 'primary')
        size    — 'sm' | 'md' | 'lg'  (default: 'md')
        showPct — boolean tampilkan angka persen (default: true)

    Usage:
        <x-progress-bar :value="75" label="Cakupan Vitamin A" />
        <x-progress-bar :value="45" color="warning" size="sm" :showPct="false" />
--}}

@props([
    'value'   => 0,
    'label'   => '',
    'color'   => 'primary',
    'size'    => 'md',
    'showPct' => true,
])

@php
    $pct = max(0, min(100, (int) $value));

    $barColor = match($color) {
        'success'   => 'bg-status-normal',
        'warning'   => 'bg-status-warning',
        'error'     => 'bg-error',
        'secondary' => 'bg-secondary',
        default     => 'bg-primary',
    };

    $trackColor = match($color) {
        'success'   => 'bg-emerald-100',
        'warning'   => 'bg-amber-100',
        'error'     => 'bg-red-100',
        'secondary' => 'bg-blue-100',
        default     => 'bg-primary/15',
    };

    $height = match($size) {
        'sm' => 'h-1.5',
        'lg' => 'h-4',
        default => 'h-2.5',
    };
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}
     style="font-family:'Public Sans',sans-serif;">

    {{-- Label row --}}
    @if($label || $showPct)
    <div class="flex items-center justify-between mb-1.5">
        @if($label)
            <span class="text-[12px] font-semibold text-on-surface-variant">{{ $label }}</span>
        @endif
        @if($showPct)
            <span class="text-[12px] font-bold text-on-surface ml-auto">{{ $pct }}%</span>
        @endif
    </div>
    @endif

    {{-- Track --}}
    <div class="w-full {{ $trackColor }} {{ $height }} rounded-full overflow-hidden"
         role="progressbar"
         aria-valuenow="{{ $pct }}"
         aria-valuemin="0"
         aria-valuemax="100"
         @if($label) aria-label="{{ $label }}" @endif>
        {{-- Fill --}}
        <div class="{{ $barColor }} {{ $height }} rounded-full transition-all duration-500 ease-out"
             style="width: {{ $pct }}%">
        </div>
    </div>

</div>
