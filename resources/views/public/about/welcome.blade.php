{{-- ── 3. SAMBUTAN / WELCOME SECTION ── --}}
<section class="pt-10 pb-20 lg:pt-14 lg:pb-28 bg-surface-container-low dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800/60 relative">
    
    <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10">
        {{-- Title (centered) --}}
        <h1 class="text-center text-display-sm md:text-5xl font-black text-on-surface dark:text-white tracking-tight font-jakarta leading-normal max-w-4xl mx-auto py-2">
            Selamat Datang di <span class="inline-block text-transparent bg-clip-text bg-linear-to-r from-primary to-teal-500 dark:from-teal-300 dark:to-emerald-400 italic px-4">Posyandu ILP Kenanga</span>
        </h1>

        {{-- Slogan Badge (centered) --}}
        <div class="flex justify-center mt-4">
            <span class="inline-flex items-center justify-center px-5 py-2 rounded-lg bg-primary-container/50 dark:bg-teal-950/20 text-primary dark:text-teal-400 font-extrabold text-xs md:text-sm tracking-wide border border-teal-100/40 dark:border-teal-900/40 font-jakarta shadow-xs">
                Posyandu ILP Kenanga RW 011, Mitra Masyarakat Menuju Hidup Sehat
            </span>
        </div>

        {{-- Description/Visi (dimmed/centered, holds the Welcome Greeting) --}}
        <p class="text-center max-w-3xl mx-auto text-base md:text-body-lg text-slate-655 dark:text-outline-variant mt-8 leading-relaxed font-semibold italic">
            "Posyandu ILP Kenanga RW 011 hadir sebagai wujud nyata komitmen masyarakat dalam meningkatkan kualitas kesehatan warga melalui pelayanan kesehatan primer yang terpadu, mudah diakses, dan berkelanjutan."
        </p>

        {{-- Grid of Cards (3 Columns - Matching Visi-Misi style exactly) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
            
            {{-- Pilar 1: Wilayah & Sasaran --}}
            <div class="bg-white dark:bg-inverse-surface border border-outline-variant/60 dark:border-slate-800 rounded-2xl p-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group text-center">
                {{-- Decorative Top Border Hover effect --}}
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-linear-to-r from-primary to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                {{-- Icon --}}
                <div class="w-14 h-14 bg-primary/10 dark:bg-primary/5 text-primary dark:text-teal-400 rounded-2xl flex items-center justify-center mb-6 border border-primary/20 shadow-xs group-hover:bg-primary group-hover:text-white transition-colors duration-300 mx-auto">
                    <span class="material-symbols-outlined text-[32px] stroke-[1.5]">location_on</span>
                </div>

                {{-- Card Title --}}
                <h3 class="text-headline-sm font-black text-on-surface dark:text-white font-jakarta group-hover:text-primary transition-colors duration-300">
                    Wilayah &amp; Sasaran
                </h3>

                {{-- Card Description --}}
                <p class="text-base text-on-surface-variant dark:text-outline-variant mt-4 leading-relaxed font-medium">
                    Melayani seluruh lapisan warga RW 011 Kelurahan Aren Jaya—mulai dari ibu hamil, bayi, remaja, dewasa, hingga lansia.
                </p>
            </div>

            {{-- Pilar 2: Integrasi Layanan Primer --}}
            <div class="bg-white dark:bg-inverse-surface border border-outline-variant/60 dark:border-slate-800 rounded-2xl p-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group text-center">
                {{-- Decorative Top Border Hover effect --}}
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-linear-to-r from-primary to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                {{-- Icon --}}
                <div class="w-14 h-14 bg-primary/10 dark:bg-primary/5 text-primary dark:text-teal-400 rounded-2xl flex items-center justify-center mb-6 border border-primary/20 shadow-xs group-hover:bg-primary group-hover:text-white transition-colors duration-300 mx-auto">
                    <span class="material-symbols-outlined text-[32px] stroke-[1.5]">volunteer_activism</span>
                </div>

                {{-- Card Title --}}
                <h3 class="text-headline-sm font-black text-on-surface dark:text-white font-jakarta group-hover:text-primary transition-colors duration-300">
                    Integrasi Layanan Primer
                </h3>

                {{-- Card Description --}}
                <p class="text-base text-on-surface-variant dark:text-outline-variant mt-4 leading-relaxed font-medium">
                    Fokus pada deteksi dini risiko kesehatan, pencegahan penyakit secara preventif, serta promosi pola hidup bersih dan sehat.
                </p>
            </div>

            {{-- Pilar 3: Portal Digital --}}
            <div class="bg-white dark:bg-inverse-surface border border-outline-variant/60 dark:border-slate-800 rounded-2xl p-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group text-center">
                {{-- Decorative Top Border Hover effect --}}
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-linear-to-r from-primary to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                {{-- Icon --}}
                <div class="w-14 h-14 bg-primary/10 dark:bg-primary/5 text-primary dark:text-teal-400 rounded-2xl flex items-center justify-center mb-6 border border-primary/20 shadow-xs group-hover:bg-primary group-hover:text-white transition-colors duration-300 mx-auto">
                    <span class="material-symbols-outlined text-[32px] stroke-[1.5]">campaign</span>
                </div>

                {{-- Card Title --}}
                <h3 class="text-headline-sm font-black text-on-surface dark:text-white font-jakarta group-hover:text-primary transition-colors duration-300">
                    Portal Layanan Digital
                </h3>

                {{-- Card Description --}}
                <p class="text-base text-on-surface-variant dark:text-outline-variant mt-4 leading-relaxed font-medium">
                    Media informasi terintegrasi untuk melihat jadwal bulanan, agenda program kerja posyandu, dan artikel edukasi kesehatan warga.
                </p>
            </div>

        </div>

    </div>
</section>
