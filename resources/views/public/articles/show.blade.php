@extends('layouts.public-layout')

@section('title', $article->title . ' - Posyandu Digital')

@section('content')
<article class="max-w-screen-xl mx-auto px-6 md:px-12 py-12 md:py-20">
    
    {{-- ── Breadcrumb (Minimalist) ── --}}
    @include('public.articles.breadcrumb')

    {{-- ── Medium Style Header ── --}}
    @include('public.articles.header')

    {{-- ── Main Hero Image (Large & Rounded) ── --}}
    @include('public.articles.hero-image')

    {{-- ── Article Content (Medium Reading Experience) ── --}}
    <div class="max-w-3xl mx-auto mb-24">
        @include('public.articles.content')

        {{-- ── Tags / Keywords ── --}}
        @include('public.articles.tags')

        {{-- ── Bottom Actions (Medium style claps/shares) ── --}}
        @include('public.articles.bottom-actions')
    </div>
</article>
@endsection
