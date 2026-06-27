<footer class="relative bg-linear-to-br from-white via-[#f8fafc] to-[#f1f5f9] pt-24 pb-12 overflow-hidden border-t border-outline-variant/60">
    {{-- Background grid patterns --}}
    <div class="absolute inset-0 pointer-events-none opacity-70">
        <div class="absolute inset-0" style="background-image: linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px); bg-size: 4rem 4rem; background-size: 4rem 4rem; mask-image: radial-gradient(ellipse 60% 50% at 50% 0%, #000 70%, transparent 100%); -webkit-mask-image: radial-gradient(ellipse 60% 50% at 50% 0%, #000 70%, transparent 100%);"></div>
        <div class="absolute inset-0 bg-linear-to-br from-emerald-500/5 via-teal-500/5 to-cyan-500/5"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16">
            
            {{-- Brand Section --}}
            <div class="group">
                <div class="flex items-center mb-6">
                    <div class="w-11 h-11 rounded-xl bg-linear-to-br from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-600/10 group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-heartbeat text-body-lg"></i>
                    </div>
                    <span class="ml-3 text-body-lg font-extrabold tracking-tight bg-linear-to-r from-slate-900 via-slate-800 to-slate-700 bg-clip-text text-transparent">
                        Posyandu <span class="text-emerald-700">Digital</span>
                    </span>
                </div>
                <p class="text-on-surface-variant text-sm leading-relaxed mb-6">
                    Mentransformasi dan memodernisasi pelayanan kesehatan primer untuk ibu, bayi, dan lansia di wilayah Bekasi Timur.
                </p>
                <div class="flex space-x-3">
                    @php
                        $socials = [
                            ['icon' => 'fa-instagram', 'href' => '#'],
                            ['icon' => 'fa-facebook',  'href' => '#'],
                            ['icon' => 'fa-twitter',   'href' => '#'],
                            ['icon' => 'fa-whatsapp',  'href' => '#'],
                        ];
                    @endphp
                    @foreach($socials as $soc)
                        <a href="{{ $soc['href'] }}" 
                           class="w-9 h-9 rounded-xl bg-white border border-outline-variant/80 flex items-center justify-center text-outline hover:bg-linear-to-br hover:from-emerald-600 hover:to-teal-500 hover:text-white hover:border-transparent transition-all duration-300 shadow-sm hover:shadow-md hover:shadow-emerald-600/10">
                            <i class="fab {{ $soc['icon'] }} text-xs"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Column 2: Layanan --}}
            <div>
                <h4 class="text-[11px] font-extrabold uppercase tracking-widest text-outline mb-6 relative pl-3">
                    <span class="absolute left-0 top-0 bottom-0 w-0.75 rounded bg-primary"></span>
                    Layanan Kami
                </h4>
                <ul class="space-y-3.5">
                    @php
                        $services = [
                            ['label' => 'Jadwal Kegiatan', 'route' => 'public.home', 'anchor' => '#jadwal'],
                            ['label' => 'Portal Berita', 'route' => 'public.articles.index', 'anchor' => null],
                            ['label' => 'Pencatatan Balita', 'route' => 'login', 'anchor' => null],
                            ['label' => 'Pemeriksaan Lansia', 'route' => 'login', 'anchor' => null],
                        ];
                    @endphp
                    @foreach($services as $serv)
                        <li>
                            <a href="{{ route($serv['route']) }}{{ $serv['anchor'] }}" class="text-on-surface-variant hover:text-on-surface text-[13.5px] font-medium transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 rounded-lg bg-linear-to-r from-emerald-600 to-teal-500 mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                {{ $serv['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Column 3: Informasi --}}
            <div>
                <h4 class="text-[11px] font-extrabold uppercase tracking-widest text-outline mb-6 relative pl-3">
                    <span class="absolute left-0 top-0 bottom-0 w-0.75 rounded bg-primary"></span>
                    Informasi
                </h4>
                <ul class="space-y-3.5">
                    @php
                        $info = [
                            ['label' => 'Beranda', 'route' => 'public.home'],
                            ['label' => 'Artikel Kesehatan', 'route' => 'public.articles.index'],
                            ['label' => 'Tentang Posyandu', 'route' => 'public.about'],
                            ['label' => 'Hubungi Kami', 'route' => 'public.contact'],
                        ];
                    @endphp
                    @foreach($info as $inf)
                        <li>
                            <a href="{{ route($inf['route']) }}" class="text-on-surface-variant hover:text-on-surface text-[13.5px] font-medium transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 rounded-lg bg-linear-to-r from-emerald-600 to-teal-500 mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                {{ $inf['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Column 4: Kontak --}}
            <div>
                <h4 class="text-[11px] font-extrabold uppercase tracking-widest text-outline mb-6 relative pl-3">
                    <span class="absolute left-0 top-0 bottom-0 w-0.75 rounded bg-primary"></span>
                    Kontak Kami
                </h4>
                <ul class="space-y-4 text-[13.5px]">
                    <li class="text-on-surface-variant flex items-start">
                        <span class="material-symbols-outlined text-[18px] text-outline-variant mr-2.5 mt-0.5">map</span>
                        <span>Bekasi Timur, Jawa Barat, Indonesia</span>
                    </li>
                    <li>
                        <a href="mailto:support@posyandudigital.com" class="text-on-surface-variant hover:text-on-surface transition-colors duration-300 flex items-center group">
                            <span class="material-symbols-outlined text-[18px] text-outline-variant mr-2.5 group-hover:text-on-surface-variant">mail</span>
                            support@posyandudigital.com
                        </a>
                    </li>
                    <li>
                        <a href="tel:+628123456789" class="text-on-surface-variant hover:text-on-surface transition-colors duration-300 flex items-center group">
                            <span class="material-symbols-outlined text-[18px] text-outline-variant mr-2.5 group-hover:text-on-surface-variant">call</span>
                            +62 (812) 3456-789
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Bottom Section --}}
        <div class="mt-20 pt-8 border-t border-outline-variant/80 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
            <p class="text-outline text-xs font-semibold">
                &copy; {{ date('Y') }} Posyandu Digital Bekasi Timur. All rights reserved.
            </p>
            <div class="flex gap-6 text-xs font-semibold text-outline-variant">
                <a href="#" class="hover:text-on-surface-variant transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-on-surface-variant transition-colors">Terms of Service</a>
            </div>
        </div>

    </div>
</footer>
