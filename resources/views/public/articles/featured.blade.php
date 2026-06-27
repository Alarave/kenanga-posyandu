<section class="mb-20 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
    <div class="lg:col-span-7 space-y-8">
        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-lg bg-secondary-container border border-indigo-100 text-secondary">
            <span class="material-symbols-outlined text-[18px] animate-pulse">star</span>
            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Artikel Terpopuler</span>
        </div>
        
        <h1 class="text-4xl md:text-6xl font-black text-on-surface leading-tight tracking-tight">
            {{ $featured->title }}
        </h1>
        
        <p class="text-body-lg text-outline font-medium leading-relaxed max-w-2xl">
            {{ \App\Services\ArticleService::getExcerpt($featured->content, 180) }}
        </p>

        <div class="flex items-center gap-6 pt-6">
            <a href="{{ route('public.articles.show', $featured->slug) }}" 
               class="h-14 px-10 flex items-center justify-center bg-inverse-surface text-white rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] hover:bg-secondary transition-all shadow-xl active:scale-95">
                Mulai Membaca
            </a>
            <span class="text-outline-variant text-[11px] font-bold uppercase tracking-widest flex items-center gap-2">
                {{ ceil(str_word_count(strip_tags($featured->content)) / 200) }} mnt baca
            </span>
        </div>
    </div>
    <div class="lg:col-span-5">
        <div class="relative group">
            <div class="absolute inset-0 bg-secondary rounded-[3rem] rotate-3 opacity-10 group-hover:rotate-6 transition-transform"></div>
            <div class="relative aspect-[4/3] rounded-[3rem] overflow-hidden shadow-2xl border-4 border-white">
                <img src="{{ $featured->thumbnail ? asset('storage/'.$featured->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=1200&auto=format&fit=crop' }}" 
                     alt="{{ $featured->title }}" 
                     class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110">
            </div>
        </div>
    </div>
</section>
