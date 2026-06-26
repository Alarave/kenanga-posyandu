<div class="space-y-5">
    @push('styles')
        <style>
            /* ── Dashboard custom styles ── */
            .dash-hero {
                background: linear-gradient(135deg, #0f766e 0%, #042f2e 100%);
                border-radius: 20px;
                overflow: hidden;
                position: relative;
                box-shadow: 0 10px 25px -5px rgba(4, 47, 46, 0.4);
            }
            .dash-hero-orb-a {
                position: absolute; top: -40px; left: 30%;
                width: 300px; height: 300px;
                background: radial-gradient(circle, rgba(20,184,166,0.18) 0%, transparent 70%);
                border-radius: 50%; pointer-events: none;
            }
            .dash-hero-orb-b {
                position: absolute; bottom: -60px; right: 10%;
                width: 280px; height: 280px;
                background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
                border-radius: 50%; pointer-events: none;
            }
            .dash-hero-grid {
                position: absolute; inset: 0; opacity: 0.03;
                background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgc3Ryb2tlPSIjZmZmIiBzdHJva2Utd2lkdGg9IjAuNSIgZmlsbD0ibm9uZSI+PHBhdGggZD0iTTQwIDBMMCA0ME0wIDBsNDAgNDAiLz48L2c+PC9zdmc+');
            }

            /* KPI Cards */
            .kpi-card {
                background: #fff;
                border: 1px solid rgba(0,0,0,0.06);
                border-radius: 16px;
                padding: 1.25rem 1.375rem;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                transition: all 180ms ease-out;
            }
            .kpi-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px -4px rgba(0,104,73,0.1);
                border-color: rgba(0,104,73,0.14);
            }
            .kpi-icon {
                width: 42px; height: 42px;
                border-radius: 11px;
                display: flex; align-items: center; justify-content: center;
                transition: transform 250ms ease;
            }
            .kpi-card:hover .kpi-icon { transform: scale(1.07); }

            /* Metric mini card inside hero */
            .hero-metric {
                background: rgba(255,255,255,0.07);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 14px;
                padding: 0.875rem 1.125rem;
                backdrop-filter: blur(8px);
                transition: background 200ms;
            }
            .hero-metric:hover { background: rgba(255,255,255,0.11); }

            /* Widget card */
            .widget-card {
                background: #fff;
                border: 1px solid rgba(0,0,0,0.06);
                border-radius: 18px;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                overflow: hidden;
            }
            .widget-header {
                padding: 1.125rem 1.375rem;
                border-bottom: 1px solid rgba(0,0,0,0.05);
                display: flex; align-items: center; justify-content: space-between;
            }

            /* Filter bar */
            .filter-bar {
                background: #fff;
                border: 1px solid rgba(0,0,0,0.06);
                border-radius: 16px;
                padding: 1rem 1.375rem;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }
            .filter-select {
                border-radius: 10px;
                border: 1px solid #e2e8f0;
                background: #f8fafc;
                font-size: 0.8125rem;
                font-weight: 500;
                height: 38px;
                padding: 0 0.75rem;
                color: #334155;
                transition: border-color 150ms, box-shadow 150ms;
                width: 100%;
            }
            .filter-select:focus {
                outline: none;
                border-color: #006c49;
                box-shadow: 0 0 0 3px rgba(0,108,73,0.1);
            }

            /* Table rows */
            .dash-tr:hover { background: #f8fafb; }

            /* Progress bar animated */
            .progress-fill {
                transition: width 800ms cubic-bezier(0.4,0,0.2,1);
            }

            /* Alert banner */
            .alert-critical {
                background: linear-gradient(135deg, #dc2626, #b91c1c);
                border-radius: 14px;
                color: white;
            }

            @keyframes ping-slow {
                0%,100% { transform: scale(1); opacity: 0.8; }
                50%      { transform: scale(1.8); opacity: 0; }
            }
            .animate-ping-slow { animation: ping-slow 2s ease-in-out infinite; }

            /* Pulse indicator */
            .live-dot {
                position: relative; display: inline-flex; width: 8px; height: 8px;
            }
            .live-dot::before {
                content: ''; position: absolute; inset: 0;
                border-radius: 50%; background: #14b8a6;
                animation: ping-slow 2s ease-in-out infinite;
            }
            .live-dot::after {
                content: ''; position: absolute; inset: 1px;
                border-radius: 50%; background: #14b8a6;
            }

            /* Circular progress */
            .circular-progress { transform: rotate(-90deg); }
            .circular-progress circle.track { fill: none; stroke: #e2e8f0; }
            .circular-progress circle.fill { fill: none; stroke-linecap: round; transition: stroke-dashoffset 1s ease; }
        </style>
    @endpush

    @php
        $hour = now()->hour;
        $sapa = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
        $sapaIcon = $hour < 11 ? 'wb_sunny' : ($hour < 15 ? 'light_mode' : ($hour < 18 ? 'wb_twilight' : 'nights_stay'));
        $user = Auth::user();
        $posyanduName = $user->posyandu?->name ?? 'Semua Wilayah';
        $todayStr = now()->translatedFormat('l, d F Y');
    @endphp

    {{-- ── Hero Section ── --}}
    <section class="dash-hero">
        <div class="dash-hero-orb-a"></div>
        <div class="dash-hero-orb-b"></div>
        <div class="dash-hero-grid"></div>

        <div class="relative z-10 px-7 py-8 md:px-10 md:py-10">
            {{-- Top row: greeting + date + actions --}}
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                <div class="flex-1 min-w-0">
                    {{-- Live badge --}}
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-4"
                         style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.1);">
                        <span class="live-dot shrink-0"></span>
                        <span class="text-xs font-semibold text-teal-100 tracking-wide">Sistem Aktif</span>
                        <span class="text-teal-200/50 text-xs">·</span>
                        <span class="text-xs text-teal-100/80">{{ $todayStr }}</span>
                    </div>

                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight mb-2"
                        style="letter-spacing:-0.025em;">
                        <span class="material-symbols-outlined text-yellow-300 align-middle"
                              style="font-size:1.75rem; margin-right:6px;">{{ $sapaIcon }}</span>
                        {{ $sapa }},
                        <span class="text-transparent bg-clip-text"
                              style="background-image:linear-gradient(135deg,#5eead4 0%,#a7f3d0 100%);">
                            {{ explode(' ', $user->name)[0] }}!
                        </span>
                    </h1>

                    <p class="text-teal-50/90 text-sm max-w-lg leading-relaxed font-normal">
                        Pantau indikator kesehatan masyarakat secara real-time. Wilayah aktif:
                        <span class="text-teal-300 font-bold">{{ $posyanduName }}</span>
                    </p>

                    {{-- Quick action buttons --}}
                    <div class="flex flex-wrap items-center gap-3 mt-6">
                        @can('create', App\Models\Patient::class)
                            <a href="{{ route('admin.patients.create') }}"
                               class="inline-flex items-center gap-2 h-10 px-5 rounded-xl font-bold text-xs text-teal-900 bg-teal-400 transition-all hover:-translate-y-0.5 hover:bg-teal-300 active:scale-95 shadow-lg shadow-teal-500/30">
                                <span class="material-symbols-outlined text-[18px]">person_add</span>
                                Registrasi Warga
                            </a>
                        @endcan
                        @can('create', App\Models\MedicalRecord::class)
                            <a href="{{ route('admin.medical-records.create') }}"
                               class="inline-flex items-center gap-2 h-10 px-5 rounded-xl font-semibold text-xs text-white transition-all hover:-translate-y-0.5 hover:bg-white/20 active:scale-95"
                               style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2);">
                                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                Input Rekam Medis
                            </a>
                        @endcan
                        <a href="{{ route('admin.reports.index') }}"
                           class="inline-flex items-center gap-2 h-10 px-5 rounded-xl font-semibold text-xs text-white transition-all hover:-translate-y-0.5 hover:bg-white/20 active:scale-95 no-print"
                           style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2);">
                            <span class="material-symbols-outlined text-[18px]">bar_chart</span>
                            Laporan
                        </a>
                    </div>
                </div>

                {{-- Hero metrics (right side) --}}
                <div class="grid grid-cols-2 gap-3 lg:w-auto lg:shrink-0 lg:grid-cols-2 xl:grid-cols-2">
                    <div class="hero-metric">
                        <p class="text-[10px] font-bold text-teal-100/70 uppercase tracking-wider mb-1">Total Balita</p>
                        <p class="text-2xl font-bold text-white leading-none" style="font-variant-numeric:tabular-nums;">
                            {{ number_format($totalBalita) }}</p>
                        @if($kelahiranBulanIni > 0)
                            <p class="text-[10px] text-teal-300 font-semibold mt-1.5">+{{ $kelahiranBulanIni }} bulan ini</p>
                        @else
                            <p class="text-[10px] text-teal-100/50 mt-1.5">anak terdaftar</p>
                        @endif
                    </div>
                    <div class="hero-metric">
                        <p class="text-[10px] font-bold text-teal-100/70 uppercase tracking-wider mb-1">Pemeriksaan (YTD)</p>
                        <p class="text-2xl font-bold text-white leading-none" style="font-variant-numeric:tabular-nums;">
                            {{ number_format($totalPemeriksaan) }}</p>
                        <p class="text-[10px] text-teal-100/50 mt-1.5">kunjungan total</p>
                    </div>
                    <div class="hero-metric">
                        <p class="text-[10px] font-bold text-teal-100/70 uppercase tracking-wider mb-1">Imunisasi (YTD)</p>
                        <p class="text-2xl font-bold text-white leading-none" style="font-variant-numeric:tabular-nums;">
                            {{ number_format($totalImunisasi) }}</p>
                        <p class="text-[10px] text-teal-100/50 mt-1.5">dosis diberikan</p>
                    </div>
                    <div class="hero-metric">
                        <p class="text-[10px] font-bold text-teal-100/70 uppercase tracking-wider mb-1">Kunjungan Bulan Ini</p>
                        <p class="text-2xl font-bold text-white leading-none" style="font-variant-numeric:tabular-nums;">
                            {{ number_format($kunjunganBaru) }}</p>
                        <p class="text-[10px] text-teal-100/50 mt-1.5">{{ now()->translatedFormat('F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Global Filter Bar ── --}}
    <div class="filter-bar">
        <div class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="flex items-center gap-2 shrink-0 self-center sm:self-auto">
                <span class="material-symbols-outlined text-[18px] text-slate-400">filter_list</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">Filter Data</span>
            </div>

            <!-- Filter Periode -->
            <div class="flex-1 min-w-0">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Periode</label>
                <select wire:model.live="filterPeriode" class="filter-select">
                    <option value="semua">Sepanjang Waktu</option>
                    <option value="bulan_ini">Bulan Ini</option>
                    <option value="bulan_lalu">Bulan Lalu</option>
                    <option value="tahun_ini">Tahun Ini</option>
                    <option value="tahun_lalu">Tahun Lalu</option>
                    <option value="custom">Rentang Kustom...</option>
                </select>
            </div>

            @if($filterPeriode === 'custom')
            <div class="flex gap-2 flex-1 min-w-0">
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Dari</label>
                    <input type="date" wire:model.live="filterCustomStartDate"
                           class="filter-select" style="padding:0 0.625rem;">
                </div>
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sampai</label>
                    <input type="date" wire:model.live="filterCustomEndDate"
                           class="filter-select" style="padding:0 0.625rem;">
                </div>
            </div>
            @endif

            @if(Auth::user()->isSuperAdmin())
            <div class="flex-1 min-w-0">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Wilayah</label>
                <select wire:model.live="filterPosyandu" class="filter-select">
                    <option value="semua">Semua Posyandu</option>
                    @foreach($availablePosyandus as $pos)
                        <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="flex-1 min-w-0">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori</label>
                <select wire:model.live="filterRisiko" class="filter-select">
                    <option value="semua">Semua Warga</option>
                    <option value="risiko_tinggi">Risiko Tinggi</option>
                </select>
            </div>

            <div class="shrink-0 flex items-center gap-2">
                <button wire:click="resetFilters"
                        class="h-9 px-4 rounded-xl font-semibold text-xs text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors flex items-center gap-1.5 whitespace-nowrap">
                    <span class="material-symbols-outlined text-[15px]">restart_alt</span>
                    Reset
                </button>

                <div wire:loading wire:target="filterPeriode, filterCustomStartDate, filterCustomEndDate, filterPosyandu, filterRisiko, resetFilters"
                     class="flex items-center gap-1.5 text-teal-600 text-xs font-semibold">
                    <svg class="animate-spin h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memuat...
                </div>
            </div>
        </div>
    </div>

    {{-- ── Critical Alert Banner ── --}}
    @php
        $giziBurukCount = $balitaStunting->filter(function($b) {
            $mr = $b->medicalRecords->first();
            return $mr && (
                $mr->nutrition_status === 'Gizi Buruk' ||
                $mr->wasting_status === 'Gizi Buruk' ||
                $mr->stunting_status === 'Sangat Pendek'
            );
        })->count();
    @endphp
    @if($giziBurukCount > 0)
        <div class="alert-critical p-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px] text-white">warning</span>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-white leading-tight">Perhatian: {{ $giziBurukCount }} Kasus Gizi Buruk Terdeteksi!</h4>
                    <p class="text-red-100 text-xs mt-0.5">Balita dengan status Gizi Buruk atau Sangat Pendek perlu penanganan segera.</p>
                </div>
            </div>
            <a href="{{ route('admin.patients.index') }}"
               class="shrink-0 bg-white text-red-600 px-4 py-2 rounded-xl font-bold text-xs hover:bg-red-50 transition-colors">
                Lihat Data →
            </a>
        </div>
    @endif

    {{-- ── Demographic Grid ── --}}
    <section class="mb-5">
        <x-widget.demographic-grid :stats="$demographicStats" />
    </section>

    {{-- ── KPI Summary Row ── --}}
    @php
        $stuntingCount = count($balitaStunting);
        $bumilRisikoCount = count($bumilRisikoTinggi);
        $missingVaxCount = count($missingImmunizations);
        $kpiCards = [
            [
                'label'   => 'Total Balita/Bayi',
                'value'   => $totalBalita,
                'unit'    => 'anak',
                'icon'    => 'child_care',
                'bg'      => '#eff6ff',
                'fg'      => '#2563eb',
                'sub'     => $kelahiranBulanIni > 0 ? "+{$kelahiranBulanIni} bulan ini" : null,
                'link'    => route('admin.patients.index', ['category' => 'balita']),
            ],
            [
                'label'   => 'Total Pemeriksaan',
                'value'   => $totalPemeriksaan,
                'unit'    => 'kunjungan',
                'icon'    => 'medical_services',
                'bg'      => '#ecfdf5',
                'fg'      => '#059669',
                'sub'     => "Bulan ini: {$kunjunganBaru}",
                'link'    => route('admin.medical-records.index'),
            ],
            [
                'label'   => 'Total Imunisasi',
                'value'   => $totalImunisasi,
                'unit'    => 'dosis',
                'icon'    => 'vaccines',
                'bg'      => '#f0fdfa',
                'fg'      => '#0f766e',
                'sub'     => $missingVaxCount > 0 ? "{$missingVaxCount} anak belum lengkap" : 'Semua terpenuhi',
                'link'    => null,
            ],
            [
                'label'   => 'Partisipasi Penimbangan',
                'value'   => $kehadiranBalita['persentase'],
                'unit'    => '%',
                'icon'    => 'how_to_reg',
                'bg'      => '#f0fdf4',
                'fg'      => '#16a34a',
                'sub'     => "{$kehadiranBalita['hadir']} hadir · {$kehadiranBalita['tidak_hadir']} absen",
                'link'    => null,
            ],
            [
                'label'   => 'Atensi Gizi',
                'value'   => $stuntingCount,
                'unit'    => 'kasus',
                'icon'    => 'warning',
                'bg'      => '#fef2f2',
                'fg'      => '#dc2626',
                'sub'     => $giziBurukCount > 0 ? "{$giziBurukCount} gizi buruk" : 'Pantau rutin',
                'link'    => route('admin.patients.index'),
            ],
            [
                'label'   => 'Bumil Risiko Tinggi',
                'value'   => $bumilRisikoCount,
                'unit'    => 'orang',
                'icon'    => 'pregnant_woman',
                'bg'      => '#fff1f2',
                'fg'      => '#e11d48',
                'sub'     => "Perlu pantauan khusus",
                'link'    => route('admin.patients.index'),
            ],
        ];
    @endphp

    <section class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3">
        @foreach($kpiCards as $card)
            @if($card['link'])
                <a href="{{ $card['link'] }}" class="kpi-card group">
            @else
                <div class="kpi-card">
            @endif
                <div class="flex items-start justify-between mb-3">
                    <div class="kpi-icon" style="background:{{ $card['bg'] }}; color:{{ $card['fg'] }};">
                        <span class="material-symbols-outlined text-[20px]">{{ $card['icon'] }}</span>
                    </div>
                    @if($card['link'])
                        <span class="material-symbols-outlined text-[14px] text-slate-300 group-hover:text-slate-500 transition-colors">arrow_outward</span>
                    @endif
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 leading-tight">{{ $card['label'] }}</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-xl font-bold text-slate-900 leading-none"
                          style="font-variant-numeric:tabular-nums; letter-spacing:-0.02em;">{{ number_format($card['value']) }}</span>
                    <span class="text-[10px] font-medium text-slate-400">{{ $card['unit'] }}</span>
                </div>
                @if($card['sub'])
                    <p class="text-[10px] font-medium text-slate-400 mt-1.5 truncate leading-tight">{{ $card['sub'] }}</p>
                @endif
            @if($card['link'])
                </a>
            @else
                </div>
            @endif
        @endforeach
    </section>

    {{-- ── Analytics Chart ── --}}
    <div class="widget-card p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[20px]">monitoring</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Tren Kunjungan & Layanan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Statistik pemeriksaan 12 bulan terakhir</p>
                </div>
            </div>
        </div>
        <div class="relative w-full h-70">
            <canvas id="dashboardVisitsChart" wire:ignore></canvas>
        </div>
    </div>

    {{-- ── Main Grid ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        {{-- Left: 8 Columns --}}
        <div class="lg:col-span-8 space-y-5">

            {{-- Stunting Alert Table --}}
            <div class="widget-card">
                <div class="widget-header">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">warning</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Prioritas Atensi Gizi</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Status stunting & gizi buruk terdeteksi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-red-50 border border-red-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-red-600">{{ count($balitaStunting) }} Kasus</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr style="background:#f9fafb; border-bottom:1px solid rgba(0,0,0,0.05);">
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Balita</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Usia</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                                <th class="px-5 py-3 text-right text-[10px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($balitaStunting as $balita)
                                <tr class="dash-tr transition-colors border-b border-slate-50">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($balita->full_name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="block text-sm font-semibold text-slate-800">{{ $balita->full_name }}</span>
                                                <span class="text-xs text-slate-400">ID #{{ $balita->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-slate-600 text-center font-medium">{{ $balita->age }}</td>
                                    <td class="px-5 py-3.5 text-center">
                                        @php
                                            $latestRecord = $balita->medicalRecords->first();
                                            $displayStatus = 'Atensi Gizi';
                                            if ($latestRecord) {
                                                foreach ([$latestRecord->stunting_status, $latestRecord->nutrition_status, $latestRecord->wasting_status] as $ps) {
                                                    if (str_contains((string)$ps, 'Sangat') || str_contains((string)$ps, 'Buruk') || str_contains((string)$ps, 'Pendek')) {
                                                        $displayStatus = $ps; break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <span class="badge badge-red">{{ $displayStatus }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('admin.patients.show', $balita->id) }}"
                                           class="inline-flex w-8 h-8 items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-14 text-center">
                                        <div class="flex flex-col items-center gap-2.5">
                                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-400">
                                                <span class="material-symbols-outlined text-[24px]">verified_user</span>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-500">Semua data terpantau normal</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Bumil Risiko Tinggi Alert Table --}}
            <div class="widget-card">
                <div class="widget-header">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">pregnant_woman</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Ibu Hamil Risiko Tinggi</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Pemantauan khusus bumil berisiko</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-rose-50 border border-rose-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-rose-600">{{ count($bumilRisikoTinggi) }} Kasus</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr style="background:#f9fafb; border-bottom:1px solid rgba(0,0,0,0.05);">
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ibu Hamil</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Usia</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Kondisi</th>
                                <th class="px-5 py-3 text-right text-[10px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bumilRisikoTinggi as $bumil)
                                <tr class="dash-tr transition-colors border-b border-slate-50">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($bumil->full_name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="block text-sm font-semibold text-slate-800">{{ $bumil->full_name }}</span>
                                                <span class="text-xs text-slate-400">ID #{{ $bumil->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-slate-600 text-center font-medium">{{ $bumil->age }}</td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="badge badge-red">Risiko Tinggi</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('admin.patients.show', $bumil->id) }}"
                                           class="inline-flex w-8 h-8 items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-rose-500 hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center">
                                        <p class="text-sm font-medium text-slate-400">Tidak ada ibu hamil dengan risiko tinggi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="widget-card">
                <div class="widget-header">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">history</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Pemeriksaan Terbaru</h3>
                            <p class="text-xs text-slate-400 mt-0.5">5 kunjungan pemeriksaan terakhir</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.medical-records.index') }}"
                       class="text-xs font-semibold text-teal-600 hover:text-teal-700 flex items-center gap-1 transition-colors">
                        Lihat Semua
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr style="background:#f9fafb; border-bottom:1px solid rgba(0,0,0,0.05);">
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pasien</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Visit</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Unit Posyandu</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentActivities as $activity)
                                <tr class="dash-tr transition-colors border-b border-slate-50">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($activity->patient->full_name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="block text-sm font-semibold text-slate-800">
                                                    <a href="{{ route('admin.patients.show', $activity->patient->id) }}" class="hover:text-teal-600 transition-colors">
                                                        {{ $activity->patient->full_name }}
                                                    </a>
                                                </span>
                                                <span class="text-xs text-slate-400">{{ $activity->patient->category }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-slate-600 font-medium">
                                        {{ $activity->visit_date->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="badge badge-blue">{{ $activity->patient->posyandu->name }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-slate-600">
                                        {{ $activity->user->name ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Immunizations --}}
            <div class="widget-card">
                <div class="widget-header">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">vaccines</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Imunisasi Terbaru</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Pemberian imunisasi terakhir tercatat</p>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr style="background:#f9fafb; border-bottom:1px solid rgba(0,0,0,0.05);">
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Balita</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentImmunizations as $vaxRecord)
                                <tr class="dash-tr transition-colors border-b border-slate-50">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($vaxRecord->patient->full_name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="block text-sm font-semibold text-slate-800">{{ $vaxRecord->patient->full_name }}</span>
                                                <span class="text-xs text-slate-400">ID #{{ $vaxRecord->patient->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-slate-600 font-medium">
                                        {{ $vaxRecord->visit_date->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="badge badge-teal">{{ $vaxRecord->vaccine_name && $vaxRecord->vaccine_name !== 'Tidak ada' ? $vaxRecord->vaccine_name : $vaxRecord->immunization }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-slate-600">
                                        {{ $vaxRecord->user->name ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center">
                                        <p class="text-sm font-medium text-slate-400">Belum ada data imunisasi terbaru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Side: 4 Columns --}}
        <div class="lg:col-span-4 flex flex-col gap-4">

            {{-- Upcoming Schedule Widget --}}
            <div class="widget-card p-5 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-teal-50 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-teal-600 text-white flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">event</span>
                            </div>
                            <span class="font-bold text-slate-900 text-sm">Agenda Terdekat</span>
                        </div>
                        <span class="live-dot"></span>
                    </div>

                    @if ($upcomingSchedule)
                        <div class="space-y-3">
                            <div class="flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-xl bg-slate-900 flex flex-col items-center justify-center text-white shadow-md shrink-0">
                                    <span class="text-[8px] font-bold uppercase opacity-60 tracking-wider">{{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->translatedFormat('M') }}</span>
                                    <span class="text-xl font-bold leading-none">{{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->format('d') }}</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-900 text-sm leading-snug truncate">{{ $upcomingSchedule->title }}</h4>
                                    <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                        <span class="material-symbols-outlined text-[13px] text-teal-500">schedule</span>
                                        {{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->format('H:i') }} WIB
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="material-symbols-outlined text-[16px] text-teal-500 shrink-0">location_on</span>
                                <span class="text-xs text-slate-700 font-medium truncate">{{ $upcomingSchedule->location ?: 'Pusat Posyandu' }}</span>
                            </div>

                            @if(\Carbon\Carbon::parse($upcomingSchedule->start_time)->isToday())
                            <div class="p-3 rounded-xl bg-teal-50 border border-teal-100">
                                <p class="text-[10px] font-bold text-teal-700 mb-2 uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="live-dot"></span>
                                    Target Imunisasi Hari Ini
                                </p>
                                <div class="space-y-1.5">
                                    @forelse($missingImmunizations->take(3) as $item)
                                        <div class="flex items-center justify-between bg-white border border-teal-100 p-2 rounded-lg">
                                            <div class="flex items-center gap-2 overflow-hidden">
                                                <div class="w-6 h-6 rounded bg-teal-100 text-teal-700 flex shrink-0 items-center justify-center font-bold text-[9px]">
                                                    {{ strtoupper(substr($item['patient']->full_name, 0, 2)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[11px] font-semibold text-slate-800 truncate">{{ $item['patient']->full_name }}</p>
                                                    <p class="text-[10px] text-slate-400 truncate">{{ $item['next_vaccine'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-[10px] text-teal-500 italic">Tidak ada target khusus.</p>
                                    @endforelse
                                    @if(count($missingImmunizations) > 3)
                                        <p class="text-[10px] text-center text-teal-600 font-semibold mt-1">
                                            + {{ count($missingImmunizations) - 3 }} warga lainnya
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <a href="{{ route('admin.schedules.index') }}"
                                class="w-full h-10 bg-teal-600 text-white rounded-xl font-semibold text-xs flex items-center justify-center hover:bg-teal-700 transition-colors gap-1.5 mt-1">
                                <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                                Buka Kalender Jadwal
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col items-center py-8 text-center">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 mb-2.5">
                                <span class="material-symbols-outlined text-[24px]">event_busy</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">Tidak ada jadwal terdekat</p>
                            <p class="text-xs text-slate-400 mt-0.5">Buat jadwal kegiatan baru</p>
                            <a href="{{ route('admin.schedules.index') }}"
                               class="mt-3 text-xs font-semibold text-teal-600 hover:text-teal-700 flex items-center gap-1">
                                Kelola Jadwal
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Missing Immunizations Widget --}}
            <div class="widget-card p-5 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-orange-50 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-orange-500 text-white flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">vaccines</span>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 text-sm block">Atensi Imunisasi</span>
                                <span class="text-[10px] text-slate-400">Belum lengkap vaksinasi</span>
                            </div>
                        </div>
                        @if (count($missingImmunizations) > 0)
                            <span class="badge badge-amber">{{ count($missingImmunizations) }}</span>
                        @endif
                    </div>

                    <div class="space-y-1.5">
                        @forelse($missingImmunizations as $item)
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-sm transition-all">
                                <div class="flex items-center gap-2 overflow-hidden">
                                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-700 shrink-0 flex items-center justify-center font-bold text-[10px]">
                                        {{ strtoupper(substr($item['patient']->full_name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-slate-900 truncate">{{ $item['patient']->full_name }}</p>
                                        <p class="text-[10px] text-slate-400 truncate">Next: {{ $item['next_vaccine'] }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.patients.show', $item['patient']->id) }}"
                                   class="w-7 h-7 shrink-0 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all">
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </a>
                            </div>
                        @empty
                            <div class="flex flex-col items-center py-6 text-center">
                                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-400 mb-2">
                                    <span class="material-symbols-outlined text-[22px]">verified</span>
                                </div>
                                <p class="text-sm font-semibold text-slate-500">Semua Imunisasi Terpenuhi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Kehadiran Balita Widget --}}
            <div class="widget-card p-5 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-emerald-50 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                            </div>
                            <span class="font-bold text-slate-900 text-sm">Partisipasi (D/S)</span>
                        </div>
                        <span class="badge badge-emerald">{{ $kehadiranBalita['persentase'] }}%</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100 flex flex-col justify-center items-center text-center">
                            <span class="text-xl font-bold text-emerald-700">{{ $kehadiranBalita['hadir'] }}</span>
                            <span class="text-[10px] font-semibold text-emerald-600 uppercase mt-1">Hadir</span>
                        </div>
                        <div class="p-3 rounded-xl bg-rose-50 border border-rose-100 flex flex-col justify-center items-center text-center">
                            <span class="text-xl font-bold text-rose-700">{{ $kehadiranBalita['tidak_hadir'] }}</span>
                            <span class="text-[10px] font-semibold text-rose-600 uppercase mt-1">Tidak Hadir</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ibu Hamil Trimester Widget --}}
            <div class="widget-card p-5 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-pink-50 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-pink-500 text-white flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">pregnant_woman</span>
                            </div>
                            <span class="font-bold text-slate-900 text-sm">Bumil per Trimester</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @php
                            $totalBumil = array_sum($bumilTrimester);
                        @endphp
                        @foreach (['T1' => 'Trimester 1 (0-13 mgg)', 'T2' => 'Trimester 2 (14-27 mgg)', 'T3' => 'Trimester 3 (28+ mgg)'] as $key => $label)
                            @php
                                $count = $bumilTrimester[$key];
                                $percent = $totalBumil > 0 ? ($count / $totalBumil) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between text-xs font-semibold text-slate-600 mb-1">
                                    <span>{{ $label }}</span>
                                    <span>{{ $count }} orang</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5">
                                    <div class="bg-pink-500 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Demografi Lansia Widget --}}
            <div class="widget-card p-5 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-orange-50 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-orange-500 text-white flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">elderly</span>
                            </div>
                            <span class="font-bold text-slate-900 text-sm">Demografi Lansia</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-orange-50 border border-orange-100 flex flex-col justify-center items-center text-center">
                            <span class="text-xl font-bold text-orange-700">{{ $lansiaDemografi['60_69'] }}</span>
                            <span class="text-[10px] font-semibold text-orange-600 uppercase mt-1">60-69 Tahun</span>
                        </div>
                        <div class="p-3 rounded-xl bg-red-50 border border-red-100 flex flex-col justify-center items-center text-center">
                            <span class="text-xl font-bold text-red-700">{{ $lansiaDemografi['70_plus'] }}</span>
                            <span class="text-[10px] font-semibold text-red-600 uppercase mt-1">70+ Tahun</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nutrition Status Widget --}}
            <div class="widget-card p-5 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-50 rounded-full blur-3xl pointer-events-none">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Kondisi Gizi</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Distribusi status gizi balita</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <span class="material-symbols-outlined text-[18px]">donut_large</span>
                        </div>
                    </div>

                    @php
                        $ndLabels = $nutritionStatusDistribution['labels'];
                        $ndData = $nutritionStatusDistribution['data'];
                        $chartTotal = array_sum($ndData);
                    @endphp

                    {{-- Chart --}}
                    <div x-data="{
                        chart: null,
                        hiddenItems: [],
                        isEmpty: false,
                        init() {
                            const nd = $wire.nutritionStatusDistribution;
                            if (!nd || !nd.labels || !nd.data || nd.data.length === 0) {
                                this.isEmpty = true;
                                return;
                            }
                            this.isEmpty = nd.data.every(v => parseInt(v) === 0);
                            if (this.isEmpty) return;
                    
                            const colors = nd.labels.map(label => {
                                if (label.includes('Normal') || label.includes('Baik')) return '#059669';
                                if (label.includes('Kurang') && !label.includes('Sangat')) return '#f59e0b';
                                if (label.includes('Risiko') || label.includes('Berisiko')) return '#f59e0b';
                                if (label.includes('Sangat') || label.includes('Buruk') || label.includes('Pendek')) return '#ef4444';
                                if (label.includes('Lebih') || label.includes('Obesitas')) return '#f59e0b'; // Oranye untuk Gizi Lebih
                                return '#94a3b8';
                            });
                    
                            this.chart = new Chart(this.$refs.canvas, {
                                type: 'doughnut',
                                data: {
                                    labels: nd.labels,
                                    datasets: [{
                                        data: nd.data,
                                        backgroundColor: colors,
                                        borderWidth: 3,
                                        borderColor: '#ffffff',
                                        hoverOffset: 8
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '80%',
                                    animation: { duration: 800, easing: 'easeOutQuart' },
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            cornerRadius: 10,
                                            padding: 10,
                                            bodyFont: { family: '\'Public Sans\', sans-serif', size: 12 },
                                            titleFont: { family: '\'Public Sans\', sans-serif', size: 12, weight: 'bold' }
                                        }
                                    }
                                }
                            });
                        },
                        toggleVisibility(index) {
                            if (!this.chart) return;
                            this.chart.toggleDataVisibility(index);
                            this.chart.update();
                            if (this.hiddenItems.includes(index)) {
                                this.hiddenItems = this.hiddenItems.filter(i => i !== index);
                            } else {
                                this.hiddenItems.push(index);
                            }
                        }
                    }" wire:ignore class="relative flex justify-center mb-5">
                        <canvas x-show="!isEmpty" x-ref="canvas" width="180" height="180"
                            style="max-width:180px;max-height:180px;"></canvas>
                        <div x-show="!isEmpty" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-slate-900 leading-none"
                                style="font-variant-numeric:tabular-nums;">{{ $chartTotal }}</span>
                            <span class="text-xs font-medium text-slate-400 mt-1">Total</span>
                        </div>
                        <template x-if="isEmpty">
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined text-[32px] mb-2 opacity-50">pie_chart</span>
                                <span class="text-xs font-medium">Belum ada data</span>
                            </div>
                        </template>
                    </div>

                    {{-- Legend --}}
                    <div class="space-y-2.5 pt-4 border-t border-slate-100">
                        @foreach ($ndLabels as $index => $label)
                            @php
                                $count = $ndData[$index] ?? 0;
                                $percentage = $chartTotal > 0 ? round(($count / $chartTotal) * 100, 1) : 0;
                                $color = match (true) {
                                    str_contains($label, 'Normal') || str_contains($label, 'Baik') => '#059669',
                                    str_contains($label, 'Kurang') && !str_contains($label, 'Sangat') => '#f59e0b',
                                    str_contains($label, 'Risiko') || str_contains($label, 'Berisiko') => '#f59e0b',
                                    str_contains($label, 'Sangat') ||
                                        str_contains($label, 'Buruk') ||
                                        str_contains($label, 'Pendek')
                                        => '#ef4444',
                                    str_contains($label, 'Lebih') || str_contains($label, 'Obesitas') => '#f59e0b',
                                    default => '#94a3b8',
                                };
                            @endphp
                            <div class="flex items-center gap-2 cursor-pointer transition-opacity duration-200 hover:opacity-80" 
                                 :class="hiddenItems.includes({{ $index }}) ? 'opacity-40 grayscale' : ''"
                                 @click="toggleVisibility({{ $index }})">
                                <span class="w-2 h-2 rounded-full shrink-0"
                                    style="background:{{ $color }}"></span>
                                <span class="text-xs text-slate-600 flex-1 truncate select-none">{{ $label }}</span>
                                <div class="flex items-center gap-2 shrink-0">
                                    <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500"
                                            style="background:{{ $color }}; width:{{ $percentage }}%;">
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-700 w-8 text-right select-none"
                                        style="font-variant-numeric:tabular-nums;">{{ $percentage }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Trend Analysis Section ── --}}
    <section class="widget-card p-6 md:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <div
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-emerald-700">Analitik Tahunan</span>
                </div>
                <h3 class="font-bold text-slate-900 text-lg" style="letter-spacing:-0.02em;">Tren Aktivitas
                    Pemeriksaan</h3>
                <p class="text-sm text-slate-500 mt-1">Frekuensi penimbangan kumulatif selama 12 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-3 sm:shrink-0">
                <div class="text-right">
                    <p class="text-xs font-medium text-slate-400 mb-0.5">Rata-rata Bulanan</p>
                    <p class="font-bold text-slate-900 text-lg" style="font-variant-numeric:tabular-nums;">
                        {{ count($monthlyWeighingData['data']) > 0 ? round(array_sum($monthlyWeighingData['data']) / count($monthlyWeighingData['data'])) : 0 }}
                        <span class="text-sm font-medium text-slate-400">Sesi</span>
                    </p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">trending_up</span>
                </div>
            </div>
        </div>
        <div x-data="{
            chart: null,
            init() {
                const wd = $wire.monthlyWeighingData;
                if (!wd || !wd.labels || !wd.data || wd.data.length === 0) return;
        
                const ctx = this.$refs.canvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 280);
                gradient.addColorStop(0, 'rgba(0, 108, 73, 0.18)');
                gradient.addColorStop(1, 'rgba(0, 108, 73, 0)');
        
                this.chart = new Chart(this.$refs.canvas, {
                    type: 'line',
                    data: {
                        labels: wd.labels,
                        datasets: [{
                            label: 'Penimbangan',
                            data: wd.data,
                            borderColor: '#006c49',
                            borderWidth: 2.5,
                            fill: true,
                            backgroundColor: gradient,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#006c49',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 1000, easing: 'easeOutQuart' },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                cornerRadius: 10,
                                padding: 12,
                                mode: 'index',
                                intersect: false,
                                backgroundColor: '#1e293b',
                                titleColor: '#94a3b8',
                                bodyColor: '#f1f5f9',
                                titleFont: { family: '\'Public Sans\', sans-serif', size: 11 },
                                bodyFont: { family: '\'Public Sans\', sans-serif', size: 13, weight: 'bold' },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) label += ': ';
                                        if (context.parsed.y !== null) label += context.parsed.y + ' Kunjungan';
                                        return label;
                                    },
                                    afterLabel: function(context) {
                                        const dataIndex = context.dataIndex;
                                        if (dataIndex > 0) {
                                            const current = context.parsed.y;
                                            const previous = context.dataset.data[dataIndex - 1];
                                            if (previous > 0) {
                                                const diff = current - previous;
                                                const percent = ((diff / previous) * 100).toFixed(1);
                                                if (diff > 0) return `▲ Naik ${percent}% dari bulan lalu`;
                                                if (diff < 0) return `▼ Turun ${Math.abs(percent)}% dari bulan lalu`;
                                                return `▶ Stabil (0%)`;
                                            } else if (current > 0) {
                                                return `▲ Naik 100% dari bulan lalu`;
                                            }
                                        }
                                        return '';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.04)', drawTicks: false },
                                border: { display: false },
                                ticks: {
                                    font: { family: '\'Public Sans\', sans-serif', size: 12 },
                                    color: '#94a3b8',
                                    padding: 8
                                }
                            },
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: {
                                    font: { family: '\'Public Sans\', sans-serif', size: 12 },
                                    color: '#94a3b8',
                                    padding: 6
                                }
                            }
                        }
                    }
                });
            }
        }" wire:ignore class="h-72 -mx-2">
            <canvas x-ref="canvas"></canvas>
        </div>
    </section>

</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', () => {
    let visitsChart = null;

    function initDashboardChart() {
        const ctx = document.getElementById('dashboardVisitsChart');
        if (!ctx) return;

        if (visitsChart) {
            visitsChart.destroy();
        }

        const data = @json($monthlyWeighingData);
        
        Chart.defaults.font.family = "'Public Sans', sans-serif";
        Chart.defaults.font.weight = '600';
        Chart.defaults.color = '#64748b';

        visitsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Total Kunjungan',
                    data: data.data,
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0d9488',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13, family: "'Public Sans', sans-serif" },
                        bodyFont: { size: 13, family: "'Public Sans', sans-serif" },
                        displayColors: false,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false,
                        },
                        ticks: {
                            precision: 0,
                            padding: 10
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            padding: 10
                        },
                        border: { display: false }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    }

    // Initialize on load
    initDashboardChart();

    // Re-initialize when Livewire updates the data
    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
        succeed(({ snapshot, effect }) => {
            if(component.name === 'admin.admin-dashboard') {
                setTimeout(() => {
                    initDashboardChart();
                }, 50);
            }
        });
    });
});
</script>
@endpush
