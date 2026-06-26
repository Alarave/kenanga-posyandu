{{-- ── 1. HERO SECTION ── --}}
<section class="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-32 bg-slate-50 dark:bg-slate-950">
    {{-- Decorative Background Blobs --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 opacity-70"></div>
    <div class="absolute bottom-0 right-10 w-125 h-125 bg-teal-500/5 rounded-full blur-3xl opacity-60"></div>
    
    <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            {{-- Hero Left: Content --}}
            <div class="lg:col-span-7 space-y-6 text-left">
                <div class="space-y-3">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-primary/10 dark:bg-primary/25 rounded-full border border-primary/20 dark:border-primary/45 text-xs md:text-sm font-black text-primary dark:text-teal-300 uppercase tracking-[0.2em]">
                            <span class="material-symbols-outlined text-base">info</span>
                            Profil & Editorial
                        </span>
                    </div>

                </div>
                
                <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight font-jakarta leading-[1.15] py-2">
                    Mitra Masyarakat<br/>
                    <span class="inline-block text-transparent bg-clip-text bg-linear-to-r from-primary to-teal-500 dark:from-teal-300 dark:to-emerald-400 italic pl-2 pr-8 py-2 -mr-6">Menuju Hidup Sehat.</span>
                </h1>
                
                <p class="text-base md:text-lg text-slate-650 dark:text-slate-350 font-medium leading-relaxed max-w-2xl">
                    Posyandu ILP Kenanga RW 011 Kelurahan Aren Jaya hadir sebagai wujud komitmen nyata warga dalam membangun kualitas kesehatan keluarga yang unggul melalui pendekatan pelayanan kesehatan primer terintegrasi.
                </p>
                
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('public.home') }}#jadwal" class="inline-flex items-center justify-center px-8 py-4 bg-linear-to-r from-primary to-teal-500 text-white text-xs font-black uppercase tracking-widest rounded-full hover:from-primary-dark hover:to-teal-650 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5">
                        Jadwal Kegiatan
                    </a>
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-slate-900 text-slate-800 dark:text-white text-xs font-black uppercase tracking-widest rounded-full border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-0.5">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            {{-- Hero Right: Image & Floating Cards --}}
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-112.5 lg:max-w-none">
                    {{-- Background Accent Card --}}
                    <div class="absolute -inset-4 bg-linear-to-tr from-primary/10 to-teal-500/10 rounded-[2.5rem] blur-xl opacity-80 -z-10"></div>
                    
                    {{-- Main Image Card --}}
                    <div class="relative overflow-hidden rounded-4xl border border-white dark:border-slate-800 shadow-2xl bg-white dark:bg-slate-900 p-4">
                        <img src="{{ asset('assets/img/about_hero_illustration.png') }}" alt="Posyandu Kenanga Illustration" class="w-full h-auto object-contain rounded-2xl transform hover:scale-[1.01] transition-transform duration-500 max-h-105">
                    </div>


                </div>
            </div>

        </div>
    </div>
</section>
