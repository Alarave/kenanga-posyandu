@props([
    'src' => null,
    'alt' => 'User Avatar',
    'size' => 'medium',
    'status' => 'none',
    'name' => null,
])

@php
    $sizeClasses = [
        'xsmall'  => 'h-6 w-6 min-w-6 max-w-6',
        'small'   => 'h-8 w-8 min-w-8 max-w-8',
        'medium'  => 'h-10 w-10 min-w-10 max-w-10',
        'large'   => 'h-12 w-12 min-w-12 max-w-12',
        'xlarge'  => 'h-14 w-14 min-w-14 max-w-14',
        'xxlarge' => 'h-16 w-16 min-w-16 max-w-16',
    ];

    $fontSizeClasses = [
        'xsmall'  => 'text-[9px]',
        'small'   => 'text-[11px]',
        'medium'  => 'text-[13px]',
        'large'   => 'text-[15px]',
        'xlarge'  => 'text-[18px]',
        'xxlarge' => 'text-[20px]',
    ];

    $statusSizeClasses = [
        'xsmall'  => 'h-1.5 w-1.5 max-w-1.5',
        'small'   => 'h-2 w-2 max-w-2',
        'medium'  => 'h-2.5 w-2.5 max-w-2.5',
        'large'   => 'h-3 w-3 max-w-3',
        'xlarge'  => 'h-3.5 w-3.5 max-w-3.5',
        'xxlarge' => 'h-4 w-4 max-w-4',
    ];

    $statusColorClasses = [
        'online'  => 'bg-emerald-500',
        'offline' => 'bg-slate-400',
        'busy'    => 'bg-rose-500',
    ];

    $containerClass = $sizeClasses[$size] ?? $sizeClasses['medium'];
    $fontSizeClass = $fontSizeClasses[$size] ?? $fontSizeClasses['medium'];
    $statusSizeClass = $statusSizeClasses[$size] ?? $statusSizeClasses['medium'];
    $statusColorClass = $statusColorClasses[$status] ?? '';

    // Generate initials (1-2 letters)
    $initials = 'A';
    if ($name) {
        $words = explode(' ', preg_replace('/\s+/', ' ', trim($name)));
        if (count($words) >= 2) {
            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $initials = strtoupper(substr($words[0] ?? 'A', 0, 2));
        }
    }
@endphp

<div class="relative rounded-full flex-shrink-0 {{ $containerClass }}">
    @if($src)
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            class="object-cover w-full h-full rounded-full shadow-inner border border-slate-100 dark:border-slate-800"
            loading="lazy"
        />
    @else
        <div class="w-full h-full rounded-full flex items-center justify-center text-white font-black shadow-sm select-none {{ $fontSizeClass }}"
             style="background: linear-gradient(135deg, #1e293b 0%, #475569 100%);">
            {{ $initials }}
        </div>
    @endif

    {{-- Status Indicator --}}
    @if($status !== 'none' && isset($statusColorClasses[$status]))
        <span class="absolute bottom-0 right-0 flex {{ $statusSizeClass }}">
            {{-- Pulsating effect for Online status --}}
            @if($status === 'online')
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            @endif
            {{-- Solid indicator dot --}}
            <span class="relative inline-flex rounded-full border-[1.5px] border-white dark:border-slate-900 w-full h-full {{ $statusColorClass }}"></span>
        </span>
    @endif
</div>
