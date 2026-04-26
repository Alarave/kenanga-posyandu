<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Posyandu') }} | @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Public Sans', sans-serif; background: #fdfdfd; }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 104, 95, 0.1);
        }
        /* Focus state for better accessibility */
        input:focus { border-color: #00685f !important; border-width: 2px !important; }
        /* Larger tap targets for older fingers */
        label { margin-bottom: 0.75rem !important; display: block; font-size: 1.125rem !important; }
        input[type="checkbox"] { width: 1.5rem; height: 1.5rem; }
    </style>
</head>
<body class="antialiased text-slate-800">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        {{-- ── LEFT SIDE: Branding & Illustration (Visible on Desktop) ── --}}
        <div class="hidden lg:flex flex-col justify-center items-center bg-teal-900 relative overflow-hidden px-20">
            {{-- Decorative circles --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-teal-400/10 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

            <div class="relative z-10 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-teal-500 rounded-[2rem] text-white shadow-2xl mb-10">
                    <span class="material-symbols-outlined text-[48px]">health_and_safety</span>
                </div>
                <h1 class="text-5xl font-black text-white mb-6 font-jakarta tracking-tight leading-tight">
                    Sistem Layanan <br> <span class="text-teal-400 italic">Posyandu Digital.</span>
                </h1>
                <p class="text-teal-100 text-xl font-medium max-w-md mx-auto opacity-80 leading-relaxed italic">
                    Memudahkan pencatatan dan pemantauan kesehatan seluruh warga dalam satu genggaman.
                </p>
            </div>
            
            <div class="absolute bottom-10 left-10 text-teal-500/30 font-black text-6xl uppercase tracking-[0.2em] pointer-events-none select-none">
                POSYANDU
            </div>
        </div>

        {{-- ── RIGHT SIDE: Auth Form ── --}}
        <div class="flex flex-col justify-center items-center px-6 py-12 lg:px-20 bg-slate-50/50">
            <div class="w-full max-w-[500px]">
                
                {{-- Logo for mobile --}}
                <div class="lg:hidden flex justify-center mb-10">
                    <div class="flex flex-col items-center gap-3">
                         <div class="w-16 h-16 bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-xl">
                            <span class="material-symbols-outlined text-[32px]">health_and_safety</span>
                        </div>
                        <h2 class="text-2xl font-black text-teal-900 font-jakarta uppercase tracking-tighter">Posyandu Digital</h2>
                    </div>
                </div>

                {{-- The Form Card --}}
                <div class="auth-card p-10 md:p-14 rounded-[3.5rem] shadow-2xl">
                    
                    {{-- Alert Messages (Session) --}}
                    @if (session('status'))
                        <div class="mb-8 p-5 bg-teal-50 text-teal-700 border border-teal-200 rounded-2xl text-lg font-bold flex items-center gap-3">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl">
                             <div class="text-red-700 font-bold flex items-center gap-2 mb-3 text-lg">
                                <span class="material-symbols-outlined">error</span>
                                Ada kesalahan pengisian:
                            </div>
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-600 text-base font-semibold">• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>

                {{-- Copyright --}}
                <div class="mt-12 text-center">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest leading-loose">
                        &copy; {{ date('Y') }} POSYANDU DIGITAL <br> BEKASI TIMUR
                    </p>
                </div>

            </div>
        </div>

    </div>
</body>
</html>