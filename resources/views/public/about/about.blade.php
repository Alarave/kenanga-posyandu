@extends('layouts.public-layout')

@section('title', 'Tentang Kami - Posyandu ILP Kenanga RW 011')

@section('content')
<div class="bg-slate-50 dark:bg-gray-950 min-h-screen">
    
    {{-- ── 1. HERO SECTION ── --}}
    @include('public.about.hero')

    {{-- ── 2. STATS SECTION (METRIC COUNTERS) ── --}}
    @include('public.about.stats')

    {{-- ── 3. SAMBUTAN / WELCOME CARD ── --}}
    @include('public.about.welcome')

    {{-- ── 4. VISI & MISI SECTION ── --}}
    @include('public.about.visi-misi')

    {{-- ── 5. TUJUAN STRATEGIS ── --}}
    @include('public.about.tujuan')

    {{-- ── 6. BIODATA KADER POSYANDU ── --}}
    @include('public.about.tim')

    {{-- ── C. DETAIL MODAL DIALOG ── --}}
    @include('public.about.modal')

    {{-- ── 7. CALL TO ACTION SECTION ── --}}
    @include('public.about.cta')

</div>
@endsection
