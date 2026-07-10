@push('scripts')
    @vite(['resources/js/charts.js'])
@endpush

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <style>
        .hero-gradient { background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #115e59 100%); }
        .hero-orb-1 { background: radial-gradient(circle, rgba(204,251,241,0.12) 0%, transparent 70%); }
        .hero-orb-2 { background: radial-gradient(circle, rgba(45,212,191,0.1) 0%, transparent 70%); }

        @keyframes ping-slow {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.8); opacity: 0; }
        }
        .animate-ping-slow { animation: ping-slow 2.5s ease-in-out infinite; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
        canvas { touch-action: pan-y; }

        /* ── KPI Cards: rich gradient personalities ── */
        .kpi-card {
            position: relative; overflow: hidden; border-radius: 24px;
            padding: 1.4rem 1.5rem 1.25rem;
            display: flex; flex-direction: column;
            transition: transform 250ms ease-out, box-shadow 250ms ease-out;
            cursor: default;
        }
        .kpi-card:hover { transform: translateY(-5px); }

        /* Noise texture overlay */
        .kpi-card::after {
            content: ''; position: absolute; inset: 0; border-radius: 24px;
            pointer-events: none;
            background-image: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.12) 0%, transparent 50%);
        }

        /* Color variants */
        .kpi-slate  { background: linear-gradient(145deg,#1e293b,#0f172a); box-shadow:0 4px 20px -4px rgba(15,23,42,.45); }
        .kpi-teal   { background: linear-gradient(145deg,#0d9488,#0f766e); box-shadow:0 4px 20px -4px rgba(13,148,136,.5); }
        .kpi-rose   { background: linear-gradient(145deg,#e11d48,#be123c); box-shadow:0 4px 20px -4px rgba(225,29,72,.5); }
        .kpi-indigo { background: linear-gradient(145deg,#4f46e5,#3730a3); box-shadow:0 4px 20px -4px rgba(79,70,229,.5); }
        .kpi-red    { background: linear-gradient(145deg,#dc2626,#b91c1c); box-shadow:0 4px 20px -4px rgba(220,38,38,.5); }
        .kpi-blue   { background: linear-gradient(145deg,#2563eb,#1d4ed8); box-shadow:0 4px 20px -4px rgba(37,99,235,.5); }
        .kpi-amber  { background: linear-gradient(145deg,#d97706,#b45309); box-shadow:0 4px 20px -4px rgba(217,119,6,.5); }

        .kpi-slate:hover  { box-shadow:0 14px 36px -6px rgba(15,23,42,.6); }
        .kpi-teal:hover   { box-shadow:0 14px 36px -6px rgba(13,148,136,.65); }
        .kpi-rose:hover   { box-shadow:0 14px 36px -6px rgba(225,29,72,.65); }
        .kpi-indigo:hover { box-shadow:0 14px 36px -6px rgba(79,70,229,.65); }
        .kpi-red:hover    { box-shadow:0 14px 36px -6px rgba(220,38,38,.65); }
        .kpi-blue:hover   { box-shadow:0 14px 36px -6px rgba(37,99,235,.65); }
        .kpi-amber:hover  { box-shadow:0 14px 36px -6px rgba(217,119,6,.65); }

        /* Icon wrappers */
        .kpi-card .kpi-icon-wrap {
            width:44px; height:44px; border-radius:13px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
            background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.18);
            transition: transform 250ms ease-out;
        }
        .kpi-card:hover .kpi-icon-wrap { transform: scale(1.1) rotate(-4deg); }

        /* Unit badge */
        .kpi-unit {
            font-size:9.5px; font-weight:800; letter-spacing:0.08em;
            text-transform:uppercase; padding:2px 7px; border-radius:5px;
            background:rgba(255,255,255,0.16); color:rgba(255,255,255,0.8);
        }

        /* Big number */
        .kpi-number {
            font-size:2.75rem; font-weight:900; line-height:1;
            letter-spacing:-0.045em; margin:0.55rem 0 0.15rem;
            font-family:'Outfit',sans-serif; color:#fff;
        }

        /* Label */
        .kpi-label {
            font-size:0.68rem; font-weight:800; letter-spacing:0.1em;
            text-transform:uppercase; margin-bottom:0.8rem;
            color:rgba(255,255,255,0.65);
        }

        /* Description area */
        .kpi-desc {
            font-size:0.75rem; font-weight:500; line-height:1.5;
            border-top:1px solid rgba(255,255,255,0.15);
            padding-top:0.7rem; margin-top:auto;
            color:rgba(255,255,255,0.55);
        }

        /* Bottom accent line */
        .kpi-accent-bar {
            position:absolute; bottom:0; left:0; right:0; height:3px;
            background:linear-gradient(90deg,rgba(255,255,255,0.5),rgba(255,255,255,0.05));
        }

        /* ── Chart cards ── */
        .chart-card { background:white; border-radius:20px; padding:1.75rem 2rem; border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(0,0,0,0.05); }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(10px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .animate-fadeIn { animation: fadeInUp 280ms ease-out both; }

        @keyframes scaleUp {
            from { opacity:0; transform:scale(0.96); }
            to   { opacity:1; transform:scale(1); }
        }
        .animate-scaleUp { animation: scaleUp 200ms ease-out both; }

        /* ── Mobile KPI overrides ── */
        @media (max-width: 639px) {
            .kpi-card { padding: 1rem 1rem 0.9rem; border-radius: 18px; }
            .kpi-number { font-size: 2rem; }
            .kpi-label { font-size: 0.6rem; margin-bottom: 0.6rem; }
            .kpi-desc { font-size: 0.68rem; padding-top: 0.55rem; }
            .kpi-icon-wrap { width: 36px; height: 36px; border-radius: 10px; }
            .kpi-unit { font-size: 8px; padding: 2px 5px; }
        }

        /* ── Mobile tab nav ── */
        @media (max-width: 479px) {
            .analytics-tab-btn { padding: 0.6rem 0.875rem; font-size: 0.75rem; }
        }
    </style>
@endpush

<div class="max-w-7xl mx-auto space-y-4 sm:space-y-6 pb-20 px-3 sm:px-6">

    {{-- ── Hero Section (Analitik) ── --}}
    <section class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-lg" style="background:#0f766e;">
        {{-- Background layers --}}
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 hero-orb-1 rounded-full filter blur-[70px] animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 hero-orb-2 rounded-full filter blur-[70px]" style="animation:pulse 5s ease-in-out 1.5s infinite;"></div>
        {{-- Decorative grid pattern --}}
        <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px),linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size:40px 40px;"></div>

        <div class="relative z-10 px-5 py-7 sm:px-8 sm:py-10 md:px-12 md:py-12">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-6">

                {{-- Left: Title block --}}
                <div class="min-w-0">
                    {{-- Live badge --}}
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full mb-3 sm:mb-5"
                        style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.18);">
                        <span class="relative flex h-1.5 w-1.5 shrink-0">
                            <span class="animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-teal-200 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-teal-300"></span>
                        </span>
                        <span class="text-[10px] font-bold text-teal-100 tracking-wider uppercase leading-none">Analitik &middot; Posyandu Kenanga</span>
                    </div>

                    <h1 class="text-[1.6rem] sm:text-3xl md:text-4xl lg:text-[2.75rem] font-black text-white leading-[1.1] mb-2 sm:mb-3" style="letter-spacing:-0.03em; font-family:'Outfit',sans-serif;">
                        Wawasan &amp; Data Kesehatan
                    </h1>
                    <p class="text-teal-100/75 text-xs sm:text-sm leading-relaxed font-medium mb-4 md:mb-0">
                        Periode tahun <span class="text-white font-black">{{ $selectedYear }}</span>
                        @if(auth()->user()->posyandu)
                            &nbsp;&middot;&nbsp; <span class="text-teal-200 font-semibold">{{ auth()->user()->posyandu->name }}</span>
                        @endif
                    </p>

                    {{-- Meta pills: visible on mobile below title, hidden on md (shown right column) --}}
                    <div class="flex flex-wrap gap-2 md:hidden no-print">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg"
                            style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.14);">
                            <span class="material-symbols-outlined text-[14px] text-teal-300">sync</span>
                            <span class="text-[11px] font-semibold text-teal-100">{{ $lastUpdated }}</span>
                        </div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg"
                            style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.14);">
                            <span class="material-symbols-outlined text-[14px] text-teal-300">query_stats</span>
                            <span class="text-[11px] font-semibold text-teal-100"><strong class="text-white font-black">{{ number_format($totalKunjungan) }}</strong> kunjungan</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Quick meta — desktop only --}}
                <div class="hidden md:flex flex-col gap-2.5 shrink-0">
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-teal-100 no-print"
                        style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12);">
                        <span class="material-symbols-outlined text-[18px] text-teal-300">sync</span>
                        <span class="text-xs">Diperbarui: <strong class="text-white font-black">{{ $lastUpdated }}</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-teal-100"
                        style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12);">
                        <span class="material-symbols-outlined text-[18px] text-teal-300">query_stats</span>
                        <span class="text-xs">Total: <strong class="text-white font-black">{{ number_format($totalKunjungan) }}</strong> kunjungan</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Tab Navigation ── --}}
    <div class="flex overflow-x-auto whitespace-nowrap bg-slate-100/80 backdrop-blur-sm p-1.5 sm:p-2 rounded-2xl border border-slate-200/80 shadow-sm gap-1 sm:gap-2 scrollbar-none w-full">
        <button wire:click="$set('activeTab', 'overview')" @class([
            'analytics-tab-btn flex-1 shrink-0 min-w-max py-3.5 sm:py-4 px-4 sm:px-7 rounded-xl text-sm sm:text-[15px] transition-all duration-200 flex items-center justify-center gap-2 sm:gap-2.5 cursor-pointer',
            'bg-white text-teal-850 border border-teal-100/80 shadow-md font-black tracking-tight' => $activeTab === 'overview',
            'text-slate-500 hover:text-slate-800 hover:bg-white/60 border border-transparent font-extrabold' => $activeTab !== 'overview'
        ]) style="min-width: max-content; flex-shrink: 0;">
            <span class="material-symbols-outlined text-[18px] sm:text-[22px] {{ $activeTab === 'overview' ? 'text-teal-600' : 'text-slate-400' }}">dashboard</span>
            <span class="hidden xs:inline sm:inline">Overview</span>
            <span class="inline xs:hidden sm:hidden">Ov.</span>
            @if($activeTab === 'overview')<span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-teal-500 ml-0.5 sm:ml-1"></span>@endif
        </button>
        <button wire:click="$set('activeTab', 'balita')" @class([
            'analytics-tab-btn flex-1 shrink-0 min-w-max py-3.5 sm:py-4 px-4 sm:px-7 rounded-xl text-sm sm:text-[15px] transition-all duration-200 flex items-center justify-center gap-2 sm:gap-2.5 cursor-pointer',
            'bg-white text-teal-850 border border-teal-100/80 shadow-md font-black tracking-tight' => $activeTab === 'balita',
            'text-slate-500 hover:text-slate-800 hover:bg-white/60 border border-transparent font-extrabold' => $activeTab !== 'balita'
        ]) style="min-width: max-content; flex-shrink: 0;">
            <span class="material-symbols-outlined text-[18px] sm:text-[22px] {{ $activeTab === 'balita' ? 'text-teal-600' : 'text-slate-400' }}">child_care</span>
            Balita
            @if($activeTab === 'balita')<span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-teal-500 ml-0.5 sm:ml-1"></span>@endif
        </button>
        <button wire:click="$set('activeTab', 'pregnancy')" @class([
            'analytics-tab-btn flex-1 shrink-0 min-w-max py-3.5 sm:py-4 px-4 sm:px-7 rounded-xl text-sm sm:text-[15px] transition-all duration-200 flex items-center justify-center gap-2 sm:gap-2.5 cursor-pointer',
            'bg-white text-rose-850 border border-rose-100/80 shadow-md font-black tracking-tight' => $activeTab === 'pregnancy',
            'text-slate-500 hover:text-slate-800 hover:bg-white/60 border border-transparent font-extrabold' => $activeTab !== 'pregnancy'
        ]) style="min-width: max-content; flex-shrink: 0;">
            <span class="material-symbols-outlined text-[18px] sm:text-[22px] {{ $activeTab === 'pregnancy' ? 'text-rose-500' : 'text-slate-400' }}">pregnant_woman</span>
            Hamil
            @if($activeTab === 'pregnancy')<span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-rose-500 ml-0.5 sm:ml-1"></span>@endif
        </button>
        <button wire:click="$set('activeTab', 'lansia')" @class([
            'analytics-tab-btn flex-1 shrink-0 min-w-max py-3.5 sm:py-4 px-4 sm:px-7 rounded-xl text-sm sm:text-[15px] transition-all duration-200 flex items-center justify-center gap-2 sm:gap-2.5 cursor-pointer',
            'bg-white text-indigo-850 border border-indigo-100/80 shadow-md font-black tracking-tight' => $activeTab === 'lansia',
            'text-slate-500 hover:text-slate-800 hover:bg-white/60 border border-transparent font-extrabold' => $activeTab !== 'lansia'
        ]) style="min-width: max-content; flex-shrink: 0;">
            <span class="material-symbols-outlined text-[18px] sm:text-[22px] {{ $activeTab === 'lansia' ? 'text-indigo-500' : 'text-slate-400' }}">elderly</span>
            Lansia
            @if($activeTab === 'lansia')<span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-indigo-500 ml-0.5 sm:ml-1"></span>@endif
        </button>
    </div>

    {{-- ── Unified Control Card (Filter + View Settings) ── --}}
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">

        {{-- ── Baris 1: Filter Global ── --}}
        <div class="p-4 sm:p-6">
            <div class="flex flex-col xl:flex-row gap-4 sm:gap-6 items-start xl:items-end">

                {{-- Label kiri atas --}}
                <div class="flex-1 w-full">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-teal-600">tune</span>
                        Filter Parameter Data
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        {{-- Wilayah Posyandu --}}
                        @if(auth()->user()->isSuperAdmin())
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider pl-1">Wilayah Posyandu</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-teal-600">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                                </span>
                                <select wire:model.live="selectedPosyandu"
                                    class="w-full h-11 pl-9 pr-4 rounded-xl border border-slate-300 text-sm font-semibold text-slate-800 bg-white focus:ring-4 focus:ring-teal-100 focus:border-teal-600 shadow-xs transition-all hover:border-slate-400 focus:outline-none">
                                    <option value="">Semua Wilayah</option>
                                    @foreach(\App\Models\Posyandu::all() as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        {{-- Tahun --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider pl-1">Tahun</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                </span>
                                <select wire:model.live="selectedYear"
                                    class="w-full h-11 pl-9 pr-4 rounded-xl border border-slate-300 text-sm font-semibold text-slate-800 bg-white focus:ring-4 focus:ring-teal-100 focus:border-teal-600 shadow-xs transition-all hover:border-slate-400 focus:outline-none">
                                    @foreach($years as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Bulan --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider pl-1">Bulan</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center {{ ($activeTab === 'overview' && $viewMode === 'yearly') ? 'text-slate-300' : 'text-slate-400' }}">
                                    <span class="material-symbols-outlined text-[18px]">event_note</span>
                                </span>
                                <select wire:model.live="selectedMonth"
                                    @if($activeTab === 'overview' && $viewMode === 'yearly') disabled @endif
                                    class="w-full h-11 pl-9 pr-4 rounded-xl border text-sm font-semibold bg-white focus:ring-4 focus:ring-teal-100 focus:border-teal-600 shadow-xs transition-all focus:outline-none
                                        {{ ($activeTab === 'overview' && $viewMode === 'yearly')
                                            ? 'border-slate-100 text-slate-350 bg-slate-50 cursor-not-allowed'
                                            : 'border-slate-300 text-slate-800 hover:border-slate-400 cursor-pointer' }}">
                                    <option value="">{{ ($activeTab === 'overview' && $viewMode === 'yearly') ? 'Nonaktif (Mode YoY)' : 'Semua Bulan (Tahunan)' }}</option>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}">{{ Carbon\Carbon::create(2000, $m)->translatedFormat('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-3 w-full xl:w-auto shrink-0">
                    <button wire:click="resetFilters"
                        class="flex-1 xl:flex-none h-11 px-4 flex items-center justify-center gap-2 text-red-500 font-semibold text-sm hover:bg-red-50 rounded-xl transition-all">
                        <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                        Reset
                    </button>
                    <button wire:click="refreshStats"
                        wire:loading.attr="disabled"
                        class="flex-1 xl:flex-none h-11 px-6 inline-flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-xs transition-all cursor-pointer focus:outline-none disabled:opacity-60 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined text-[18px]" wire:loading.class="animate-spin" wire:target="refreshStats">sync</span>
                        Perbarui Data
                    </button>
                </div>
            </div>
        </div>

        {{-- ── Baris 2: Pengaturan Visualisasi (hanya untuk tab Overview) ── --}}
        @if($activeTab === 'overview')
        <div class="border-t border-slate-150 bg-slate-50/50 px-6 py-4">
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-indigo-500">insert_chart</span>
                Konfigurasi Visualisasi Grafik Overview
            </p>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">

                {{-- Segmented view mode control --}}
                <div class="flex flex-col gap-1">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider pl-1">Mode Tampilan</span>
                    <div class="inline-flex items-center bg-slate-200/50 rounded-xl p-1 gap-1 border border-slate-200">
                        <button wire:click="$set('viewMode', 'monthly')" @class([
                            'inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-bold tracking-wide transition-all cursor-pointer',
                            'bg-white text-teal-800 shadow-xs border border-slate-200/50' => $viewMode === 'monthly',
                            'text-slate-500 hover:text-slate-900 hover:bg-white/40' => $viewMode !== 'monthly',
                        ])>
                            <span class="material-symbols-outlined text-[16px]">bar_chart</span>
                            Tampilan Bulanan
                        </button>
                        <button wire:click="$set('viewMode', 'yearly')" @class([
                            'inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-bold tracking-wide transition-all cursor-pointer',
                            'bg-white text-indigo-800 shadow-xs border border-slate-200/50' => $viewMode === 'yearly',
                            'text-slate-500 hover:text-slate-900 hover:bg-white/40' => $viewMode !== 'yearly',
                        ])>
                            <span class="material-symbols-outlined text-[16px]">show_chart</span>
                            Year-over-Year (Tahunan)
                        </button>
                    </div>
                </div>


            </div>
        </div>
        @endif
    </div>

    {{-- ── Tab Contents ── --}}
    @if($activeTab === 'overview')
        {{-- ================= OVERVIEW TAB ================= --}}
        <div class="space-y-4 sm:space-y-6 animate-fadeIn">
            {{-- Stats Grid: 2 cols mobile, 4 cols desktop --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                @php
                    $overviewCards = [
                        ['label' => 'Total Kunjungan', 'val' => number_format($totalKunjungan), 'unit' => 'Pemeriksaan', 'icon' => 'analytics', 'color' => 'slate', 'desc' => 'Total rekam medis terdaftar'],
                        ['label' => 'Balita & Anak', 'val' => number_format($totalBalita), 'unit' => 'Jiwa', 'icon' => 'child_care', 'color' => 'teal', 'desc' => 'Kategori Balita, Bayi & Baduta'],
                        ['label' => 'Ibu Hamil', 'val' => number_format($totalIbuHamil), 'unit' => 'Jiwa', 'icon' => 'pregnant_woman', 'color' => 'rose', 'desc' => 'Ibu mengandung terdaftar'],
                        ['label' => 'Lansia', 'val' => number_format($totalLansia), 'unit' => 'Jiwa', 'icon' => 'elderly', 'color' => 'indigo', 'desc' => 'Kategori Lanjut Usia'],
                    ];
                @endphp

                @foreach($overviewCards as $c)
                <div class="kpi-card kpi-{{ $c['color'] }}">
                    <div class="relative z-10 flex items-center justify-between mb-3">
                        <div class="kpi-icon-wrap">
                            <span class="material-symbols-outlined text-[22px] text-white">{{ $c['icon'] }}</span>
                        </div>
                        <span class="kpi-unit">{{ $c['unit'] }}</span>
                    </div>
                    <p class="kpi-number relative z-10">{{ $c['val'] }}</p>
                    <p class="kpi-label relative z-10">{{ $c['label'] }}</p>
                    <p class="kpi-desc relative z-10">{{ $c['desc'] }}</p>
                    <div class="kpi-accent-bar"></div>
                </div>
                @endforeach
            </div>

            {{-- New Layout: Grid 3 Kolom responsif (Desktop: 2 kolom utama di kiri, 1 sidebar di kanan) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                
                {{-- Kiri: Analitik Kehadiran & Grafik Tren (Span-2) --}}
                <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                    
                    {{-- Widget 1: Realisasi Kehadiran --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-xs">
                        <div class="mb-4">
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-teal-600 text-[20px]">how_to_reg</span>
                                Target vs Realisasi Kehadiran Pasien
                            </h3>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Persentase keaktifan kunjungan warga terdaftar di periode terpilih</p>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach([
                                ['label' => 'Balita & Anak', 'visited' => $balitaBerkunjung, 'total' => $totalBalita, 'color' => 'bg-teal-500', 'text' => 'text-teal-700', 'bg' => 'bg-teal-50', 'icon' => 'child_care'],
                                ['label' => 'Ibu Hamil', 'visited' => $ibuHamilBerkunjung, 'total' => $totalIbuHamil, 'color' => 'bg-rose-500', 'text' => 'text-rose-700', 'bg' => 'bg-rose-50', 'icon' => 'pregnant_woman'],
                                ['label' => 'Lansia', 'visited' => $lansiaBerkunjung, 'total' => $totalLansia, 'color' => 'bg-indigo-500', 'text' => 'text-indigo-700', 'bg' => 'bg-indigo-50', 'icon' => 'elderly']
                            ] as $item)
                                @php
                                    $pct = $item['total'] > 0 ? round(($item['visited'] / $item['total']) * 100, 1) : 0;
                                    // Dinamis warna bar
                                    $barColor = $pct >= 75 ? 'bg-emerald-500' : ($pct >= 40 ? 'bg-amber-500' : 'bg-rose-500');
                                @endphp
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between text-xs sm:text-sm font-bold text-slate-700">
                                        <span class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px] text-slate-400">{{ $item['icon'] }}</span>
                                            <span>{{ $item['label'] }}</span>
                                        </span>
                                        <span>
                                            <span class="font-extrabold text-slate-900">{{ $pct }}%</span>
                                            <span class="text-slate-400 font-semibold">({{ $item['visited'] }} / {{ $item['total'] }})</span>
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                        <div class="{{ $barColor }} h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Widget 2: Combined Monthly Visits Trend --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                    <span class="material-symbols-outlined text-teal-600 text-[20px]">insights</span>
                                    Tren Kunjungan Bulanan Gabungan
                                </h3>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">Perbandingan tren frekuensi kunjungan pasien per kategori di posyandu (Dapat diklik untuk detail)</p>
                            </div>
                            <button onclick="downloadChart(visitsTrendChart, 'tren_kunjungan')" class="p-2 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                            </button>
                        </div>
                        <div class="relative h-80 sm:h-96">
                            <canvas id="visitsTrendChart" wire:ignore></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-visitsTrendChart">
                                <span class="material-symbols-outlined text-rose-600 text-4xl mb-2">error</span>
                                <p class="text-sm font-extrabold text-slate-800">Gagal memuat data grafik</p>
                                <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Rangkuman Indikator Kesehatan & Umpan Kasus Risiko (Span-1) --}}
                <div class="space-y-4 sm:space-y-6">
                    
                    {{-- Widget 3: Rangkuman Indikator Kesehatan Utama --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-xs">
                        <div class="mb-4">
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-teal-600 text-[20px]">clinical_notes</span>
                                Indikator Kesehatan Utama
                            </h3>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Ringkasan parameter klinis pasien dari pemeriksaan terbaru</p>
                        </div>
                        
                        <div class="space-y-4">
                            {{-- Balita --}}
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Balita & Anak
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    {{-- Prevalensi Stunting --}}
                                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col items-center text-center justify-between min-h-[140px]">
                                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Prevalensi Stunting</p>
                                        <div class="relative w-14 h-14 flex items-center justify-center mb-2.5">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-emerald-500" stroke-width="4.5"></circle>
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-rose-500" stroke-width="4.5"
                                                        stroke-dasharray="{{ $stuntingRate }} {{ 100 - $stuntingRate }}" stroke-dashoffset="0"></circle>
                                            </svg>
                                            <span class="absolute text-[10px] font-black text-slate-800">{{ $stuntingRate }}%</span>
                                        </div>
                                        <div class="flex items-center justify-center gap-2 text-[8px] font-black border-t border-slate-200/55 pt-1.5 w-full">
                                            <span class="text-rose-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-rose-500"></span> Stunting: {{ $stuntingRate }}%
                                            </span>
                                            <span class="text-slate-300">|</span>
                                            <span class="text-emerald-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Normal: {{ round(100 - $stuntingRate, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                    
                                    {{-- Imunisasi Dasar --}}
                                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col items-center text-center justify-between min-h-[140px]">
                                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Imunisasi Dasar</p>
                                        <div class="relative w-14 h-14 flex items-center justify-center mb-2.5">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-slate-200" stroke-width="4.5"></circle>
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-teal-500" stroke-width="4.5"
                                                        stroke-dasharray="{{ $cakupanImunisasi }} {{ 100 - $cakupanImunisasi }}" stroke-dashoffset="0"></circle>
                                            </svg>
                                            <span class="absolute text-[10px] font-black text-slate-800">{{ $cakupanImunisasi }}%</span>
                                        </div>
                                        <div class="flex items-center justify-center gap-2 text-[8px] font-black border-t border-slate-200/55 pt-1.5 w-full">
                                            <span class="text-teal-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-teal-500"></span> Lengkap: {{ $cakupanImunisasi }}%
                                            </span>
                                            <span class="text-slate-300">|</span>
                                            <span class="text-slate-500 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-slate-400"></span> Belum: {{ round(100 - $cakupanImunisasi, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Ibu Hamil --}}
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ibu Hamil
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    {{-- Risiko Hipertensi --}}
                                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col items-center text-center justify-between min-h-[140px]">
                                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Risiko Hipertensi</p>
                                        <div class="relative w-14 h-14 flex items-center justify-center mb-2.5">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-emerald-500" stroke-width="4.5"></circle>
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-rose-500" stroke-width="4.5"
                                                        stroke-dasharray="{{ $hypertensionRiskRate }} {{ 100 - $hypertensionRiskRate }}" stroke-dashoffset="0"></circle>
                                            </svg>
                                            <span class="absolute text-[10px] font-black text-slate-800">{{ $hypertensionRiskRate }}%</span>
                                        </div>
                                        <div class="flex items-center justify-center gap-2 text-[8px] font-black border-t border-slate-200/55 pt-1.5 w-full">
                                            <span class="text-rose-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-rose-500"></span> Risiko: {{ $hypertensionRiskRate }}%
                                            </span>
                                            <span class="text-slate-300">|</span>
                                            <span class="text-emerald-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Normal: {{ round(100 - $hypertensionRiskRate, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                    
                                    {{-- Kepatuhan Fe --}}
                                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col items-center text-center justify-between min-h-[140px]">
                                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Kepatuhan Tablet Fe</p>
                                        <div class="relative w-14 h-14 flex items-center justify-center mb-2.5">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-slate-200" stroke-width="4.5"></circle>
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-teal-500" stroke-width="4.5"
                                                        stroke-dasharray="{{ $feComplianceRate }} {{ 100 - $feComplianceRate }}" stroke-dashoffset="0"></circle>
                                            </svg>
                                            <span class="absolute text-[10px] font-black text-slate-800">{{ $feComplianceRate }}%</span>
                                        </div>
                                        <div class="flex items-center justify-center gap-2 text-[8px] font-black border-t border-slate-200/55 pt-1.5 w-full">
                                            <span class="text-teal-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-teal-500"></span> Patuh: {{ $feComplianceRate }}%
                                            </span>
                                            <span class="text-slate-300">|</span>
                                            <span class="text-slate-500 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-slate-400"></span> Belum: {{ round(100 - $feComplianceRate, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Lansia --}}
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Lanjut Usia
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    {{-- Lansia Hipertensi --}}
                                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col items-center text-center justify-between min-h-[140px]">
                                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Hipertensi Lansia</p>
                                        <div class="relative w-14 h-14 flex items-center justify-center mb-2.5">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-emerald-500" stroke-width="4.5"></circle>
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-rose-500" stroke-width="4.5"
                                                        stroke-dasharray="{{ $lansiaHypertensionRate }} {{ 100 - $lansiaHypertensionRate }}" stroke-dashoffset="0"></circle>
                                            </svg>
                                            <span class="absolute text-[10px] font-black text-slate-800">{{ $lansiaHypertensionRate }}%</span>
                                        </div>
                                        <div class="flex items-center justify-center gap-2 text-[8px] font-black border-t border-slate-200/55 pt-1.5 w-full">
                                            <span class="text-rose-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-rose-500"></span> Risiko: {{ $lansiaHypertensionRate }}%
                                            </span>
                                            <span class="text-slate-300">|</span>
                                            <span class="text-emerald-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Normal: {{ round(100 - $lansiaHypertensionRate, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                    
                                    {{-- Lansia Hiperglikemia --}}
                                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col items-center text-center justify-between min-h-[140px]">
                                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Diabetes Lansia</p>
                                        <div class="relative w-14 h-14 flex items-center justify-center mb-2.5">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-emerald-500" stroke-width="4.5"></circle>
                                                <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-rose-500" stroke-width="4.5"
                                                        stroke-dasharray="{{ $lansiaHyperglycemiaRate }} {{ 100 - $lansiaHyperglycemiaRate }}" stroke-dashoffset="0"></circle>
                                            </svg>
                                            <span class="absolute text-[10px] font-black text-slate-800">{{ $lansiaHyperglycemiaRate }}%</span>
                                        </div>
                                        <div class="flex items-center justify-center gap-2 text-[8px] font-black border-t border-slate-200/55 pt-1.5 w-full">
                                            <span class="text-rose-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-rose-500"></span> Risiko: {{ $lansiaHyperglycemiaRate }}%
                                            </span>
                                            <span class="text-slate-300">|</span>
                                            <span class="text-emerald-600 flex items-center gap-1">
                                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Normal: {{ round(100 - $lansiaHyperglycemiaRate, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Widget 4: Live Health Alerts Feed --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-xs flex flex-col">
                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                    <span class="material-symbols-outlined text-rose-600 text-[20px] animate-pulse">warning</span>
                                    Live Health Alerts
                                </h3>
                                <span class="text-[9px] font-black uppercase tracking-wider bg-rose-50 text-rose-700 px-2 py-0.5 rounded-full border border-rose-200">Kasus Kritis</span>
                            </div>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">5 kasus pemeriksaan berisiko kesehatan tinggi terbaru</p>
                        </div>
                        
                        <div class="space-y-3 flex-1">
                            @forelse($liveHealthAlerts as $alert)
                                <div class="p-3 rounded-xl border border-rose-100 bg-rose-50/30 flex flex-col gap-1.5 transition-all hover:bg-rose-50/60">
                                    <div class="flex items-center justify-between">
                                        <a href="/admin/patients/{{ $alert['patient_id'] }}" class="text-xs font-black text-slate-800 hover:text-rose-600 hover:underline">
                                            {{ $alert['patient_name'] }}
                                        </a>
                                        <span class="text-[9px] font-extrabold uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600">
                                            {{ $alert['patient_category'] }}
                                        </span>
                                    </div>
                                    
                                    {{-- Reasons pills --}}
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($alert['reasons'] as $reason)
                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-rose-100 text-rose-700">{{ $reason }}</span>
                                        @endforeach
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-[10px] text-slate-400 font-semibold border-t border-rose-100/50 pt-1.5 mt-0.5">
                                        <span>Pos: {{ $alert['posyandu_name'] }}</span>
                                        <span>{{ $alert['visit_date'] }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 text-center text-slate-400">
                                    <span class="material-symbols-outlined text-emerald-500 text-4xl mb-2">check_circle</span>
                                    <p class="text-xs font-bold text-slate-700">Seluruh Warga Sehat!</p>
                                    <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Tidak terdeteksi adanya kasus berisiko tinggi baru</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($activeTab === 'balita')
        {{-- ================= BALITA TAB ================= --}}
        <div class="space-y-8 animate-fadeIn">
            {{-- Stats Grid: 2 cols mobile, 4 cols desktop --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                @php
                    $balitaCards = [
                        ['label' => 'Total Balita', 'val' => number_format($totalBalita), 'unit' => 'Jiwa', 'icon' => 'child_care', 'color' => 'teal', 'desc' => 'Tumbuh kembang aktif terpantau'],
                        ['label' => 'Prevalensi Stunting', 'val' => $stuntingRate . '%', 'unit' => 'Persentase', 'icon' => 'trending_down', 'color' => 'red', 'desc' => $stuntingRate >= 14 ? 'Butuh perhatian khusus' : 'Kategori aman & terkendali'],
                        ['label' => 'Cakupan Imunisasi', 'val' => $cakupanImunisasi . '%', 'unit' => 'Target 100%', 'icon' => 'vaccines', 'color' => 'blue', 'desc' => 'Persentase dosis imunisasi dasar'],
                        ['label' => 'Kader Lapangan', 'val' => $kaderAktif, 'unit' => 'Personel', 'icon' => 'badge', 'color' => 'amber', 'desc' => 'Kader aktif membina balita'],
                    ];
                @endphp

                @foreach($balitaCards as $c)
                <div class="kpi-card kpi-{{ $c['color'] }}">
                    <div class="relative z-10 flex items-center justify-between mb-3">
                        <div class="kpi-icon-wrap">
                            <span class="material-symbols-outlined text-[22px] text-white">{{ $c['icon'] }}</span>
                        </div>
                        <span class="kpi-unit">{{ $c['unit'] }}</span>
                    </div>
                    <p class="kpi-number relative z-10">{{ $c['val'] }}</p>
                    <p class="kpi-label relative z-10">{{ $c['label'] }}</p>
                    <p class="kpi-desc relative z-10">{{ $c['desc'] }}</p>
                    <div class="kpi-accent-bar"></div>
                </div>
                @endforeach
            </div>

            {{-- Prevalensi Pertumbuhan Balita — Full Width Card --}}
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">Prevalensi Pertumbuhan Balita</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-semibold mt-1">Tren bulanan persentase status gizi balita: Normal, Risiko, dan Stunting/Gizi Buruk</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="downloadChart(nutritionTrendChart, 'tren_status_gizi_balita')" class="shrink-0 p-2.5 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                            <span class="material-symbols-outlined text-[20px]">download</span>
                        </button>
                    </div>
                </div>

                {{-- Legend badges --}}
                <div class="flex flex-wrap gap-3 mb-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200/60">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                        <span class="text-xs font-bold text-emerald-700">Normal</span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200/60">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                        <span class="text-xs font-bold text-amber-700">Risiko Gizi</span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-50 border border-red-200/60">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                        <span class="text-xs font-bold text-red-700">Stunting / Gizi Buruk</span>
                    </div>
                </div>

                <div class="relative h-96">
                    <canvas id="nutritionTrendChart" wire:ignore></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-nutritionTrendChart">
                        <span class="material-symbols-outlined text-rose-600 text-4xl mb-2">error</span>
                        <p class="text-sm font-extrabold text-slate-800">Gagal memuat data grafik</p>
                        <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
                    </div>
                </div>
            </div>

            {{-- Status Gizi Balita — Dedicated Card --}}
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">Status Gizi Balita (Pemeriksaan Terbaru)</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-semibold mt-1">Distribusi persentase status gizi balita berdasarkan hasil pemeriksaan status gizi terbaru</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="downloadChart(nutritionDonutChart, 'distribusi_status_gizi_balita')" class="shrink-0 p-2.5 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                            <span class="material-symbols-outlined text-[20px]">download</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    {{-- Chart container --}}
                    <div class="relative flex justify-center py-6">
                        <canvas id="nutritionDonutChart" width="220" height="220" style="max-width:220px;max-height:220px;" wire:ignore></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-nutritionDonutChart">
                            <span class="material-symbols-outlined text-rose-600 text-4xl mb-2">error</span>
                            <p class="text-sm font-extrabold text-slate-800">Gagal memuat grafik</p>
                            <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
                        </div>
                    </div>

                    {{-- Distribution list --}}
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Rincian Data Pemeriksaan</h4>
                        <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto pr-2">
                            @php $i = 0; @endphp
                            @foreach($nutritionLabels as $label)
                            @php
                                $val = $nutritionData[$i] ?? 0;
                                $sum = array_sum($nutritionData);
                                $pct = $sum > 0 ? round(($val / $sum) * 100, 1) : 0;
                                
                                $sLabel = strtolower($label);
                                if ($sLabel === 'baik' || $sLabel === 'normal') {
                                    $bulletColor = 'bg-emerald-500';
                                } elseif ($sLabel === 'gizi baik') {
                                    $bulletColor = 'bg-teal-500';
                                } elseif ($sLabel === 'gizi kurang' || $sLabel === 'kurang') {
                                    $bulletColor = 'bg-[#C2410C]';
                                } elseif (str_contains($sLabel, 'sangat') || str_contains($sLabel, 'buruk') || str_contains($sLabel, 'pendek')) {
                                    $bulletColor = 'bg-[#B91C1C]';
                                } elseif (str_contains($sLabel, 'risiko') || str_contains($sLabel, 'berisiko') || str_contains($sLabel, 'lebih') || str_contains($sLabel, 'obesitas')) {
                                    $bulletColor = 'bg-[#A16207]';
                                } else {
                                    $bulletColor = 'bg-slate-400';
                                }
                            @endphp
                            <div wire:click="drillDown('Balita ({{ $label }})', 'nutrition_status', null, '{{ $label }}')" 
                                 class="flex items-center justify-between py-2.5 text-sm font-bold text-slate-750 hover:text-indigo-600 cursor-pointer transition-colors hover:bg-slate-50/50 px-2 -mx-2 rounded-lg"
                                 title="Klik untuk melihat daftar balita">
                                <span class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full inline-block {{ $bulletColor }}"></span>
                                    <span class="hover:underline">{{ $label }}</span>
                                </span>
                                <span class="font-extrabold text-slate-900">{{ $val }} <span class="text-slate-400 font-semibold">({{ $pct }}%)</span></span>
                            </div>
                            @php $i++; @endphp
                            @endforeach
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500 font-bold">
                            <span>Total Penimbangan Terdaftar</span>
                            <span class="text-slate-800 text-sm font-black">{{ number_format(array_sum($nutritionData)) }} Balita</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Capaian Imunisasi Per Jenis — Full Width Card --}}
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">Capaian Imunisasi Per Jenis Vaksin</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-semibold mt-1">Jumlah balita yang menerima setiap jenis imunisasi dasar pada periode yang dipilih</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="downloadChart(vaccineChart, 'capaian_imunisasi_balita')" class="shrink-0 p-2.5 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                            <span class="material-symbols-outlined text-[20px]">download</span>
                        </button>
                    </div>
                </div>

                {{-- Cakupan badge --}}
                <div class="flex items-center gap-3 mb-6 p-4 rounded-2xl bg-teal-50/60 border border-teal-200/50">
                    <span class="material-symbols-outlined text-teal-600 text-[28px]">vaccines</span>
                    <div>
                        <p class="text-sm font-extrabold text-teal-900">Cakupan Imunisasi Keseluruhan: <span class="text-teal-600">{{ $cakupanImunisasi }}%</span></p>
                        <p class="text-xs font-semibold text-teal-700 mt-0.5">dari total {{ number_format($totalBalita) }} balita terdaftar</p>
                    </div>
                    <div class="ml-auto flex-shrink-0">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center border-4 {{ $cakupanImunisasi >= 80 ? 'border-teal-500 bg-teal-50' : ($cakupanImunisasi >= 50 ? 'border-amber-400 bg-amber-50' : 'border-red-400 bg-red-50') }}">
                            <span class="text-sm font-black {{ $cakupanImunisasi >= 80 ? 'text-teal-700' : ($cakupanImunisasi >= 50 ? 'text-amber-700' : 'text-red-700') }}">{{ $cakupanImunisasi }}%</span>
                        </div>
                    </div>
                </div>

                <div class="relative h-96">
                    <canvas id="vaccineBarChart" wire:ignore></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-vaccineBarChart">
                        <span class="material-symbols-outlined text-rose-600 text-4xl mb-2">error</span>
                        <p class="text-sm font-extrabold text-slate-800">Gagal memuat data grafik</p>
                        <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
                    </div>
                </div>
                <p class="text-xs font-semibold text-slate-400 text-center mt-4">* Klik batang grafik untuk melihat detail penerima imunisasi</p>
            </div>

            {{-- Growth Chart (BB & TB Rata-rata) --}}
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">Grafik Pertumbuhan Keseluruhan Balita & Anak</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-semibold mt-1">Rata-rata berat badan (kg) dan tinggi badan (cm) per bulan sepanjang tahun</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="downloadChart(growthChart, 'pertumbuhan_balita')" class="p-2.5 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                            <span class="material-symbols-outlined text-[20px]">download</span>
                        </button>
                    </div>
                </div>
                <div class="relative h-96">
                    <canvas id="growthChart" wire:ignore></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-growthChart">
                        <span class="material-symbols-outlined text-rose-600 text-4xl mb-2">error</span>
                        <p class="text-sm font-extrabold text-slate-800">Gagal memuat data grafik</p>
                        <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
                    </div>
                </div>
                <div class="mt-5 flex flex-wrap gap-6 justify-center">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-0.5 bg-teal-500 inline-block rounded-full"></span>
                        <span class="text-xs font-bold text-slate-600">Rata-rata Berat Badan (kg) — Skala Kiri</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-0.5 bg-violet-500 inline-block rounded-full"></span>
                        <span class="text-xs font-bold text-slate-600">Rata-rata Tinggi Badan (cm) — Skala Kanan</span>
                    </div>
                </div>
            </div>

            {{-- Detailed Stunting per Posyandu --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Prevalensi Stunting per Wilayah Posyandu</h3>
                    <div class="space-y-6">
                        @forelse($stuntingByPosyandu as $item)
                        <div class="cursor-pointer hover:bg-slate-50 p-2 -mx-2 rounded-lg transition-colors" wire:dblclick="drillDown('Stunting - {{ $item['name'] ?? '' }}', 'balita_stunting_buruk', null, null, null, {{ $item['id'] ?? 'null' }}, 'stunting_posyandu')">
                            <div class="flex justify-between items-end mb-2 text-xs font-bold text-slate-700">
                                <span>{{ $item['name'] }} ({{ $item['stunting'] }}/{{ $item['total'] }} Balita)</span>
                                <span class="font-extrabold text-slate-900">{{ $item['rate'] }}%</span>
                            </div>
                            <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $item['color'] }}" style="width: {{ $item['width'] }}%"></div>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-6">Tidak ada data posyandu</p>
                        @endforelse
                    </div>
                </div>

                {{-- Demographic segments and insights --}}
                <div class="space-y-6 flex flex-col justify-between">
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                        <h3 class="text-lg font-bold text-slate-900 mb-6 text-center">Segmentasi Usia Terpantau</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center cursor-pointer hover:bg-slate-100 transition-colors" wire:dblclick="drillDown('Segmentasi Usia: 0-12 Bulan', 'balita_age_0_12', null, null, null, null, 'age_segmentation')">
                                <span class="block text-2xl font-black text-slate-900">{{ $usia0_12 }}</span>
                                <span class="text-xs md:text-sm font-bold text-slate-600 uppercase tracking-wider">0–12 Bulan</span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center cursor-pointer hover:bg-slate-100 transition-colors" wire:dblclick="drillDown('Segmentasi Usia: 12-24 Bulan', 'balita_age_12_24', null, null, null, null, 'age_segmentation')">
                                <span class="block text-2xl font-black text-slate-900">{{ $usia12_24 }}</span>
                                <span class="text-xs md:text-sm font-bold text-slate-600 uppercase tracking-wider">12–24 Bulan</span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center cursor-pointer hover:bg-slate-100 transition-colors" wire:dblclick="drillDown('Segmentasi Usia: >24 Bulan', 'balita_age_24plus', null, null, null, null, 'age_segmentation')">
                                <span class="block text-2xl font-black text-slate-900">{{ $usia24plus }}</span>
                                <span class="text-xs md:text-sm font-bold text-slate-600 uppercase tracking-wider">>24 Bulan</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden flex-1 flex flex-col justify-center">
                        <div class="relative z-10 space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-teal-400 text-[24px]">insights</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider text-teal-300">Wawasan Balita</h4>
                            </div>
                            <p class="text-xs md:text-sm text-slate-300 leading-relaxed font-semibold">
                                @if($stuntingRate >= 14)
                                    Lampu Kuning: Prevalensi stunting mencapai {{ $stuntingRate }}% (ambang batas WHO: 14%). Tingkatkan pemantauan status gizi (tinggi badan & berat badan) dan distribusi PMT kaya protein.
                                @else
                                    Kondisi Kondusif: Prevalensi stunting terpantau di angka {{ $stuntingRate }}% yang aman di bawah ambang batas WHO. Pertahankan cakupan pemberian ASI eksklusif dan pendampingan kader.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Records for Balita --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-150 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Pemeriksaan Balita Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5 font-semibold">Daftar rekam medis pemeriksaan balita terkini</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center">
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="tableSearch" wire:key="search-balita"
                                   class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-teal-100 focus:border-teal-600 shadow-xs transition-all" 
                                   placeholder="Cari Nama atau NIK Anak...">
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <span class="text-xs font-bold text-slate-650 whitespace-nowrap uppercase tracking-wider">Status Gizi:</span>
                            <select wire:model.live="filterNutritionStatus" wire:key="nutrition-balita"
                                    class="w-full sm:w-36 py-2 px-3 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-4 focus:ring-teal-100 focus:border-teal-600 shadow-xs transition-all">
                                <option value="">Semua</option>
                                <option value="Gizi Baik">Gizi Baik</option>
                                <option value="Gizi Kurang">Gizi Kurang</option>
                                <option value="Gizi Buruk">Gizi Buruk</option>
                                <option value="Gizi Lebih">Gizi Lebih</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Nama Anak</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Unit Posyandu</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Status Gizi</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3.5 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentRecords as $record)
                            <tr class="hover:bg-slate-50/80 transition-colors text-slate-800">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-extrabold text-sm border border-teal-100 shadow-xs">
                                            {{ strtoupper(substr($record->patient?->full_name ?? 'B', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900 text-sm">{{ $record->patient?->full_name }}</span>
                                            <span class="text-[10px] font-black text-slate-400 uppercase block tracking-wider mt-0.5">NIK: {{ $record->patient?->id_number ?: '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-650">{{ $record->patient?->posyandu?->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusStr = strtolower(trim($record->nutrition_status ?: 'Gizi Baik'));
                                        $tagStyle = '';
                                        $tagClass = '';
                                        if ($statusStr === 'gizi buruk' || $statusStr === 'buruk') {
                                            $tagStyle = 'background-color: #FEE2E2; color: #B91C1C; border-color: rgba(185, 28, 28, 0.2);';
                                        } elseif ($statusStr === 'gizi kurang' || $statusStr === 'kurang') {
                                            $tagStyle = 'background-color: #FFEDD5; color: #C2410C; border-color: rgba(194, 65, 12, 0.2);';
                                        } elseif (str_contains($statusStr, 'lebih') || str_contains($statusStr, 'obesitas')) {
                                            $tagStyle = 'background-color: #FEF9C3; color: #A16207; border-color: rgba(161, 98, 7, 0.2);';
                                        } else {
                                            $tagClass = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
                                        }
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $tagClass }}" style="{{ $tagStyle }}">
                                        {{ $record->nutrition_status ?: 'Gizi Baik' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ \Carbon\Carbon::parse($record->visit_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.patients.show', $record->patient_id) }}" class="w-9 h-9 inline-flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-teal-600 hover:text-white hover:shadow-md hover:shadow-teal-600/10 transition-all border border-slate-200/60">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400 font-bold bg-white">Belum ada pemeriksaan balita</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if($activeTab === 'pregnancy')
        {{-- ================= PREGNANCY TAB ================= --}}
        <div class="space-y-8 animate-fadeIn">
            <livewire:admin.analytics.ibu-hamil-analytics :selected-year="$selectedYear" :selected-month="$selectedMonth" :selected-posyandu="$selectedPosyandu" />

            {{-- Recent Records for Ibu Hamil --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-150 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Pemeriksaan Ibu Hamil Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5 font-semibold">Daftar rekam medis pemeriksaan ibu hamil terkini</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center">
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="tableSearch" wire:key="search-hamil"
                                   class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-teal-100 focus:border-teal-600 shadow-xs transition-all" 
                                   placeholder="Cari Nama atau NIK Ibu...">
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Nama Ibu</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Unit Posyandu</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Usia Kehamilan</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3.5 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentPregnancyRecords as $record)
                            <tr class="hover:bg-slate-50/80 transition-colors text-slate-800">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center font-extrabold text-sm border border-rose-100 shadow-xs">
                                            {{ strtoupper(substr($record->patient?->full_name ?? 'I', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900 text-sm">{{ $record->patient?->full_name }}</span>
                                            <span class="text-[10px] font-black text-slate-400 uppercase block tracking-wider mt-0.5">NIK: {{ $record->patient?->id_number ?: '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-650">{{ $record->patient?->posyandu?->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-750 border border-rose-200/60">
                                        {{ $record->gestational_age ?: 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ \Carbon\Carbon::parse($record->visit_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.patients.show', $record->patient_id) }}" class="w-9 h-9 inline-flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-600 hover:text-white hover:shadow-md hover:shadow-rose-600/10 transition-all border border-slate-200/60">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400 font-bold bg-white">Belum ada pemeriksaan ibu hamil</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if($activeTab === 'lansia')
        {{-- ================= LANSIA TAB ================= --}}
        <div class="space-y-8 animate-fadeIn">
            <livewire:admin.analytics.lansia-analytics :selected-year="$selectedYear" :selected-month="$selectedMonth" :selected-posyandu="$selectedPosyandu" />

            {{-- Recent Records for Lansia --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-150 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Pemeriksaan Lansia Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5 font-semibold">Daftar rekam medis pemeriksaan lansia terkini</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center">
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="tableSearch" wire:key="search-lansia"
                                   class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-teal-100 focus:border-teal-600 shadow-xs transition-all" 
                                   placeholder="Cari Nama atau NIK Lansia...">
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Nama Lansia</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Unit Posyandu</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Tekanan Darah</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Gula Darah</th>
                                <th class="px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3.5 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentLansiaRecords as $record)
                            <tr class="hover:bg-slate-50/80 transition-colors text-slate-800">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-750 flex items-center justify-center font-extrabold text-sm border border-indigo-100 shadow-xs">
                                            {{ strtoupper(substr($record->patient?->full_name ?? 'L', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900 text-sm">{{ $record->patient?->full_name }}</span>
                                            <span class="text-[10px] font-black text-slate-400 uppercase block tracking-wider mt-0.5">NIK: {{ $record->patient?->id_number ?: '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-650">{{ $record->patient?->posyandu?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-800">
                                    {{ $record->systolic_bp ?: '-' }}/{{ $record->diastolic_bp ?: '-' }} <span class="text-[10px] font-semibold text-slate-500">mmHg</span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-800">
                                    {{ $record->blood_sugar ?: '-' }} <span class="text-[10px] font-semibold text-slate-500">mg/dL</span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ \Carbon\Carbon::parse($record->visit_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.patients.show', $record->patient_id) }}" class="w-9 h-9 inline-flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-indigo-700 hover:text-white hover:shadow-md hover:shadow-indigo-700/10 transition-all border border-slate-200/60">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400 font-bold bg-white">Belum ada pemeriksaan lansia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- ── ANA-22: Drill-down Modal ── --}}
    @if($showDrillDown)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fadeIn">
        <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[85vh] animate-scaleUp">
            {{-- Modal Header --}}
            <div class="px-8 py-6 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">{{ $drillDownTitle }}</h3>
                    <p class="text-xs text-slate-500 mt-1 font-bold">Menampilkan seluruh rekam medis pencocokan</p>
                </div>
                <button wire:click="closeDrillDown" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:text-slate-900 transition-colors cursor-pointer border border-slate-200">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                {{-- Balita Category Tabs --}}
                @if(in_array($drillDownType, ['balita_normal', 'balita_risiko', 'balita_stunting_buruk']))
                <div class="flex gap-2 p-1.5 bg-slate-100 rounded-2xl w-fit">
                    <button wire:click="switchDrillDownCategory('balita_normal')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'balita_normal' ? 'bg-white text-emerald-700 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Normal
                    </button>
                    <button wire:click="switchDrillDownCategory('balita_risiko')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'balita_risiko' ? 'bg-white text-amber-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        Risiko Gizi
                    </button>
                    <button wire:click="switchDrillDownCategory('balita_stunting_buruk')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'balita_stunting_buruk' ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        Stunting / Gizi Buruk
                    </button>
                </div>
                @endif

                {{-- Lansia Category Tabs --}}
                @if(in_array($drillDownType, ['lansia_hipertensi', 'lansia_hiperglikemia', 'lansia_hiperkolesterolemia', 'lansia_hiperurisemia']))
                <div class="flex flex-wrap gap-2 p-1.5 bg-slate-100 rounded-2xl w-fit">
                    <button wire:click="switchDrillDownCategory('lansia_hipertensi')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'lansia_hipertensi' ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        Hipertensi
                    </button>
                    <button wire:click="switchDrillDownCategory('lansia_hiperglikemia')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'lansia_hiperglikemia' ? 'bg-white text-amber-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                        Hiperglikemia
                    </button>
                    <button wire:click="switchDrillDownCategory('lansia_hiperkolesterolemia')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'lansia_hiperkolesterolemia' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        Hiperkolesterolemia
                    </button>
                    <button wire:click="switchDrillDownCategory('lansia_hiperurisemia')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'lansia_hiperurisemia' ? 'bg-white text-purple-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        Hiperurisemia
                    </button>
                </div>
                @endif

                {{-- Ibu Hamil Category Tabs --}}
                @if(in_array($drillDownType, ['pregnancy_high_risk', 'pregnancy_kek', 'pregnancy_anemia', 'pregnancy_tablet_fe']))
                <div class="flex flex-wrap gap-2 p-1.5 bg-slate-100 rounded-2xl w-fit">
                    <button wire:click="switchDrillDownCategory('pregnancy_high_risk')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'pregnancy_high_risk' ? 'bg-white text-amber-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        Risiko Tinggi &amp; 4T
                    </button>
                    <button wire:click="switchDrillDownCategory('pregnancy_kek')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'pregnancy_kek' ? 'bg-white text-purple-650 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        Kasus KEK
                    </button>
                    <button wire:click="switchDrillDownCategory('pregnancy_anemia')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'pregnancy_anemia' ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        Kasus Anemia
                    </button>
                    <button wire:click="switchDrillDownCategory('pregnancy_tablet_fe')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-2 {{ $drillDownType === 'pregnancy_tablet_fe' ? 'bg-white text-teal-650 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                        Pemberian Tablet Fe
                    </button>
                </div>
                @endif

                {{-- Ibu Hamil ANC K1-K6 Category Tabs --}}
                @if(in_array($drillDownType, ['pregnancy_k1', 'pregnancy_k2', 'pregnancy_k3', 'pregnancy_k4', 'pregnancy_k5', 'pregnancy_k6']))
                <div class="flex flex-wrap gap-2 p-1.5 bg-slate-100 rounded-2xl w-fit">
                    @foreach([
                        'pregnancy_k1' => 'K1',
                        'pregnancy_k2' => 'K2',
                        'pregnancy_k3' => 'K3',
                        'pregnancy_k4' => 'K4',
                        'pregnancy_k5' => 'K5',
                        'pregnancy_k6' => 'K6'
                    ] as $key => $lbl)
                    <button wire:click="switchDrillDownCategory('{{ $key }}')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center gap-1.5 {{ $drillDownType === $key ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-2.5 h-2.5 rounded-full {{ $drillDownType === $key ? 'bg-indigo-500' : 'bg-slate-400' }}"></span>
                        {{ $lbl }}
                    </button>
                    @endforeach
                </div>
                @endif

                <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                    <table class="w-full text-left">
                                                <thead>
                              <tr class="bg-slate-100 border-b border-slate-200">
                                @if ($drillDownChartSource === 'visits_trend')
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Unit Posyandu</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Kunjungan</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">BB (kg)</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">TB (cm)</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Status / Info</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @elseif ($drillDownChartSource === 'nutrition_trend')
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Unit Posyandu</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori Gizi</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Status / Info</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Kunjungan</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">BB (kg)</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">TB (cm)</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @elseif ($drillDownChartSource === 'nutrition_donut')
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Unit Posyandu</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Status / Info</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Kunjungan</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @elseif ($drillDownChartSource === 'vaccine_chart')
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Unit Posyandu</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Kunjungan</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @elseif ($drillDownChartSource === 'growth_chart')
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Unit Posyandu</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Status / Info</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Kunjungan</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">BB (kg)</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">TB (cm)</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @elseif ($drillDownChartSource === 'stunting_posyandu')
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Status / Info (Gizi Buruk)</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Kunjungan</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @elseif ($drillDownChartSource === 'age_segmentation')
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Umur (Bulan)</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Status / Info</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @else
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Warga</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Unit Posyandu</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Status / Info</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Kunjungan</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">BB</th>
                                  <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">TB</th>
                                  <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                                @endif
                              </tr></thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($drillDownData as $row)
                            <tr class="hover:bg-slate-50 text-slate-800">
                                  <td class="px-6 py-4">
                                      <div>
                                          <span class="block font-bold text-slate-900">{{ $row['name'] }}</span>
                                          <span class="text-[10px] text-slate-500 uppercase block font-semibold">NIK: {{ $row['nik'] }}</span>
                                      </div>
                                  </td>

                                  @php
                                      $statusText = ($row['status_info'] ?? '') !== '-' ? ($row['status_info'] ?? '') : ($row['nutrition_status'] ?? '-');
                                      $statusStr = strtolower(trim($statusText));
                                      $tagStyle = '';
                                      $tagClass = '';
                                      
                                      $isDanger = false;
                                      $isWarning = false;
                                      $isSuccess = false;
                                      $customStyle = '';

                                      if (str_contains($statusStr, 'gizi buruk') || $statusStr === 'buruk') {
                                          $customStyle = 'background-color: #FEE2E2; color: #B91C1C; border-color: rgba(185, 28, 28, 0.15);';
                                      } elseif (str_contains($statusStr, 'gizi kurang') || $statusStr === 'kurang') {
                                          $customStyle = 'background-color: #FFEDD5; color: #C2410C; border-color: rgba(194, 65, 12, 0.15);';
                                      } elseif (str_contains($statusStr, 'gizi lebih') || str_contains($statusStr, 'lebih') || str_contains($statusStr, 'obesitas')) {
                                          $customStyle = 'background-color: #FEF9C3; color: #A16207; border-color: rgba(161, 98, 7, 0.15);';
                                      } elseif (str_contains($statusStr, 'gizi baik') || $statusStr === 'baik' || str_contains($statusStr, 'normal')) {
                                          $customStyle = 'background-color: #DCFCE7; color: #15803D; border-color: rgba(21, 128, 61, 0.15);';
                                      } elseif (str_contains($statusStr, 'sangat kurang') || str_contains($statusStr, 'belum') || str_contains($statusStr, 'anemia') || str_contains($statusStr, 'risiko')) {
                                          $isDanger = true;
                                      }
                                      
                                      // Specific clinical measurement warning checks
                                      if (str_contains($statusStr, 'tb:')) {
                                          preg_match('/tb:\s*([\d\.]+)/', $statusStr, $matches);
                                          if (isset($matches[1]) && (float)$matches[1] < 145) {
                                              $isDanger = true;
                                          }
                                      }
                                      if (str_contains($statusStr, 'lila:')) {
                                          preg_match('/lila:\s*([\d\.]+)/', $statusStr, $matches);
                                          if (isset($matches[1]) && (float)$matches[1] < 23.5) {
                                              $isDanger = true;
                                          }
                                      }
                                      if (str_contains($statusStr, 'hb:')) {
                                          preg_match('/hb:\s*([\d\.]+)/', $statusStr, $matches);
                                          if (isset($matches[1]) && (float)$matches[1] < 11) {
                                              $isDanger = true;
                                          }
                                      }
                                      if (str_contains($statusStr, 'umur:')) {
                                          preg_match('/umur:\s*([\d\.]+)/', $statusStr, $matches);
                                          if (isset($matches[1])) {
                                              $ageVal = (float)$matches[1];
                                              if ($ageVal < 20 || $ageVal > 35) {
                                                  $isDanger = true;
                                              }
                                          }
                                      }
                                      if (str_contains($statusStr, 'menerima')) {
                                          $isSuccess = true;
                                      }

                                      if ($customStyle !== '') {
                                          $tagStyle = $customStyle;
                                      } elseif ($isDanger) {
                                          $tagStyle = 'background-color: #FEF2F2; color: #DC2626; border-color: rgba(220, 38, 38, 0.15);';
                                      } elseif ($isWarning) {
                                          $tagStyle = 'background-color: #FFFBEB; color: #D97706; border-color: rgba(217, 119, 6, 0.15);';
                                      } elseif ($isSuccess) {
                                          $tagClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                      } else {
                                          $tagClass = 'bg-slate-50 text-slate-650 border-slate-200';
                                      }
                                      $statusHtml = '<span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border ' . $tagClass . '" style="' . $tagStyle . '">' . $statusText . '</span>';
                                  @endphp

                                @if ($drillDownChartSource === 'visits_trend')
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['posyandu'] }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['category_warga'] ?? '-' }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['visit_date'] }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['weight'] ?? '-' }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['height'] ?? '-' }}</td>
                                  <td class="px-6 py-4">{!! $statusHtml !!}</td>
                                @elseif ($drillDownChartSource === 'nutrition_trend')
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['posyandu'] }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['kategori_gizi'] ?? '-' }}</td>
                                  <td class="px-6 py-4">{!! $statusHtml !!}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['visit_date'] }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['weight'] ?? '-' }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['height'] ?? '-' }}</td>
                                @elseif ($drillDownChartSource === 'nutrition_donut')
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['posyandu'] }}</td>
                                  <td class="px-6 py-4">{!! $statusHtml !!}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['visit_date'] }}</td>
                                @elseif ($drillDownChartSource === 'vaccine_chart')
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['posyandu'] }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['visit_date'] }}</td>
                                @elseif ($drillDownChartSource === 'growth_chart')
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['posyandu'] }}</td>
                                  <td class="px-6 py-4">{!! $statusHtml !!}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['visit_date'] }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['weight'] ?? '-' }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['height'] ?? '-' }}</td>
                                @elseif ($drillDownChartSource === 'stunting_posyandu')
                                  <td class="px-6 py-4">{!! $statusHtml !!}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['visit_date'] }}</td>
                                @elseif ($drillDownChartSource === 'age_segmentation')
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['age_months'] ?? '-' }}</td>
                                  <td class="px-6 py-4">{!! $statusHtml !!}</td>
                                @else
                                  <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $row['posyandu'] }}</td>
                                  <td class="px-6 py-4">{!! $statusHtml !!}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['visit_date'] }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['weight'] ?? '-' }}</td>
                                  <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $row['height'] ?? '-' }}</td>
                                @endif

                                  <td class="px-6 py-4 text-right">
                                      <a href="{{ route('admin.patients.show', $row['patient_id']) }}" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-teal-600 hover:text-white transition-all shadow-xs">
                                          <span class="material-symbols-outlined text-[18px]">visibility</span>
                                      </a>
                                  </td>
                              </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-slate-500 font-bold bg-white">Tidak ada data detail untuk periode/filter ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end">
                <button wire:click="closeDrillDown" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md transition-colors cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

@script
<script>
// ── Global Chart Defaults will be applied inside initCharts ──

window.visitsTrendChart = null;
window.nutritionTrendChart = null;
window.nutritionDonutChart = null;
window.vaccineChart = null;
window.growthChart = null;
window.pregnancyRiskChart = null;
window.lansiaMetabolicChart = null;
window.isDrillingDown = false;

// ── ANA-30: Download Chart as Image ──
window.downloadChart = function(chartInstance, fileName) {
    if (!chartInstance) return;
    
    // 1. Download Gambar PNG dengan Background Putih Solid agar informasinya jelas
    try {
        const sourceCanvas = chartInstance.canvas;
        const scale = window.devicePixelRatio || 1;
        
        // Cari judul dan subjudul dari kontainer DOM terdekat
        const card = sourceCanvas.closest('.bg-white');
        let titleText = '';
        let subtitleText = '';
        if (card) {
            const h3 = card.querySelector('h3');
            if (h3) titleText = h3.innerText.trim();
            const p = card.querySelector('p');
            if (p) subtitleText = p.innerText.trim();
        }
        
        // Judul fallback jika tidak ditemukan
        if (!titleText) {
            titleText = fileName.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
        }
        
        // Tentukan tinggi header dan footer berdasarkan teks
        const topPadding = (titleText ? (subtitleText ? 90 : 60) : 20) * scale;
        const bottomPadding = 50 * scale; // Untuk legenda
        
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = sourceCanvas.width;
        tempCanvas.height = sourceCanvas.height + topPadding + bottomPadding;
        const tempCtx = tempCanvas.getContext('2d');
        
        // Isi background dengan warna putih solid
        tempCtx.fillStyle = '#ffffff';
        tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
        
        // Gambar Judul & Subjudul
        let currentY = 30 * scale;
        if (titleText) {
            tempCtx.font = `bold ${Math.round(18 * scale)}px sans-serif`;
            tempCtx.fillStyle = '#0f172a'; // slate-900
            tempCtx.fillText(titleText, 24 * scale, currentY);
            currentY += 22 * scale;
        }
        if (subtitleText) {
            tempCtx.font = `${Math.round(11 * scale)}px sans-serif`;
            tempCtx.fillStyle = '#64748b'; // slate-500
            
            // Bungkus kata jika teks subjudul terlalu panjang
            const maxWidth = tempCanvas.width - 48 * scale;
            const words = subtitleText.split(' ');
            let line = '';
            for (let n = 0; n < words.length; n++) {
                let testLine = line + words[n] + ' ';
                let metrics = tempCtx.measureText(testLine);
                let testWidth = metrics.width;
                if (testWidth > maxWidth && n > 0) {
                    tempCtx.fillText(line, 24 * scale, currentY);
                    line = words[n] + ' ';
                    currentY += 16 * scale;
                } else {
                    line = testLine;
                }
            }
            tempCtx.fillText(line, 24 * scale, currentY);
        }
        
        // Gambar chart di atas background putih
        tempCtx.drawImage(sourceCanvas, 0, topPadding);
        
        // Gambar Legenda di bagian bawah
        const datasets = chartInstance.data.datasets || [];
        if (datasets.length > 0) {
            tempCtx.font = `bold ${Math.round(11 * scale)}px sans-serif`;
            let startX = 24 * scale;
            const legendY = tempCanvas.height - (bottomPadding / 2) + 4 * scale;
            
            datasets.forEach((dataset, index) => {
                const color = dataset.borderColor || dataset.backgroundColor || '#64748b';
                const label = dataset.label || `Dataset ${index + 1}`;
                
                // Gambar indikator warna (lingkaran)
                tempCtx.fillStyle = color;
                tempCtx.beginPath();
                tempCtx.arc(startX + 6 * scale, legendY - 4 * scale, 5 * scale, 0, 2 * Math.PI);
                tempCtx.fill();
                
                // Gambar label teks legenda
                tempCtx.fillStyle = '#334155'; // slate-700
                tempCtx.fillText(label, startX + 16 * scale, legendY);
                
                // Geser koordinat X untuk item legenda berikutnya
                const textWidth = tempCtx.measureText(label).width;
                startX += textWidth + 36 * scale;
            });
        }
        
        const url = tempCanvas.toDataURL('image/png');
        const a = document.createElement('a');
        a.href = url;
        a.download = fileName + '.png';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    } catch (e) {
        console.error("Gagal mendownload gambar PNG:", e);
    }

    // 2. Unduh data Excel detail dari backend (berisi informasi nama pasien dll)
    try {
        const typeMap = {
            'tren_kunjungan': 'visits_trend',
            'tren_status_gizi_balita': 'nutrition_trend',
            'distribusi_status_gizi_balita': 'nutrition_donut',
            'capaian_imunisasi_balita': 'vaccine_chart',
            'pertumbuhan_balita': 'growth_chart',
            'tren_risiko_metabolik_lansia': 'lansia_metabolic_trend'
        };
        const chartType = typeMap[fileName];
        if (chartType && typeof $wire !== 'undefined') {
            $wire.call('exportChartData', chartType);
        }
    } catch (e) {
        console.error("Gagal mendownload data Excel:", e);
    }
}

// ── ANA-50: Fallback Error Helpers ──
function showChartError(canvasId) {
    const errorEl = document.getElementById('error-' + canvasId);
    if (errorEl) {
        errorEl.classList.remove('opacity-0', 'pointer-events-none');
    }
}

function hideChartError(canvasId) {
    const errorEl = document.getElementById('error-' + canvasId);
    if (errorEl) {
        errorEl.classList.add('opacity-0', 'pointer-events-none');
    }
}

function initCharts(data = null) {
    if (typeof Chart === 'undefined') {
        setTimeout(() => initCharts(data), 100);
        return;
    }

    // Apply defaults here so they are guaranteed to run when Chart is available
    Chart.defaults.font.family = "'Public Sans', sans-serif";
    Chart.defaults.font.weight = '700';
    Chart.defaults.color = '#475569';

    // Destroy existing if they exist (safely inside try-catch)
    try { if (visitsTrendChart) { visitsTrendChart.destroy(); visitsTrendChart = null; } } catch (e) {}
    try { if (nutritionTrendChart) { nutritionTrendChart.destroy(); nutritionTrendChart = null; } } catch (e) {}
    try { if (nutritionDonutChart) { nutritionDonutChart.destroy(); nutritionDonutChart = null; } } catch (e) {}
    try { if (vaccineChart) { vaccineChart.destroy(); vaccineChart = null; } } catch (e) {}
    try { if (growthChart) { growthChart.destroy(); growthChart = null; } } catch (e) {}
    try { if (pregnancyRiskChart) { pregnancyRiskChart.destroy(); pregnancyRiskChart = null; } } catch (e) {}
    try { if (lansiaMetabolicChart) { lansiaMetabolicChart.destroy(); lansiaMetabolicChart = null; } } catch (e) {}

    // Hide error messages
    hideChartError('visitsTrendChart');
    hideChartError('nutritionTrendChart');
    hideChartError('nutritionDonutChart');
    hideChartError('vaccineBarChart');
    hideChartError('growthChart');
    hideChartError('pregnancyRiskChart');
    hideChartError('lansiaMetabolicChart');

    // Helper to extract plain array from data payload or Livewire proxy
    const getArr = (fromData, wireProp) => {
        let val = null;
        if (fromData && fromData[wireProp] !== undefined) {
            val = fromData[wireProp];
        } else {
            val = $wire[wireProp];
        }
        try {
            return JSON.parse(JSON.stringify(val || []));
        } catch(e) {
            return [];
        }
    };
    
    // Fetch data arrays safely avoiding Chart.js crash on Proxies
    const labels = getArr(data, 'trendLabels');
    
    // Overview trend
    const visitsBalita = getArr(data, 'trendVisitsBalita');
    const visitsIbuHamil = getArr(data, 'trendVisitsIbuHamil');
    const visitsLansia = getArr(data, 'trendVisitsLansia');

    const viewMode = data ? data.viewMode : $wire.viewMode;
    const compareMode = data ? data.compareMode : $wire.compareMode;
    const trendCompareCurrent = getArr(data, 'trendCompareCurrent');
    const trendComparePrevious = getArr(data, 'trendComparePrevious');
    const trendLabelsPrevious = getArr(data, 'trendLabelsPrevious');

    // Balita trend
    const normal = getArr(data, 'trendNormal');
    const stunting = getArr(data, 'trendStunting');
    const risk = getArr(data, 'trendRisk');
    const avgWeight = getArr(data, 'trendAvgWeight');
    const avgHeight = getArr(data, 'trendAvgHeight');
    const nutLabels = getArr(data, 'nutritionLabels');
    const nutData = getArr(data, 'nutritionData');
    const vaxLabels = getArr(data, 'vaccineLabels');
    const vaxData = getArr(data, 'vaccineData');

    // Ibu Hamil trend
    const pregHyper = getArr(data, 'trendPregnancyHypertension');
    const pregFe = getArr(data, 'trendPregnancyFe');

    // Lansia trend
    const lansiaBP = getArr(data, 'trendLansiaHypertension');
    const lansiaSugar = getArr(data, 'trendLansiaHyperglycemia');
    const lansiaChol = getArr(data, 'trendLansiaHypercholesterolemia');
    const lansiaUric = getArr(data, 'trendLansiaHyperuricemia');

    // 1. Overview Visits Trend Line Chart
    const visitsCtx = document.getElementById('visitsTrendChart');
    if (visitsCtx) {
        try {
            let chartType = 'line';
            let chartLabels = labels;
            let chartDatasets = [];

            if (viewMode === 'yearly') {
                chartType = 'line';
                chartLabels = labels;
                chartDatasets = [
                    {
                        label: 'Tahun Ini',
                        data: trendCompareCurrent,
                        borderColor: '#0d9488',
                        backgroundColor: 'rgba(13, 148, 136, 0.03)',
                        borderWidth: 3.5,
                        tension: 0.35,
                        fill: true,
                    },
                    {
                        label: 'Tahun Lalu',
                        data: trendComparePrevious,
                        borderColor: '#94a3b8',
                        borderDash: [5, 5],
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.35,
                        fill: false,
                    }
                ];
            } else if (compareMode && trendLabelsPrevious.length > 0) {
                chartType = 'bar';
                chartLabels = trendLabelsPrevious; // Balita, Ibu Hamil, Lansia
                chartDatasets = [
                    {
                        label: 'Bulan Ini',
                        data: trendCompareCurrent,
                        backgroundColor: '#0d9488',
                        borderRadius: 4
                    },
                    {
                        label: 'Bulan Lalu',
                        data: trendComparePrevious,
                        backgroundColor: '#94a3b8',
                        borderRadius: 4
                    }
                ];
            } else {
                chartType = 'line';
                chartLabels = labels;
                chartDatasets = [
                    {
                        label: 'Balita & Anak',
                        data: visitsBalita,
                        borderColor: '#0d9488', // teal-600
                        backgroundColor: 'rgba(13, 148, 136, 0.03)',
                        borderWidth: 3.5,
                        tension: 0.35,
                        fill: true,
                    },
                    {
                        label: 'Ibu Hamil',
                        data: visitsIbuHamil,
                        borderColor: '#e11d48', // rose-600
                        backgroundColor: 'rgba(225, 29, 72, 0.03)',
                        borderWidth: 3.5,
                        tension: 0.35,
                        fill: true,
                    },
                    {
                        label: 'Lansia',
                        data: visitsLansia,
                        borderColor: '#4f46e5', // indigo-600
                        backgroundColor: 'rgba(79, 70, 229, 0.03)',
                        borderWidth: 3.5,
                        tension: 0.35,
                        fill: true,
                    }
                ];
            }

            visitsTrendChart = new Chart(visitsCtx, {
                type: chartType,
                data: {
                    labels: chartLabels,
                    datasets: chartDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (event, activeElements) => {
                        if (activeElements.length > 0) {
                            if (window.isDrillingDown) return;
                            window.isDrillingDown = true;

                            const firstPoint = activeElements[0];
                            const index = firstPoint.index;
                            const datasetIndex = firstPoint.datasetIndex;
                            const label = chartLabels[index];
                            const month = index + 1;

                            let type = 'balita';
                            let dsLabel = '';
                            let targetMonth = month;
                            let targetYear = null;

                            if (viewMode === 'yearly' || (compareMode && trendLabelsPrevious.length > 0)) {
                                if (viewMode === 'yearly') {
                                    dsLabel = 'Semua Kunjungan';
                                    type = 'all';
                                    targetMonth = month;
                                    if (datasetIndex === 1) {
                                        targetYear = parseInt($wire.selectedYear) - 1;
                                    }
                                } else {
                                    const catName = trendLabelsPrevious[index];
                                    dsLabel = catName;
                                    type = catName === 'Balita' ? 'balita' : (catName === 'Ibu Hamil' ? 'ibu_hamil' : 'lansia');
                                    
                                    const currentMonth = parseInt($wire.selectedMonth);
                                    if (datasetIndex === 0) {
                                        targetMonth = currentMonth;
                                    } else {
                                        if (currentMonth === 1) {
                                            targetMonth = 12;
                                            targetYear = parseInt($wire.selectedYear) - 1;
                                        } else {
                                            targetMonth = currentMonth - 1;
                                        }
                                    }
                                }
                            } else {
                                const datasetLabel = chartDatasets[datasetIndex].label;
                                dsLabel = datasetLabel;
                                if (datasetLabel.includes('Ibu')) type = 'ibu_hamil';
                                else if (datasetLabel.includes('Lansia')) type = 'lansia';
                            }

                            $wire.call('drillDown', `${dsLabel} - ${label}`, type, targetMonth, null, targetYear, null, 'visits_trend')
                                .then(() => { window.isDrillingDown = false; })
                                .catch(() => { window.isDrillingDown = false; });
                        }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { precision: 0 } }
                    },
                    plugins: {
                        legend: { display: true, position: 'top' }
                    }
                }
            });
        } catch (e) {
            console.error("Error loading visitsTrendChart:", e);
            showChartError('visitsTrendChart');
        }
    }

    // 2. Balita Nutrition Trend Chart
    const trendCtx = document.getElementById('nutritionTrendChart');
    if (trendCtx) {
        try {
            nutritionTrendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Normal',
                            data: normal,
                            borderColor: '#059669',
                            backgroundColor: 'rgba(5, 150, 105, 0.10)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#059669',
                            pointRadius: 4,
                            pointHoverRadius: 7,
                        },
                        {
                            label: 'Risiko Gizi',
                            data: risk,
                            borderColor: '#C2410C',
                            backgroundColor: 'rgba(194, 65, 12, 0.10)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#C2410C',
                            pointRadius: 4,
                            pointHoverRadius: 7,
                        },
                        {
                            label: 'Stunting / Gizi Buruk',
                            data: stunting,
                            borderColor: '#B91C1C',
                            backgroundColor: 'rgba(185, 28, 28, 0.10)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#B91C1C',
                            pointRadius: 4,
                            pointHoverRadius: 7,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    onClick: (event, activeElements, chart) => {
                        if (window.isDrillingDown) return;

                        // Gunakan 'nearest' + intersect:true agar tepat mendeteksi
                        // titik mana yang diklik (bukan selalu dataset pertama)
                        const nearest = chart.getElementsAtEventForMode(
                            event, 'nearest', { intersect: true }, false
                        );
                        if (nearest.length === 0) return;

                        window.isDrillingDown = true;

                        const clicked = nearest[0];
                        const index        = clicked.index;
                        const datasetIndex = clicked.datasetIndex;
                        const label  = labels[index]; // e.g. "Mar"
                        const month  = index + 1;     // bulan ke-1..12

                        // Map dataset index → nama & type backend
                        const datasetMap = [
                            { name: 'Normal',                type: 'balita_normal' },
                            { name: 'Risiko Gizi',           type: 'balita_risiko' },
                            { name: 'Stunting / Gizi Buruk', type: 'balita_stunting_buruk' },
                        ];
                        const { name: datasetLabel, type } = datasetMap[datasetIndex]
                            ?? { name: 'Balita', type: 'balita' };

                        // Kirim bulan + status gizi spesifik ke backend
                        $wire.call('drillDown', `Balita ${datasetLabel} - ${label}`, type, month, null, null, null, 'nutrition_trend')
                            .then(() => { window.isDrillingDown = false; })
                            .catch(() => { window.isDrillingDown = false; });
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: '#f1f5f9' },
                            ticks: { callback: function(value) { return value + '%'; } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    }
                }
            });
        } catch (e) {
            console.error("Error loading nutritionTrendChart:", e);
            showChartError('nutritionTrendChart');
        }
    }

    // 3. Balita Donut Chart
    const donutCtx = document.getElementById('nutritionDonutChart');
    if (donutCtx && nutData && nutData.length > 0 && nutData.some(v => v > 0)) {
        try {
            const colors = nutLabels.map(label => {
                const sLabel = String(label).toLowerCase();
                if (sLabel === 'baik' || sLabel === 'normal') return '#10b981'; // emerald-500
                if (sLabel === 'gizi baik') return '#0d9488'; // teal-500
                if (sLabel === 'gizi kurang' || sLabel === 'kurang') return '#C2410C';
                if (sLabel.includes('sangat') || sLabel.includes('buruk') || sLabel.includes('pendek')) return '#B91C1C';
                if (sLabel.includes('risiko') || sLabel.includes('berisiko') || sLabel.includes('lebih') || sLabel.includes('obesitas')) return '#A16207';
                return '#94a3b8'; // slate-400
            });
            nutritionDonutChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: nutLabels,
                    datasets: [{
                        data: nutData,
                        backgroundColor: colors,
                        borderWidth: 3,
                        borderColor: '#ffffff',
                    }]
                },
                options: {
                    responsive: false,
                    cutout: '75%',
                    onClick: (event, activeElements) => {
                        if (activeElements.length > 0) {
                            if (window.isDrillingDown) return;
                            window.isDrillingDown = true;

                            const firstPoint = activeElements[0];
                            const index = firstPoint.index;
                            const label = String(nutLabels[index]);
                            
                            $wire.call('drillDown', `Balita (${label})`, 'nutrition_status', null, label, null, null, 'nutrition_donut')
                                .then(() => { window.isDrillingDown = false; })
                                .catch(() => { window.isDrillingDown = false; });
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        } catch (e) {
            console.error("Error loading nutritionDonutChart:", e);
            showChartError('nutritionDonutChart');
        }
    }

    // 4. Vaccine Bar Chart
    const vaxCtx = document.getElementById('vaccineBarChart');
    if (vaxCtx) {
        try {
            // Generate gradient-style color palette per vaccine type
            const vaxColors = vaxLabels.map((label, i) => {
                const palette = [
                    '#0d9488','#0891b2','#7c3aed','#059669','#d97706',
                    '#dc2626','#2563eb','#0f766e','#7e22ce','#b45309',
                    '#0369a1','#065f46','#9333ea','#c2410c','#1d4ed8',
                    '#047857','#6d28d9','#92400e'
                ];
                return palette[i % palette.length];
            });

            const maxVal = Math.max(...vaxData, 1);
            vaccineChart = new Chart(vaxCtx, {
                type: 'bar',
                data: {
                    labels: vaxLabels,
                    datasets: [{
                        label: 'Jumlah Anak',
                        data: vaxData,
                        backgroundColor: vaxColors.map(c => c + 'CC'),
                        borderColor: vaxColors,
                        borderWidth: 1.5,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (event, activeElements) => {
                        if (activeElements.length > 0) {
                            if (window.isDrillingDown) return;
                            window.isDrillingDown = true;

                            const index = activeElements[0].index;
                            const vaccineName = vaxLabels[index];
                            $wire.call('drillDown', `Imunisasi: ${vaccineName}`, 'vaccine', null, vaccineName, null, null, 'vaccine_chart')
                                .then(() => { window.isDrillingDown = false; })
                                .catch(() => { window.isDrillingDown = false; });
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = context.parsed.y;
                                    const pct = maxVal > 0 ? ((val / maxVal) * 100).toFixed(1) : 0;
                                    return [
                                        ' Penerima: ' + val + ' anak',
                                        ' Relatif: ' + pct + '% dari tertinggi'
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' }, maxRotation: 45 }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { precision: 0 },
                            title: { display: true, text: 'Jumlah Anak', font: { weight: 'bold', size: 11 }, color: '#64748b' }
                        }
                    }
                }
            });
        } catch (e) {
            console.error("Error loading vaccineChart:", e);
            showChartError('vaccineBarChart');
        }
    }

    // 5. Balita Growth Chart (BB & TB rata-rata per bulan)
    const growthCtx = document.getElementById('growthChart');
    if (growthCtx) {
        try {
            growthChart = new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Rata-rata Berat Badan (kg)',
                            data: avgWeight,
                            borderColor: '#0d9488',
                            backgroundColor: 'rgba(13, 148, 136, 0.08)',
                            borderWidth: 3.5,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'yWeight',
                            pointBackgroundColor: '#0d9488',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        },
                        {
                            label: 'Rata-rata Tinggi Badan (cm)',
                            data: avgHeight,
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139, 92, 246, 0.06)',
                            borderWidth: 3.5,
                            borderDash: [6, 3],
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'yHeight',
                            pointBackgroundColor: '#8b5cf6',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                        },
                        yWeight: {
                            type: 'linear',
                            position: 'left',
                            beginAtZero: false,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(value) { return value + ' kg'; }
                            },
                            title: {
                                display: true,
                                text: 'Berat Badan (kg)',
                                color: '#0d9488',
                                font: { weight: 'bold', size: 11 }
                            }
                        },
                        yHeight: {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: false,
                            grid: { drawOnChartArea: false },
                            ticks: {
                                callback: function(value) { return value + ' cm'; }
                            },
                            title: {
                                display: true,
                                text: 'Tinggi Badan (cm)',
                                color: '#8b5cf6',
                                font: { weight: 'bold', size: 11 }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: true, position: 'bottom' },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#0f172a',
                            bodyColor: '#334155',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.parsed.y;
                                    if (value === 0) return label + ': Tidak ada data';
                                    if (label.includes('Berat')) return label + ': ' + value + ' kg';
                                    return label + ': ' + value + ' cm';
                                }
                            }
                        }
                    }
                }
            });

            growthCtx.ondblclick = function(evt) {
                if (!growthChart) return;
                const elements = growthChart.getElementsAtEventForMode(evt, 'index', { intersect: false }, true);
                if (elements && elements.length > 0) {
                    const index = elements[0].index;
                    const month = index + 1;
                    const label = growthChart.data.labels[index];
                    $wire.call('drillDown', 'Grafik Pertumbuhan Balita - ' + label, 'balita', month, null, null, null, 'growth_chart');
                }
            };
        } catch (e) {
            console.error("Error loading growthChart:", e);
            showChartError('growthChart');
        }
    }

    // 6. Ibu Hamil Trend Chart
    const pregCtx = document.getElementById('pregnancyRiskChart');
    if (pregCtx) {
        try {
            pregnancyRiskChart = new Chart(pregCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Kepatuhan Pil Fe',
                            data: pregFe,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.03)',
                            borderWidth: 3.5,
                            tension: 0.35,
                            fill: true,
                        },
                        {
                            label: 'Risiko Hipertensi',
                            data: pregHyper,
                            borderColor: '#f43f5e',
                            backgroundColor: 'rgba(244, 63, 94, 0.03)',
                            borderWidth: 3.5,
                            tension: 0.35,
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (event, activeElements) => {
                        if (activeElements.length > 0) {
                            if (window.isDrillingDown) return;
                            window.isDrillingDown = true;

                            const firstPoint = activeElements[0];
                            const index = firstPoint.index;
                            const label = labels[index];
                            const month = index + 1;
                            
                            $wire.call('drillDown', `Ibu Hamil - ${label}`, 'ibu_hamil', month, null, null, null, 'visits_trend')
                                .then(() => { window.isDrillingDown = false; })
                                .catch(() => { window.isDrillingDown = false; });
                        }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' }, ticks: { callback: function(value) { return value + '%'; } } }
                    },
                    plugins: { legend: { display: true } }
                }
            });
        } catch (e) {
            console.error("Error loading pregnancyRiskChart:", e);
            showChartError('pregnancyRiskChart');
        }
    }

    // 6. Lansia Metabolic Risk Chart
    const lansiaCtx = document.getElementById('lansiaMetabolicChart');
    if (lansiaCtx) {
        try {
            lansiaMetabolicChart = new Chart(lansiaCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Hipertensi',
                            data: lansiaBP,
                            backgroundColor: '#f43f5e',
                            borderRadius: 6,
                        },
                        {
                            label: 'Hiperglikemia',
                            data: lansiaSugar,
                            backgroundColor: '#eab308',
                            borderRadius: 6,
                        },
                        {
                            label: 'Hiperkolesterolemia',
                            data: lansiaChol,
                            backgroundColor: '#3b82f6',
                            borderRadius: 6,
                        },
                        {
                            label: 'Hiperurisemia',
                            data: lansiaUric,
                            backgroundColor: '#8b5cf6',
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (event, activeElements, chart) => {
                        if (window.isDrillingDown) return;

                        const nearest = chart.getElementsAtEventForMode(
                            event, 'nearest', { intersect: true }, false
                        );
                        if (nearest.length === 0) return;

                        window.isDrillingDown = true;

                        const clicked = nearest[0];
                        const index = clicked.index;
                        const label = labels[index];
                        const month = index + 1;
                        const datasetIndex = clicked.datasetIndex;

                        const types = [
                            'lansia_hipertensi',
                            'lansia_hiperglikemia',
                            'lansia_hiperkolesterolemia',
                            'lansia_hiperurisemia'
                        ];
                        const datasetLabels = [
                            'Hipertensi',
                            'Hiperglikemia',
                            'Hiperkolesterolemia',
                            'Hiperurisemia'
                        ];

                        const type = types[datasetIndex] || 'lansia';
                        const datasetLabel = datasetLabels[datasetIndex] || '';

                        $wire.call('drillDown', `Lansia - ${datasetLabel} (${label})`, type, month, null, null, null, 'visits_trend')
                            .then(() => { window.isDrillingDown = false; })
                            .catch(() => { window.isDrillingDown = false; });
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' }, ticks: { callback: function(value) { return value + '%'; } } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        } catch (e) {
            console.error("Error loading lansiaMetabolicChart:", e);
            showChartError('lansiaMetabolicChart');
        }
    }
}

// Initial load
initCharts();

// Listen for Livewire updates
$wire.on('charts-updated', (event) => {
    const data = Array.isArray(event) ? event[0] : event;
    setTimeout(() => {
        initCharts(data);
    }, 50);
});
</script>
@endscript
</div>