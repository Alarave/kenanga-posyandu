{{--
    Posyandu Breadcrumb Component
    ──────────────────────────────
    Props:
        items — array of ['label' => string, 'url' => string|null, 'active' => bool]

    Usage:
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Data Warga', 'url' => route('admin.patients.index')],
            ['label' => 'Detail', 'active' => true],
        ]" />
--}}

@props([
    'items' => [],
])

<nav aria-label="Breadcrumb" style="font-family:'Public Sans',sans-serif;">
    <ol class="flex items-center flex-wrap gap-1 text-[12px] font-medium">

        {{-- Home icon always first --}}
        <li class="flex items-center">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors">
                <i class="fas fa-house text-[11px]"></i>
            </a>
        </li>

        @foreach($items as $item)
            {{-- Separator --}}
            <li class="flex items-center text-outline" aria-hidden="true">
                <i class="fas fa-chevron-right text-[9px]"></i>
            </li>

            <li class="flex items-center">
                @if(!empty($item['active']) || empty($item['url']))
                    <span class="text-on-surface font-semibold" aria-current="page">
                        {{ $item['label'] }}
                    </span>
                @else
                    <a href="{{ $item['url'] }}"
                       class="text-on-surface-variant hover:text-primary transition-colors">
                        {{ $item['label'] }}
                    </a>
                @endif
            </li>
        @endforeach

    </ol>
</nav>
