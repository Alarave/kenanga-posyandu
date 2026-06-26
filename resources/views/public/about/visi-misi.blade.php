{{-- ── 4. VISI & MISI SECTION ── --}}
<section class="pt-10 pb-10 lg:pt-14 lg:pb-14 bg-slate-50 dark:bg-slate-950 border-y border-slate-100 dark:border-slate-800/80 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-125 h-125 bg-primary/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4 opacity-40"></div>
    <div class="absolute bottom-0 left-0 w-100 h-100 bg-teal-500/5 rounded-full blur-[100px] translate-y-1/3 -translate-x-1/4 opacity-30"></div>
    
    <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10">
        
        {{-- Badge (centered) --}}
        <div class="flex justify-center mb-4">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-primary/10 rounded-full border border-primary/20 text-xs md:text-sm font-black text-primary uppercase tracking-[0.2em]">
                <span class="material-symbols-outlined text-[14px]">explore</span>
                VISI &amp; MISI
            </span>
        </div>

        {{-- Title (centered) --}}
        <h2 class="text-center text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight font-jakarta leading-normal max-w-4xl mx-auto py-2">
            <span class="inline-block text-transparent bg-clip-text bg-linear-to-r from-primary to-teal-500 italic px-8 py-2">Posyandu ILP Kenanga</span>
        </h2>

        {{-- Description (dimmed/centered, holds the Visi) --}}
        <p class="text-center max-w-3xl mx-auto text-base md:text-lg text-slate-600 dark:text-slate-400 mt-6 leading-relaxed font-semibold italic">
            "Menjadi Posyandu ILP Kenanga 1 yang aktif, profesional, inovatif, dan terpercaya dalam memberikan pelayanan kesehatan primer terintegrasi guna mewujudkan masyarakat yang sehat, mandiri, dan sejahtera."
        </p>

        {{-- Grid of Cards (SimpleGrid style) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">
            @foreach($misis as $m)
            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-3xl p-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                {{-- Decorative Top Border Hover effect --}}
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-linear-to-r from-primary to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                {{-- Icon (styled similarly to color={theme.colors.blue[6]} in FeaturesCards) --}}
                <div class="w-14 h-14 bg-primary/10 dark:bg-primary/5 text-primary dark:text-teal-400 rounded-2xl flex items-center justify-center mb-6 border border-primary/20 shadow-xs group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                    <span class="material-symbols-outlined text-[32px] stroke-[1.5]">{{ $m->icon }}</span>
                </div>

                {{-- Card Title --}}
                <h3 class="text-xl font-black text-slate-900 dark:text-white font-jakarta group-hover:text-primary transition-colors duration-300">
                    {{ $m->title }}
                </h3>

                {{-- Card Description --}}
                <p class="text-base text-slate-600 dark:text-slate-400 mt-4 leading-relaxed font-medium">
                    {{ $m->desc }}
                </p>
            </div>
            @endforeach
        </div>

    </div>
</section>
