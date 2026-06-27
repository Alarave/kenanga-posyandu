@extends('layouts.public-layout')

@section('title', $article->title . ' - Posyandu Digital')

@section('content')
<article class="max-w-screen-xl mx-auto px-6 md:px-12 py-12 md:py-20">
    
    {{-- ── Breadcrumb ── --}}
    <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-outline-variant mb-12">
        <a href="{{ route('public.articles.index') }}" class="hover:text-secondary transition-colors">Artikel</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-slate-300 truncate max-w-[200px]">{{ $article->title }}</span>
    </nav>

    {{-- ── Header ── --}}
    <header class="max-w-4xl mx-auto mb-16">
        <div class="mb-8">
            <span class="inline-block px-4 py-1 bg-surface-container text-on-surface-variant text-[10px] font-black rounded-lg uppercase tracking-widest">
                {{ $article->category->name ?? 'Informasi Kesehatan' }}
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-black text-on-surface leading-tight tracking-tight mb-10"
            style="font-family: 'Georgia', 'Times New Roman', serif;">
            {{ $article->title }}
        </h1>

        <div class="flex items-center justify-between py-8 border-y border-slate-100">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-lg bg-secondary flex items-center justify-center text-white text-headline-sm font-black shadow-lg shadow-indigo-200">
                    {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-[15px] font-black text-on-surface tracking-tight">{{ $article->user->name ?? 'Tim Redaksi' }}</h4>
                    </div>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[12px] text-outline-variant font-medium italic">{{ ceil(str_word_count(\App\Services\ArticleService::getExcerpt($article->content, 999999)) / 200) }} mnt baca</span>
                        <span class="w-1 h-1 rounded-lg bg-surface-container-high"></span>
                        <span class="text-[12px] text-outline-variant font-medium">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-3">
                <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-100 text-outline-variant hover:text-secondary hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-[20px]">share</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-100 text-outline-variant hover:text-red-500 hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-[20px]">bookmark</span>
                </button>
            </div>
        </div>
    </header>

    {{-- ── Hero Cover Image (selalu tampil) ── --}}
    @if($article->thumbnail)
    <div class="max-w-3xl mx-auto aspect-[16/9] rounded-2xl overflow-hidden mb-16 shadow-lg relative group">
        <img src="{{ asset('storage/' . $article->thumbnail) }}"
             alt="{{ $article->title }}"
             class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-105">
    </div>
    @endif

    {{-- ── Block Content ── --}}
    <div class="max-w-3xl mx-auto mb-24 article-content">
        {!! \App\Services\ArticleService::renderContent($article->content) !!}

        {{-- Tags --}}
        <div class="mt-20 pt-12 border-t border-slate-100 flex flex-wrap gap-3">
            <span class="px-5 py-2 bg-surface-container-low rounded-lg text-xs font-bold text-outline">#Kesehatan</span>
            <span class="px-5 py-2 bg-surface-container-low rounded-lg text-xs font-bold text-outline">#PosyanduDigital</span>
            @if($article->category)
            <span class="px-5 py-2 bg-surface-container-low rounded-lg text-xs font-bold text-outline">#{{ str_replace(' ', '', $article->category->name) }}</span>
            @endif
        </div>

        {{-- Bottom CTA --}}
        <div class="mt-12 flex items-center justify-between bg-inverse-surface p-8 md:p-12 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-headline-md font-black mb-2 italic">Informasi ini bermanfaat?</h3>
                <p class="text-outline-variant text-sm font-medium">Bantu sebarkan informasi kesehatan ini kepada warga lainnya.</p>
            </div>
            <div class="flex gap-4 relative z-10">
                <a href="#" class="w-14 h-14 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-primary transition-all text-white backdrop-blur-md">
                    <span class="material-symbols-outlined">share</span>
                </a>
                <a href="{{ route('public.articles.index') }}"
                   class="h-14 px-8 flex items-center gap-3 bg-white text-on-surface rounded-2xl font-black uppercase tracking-widest text-[11px] hover:bg-indigo-500 hover:text-white transition-all shadow-xl active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
                </a>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-secondary/20 rounded-lg blur-[80px]"></div>
        </div>
    </div>
</article>


@endsection