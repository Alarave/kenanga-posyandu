<aside class="w-full lg:w-96 space-y-16 flex-shrink-0">
    
    {{-- Search Module --}}
    <div class="space-y-6">
        <h4 class="text-[11px] font-black text-on-surface uppercase tracking-[0.3em]">Cari Pengetahuan</h4>
        <form action="{{ route('public.articles.index') }}" method="GET" class="relative group">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Ingin cari apa hari ini?"
                   class="w-full h-16 pl-14 pr-6 rounded-2xl bg-white border border-slate-100 text-sm font-bold text-on-surface placeholder:text-slate-300 focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-600 transition-all shadow-sm">
            <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-secondary transition-colors">search</span>
        </form>
    </div>

    {{-- Popular Stream --}}
    <div class="space-y-10">
        <h4 class="text-[11px] font-black text-on-surface uppercase tracking-[0.3em] flex items-center gap-3">
            <span class="w-6 h-6 rounded-lg bg-secondary flex items-center justify-center text-white"><span class="material-symbols-outlined text-[14px]">trending_up</span></span>
            Paling Banyak Dibaca
        </h4>
        <div class="space-y-10">
            @foreach($popularArticles as $index => $pop)
            <a href="{{ route('public.articles.show', $pop->slug) }}" class="flex gap-6 group">
                <span class="text-4xl font-black text-slate-100 group-hover:text-indigo-50 transition-colors leading-none">0{{ $index + 1 }}</span>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-black text-on-surface uppercase tracking-tighter">{{ $article->user->name ?? 'Admin' }}</span>
                        <span class="w-0.5 h-0.5 rounded-lg bg-slate-300"></span>
                        <span class="text-[10px] text-outline-variant font-bold uppercase tracking-widest">{{ $pop->category->name ?? 'Umum' }}</span>
                    </div>
                    <h5 class="text-[15px] font-black text-on-surface leading-tight group-hover:text-secondary transition-colors line-clamp-2">
                        {{ $pop->title }}
                    </h5>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Support Bento --}}
    <div class="relative p-10 bg-inverse-surface rounded-[3rem] text-white shadow-2xl overflow-hidden group">
        <div class="relative z-10 space-y-6">
            <h4 class="text-headline-md font-black italic leading-tight">Butuh Konsultasi <br><span class="text-indigo-400">Pribadi?</span></h4>
            <p class="text-outline-variant text-[13px] font-medium leading-relaxed">Hubungi tim medis dan kader kami melalui pesan WhatsApp untuk konsultasi cepat.</p>
            <a href="{{ route('public.contact') }}" class="h-14 w-full flex items-center justify-center bg-secondary text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95">
                Hubungi Kader Sekarang
            </a>
        </div>
        <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-[140px] text-white/5 group-hover:scale-110 transition-transform duration-700">medical_services</span>
        <div class="absolute -left-10 -top-10 w-40 h-40 bg-indigo-500/10 rounded-lg blur-[80px]"></div>
    </div>
</aside>
