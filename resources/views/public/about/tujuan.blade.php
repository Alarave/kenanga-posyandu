{{-- ── 5. TUJUAN STRATEGIS ── --}}
<section class="pt-6 pb-20 lg:pt-8 lg:pb-28">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-primary/10 rounded-full border border-primary/20 text-xs md:text-sm font-black text-primary uppercase tracking-[0.2em]">
                <span class="material-symbols-outlined text-[14px]">ads_click</span>
                Sasaran &amp; Capaian
            </span>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight font-jakarta mt-4 leading-normal py-2">
                Tujuan &amp; Strategis Kami
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tujuans as $t)
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-200/60 dark:border-slate-800 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                {{-- Decorative Top Border Hover effect --}}
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-primary to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="w-12 h-12 bg-primary/10 dark:bg-primary/5 text-primary dark:text-teal-400 rounded-xl flex items-center justify-center border border-primary/20 shadow-xs group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                    <span class="material-symbols-outlined text-[24px]">{{ $t->icon }}</span>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white font-jakarta group-hover:text-primary transition-colors duration-300 mt-6">{{ $t->title }}</h3>
                <p class="text-base text-slate-600 dark:text-slate-400 mt-4 leading-relaxed font-medium">{{ $t->desc }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>
