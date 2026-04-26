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
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>

    <!-- Chart.js for Growth Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Scripts & Styles (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- WAJIB: Livewire Styles -->
    @livewireStyles
    
    @stack('styles')
</head>
<body class="font-sans antialiased" style="background:#f8fafc; color:#0f172a;">

    <div class="min-h-screen flex overflow-hidden bg-dashboard">
        <!-- Sidebar -->
        @include('components.layouts.app.sidebar')
        
        <!-- Main Content Wrapper -->
        <div id="mainContent" class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out relative overflow-y-auto lg:ml-[260px]">
            
            <!-- Navbar (Now part of the right-side flow) -->
            @php
                $routeTitles = [
                    'dashboard'                  => ['Dashboard',        'Ringkasan data posyandu'],
                    'admin.analytics'            => ['Analytics',        'Statistik & grafik data'],
                    'admin.patients.*'           => ['Data Warga',       'Kelola data pasien posyandu'],
                    'admin.posyandu.*'           => ['Data Posyandu',    'Kelola unit posyandu'],
                    'admin.schedules.*'          => ['Jadwal Kegiatan',  'Kelola jadwal posyandu'],
                    'admin.medical-records.*'    => ['Rekam Medis',      'Data pemeriksaan pasien'],
                    'admin.reports.*'            => ['Laporan Bulanan',  'Laporan & ekspor data'],
                    'admin.activity-logs.*'      => ['Log Aktivitas',    'Riwayat aktivitas sistem'],
                    'admin.articles.*'           => ['Artikel & Berita', 'Kelola konten edukasi'],
                    'admin.gallery.*'            => ['Galeri',           'Kelola foto & media'],
                    'admin.pedukuhans.*'         => ['Data Pedukuhan',   'Kelola data wilayah'],
                    'admin.users.*'              => ['Manajemen User',   'Kelola akun pengguna'],
                ];
                $pageTitle    = 'Dashboard';
                $pageSubtitle = 'Sistem Informasi Posyandu';
                foreach ($routeTitles as $pattern => $labels) {
                    if (request()->routeIs($pattern)) {
                        [$pageTitle, $pageSubtitle] = $labels;
                        break;
                    }
                }
            @endphp
            @include('components.layouts.ui.navbar', compact('pageTitle', 'pageSubtitle'))
            
            <!-- Main Content Area -->
            <main class="flex-1 p-4 md:p-8">
                @yield('content')
            </main>
            
            <!-- Footer -->
            @include('components.layouts.ui.footer')
        </div>
    </div>

    <!-- WAJIB: Livewire Scripts -->
    @livewireScripts
    
    @stack('scripts')
    
</body>
</html>