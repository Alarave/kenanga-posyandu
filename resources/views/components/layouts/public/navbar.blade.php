<header id="publicNav" class="top">
    <div class="nav-inner">
        {{-- Logo --}}
        <a href="{{ route('public.home') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="nav-logo-text">
                <span class="nav-logo-name">Posyandu <span>Digital</span></span>
                <span class="nav-logo-sub">Bekasi Timur</span>
            </div>
        </a>

        {{-- Desktop Nav Links --}}
        @php
            $navItems = [
                ['label' => 'Beranda',  'route' => 'public.home',           'icon' => 'fa-house'],
                ['label' => 'Artikel',  'route' => 'public.articles.index', 'icon' => 'fa-newspaper'],
                ['label' => 'Tentang',  'route' => 'public.about',          'icon' => 'fa-circle-info'],
                ['label' => 'Kontak',   'route' => 'public.contact',        'icon' => 'fa-envelope'],
            ];
        @endphp

        <nav class="nav-links" aria-label="Navigasi Utama">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Right side: Auth + Hamburger --}}
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-cta nav-cta-dashboard hidden md:inline-flex">
                    <i class="fas fa-gauge-high text-xs"></i>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-cta nav-cta-login hidden md:inline-flex">
                    <i class="fas fa-arrow-right-to-bracket text-xs"></i>
                    Masuk
                </a>
            @endauth

            {{-- Mobile hamburger --}}
            <button id="hamburgerBtn" class="nav-hamburger" aria-label="Buka menu" aria-expanded="false">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </div>

    {{-- Reading progress --}}
    <div id="readingProgress"></div>
</header>

{{-- Mobile Menu --}}
<div id="mobileMenu" role="dialog" aria-label="Menu Mobile">
    @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}"
           class="mobile-nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
            <span class="dot"></span>
            <i class="fas {{ $item['icon'] }} text-sm w-4 text-center opacity-70"></i>
            {{ $item['label'] }}
        </a>
    @endforeach
    <div class="mobile-cta">
        @auth
            <a href="{{ route('dashboard') }}" class="nav-cta nav-cta-dashboard w-full justify-center">
                <i class="fas fa-gauge-high text-xs"></i>
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="nav-cta nav-cta-login w-full justify-center">
                <i class="fas fa-arrow-right-to-bracket text-xs"></i>
                Masuk ke Akun
            </a>
        @endauth
    </div>
</div>

<script>
(function () {
    const nav      = document.getElementById('publicNav');
    const progress = document.getElementById('readingProgress');
    const hamburger = document.getElementById('hamburgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    function onScroll() {
        const scrolled = window.scrollY > 20;
        if(nav) {
            nav.classList.toggle('scrolled', scrolled);
            nav.classList.toggle('top', !scrolled);
        }

        if (progress) {
            const doc = document.documentElement;
            const pct = (doc.scrollTop) / (doc.scrollHeight - doc.clientHeight) * 100;
            progress.style.width = Math.min(pct, 100) + '%';
        }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function () {
            const isOpen = mobileMenu.classList.contains('open');
            mobileMenu.classList.toggle('open', !isOpen);
            hamburger.classList.toggle('open', !isOpen);
            hamburger.setAttribute('aria-expanded', String(!isOpen));
            document.body.style.overflow = isOpen ? '' : 'hidden';
        });

        document.addEventListener('click', function (e) {
            if (!nav.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                mobileMenu.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });
    }
})();
</script>
