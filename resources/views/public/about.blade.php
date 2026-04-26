@extends('layouts.public-layout')

@section('title', 'Tentang Kami - Posyandu Digital')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12">
    <!-- Hero Section -->
    <div class="relative rounded-[3.5rem] overflow-hidden min-h-[500px] flex items-center mb-32 bg-primary-dark group shadow-2xl">
        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=2080&auto=format&fit=crop" 
             class="absolute inset-0 w-full h-full object-cover opacity-40 scale-105 group-hover:scale-100 transition-transform duration-[3s]">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-dark via-primary-dark/60 to-transparent"></div>
        
        <div class="relative z-10 px-10 md:px-24 py-20 max-w-2xl">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-primary/20 backdrop-blur-md rounded-full mb-8 border border-white/10">
                <span class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Siapa Kami?</span>
            </div>
            <h1 class="text-5xl md:text-8xl font-black text-white mb-10 leading-[1] tracking-tight font-jakarta">
                Garda <span class="text-primary italic">Terdepan.</span>
            </h1>
            <p class="text-white/80 text-xl font-medium leading-relaxed italic opacity-90">
                Membangun ekosistem kesehatan primer yang modern dan terintegrasi untuk seluruh lapisan masyarakat Bekasi Timur.
            </p>
        </div>
    </div>

    <!-- Content Blocks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-32 mb-40 items-center overflow-x-hidden">
        <div class="space-y-16">
            <div>
                <h6 class="text-primary font-black text-[10px] uppercase tracking-[0.4em] mb-4">Filosofi Pelayanan</h6>
                <h2 class="text-4xl md:text-6xl font-black text-on-surface leading-[1.1] tracking-tight font-jakarta mb-8">Visi & Misi <br> <span class="text-primary/40 italic">Digital Kami.</span></h2>
            </div>
            
            <div class="grid grid-cols-1 gap-12">
                <div class="flex items-start gap-8 group">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-[2rem] flex items-center justify-center text-primary border border-outline-variant group-hover:bg-primary group-hover:text-white transition-all shrink-0">
                        <span class="material-symbols-outlined text-[36px]">digital_out_of_home</span>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-on-surface mb-3 italic">Digitalisasi Data</h4>
                        <p class="text-on-surface-variant leading-relaxed text-sm font-medium opacity-80">Mentransformasi catatan manual menjadi data digital yang akurat untuk mendukung kebijakan kesehatan berbasis bukti.</p>
                    </div>
                </div>

                <div class="flex items-start gap-8 group">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-[2rem] flex items-center justify-center text-primary border border-outline-variant group-hover:bg-primary group-hover:text-white transition-all shrink-0">
                        <span class="material-symbols-outlined text-[36px]">diversity_1</span>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-on-surface mb-3 italic">Pemberdayaan Kader</h4>
                        <p class="text-on-surface-variant leading-relaxed text-sm font-medium opacity-80">Memperkuat peran masyarakat melalui pelatihan teknologi digital untuk pelayanan kesehatan yang lebih responsif.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="relative">
            {{-- Decorative circles --}}
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/10 rounded-full blur-[60px] animate-pulse"></div>
            
            <div class="aspect-[4/5] rounded-[4rem] overflow-hidden shadow-[0_40px_100px_-20px_rgba(0,104,95,0.2)] rotate-3 bg-primary-dark">
                <img src="https://images.unsplash.com/photo-1584820923423-83324641979b?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover opacity-80 transition-all hover:scale-110 duration-1000" alt="Pelayanan Kami">
            </div>
            
            <div class="absolute -bottom-12 -left-12 bg-white/80 backdrop-blur-xl p-12 rounded-[3.5rem] shadow-2xl border border-white/20 hidden md:block max-w-[320px] hover:-translate-y-4 transition-transform duration-500">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                        <span class="material-symbols-outlined text-[28px]">verified_user</span>
                    </div>
                    <h5 class="text-2xl font-black text-on-surface tracking-tight font-jakarta uppercase">Terpercaya</h5>
                </div>
                <p class="text-[11px] text-on-surface-variant font-black uppercase tracking-[0.2em] leading-relaxed opacity-60">Sistem Informasi Posyandu Standar Nasional 2024</p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-on-surface p-20 md:p-32 rounded-[5rem] shadow-3xl mb-40 relative overflow-hidden">
        <div class="absolute inset-0 bg-primary/5"></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-24 text-center relative z-10">
            <div class="hover-lift">
                <span class="material-symbols-outlined text-[56px] text-primary mb-8 opacity-40">diversity_2</span>
                <h3 class="text-7xl font-black text-white tracking-tighter mb-4 italic">100+</h3>
                <p class="text-white/40 text-[11px] font-black uppercase tracking-[0.4em]">Kader Penggerak</p>
            </div>
            <div class="hover-lift border-y md:border-y-0 md:border-x border-white/10 py-20 md:py-0">
                <span class="material-symbols-outlined text-[56px] text-primary mb-8 opacity-40">vaccines</span>
                <h3 class="text-7xl font-black text-white tracking-tighter mb-4 italic">15</h3>
                <p class="text-white/40 text-[11px] font-black uppercase tracking-[0.4em]">Unit Posyandu</p>
            </div>
            <div class="hover-lift">
                <span class="material-symbols-outlined text-[56px] text-primary mb-8 opacity-40">crowdsource</span>
                <h3 class="text-7xl font-black text-white tracking-tighter mb-4 italic">2k+</h3>
                <p class="text-white/40 text-[11px] font-black uppercase tracking-[0.4em]">Warga Terlayani</p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="bg-primary p-20 md:p-32 rounded-[5rem] text-center mb-32 shadow-2xl shadow-primary/30 relative overflow-hidden group">
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-white/5 rounded-full blur-[100px] group-hover:scale-150 transition-transform duration-1000"></div>
        <h2 class="text-4xl md:text-7xl font-black text-white mb-10 tracking-tight font-jakarta leading-[1]">Ayo Bangun Generasi <br> <span class="text-black/20">Sehat & Cerdas.</span></h2>
        <a href="{{ route('public.articles.index') }}" class="btn-premium inline-flex items-center px-16 py-6 bg-white text-primary text-[11px] font-black uppercase tracking-[0.3em] rounded-full hover:shadow-2xl transition-all shadow-white/20 active:scale-95">
            Baca Katalog Artikel <span class="material-symbols-outlined text-[18px] ml-4">auto_stories</span>
        </a>
    </div>
</div>
@endsection
