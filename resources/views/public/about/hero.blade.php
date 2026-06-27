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

            {{-- Hero Right: Professional Image Carousel --}}
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">

                    {{-- Glow accent behind card --}}
                    <div class="absolute -inset-6 bg-gradient-to-tr from-primary/15 via-teal-400/10 to-transparent rounded-[3rem] blur-2xl opacity-70 -z-10"></div>

                    {{-- Main Carousel Card --}}
                    <div class="relative rounded-3xl overflow-visible border border-slate-200/70 dark:border-slate-700/60 shadow-2xl bg-white dark:bg-slate-900">

                        {{-- Slides Container --}}
                        <div id="carousel-track" class="relative overflow-hidden rounded-t-3xl" style="height: 400px;">

                            {{-- Slide 1 --}}
                            <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out z-10" style="opacity:1;">
                                <img src="{{ asset('assets/img/about_hero_illustration.png') }}"
                                     alt="Pelayanan Posyandu Kenanga"
                                     class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 right-0 h-28 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-5 left-5 right-5">
                                    <p class="text-white text-sm font-bold drop-shadow-sm">Pelayanan Kesehatan Terpadu</p>
                                    <p class="text-white/70 text-xs mt-0.5">Posyandu ILP Kenanga RW 011</p>
                                </div>
                            </div>

                            {{-- Slide 2 --}}
                            <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out z-0" style="opacity:0;">
                                <img src="{{ asset('assets/img/carousel_1.png') }}"
                                     alt="Layanan Ibu dan Bayi"
                                     class="w-full h-full object-cover object-top">
                                <div class="absolute bottom-0 left-0 right-0 h-28 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-5 left-5 right-5">
                                    <p class="text-white text-sm font-bold drop-shadow-sm">Layanan Ibu & Bayi</p>
                                    <p class="text-white/70 text-xs mt-0.5">Pemantauan tumbuh kembang anak</p>
                                </div>
                            </div>

                            {{-- Slide 3 --}}
                            <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out z-0" style="opacity:0;">
                                <img src="{{ asset('assets/img/carousel_2.png') }}"
                                     alt="Pemeriksaan Lansia"
                                     class="w-full h-full object-cover object-top">
                                <div class="absolute bottom-0 left-0 right-0 h-28 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-5 left-5 right-5">
                                    <p class="text-white text-sm font-bold drop-shadow-sm">Layanan Kesehatan Lansia</p>
                                    <p class="text-white/70 text-xs mt-0.5">Cek kesehatan rutin untuk lansia</p>
                                </div>
                            </div>

                            {{-- Slide 4 --}}
                            <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out z-0" style="opacity:0;">
                                <img src="{{ asset('assets/img/carousel_3.png') }}"
                                     alt="Tim Kader Aktif"
                                     class="w-full h-full object-cover object-top">
                                <div class="absolute bottom-0 left-0 right-0 h-28 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-5 left-5 right-5">
                                    <p class="text-white text-sm font-bold drop-shadow-sm">Tim Kader Posyandu Aktif</p>
                                    <p class="text-white/70 text-xs mt-0.5">Siap melayani dengan sepenuh hati</p>
                                </div>
                            </div>

                            {{-- Slide Counter Badge (top right) --}}
                            <div class="absolute top-4 right-4 z-30 bg-black/35 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full tracking-wide">
                                <span id="carousel-counter">1 / 4</span>
                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function() {
    var current = 0;
    var slides  = document.querySelectorAll('.carousel-slide');
    var dots    = document.querySelectorAll('.carousel-dot');
    var counter = document.getElementById('carousel-counter');
    var total   = slides.length;
    var timer;

    function show(index) {
        current = (index + total) % total;

        slides.forEach(function(s, i) {
            s.style.opacity = (i === current) ? '1' : '0';
            s.style.zIndex  = (i === current) ? '10' : '0';
        });

        dots.forEach(function(d, i) {
            if (i === current) {
                d.style.width = '24px';
                d.style.backgroundColor = 'var(--color-primary, #0d9488)';
            } else {
                d.style.width = '8px';
                d.style.backgroundColor = '';
                d.classList.add('bg-slate-200');
                d.classList.remove('bg-primary');
            }
        });

        if (counter) counter.textContent = (current + 1) + ' / ' + total;
    }

    function next() { show(current + 1); }
    function prev() { show(current - 1); }

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(next, 5000);
    }

    var nextBtn = document.getElementById('carousel-next');
    var prevBtn = document.getElementById('carousel-prev');
    if (nextBtn) nextBtn.addEventListener('click', function() { next(); resetTimer(); });
    if (prevBtn) prevBtn.addEventListener('click', function() { prev(); resetTimer(); });

    dots.forEach(function(d, i) {
        d.addEventListener('click', function() { show(i); resetTimer(); });
    });

    show(0);
    resetTimer();
})();
</script>
