<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Posyandu') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts (Public Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Scripts & Styles (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- WAJIB: Livewire Styles -->
    @livewireStyles
    
    <style>
        :root { --sidebar-width: 260px; }
        
        #mainContent {
            width: 100% !important;
            transition: all 0.3s ease-in-out;
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
            }
            #mainContent {
                width: 100% !important;
                min-width: 0;
                display: flex;
                flex-direction: column;
            }
        }

        /* Prevent table overlap in cards */
        .premium-card, .bento-card {
            max-width: 100%;
        }
        
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    <div class="min-h-screen app-grid bg-dashboard">
        <!-- Sidebar -->
        @include('components.layouts.app.sidebar')
        
        <!-- Main Content Wrapper -->
        <div id="mainContent" class="flex-1 flex-shrink-0 flex flex-col min-h-screen transition-all duration-300 ease-in-out relative overflow-y-auto">
            
            <!-- Navbar (Now part of the right-side flow) -->
            <x-layouts.app.navbar />
            
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
    
    {{-- Session Notifications --}}
    @if (session('success'))
        <x-ui.notification type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-ui.notification type="error" :message="session('error')" />
    @endif

    @if (session('warning'))
        <x-ui.notification type="warning" :message="session('warning')" />
    @endif
    
    @stack('scripts')
    
</body>
</html>