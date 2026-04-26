@extends('layouts.public-layout')

@section('title', 'Beranda - Posyandu Digital')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 relative">

    {{-- ── DECORATIVE FLOATING ELEMENTS ── --}}
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-primary/5 rounded-full blur-[80px] floating"></div>
    <div class="absolute top-1/2 -right-40 w-96 h-96 bg-primary/10 rounded-full blur-[100px] floating delay-2"></div>

    {{-- ── HERO SECTION ── --}}
    <div class="relative min-h-[600px] flex items-center mb-32 rounded-[3.5rem] overflow-hidden group shadow-[0_40px_100px_-20px_rgba(0,104,95,0.2)] bg-on-surface">
        {{-- Background Image with Parallax-like effect --}}
        <img src="https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=2070&auto=format&fit=crop" 
             alt="Posyandu" 
             class="absolute inset-0 w-full h-full object-cover opacity-40 scale-105 group-hover:scale-100 transition-transform duration-[4s]">
        
        <div class="absolute inset-0 bg-gradient-to-tr from-on-surface via-on-surface/40 to-transparent"></div>
        
        <div class="relative z-10 px-10 md:px-24 py-20 w-full">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-3 px-6 py-2 bg-primary/20 backdrop-blur-md rounded-full mb-8 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Era Baru Kesehatan Masyarakat</span>
                </div>
                
                <h1 class="text-5xl md:text-8xl font-black text-white mb-8 leading-[1] tracking-tight font-jakarta">
                    Digitalisasi <br> <span class="text-primary italic">Posyandu.</span>
                </h1>
                
                <p class="text-white/70 text-lg md:text-xl font-medium max-w-2xl leading-relaxed mb-12 italic">
                    Transformasi layanan kesehatan dasar melalui data yang terintegrasi. Memantau pertumbuhan anak dan kesehatan lansia menjadi lebih mudah, cepat, dan akurat.
                </p>
                
                <div class="flex flex-wrap gap-6 items-center">
                    <a href="{{ route('public.articles.index') }}" 
                       class="btn-premium group flex items-center gap-4 px-12 py-5 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-full shadow-2xl shadow-primary/40 hover:scale-105 active:scale-95 transition-all">
                        Baca Artikel 
                        <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                    
                    <a href="{{ route('public.about') }}" 
                       class="px-12 py-5 bg-white/5 backdrop-blur-md text-white text-xs font-black uppercase tracking-widest rounded-full border border-white/20 hover:bg-white/10 transition-all">
                        Kenali Kami
                    </a>
                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-12 flex flex-col items-center gap-4 animate-bounce">
            <div class="w-[1px] h-10 bg-white/20"></div>
            <span class="text-[9px] font-black text-white/40 uppercase tracking-[0.5em] vertical-text">Scroll</span>
        </div>
    </div>

    {{-- ── JADWAL (BENTO LAYOUT) ── --}}
    <section id="jadwal" class="mb-32">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 px-4 md:px-0">
            <div class="max-w-2xl">
                <h6 class="text-primary font-black text-[10px] uppercase tracking-[0.4em] mb-4">Agenda Terdekat</h6>
                <h2 class="text-4xl md:text-6xl font-black text-on-surface leading-[1.1] tracking-tight font-jakarta">
                    Jadwal Kegiatan <br> <span class="text-primary/40 italic">Posyandu Kita.</span>
                </h2>
            </div>
            <p class="text-on-surface-variant font-medium text-sm md:text-right max-w-[280px]">
                Pastikan Anda tidak melewatkan jadwal pelayanan kesehatan di wilayah Anda.
            </p>
        </div>

        @if($schedules->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                @foreach($schedules as $index => $schedule)
                    <div class="bento-card relative overflow-hidden group {{ $index === 0 ? 'md:col-span-7 aspect-[16/9]' : 'md:col-span-5' }}">
                        {{-- Decorative background icon --}}
                        <span class="material-symbols-outlined absolute -right-4 -top-4 text-primary/[0.03] text-[180px] group-hover:scale-110 transition-transform duration-700 pointer-events-none">calendar_month</span>

                        <div class="p-10 flex flex-col h-full relative z-10">
                            <div class="flex items-center justify-between mb-auto">
                                <div class="w-16 h-16 bg-surface-container rounded-[1.5rem] flex items-center justify-center text-primary shadow-sm">
                                    <span class="material-symbols-outlined text-[32px]">event_repeat</span>
                                </div>
                                <span class="px-4 py-1.5 bg-primary text-white text-[10px] font-black rounded-lg uppercase tracking-widest">
                                    Akan Datang
                                </span>
                            </div>

                            <div class="mt-12">
                                <h3 class="text-2xl font-black text-on-surface mb-4 leading-tight group-hover:text-primary transition-colors italic">
                                    {{ $schedule->title }}
                                </h3>
                                <p class="text-on-surface-variant text-[13px] font-medium leading-relaxed mb-10 max-w-md line-clamp-2">
                                    {{ $schedule->description ?? 'Kegiatan pemeriksaan rutin dan edukasi kesehatan untuk warga.' }}
                                </p>

                                <div class="flex flex-wrap items-center gap-10 border-t border-outline-variant/30 pt-8">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary text-[20px]">schedule</span>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-outline uppercase">Waktu</span>
                                            <span class="text-xs font-bold text-on-surface">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary text-[20px]">location_on</span>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-outline uppercase">Lokasi</span>
                                            <span class="text-xs font-bold text-on-surface">{{ $schedule->location ?? 'Balai RW' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-[4rem] border-2 border-dashed border-outline-variant/50 p-24 text-center">
                <span class="material-symbols-outlined text-[80px] text-outline-variant/50 mb-6">event_busy</span>
                <h3 class="text-2xl font-black text-on-surface/40 italic">Saat ini belum ada jadwal terbaru.</h3>
            </div>
        @endif
    </section>

    {{-- ── ARTIKEL (PREMIUM CARDS) ── --}}
    <section class="mb-40">
        <div class="flex items-center justify-between mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-on-surface font-jakarta uppercase tracking-tight">Kesehatan & <span class="text-primary italic">Wawasan.</span></h2>
            <a href="{{ route('public.articles.index') }}" class="group flex items-center gap-3 text-xs font-black text-primary uppercase tracking-[0.2em] hover:opacity-70 transition-all">
                Semua Artikel
                <span class="w-10 h-10 rounded-full border border-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($articles as $article)
            <article class="group relative bg-white border border-outline-variant rounded-[3rem] transition-all duration-500 hover:-translate-y-4 hover:shadow-[0_40px_80px_-20px_rgba(0,104,95,0.15)] overflow-hidden">
                <a href="{{ route('public.articles.show', $article->slug) }}" class="block aspect-video overflow-hidden">
                    <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=2070&auto=format&fit=crop' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                </a>
                
                <div class="p-10">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="px-4 py-1 bg-surface-container text-primary text-[9px] font-black rounded-full uppercase tracking-widest">
                            {{ $article->category->name ?? 'Update' }}
                        </span>
                        <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
                        <span class="text-[9px] font-black text-outline uppercase tracking-widest">{{ \Carbon\Carbon::parse($article->published_at)->format('d M') }}</span>
                    </div>

                    <h3 class="text-xl font-black text-on-surface mb-6 leading-tight group-hover:text-primary transition-colors line-clamp-2 font-jakarta">
                        <a href="{{ route('public.articles.show', $article->slug) }}">{{ $article->title }}</a>
                    </h3>

                    <div class="flex items-center justify-between mt-auto pt-8 border-t border-outline-variant/30">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-[10px] font-black text-primary">
                                {{ strtoupper(substr($article->user->name ?? 'A', 0, 2)) }}
                            </div>
                            <span class="text-[11px] font-bold text-on-surface-variant uppercase tracking-tighter">{{ $article->user->name ?? 'Admin' }}</span>
                        </div>
                        <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">read_more</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </section>

    {{-- ── CTA (DYNAMIC CAROUSEL-STYLE) ── --}}
    <div class="relative rounded-[4rem] bg-on-surface overflow-hidden p-16 md:p-32 text-center group shadow-2xl mb-24">
        {{-- Background shapes --}}
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-primary/20 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute -left-10 -top-10 w-64 h-64 bg-primary/10 rounded-full blur-[80px]"></div>

        <div class="relative z-10">
            <h2 class="text-4xl md:text-7xl font-black text-white mb-10 tracking-tight leading-[1] font-jakarta">
                Membangun <span class="text-primary italic">Masa Depan</span> <br> Bersama Kami.
            </h2>
            <p class="text-white/60 text-lg md:text-xl font-medium mb-16 max-w-2xl mx-auto italic">
                Mari bersama kita wujudkan masyarakat yang sehat dan cerdas melalui data yang akurat.
            </p>
            <div class="flex flex-wrap justify-center gap-8">
                <a href="{{ route('public.contact') }}" class="btn-premium px-16 py-6 bg-primary text-white text-xs font-black uppercase tracking-[0.2em] rounded-full shadow-2xl shadow-primary/40 active:scale-95 transition-all">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .vertical-text { writing-mode: vertical-rl; text-orientation: mixed; }
</style>
@endsection
