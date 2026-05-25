@extends('layouts.public-layout')

@section('title', 'Artikel Kesehatan - Posyandu Digital Bekasi Timur')

@section('content')
<div class="max-w-screen-xl mx-auto px-6 md:px-12 py-16">

    {{-- ── Trending Section (Top Header) ── --}}
    @if($featured)
        @include('public.articles.featured')
    @endif

    <div class="flex flex-col lg:flex-row gap-20">
        
        {{-- ── Main Articles Stream (Medium-style List) ── --}}
        @include('public.articles.stream')

        {{-- ── Sidebar (Medium Style Sidebar) ── --}}
        @include('public.articles.sidebar')

    </div>
</div>
@endsection
