<div class="mt-12 flex items-center justify-between bg-slate-900 p-8 md:p-12 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
    <div class="relative z-10">
        <h3 class="text-2xl font-black mb-2 italic">Informasi ini bermanfaat?</h3>
        <p class="text-slate-400 text-sm font-medium">Bantu sebarkan informasi kesehatan ini kepada warga lainnya.</p>
    </div>
    <div class="flex gap-4 relative z-10">
        <a href="#" class="w-14 h-14 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-emerald-500 transition-all text-white backdrop-blur-md">
            <span class="material-symbols-outlined">share</span>
        </a>
        <a href="{{ route('public.articles.index') }}" class="h-14 px-8 flex items-center gap-3 bg-white text-slate-900 rounded-2xl font-black uppercase tracking-widest text-[11px] hover:bg-indigo-500 hover:text-white transition-all shadow-xl active:scale-95">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>
    </div>
    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-600/20 rounded-full blur-[80px]"></div>
</div>
