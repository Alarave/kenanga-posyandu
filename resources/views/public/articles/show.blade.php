@extends('layouts.public-layout')

@section('title', $article->title . ' - Posyandu Digital')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-3 text-[10px] font-black uppercase tracking-[0.2em] text-outline mb-10">
        <a href="{{ route('public.home') }}" class="hover:text-primary transition-colors">Beranda</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a href="{{ route('public.articles.index') }}" class="hover:text-primary transition-colors">Artikel</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary">{{ Str::limit($article->title, 20) }}</span>
    </nav>

    <!-- Article Header Hero -->
    <div class="relative mb-20 rounded-[4rem] overflow-hidden shadow-2xl bg-primary-dark group">
        <div class="aspect-[16/9] md:aspect-[21/9] overflow-hidden">
            <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=2070&auto=format&fit=crop' }}" 
                 alt="{{ $article->title }}" 
                 class="w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-[3s]">
            <div class="absolute inset-0 bg-gradient-to-t from-primary-dark via-primary-dark/20 to-transparent"></div>
        </div>

        <div class="absolute inset-0 flex flex-col justify-end p-10 md:p-20">
            <div class="max-w-4xl">
                <span class="inline-flex px-5 py-2 bg-primary text-white text-[10px] font-black rounded-full mb-8 uppercase tracking-widest shadow-xl shadow-teal-500/20">
                    {{ $article->category->name ?? 'Informasi Kesehatan' }}
                </span>
                <h1 class="text-3xl md:text-6xl font-black text-white mb-10 leading-tight tracking-tight">
                    {{ $article->title }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-8 pt-8 border-t border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white font-black text-lg border border-white/20">
                            {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-black tracking-wide uppercase">{{ $article->user->name ?? 'Tim Redaksi' }}</h4>
                            <p class="text-primary-light text-[9px] font-black uppercase tracking-widest mt-1">Penulis Konten</p>
                        </div>
                    </div>
                    
                    <div class="hidden md:flex items-center gap-10">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black uppercase tracking-widest text-white/40 mb-1">Diterbitkan</span>
                            <span class="text-[13px] font-bold text-white">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black uppercase tracking-widest text-white/40 mb-1">Estimasi Baca</span>
                            <span class="text-[13px] font-bold text-white flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">timer</span> {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} Menit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="max-w-4xl mx-auto relative z-10">
        <div class="bg-white p-10 md:p-20 rounded-[4rem] shadow-2xl border border-outline-variant -mt-32 mb-20">
            <div class="prose prose-teal prose-lg max-w-none prose-headings:font-black prose-headings:text-on-surface prose-p:text-on-surface-variant prose-p:leading-relaxed prose-strong:text-on-surface prose-a:text-primary hover:prose-a:text-primary-dark transition-colors italic">
                {!! $article->content !!}
            </div>
            
            <!-- Footer Actions -->
            <div class="mt-20 pt-12 border-t border-outline-variant/30 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-4">
                    <span class="text-[10px] font-black text-outline uppercase tracking-widest">Bagikan:</span>
                    <div class="flex gap-2">
                        <a href="#" class="w-10 h-10 rounded-xl bg-surface-container text-outline flex items-center justify-center hover:bg-primary hover:text-white transition-all"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-surface-container text-outline flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-whatsapp text-xs"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-surface-container text-outline flex items-center justify-center hover:bg-primary-dark hover:text-white transition-all"><span class="material-symbols-outlined text-[18px]">link</span></a>
                    </div>
                </div>
                <a href="{{ route('public.articles.index') }}" class="inline-flex items-center px-10 py-4 bg-primary text-white text-[11px] font-black uppercase tracking-widest rounded-full hover:bg-primary-dark transition-all shadow-xl shadow-teal-500/20 active:scale-95">
                    <span class="material-symbols-outlined text-[18px] mr-3">arrow_back</span> KEMBALI KE ARTIKEL
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
