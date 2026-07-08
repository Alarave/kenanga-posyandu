<nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-12">
    <a href="{{ route('public.articles.index') }}" class="hover:text-primary transition-colors">Artikel</a>
    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
    <span class="text-slate-300 truncate max-w-[150px] md:max-w-2xl">{{ $article->title }}</span>
</nav>
