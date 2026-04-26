@extends('layouts.public-layout')

@section('title', 'Artikel Kesehatan - Posyandu Digital Bekasi Timur')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 py-12">

    {{-- ── HERO: Featured Article ── --}}
    @if($featured)
    <section class="mb-16">
        <div class="relative w-full h-[450px] md:h-[500px] rounded-[3rem] overflow-hidden group shadow-2xl">
            <img src="{{ $featured->thumbnail ? asset('storage/'.$featured->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=2070&auto=format&fit=crop' }}"
                 alt="{{ $featured->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-10 md:p-16">
                <span class="inline-block px-5 py-2 bg-primary text-white text-[10px] font-black rounded-full mb-6 w-fit uppercase tracking-widest">
                    {{ $featured->category?->name ?? 'Unggulan' }}
                </span>
                <h1 class="text-white font-black text-3xl md:text-5xl max-w-4xl mb-6 leading-tight tracking-tight">
                    {{ $featured->title }}
                </h1>
                <div class="flex items-center gap-6 flex-wrap">
                    <a href="{{ route('public.articles.show', $featured->slug) }}"
                       class="flex items-center gap-3 bg-white text-primary px-10 py-4 rounded-full font-black uppercase tracking-widest transition-all active:scale-95 text-xs shadow-xl">
                        BACA LENGKAP <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                    <span class="text-white/70 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                         <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                        {{ $featured->published_at ? \Carbon\Carbon::parse($featured->published_at)->translatedFormat('d M Y') : $featured->created_at->translatedFormat('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </section>
    @endif

    <div class="flex flex-col lg:flex-row gap-16">
        {{-- ── Artikels Grid ── --}}
        <div class="flex-1">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-2xl font-black text-on-surface uppercase tracking-tight">Katalog Artikel</h2>
                <div class="h-1 flex-1 mx-6 bg-surface-container rounded-full hidden md:block"></div>
            </div>

            {{-- Categories --}}
            <div class="flex flex-wrap gap-3 mb-10">
                 <a href="{{ route('public.articles.index') }}" 
                    class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest transition-all
                           {{ !request('category') ? 'bg-primary text-white shadow-lg' : 'bg-white text-on-surface-variant border border-outline-variant hover:bg-surface-container' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('public.articles.index', ['category' => $cat->slug]) }}" 
                   class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest transition-all
                          {{ request('category') === $cat->slug ? 'bg-primary text-white shadow-lg' : 'bg-white text-on-surface-variant border border-outline-variant hover:bg-surface-container' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($articles as $article)
                <article class="bg-white rounded-[2.5rem] border border-outline-variant overflow-hidden hover:shadow-2xl transition-all duration-500 group flex flex-col h-full">
                    <a href="{{ route('public.articles.show', $article->slug) }}" class="block relative aspect-[16/10] overflow-hidden">
                        <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=800&auto=format&fit=crop' }}"
                             alt="{{ $article->title }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"/>
                        @if($article->category)
                        <span class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-primary shadow-sm">
                            {{ $article->category->name }}
                        </span>
                        @endif
                    </a>
                    <div class="p-8 flex flex-col flex-1">
                        <h3 class="font-black text-on-surface text-lg mb-4 leading-tight group-hover:text-primary transition-colors line-clamp-2 italic">
                            <a href="{{ route('public.articles.show', $article->slug) }}">{{ $article->title }}</a>
                        </h3>
                        <p class="text-on-surface-variant text-[13px] leading-relaxed mb-8 flex-1 line-clamp-3 font-medium opacity-80">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <div class="pt-6 border-t border-outline-variant/30 flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-outline">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-primary opacity-50">schedule</span>
                                {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') : $article->created_at->format('d M Y') }}
                            </div>
                            <span class="text-on-surface-variant italic">{{ $article->user->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-full py-32 text-center bg-white rounded-[4rem] border border-dashed border-outline-variant">
                    <span class="material-symbols-outlined text-[84px] text-outline-variant mb-6">description</span>
                    <h3 class="text-xl font-bold text-on-surface">Tidak Ditemukan Artikel</h3>
                    <p class="text-on-surface-variant text-sm mt-2">Belum ada konten untuk kategori atau kriteria ini.</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $articles->links() }}
            </div>
        </div>

        {{-- ── Sidebar ── --}}
        <aside class="w-full lg:w-80 space-y-10 flex-shrink-0">
            {{-- Search --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant shadow-sm">
                <h4 class="text-xs font-black text-on-surface uppercase tracking-widest mb-6">Cari Berita</h4>
                <form action="{{ route('public.articles.index') }}" method="GET" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Kata kunci..."
                           class="w-full h-12 pl-12 pr-4 rounded-2xl bg-surface-container border-none text-sm font-bold text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary transition-all">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">search</span>
                </form>
            </div>

            {{-- Popular --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant shadow-sm">
                <h4 class="text-xs font-black text-on-surface uppercase tracking-widest mb-8 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">trending_up</span>
                    Terpopuler
                </h4>
                <div class="space-y-8">
                    @foreach($popularArticles as $pop)
                    <a href="{{ route('public.articles.show', $pop->slug) }}" class="group block">
                         <span class="text-[9px] font-black uppercase tracking-[0.2em] text-primary mb-2 block opacity-70">{{ $pop->category->name ?? 'Umum' }}</span>
                        <h5 class="text-sm font-bold text-on-surface leading-tight group-hover:text-primary transition-colors line-clamp-2">{{ $pop->title }}</h5>
                         <span class="text-[10px] text-outline font-medium mt-2 block">{{ \Carbon\Carbon::parse($pop->published_at)->translatedFormat('d M Y') }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Support Card --}}
            <div class="bg-primary p-8 rounded-[2.5rem] shadow-xl text-white relative overflow-hidden group">
                 <div class="relative z-10">
                    <h4 class="text-lg font-black mb-4">Konsultasi <span class="italic text-primary-light">Kesehatan</span></h4>
                    <p class="text-xs font-medium opacity-80 leading-relaxed mb-6">Hubungi kader kami untuk bantuan seputar gizi dan tumbuh kembang anak.</p>
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center w-full py-4 bg-white text-primary text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-primary-light transition-all shadow-lg active:scale-95">
                        HUBUNGI KAMI
                    </a>
                 </div>
                 <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-white opacity-10 text-[120px] group-hover:scale-110 transition-transform duration-700">support_agent</span>
            </div>
        </aside>
    </div>
</div>
@endsection
