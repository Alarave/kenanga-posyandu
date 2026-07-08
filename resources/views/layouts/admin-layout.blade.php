@extends('layouts.app')

@section('content')
<div class="w-full pt-1 sm:pt-4 pb-8">
    <!-- Admin Header -->
    @hasSection('admin-title')
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 w-full pb-4 border-b border-slate-100">
            <div class="flex-1 min-w-0 w-full">
                @php
                    $title = View::getSection('admin-title');
                    $isHtml = strip_tags($title) !== $title;
                @endphp
                @if($isHtml)
                    @yield('admin-title')
                @else
                    <h1 class="text-xl font-black text-slate-800 tracking-tight">@yield('admin-title')</h1>
                @endif
            </div>
            
            @hasSection('admin-actions')
                <div class="flex flex-wrap gap-2 items-center justify-start sm:justify-end shrink-0 w-full sm:w-auto">
                    @yield('admin-actions')
                </div>
            @endif
        </div>
    @endif
    
    <!-- Admin Content -->
    <div class="w-full">
        @if(isset($slot) && ! is_array($slot))
            {{ $slot }}
        @else
            @yield('admin-content')
        @endif
    </div>
</div>
@endsection

@push('scripts')
{{-- Admin specific scripts can go here --}}
@endpush