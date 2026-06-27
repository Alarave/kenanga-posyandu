{{--
    Posyandu Premium Pagination Component
    ─────────────────────────────────────
    Inspired by Next.js Admin Template "Pagination with Icon"
    Usage:
        <x-layouts.ui.pagination :paginator="$items" />
--}}

@props([
    'paginator',
    'showInfo' => true,
    'simple'   => false,
])

@php
    $hasPages = $paginator->hasPages();
    $total    = $paginator->total();
    $from     = $paginator->firstItem() ?? 0;
    $to       = $paginator->lastItem()  ?? 0;
    $current  = $paginator->currentPage();
    $last     = $paginator->lastPage();

    // Range of pages to display around current
    $window = 2;
    $start  = max(1, $current - $window);
    $end    = min($last, $current + $window);
@endphp

@if($hasPages)
<nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col sm:flex-row items-center justify-between gap-4 py-3">
    {{-- Left: Info --}}
    @if($showInfo && $from)
    <div class="text-sm font-medium text-outline dark:text-outline-variant">
        Menampilkan <span class="text-on-surface dark:text-white font-bold">{{ number_format($from) }}</span>
        -
        <span class="text-on-surface dark:text-white font-bold">{{ number_format($to) }}</span>
        dari
        <span class="text-on-surface dark:text-white font-bold">{{ number_format($total) }}</span> warga
    </div>
    @endif

    {{-- Right: Pagination Controls --}}
    <div class="flex items-center gap-3">
        {{-- Previous Page Button --}}
        @if($paginator->onFirstPage())
            <span class="flex items-center h-10 justify-center rounded-xl border border-outline-variant dark:border-slate-800 bg-surface-container-low dark:bg-inverse-surface/50 px-4 text-outline-variant dark:text-on-surface-variant text-sm font-semibold cursor-not-allowed select-none">
                <span class="material-symbols-outlined text-[20px] mr-1.5">chevron_left</span>
                Previous
            </span>
        @else
            <button wire:click="previousPage" rel="prev" aria-label="Previous Page" class="flex items-center h-10 justify-center rounded-xl border border-outline-variant dark:border-slate-800 bg-white dark:bg-inverse-surface px-4 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-inverse-surface/80 active:scale-95 shadow-sm text-sm font-semibold transition-all cursor-pointer">
                <span class="material-symbols-outlined text-[20px] mr-1.5">chevron_left</span>
                Previous
            </button>
        @endif

        {{-- Page Numbers --}}
        @if(!$simple)
            <div class="flex items-center gap-1.5">
                {{-- First Page --}}
                @if($start > 1)
                    <button wire:click="gotoPage(1)" aria-label="Go to page 1" class="flex items-center justify-center w-10 h-10 rounded-xl text-sm font-semibold text-on-surface-variant dark:text-outline-variant hover:bg-surface-container dark:hover:bg-inverse-surface/80 hover:text-primary transition-all">
                        1
                    </button>
                    @if($start > 2)
                        <span class="flex items-center justify-center w-10 h-10 text-outline-variant dark:text-on-surface-variant text-sm select-none">...</span>
                    @endif
                @endif

                {{-- Page List --}}
                @foreach(range($start, $end) as $page)
                    @if($page === $current)
                        <span aria-current="page" class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary text-white text-sm font-bold shadow-lg shadow-teal-500/20 select-none">
                            {{ $page }}
                        </span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" aria-label="Go to page {{ $page }}" class="flex items-center justify-center w-10 h-10 rounded-xl text-sm font-semibold text-on-surface-variant dark:text-outline-variant hover:bg-surface-container dark:hover:bg-inverse-surface/80 hover:text-primary transition-all">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach

                {{-- Last Page --}}
                @if($end < $last)
                    @if($end < $last - 1)
                        <span class="flex items-center justify-center w-10 h-10 text-outline-variant dark:text-on-surface-variant text-sm select-none">...</span>
                    @endif
                    <button wire:click="gotoPage({{ $last }})" aria-label="Go to page {{ $last }}" class="flex items-center justify-center w-10 h-10 rounded-xl text-sm font-semibold text-on-surface-variant dark:text-outline-variant hover:bg-surface-container dark:hover:bg-inverse-surface/80 hover:text-primary transition-all">
                        {{ $last }}
                    </button>
                @endif
            </div>
        @endif

        {{-- Next Page Button --}}
        @if($paginator->hasMorePages())
            <button wire:click="nextPage" rel="next" aria-label="Next Page" class="flex items-center h-10 justify-center rounded-xl border border-outline-variant dark:border-slate-800 bg-white dark:bg-inverse-surface px-4 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-inverse-surface/80 active:scale-95 shadow-sm text-sm font-semibold transition-all cursor-pointer">
                Next
                <span class="material-symbols-outlined text-[20px] ml-1.5">chevron_right</span>
            </button>
        @else
            <span class="flex items-center h-10 justify-center rounded-xl border border-outline-variant dark:border-slate-800 bg-surface-container-low dark:bg-inverse-surface/50 px-4 text-outline-variant dark:text-on-surface-variant text-sm font-semibold cursor-not-allowed select-none">
                Next
                <span class="material-symbols-outlined text-[20px] ml-1.5">chevron_right</span>
            </span>
        @endif
    </div>
</nav>
@endif
