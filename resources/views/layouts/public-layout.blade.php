<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Posyandu Digital - Portal Berita')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="antialiased overflow-x-hidden">
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full z-50 glass-header px-6 md:px-10 py-4 border-b border-white/10 transition-all duration-500" id="mainHeader">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('public.home') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:rotate-12 transition-transform duration-500">
                    <span class="material-symbols-outlined text-[24px]">health_and_safety</span>
                </div>
                <div class="flex flex-col">
                    <h1 class="text-lg font-black tracking-tight text-on-surface leading-none font-jakarta">POSYANDU <span class="text-primary">DIGITAL</span></h1>
                    <p class="text-[9px] text-on-surface-variant font-black uppercase tracking-[0.2em] mt-1 opacity-70">Bekasi Timur</p>
                </div>
            </a>

            <!-- Nav -->
            <nav class="hidden lg:flex items-center space-x-1">
                @php $navs = ['Home' => 'public.home', 'Artikel' => 'public.articles.index', 'Tentang' => 'public.about', 'Kontak' => 'public.contact']; @endphp
                @foreach($navs as $label => $route)
                    <a href="{{ route($route) }}" 
                       class="px-3.5 py-2 text-[12px] font-black uppercase tracking-widest rounded-xl transition-all
                              {{ request()->routeIs($route) ? 'bg-primary text-white shadow-md' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            <!-- Login/Auth -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-premium px-7 py-2.5 bg-on-surface text-white text-[11px] font-black rounded-full shadow-lg hover:shadow-primary/20 hover:scale-105 transition-all uppercase tracking-widest">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-premium px-7 py-2.5 bg-primary text-white text-[11px] font-black rounded-full shadow-lg hover:shadow-primary/20 hover:scale-105 transition-all uppercase tracking-widest">Login</a>
                @endauth
            </div>
        </div>
        
        <!-- Reading Progress (Dynamic) -->
        <div class="absolute bottom-0 left-6 right-6 h-[2px] bg-outline-variant/10 overflow-hidden rounded-full">
            <div id="readingProgress" class="h-full w-0"></div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-[100px]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#0f172a] text-white pt-12 pb-8 px-6 md:px-12 mt-12 relative overflow-hidden">
        {{-- Decorative background elements --}}
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-primary/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3 opacity-40"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-tr from-primary to-teal-500 rounded-lg flex items-center justify-center text-white shadow-lg rotate-3">
                            <span class="material-symbols-outlined text-[20px]">health_and_safety</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-black tracking-tight font-jakarta uppercase leading-none">Posyandu <span class="text-primary">Digital</span></span>
                            <span class="text-[6px] text-white/40 font-black uppercase tracking-[0.3em] mt-1">Bekasi Timur</span>
                        </div>
                    </div>
                    <p class="text-[12px] text-white/50 font-medium leading-relaxed">
                        Platform digital terintegrasi untuk layanan kesehatan ibu dan anak yang modern dan efisien.
                    </p>
                    <div class="flex gap-2.5">
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-primary transition-all group">
                            <i class="fab fa-instagram text-white/60 group-hover:text-white text-[10px]"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-primary transition-all group">
                            <i class="fab fa-whatsapp text-white/60 group-hover:text-white text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-[9px] font-black text-white uppercase tracking-[0.3em] mb-6 flex items-center gap-2">
                        <span class="w-4 h-px bg-primary"></span>
                        Informasi
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('public.about') }}" class="text-white/60 hover:text-primary transition-all flex items-center gap-2 group text-[11px] font-bold">Tentang Kami</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-white/60 hover:text-primary transition-all flex items-center gap-2 group text-[11px] font-bold">Hubungi Kami</a></li>
                        <li><a href="{{ route('public.articles.index') }}" class="text-white/60 hover:text-primary transition-all flex items-center gap-2 group text-[11px] font-bold">Update Berita</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[9px] font-black text-white uppercase tracking-[0.3em] mb-6 flex items-center gap-2">
                        <span class="w-4 h-px bg-primary"></span>
                        Layanan
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('public.articles.index') }}" class="text-white/60 hover:text-primary transition-all flex items-center gap-2 group text-[11px] font-bold">Portal Edukasi</a></li>
                        <li><a href="{{ route('public.home') }}#jadwal" class="text-white/60 hover:text-primary transition-all flex items-center gap-2 group text-[11px] font-bold">Jadwal Posyandu</a></li>
                        <li><a href="{{ route('login') }}" class="text-white/60 hover:text-primary transition-all flex items-center gap-2 group text-[11px] font-bold">Sistem Kader</a></li>
                    </ul>
                </div>

                <div class="relative group">
                    <div class="relative p-5 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <h4 class="text-[9px] font-black text-white uppercase tracking-[0.3em] mb-3">Butuh Bantuan?</h4>
                        <a href="{{ route('public.contact') }}" class="w-full py-2.5 bg-white text-[#0f172a] text-[8px] font-black uppercase tracking-widest rounded-lg hover:bg-primary hover:text-white transition-all text-center block shadow-lg shadow-white/5">
                            Hubungi Support
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="pt-6 border-t border-white/5 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-[8px] font-black text-white/30 uppercase tracking-[0.2em]">&copy; {{ date('Y') }} POSYANDU DIGITAL BEKASI TIMUR. ALL RIGHTS RESERVED.</p>
                <div class="flex gap-5 text-[8px] font-black text-white/30 uppercase tracking-[0.2em]">
                    <a href="#" class="hover:text-white transition-all">Privacy</a>
                    <a href="#" class="hover:text-white transition-all">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Reading Progress Logic
        window.addEventListener('scroll', () => {
            const h = document.documentElement;
            const b = document.body;
            const st = 'scrollTop';
            const sh = 'scrollHeight';
            const progress = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            const progBar = document.getElementById('readingProgress');
            if (progBar) progBar.style.width = progress + '%';

            // Header Effect
            const header = document.getElementById('mainHeader');
            if (window.scrollY > 40) {
                header.classList.add('py-2', 'top-1', 'shadow-2xl');
                header.classList.remove('py-4', 'top-2');
            } else {
                header.classList.remove('py-2', 'top-1', 'shadow-2xl');
                header.classList.add('py-4', 'top-2');
            }
        });
    </script>
</body>
</html>
