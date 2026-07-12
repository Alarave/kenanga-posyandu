<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Suppress harmless View Transition abort rejections (e.g. from tab visibility or double navigation) -->
    <script>
        window.addEventListener('unhandledrejection', function (event) {
            if (event.reason && (event.reason.name === 'AbortError' || event.reason.name === 'InvalidStateError')) {
                const msg = event.reason.message || '';
                if (msg.includes('Transition was aborted') || msg.includes('aborted')) {
                    event.preventDefault();
                }
            }
        });
    </script>

    <title>{{ config('app.name', 'Posyandu') }} - @yield('title', 'Dashboard')</title>

    <!-- Speculation Rules: Prerender frequently visited pages from dashboard -->
    <script type="speculationrules">
        {
            "prerender": [
                {
                    "source": "list",
                    "urls": ["{{ route('admin.patients.index') }}", "{{ route('admin.medical-records.index') }}", "{{ route('admin.schedules.index') }}"]
                }
            ]
        }
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Fonts: preconnect first for minimal DNS latency -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- Core fonts (deferred to prevent render-blocking FOUT on LCP text) -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;600;700&family=Outfit:wght@300;400;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;600;700&family=Outfit:wght@300;400;600;700&display=swap"></noscript>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap"></noscript>

    <!-- Font Awesome: deferred to unblock main thread (icons are non-LCP) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>

    <!-- Scripts & Styles (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/admin.js'])

    <!-- WAJIB: Livewire Styles -->
    @livewireStyles
    
    <style>
        @view-transition { navigation: auto; }
        :root { --sidebar-width: 260px; }
        @media (max-width: 1023px) {
            :root { --sidebar-width: 0px; }
        }

        /* High-performance CSS transitions for sidebar collapse */
        .sidebar-text, 
        .sidebar-section-label {
            transition: opacity 200ms ease-out, max-width 200ms ease-out, visibility 200ms;
            opacity: 1;
            max-width: 200px;
            visibility: visible;
            display: inline-block;
            vertical-align: middle;
        }

        .sidebar-collapsed .sidebar-text, 
        .sidebar-collapsed .sidebar-section-label {
            opacity: 0 !important;
            max-width: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            overflow: hidden !important;
        }

        #mainContent {
            width: 100%;
        }

        @media (min-width: 1024px) {
            .app-grid {
                display: grid;
                grid-template-columns: var(--sidebar-width, 260px) 1fr;
                min-height: 100vh;
            }
            #sidebar {
                position: sticky !important;
                top: 0;
                height: 100vh;
                width: var(--sidebar-width) !important;
                transition: width 300ms ease-out;
            }
            #mainContent {
                width: 100%;
                min-width: 0;
                display: flex;
                flex-direction: column;
            }
        }

        /* Prevent table overflow in cards */
        .section-card, .premium-card, .bento-card, .widget-card {
            max-width: 100%;
            overflow: hidden;
        }

        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }

        [x-cloak] {
            display: none !important;
        }

        @media print {
            /* Sembunyikan elemen navigasi dan filter saat cetak (DASH-36) */
            header, nav, #sidebar, .sidebar, .navbar, .no-print, footer, #toast-container {
                display: none !important;
            }
            body, main {
                background: white !important;
                color: black !important;
            }
            #mainContent {
                margin: 0 !important;
                padding: 0 !important;
            }
            .app-grid {
                display: block !important;
            }
            /* Hilangkan bayangan & pastikan ukuran penuh */
            .widget-card, .kpi-card, .premium-card {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
                page-break-inside: avoid;
            }
            .hero-gradient, .hero-orb-1, .hero-orb-2 {
                background: none !important;
                display: none !important;
            }
        }
    </style>

    @stack('styles')
    
    <!-- Prevent Sidebar Layout Shift (CLS) on initial load -->
    <script>
        (function () {
            var collapsed = localStorage.getItem('sidebar_v2_collapsed') === 'true';
            if (collapsed) {
                document.documentElement.style.setProperty('--sidebar-width', '64px');
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    <div class="min-h-screen app-grid bg-dashboard">
        <!-- Sidebar -->
        @include('components.layouts.ui.sidebar')
        
        <!-- Main Content Wrapper -->
        <div id="mainContent" class="flex-1 shrink-0 flex flex-col min-h-screen transition-all duration-300 ease-in-out relative">
            
            <!-- Navbar (Now part of the right-side flow) -->
            <x-layouts.ui.navbar />
            
            <!-- Main Content Area -->
            <main class="flex-1 w-full p-4 md:px-8 md:pt-1 md:pb-8">
                @yield('content')
            </main>
            
            <!-- Footer -->
            @include('components.layouts.ui.footer')
        </div>
    </div>

    <!-- WAJIB: Livewire Scripts -->
    @livewireScripts
    
    {{-- Session & Dynamic Notifications --}}
    <div id="toast-container" x-data="{ 
        notifications: [],
        add(type, message) {
            const id = Date.now();
            this.notifications.push({ id, type, message });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }" @notify.window="add($event.detail.type, $event.detail.message)" class="fixed bottom-4 right-4 z-50 flex flex-col gap-3 w-full max-w-sm">
        
        {{-- Existing Session Notifications (Initial Load) --}}
        @if (session('success'))
            <x-ui.notification type="success" :message="session('success')" />
            @php session()->forget('success'); @endphp
        @endif

        @if (session('error'))
            <x-ui.notification type="error" :message="session('error')" />
            @php session()->forget('error'); @endphp
        @endif

        {{-- Dynamic Notifications from Livewire --}}
        <template x-for="n in notifications" :key="n.id">
            <x-ui.notification x-bind:type="n.type" x-bind:message="n.message" />
        </template>
    </div>
    
    @stack('scripts')
    
    {{-- Global Script to toggle .has-value class on date inputs (supports browser date-placeholder translation) --}}
    {{-- Global Script to toggle .has-value class on date inputs (supports browser date-placeholder translation) --}}
    <script>
        function updateDateInputClass(input) {
            requestAnimationFrame(function () {
                if (input.value) {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });
        }

        // Toggle Session Expired Modal
        window.showSessionExpiredModal = function () {
            const modal = document.getElementById('session-expired-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            // Listen to input and change events
            ['input', 'change'].forEach(function (event) {
                document.body.addEventListener(event, function (e) {
                    if (e.target && (e.target.type === 'date' || e.target.type === 'datetime-local')) {
                        updateDateInputClass(e.target);
                    }
                });
            });

            // Initialize existing inputs
            document.querySelectorAll('input[type="date"], input[type="datetime-local"]').forEach(updateDateInputClass);

            // MutationObserver to automatically apply class to morphed/added date inputs (essential for Livewire v3)
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.addedNodes.length) {
                        mutation.addedNodes.forEach(function (node) {
                            if (node.nodeType === 1) {
                                if (node.type === 'date' || node.type === 'datetime-local') {
                                    updateDateInputClass(node);
                                }
                                node.querySelectorAll('input[type="date"], input[type="datetime-local"]').forEach(updateDateInputClass);
                            }
                        });
                    }
                });
            });
            observer.observe(document.body, { childList: true, subtree: true });
        });

        // High-performance Livewire hook fallback
        document.addEventListener('livewire:init', function () {
            // Intercept session expiration (status 419)
            Livewire.hook('request', ({ fail }) => {
                fail(({ status, preventDefault }) => {
                    if (status === 419) {
                        preventDefault();
                        if (window.showSessionExpiredModal) {
                            window.showSessionExpiredModal();
                        } else {
                            window.location.reload();
                        }
                    }
                });
            });

            Livewire.hook('request.respond', function () {
                document.querySelectorAll('input[type="date"], input[type="datetime-local"]').forEach(updateDateInputClass);
            });
            Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                succeed(function () {
                    queueMicrotask(function () {
                        document.querySelectorAll('input[type="date"], input[type="datetime-local"]').forEach(updateDateInputClass);
                    });
                });
            });
        });
    </script>
    
    {{-- Custom Session Expired Modal --}}
    <div id="session-expired-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"></div>
        <div class="relative bg-white dark:bg-slate-900 rounded-3xl p-6 md:p-8 max-w-md w-full border border-slate-100 dark:border-slate-800 shadow-2xl transform transition-all text-center">
            <div class="w-16 h-16 rounded-full bg-rose-50 dark:bg-rose-950/30 text-rose-500 flex items-center justify-center mx-auto mb-6 shadow-inner">
                <span class="material-symbols-outlined text-[32px] animate-pulse">lock_clock</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-2 font-outfit">Sesi Anda Telah Berakhir</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">
                Untuk menjaga keamanan data Anda, sesi login Anda telah kedaluwarsa secara otomatis. Silakan masuk kembali atau segarkan halaman ini.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-teal-600 hover:bg-teal-700 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-teal-600/20 transition-all duration-300 transform hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Masuk Kembali
                </a>
                <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200 px-5 py-3 text-sm font-bold text-slate-700 transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">refresh</span>
                    Segarkan
                </button>
            </div>
        </div>
    </div>
</body>
</html>