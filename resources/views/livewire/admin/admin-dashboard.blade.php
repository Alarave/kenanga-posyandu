<div>
    @section('admin-title') Dashboard @endsection

    {{-- Material Symbols CDN (for icons used in this design) --}}
    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .material-symbols-outlined { 
            font-variation-settings: 'FILL' 1, 'wght' 500;
            font-size: 24px;
        }
        /* Responsive utilities untuk ibu-ibu dan usia 50+ */
        .text-xxl { font-size: 1.375rem; line-height: 1.4; }
        .text-xl-base { font-size: 1.25rem; line-height: 1.5; }
        .text-lg-base { font-size: 1.125rem; line-height: 1.6; }
        
        @media (max-width: 768px) {
            .text-xxl { font-size: 1.25rem; }
            .text-xl-base { font-size: 1.125rem; }
            .text-lg-base { font-size: 1rem; }
            .btn-mobile { width: 100%; justify-content: center; }
            .card-mobile { padding: 1.25rem !important; }
            .stats-grid-mobile { grid-template-columns: 1fr 1fr !important; }
            .table-responsive-mobile { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }
    </style>
    @endpush

    @php
        $hour = now()->hour;
        $sapa = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
        $user = Auth::user();
        $posyanduName = $user->posyandu?->name ?? 'Posyandu';
    @endphp

    {{-- Hero Banner - More Compact --}}
    <section class="rounded-[2rem] p-6 md:p-8 text-white relative overflow-hidden shadow-xl shadow-teal-900/10 mb-8 card-mobile"
             style="background: radial-gradient(circle at top right, #00897b, #004d40);">
        {{-- Decorative elements --}}
        <div class="absolute right-0 top-0 w-80 h-80 bg-white/5 rounded-full blur-3xl -mr-24 -mt-24"></div>
        <div class="absolute left-0 bottom-0 w-48 h-48 bg-teal-400/10 rounded-full blur-3xl -ml-24 -mb-24"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="inline-flex items-center px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase">
                    {{ $posyanduName }}
                </div>
                <h2 class="font-black text-white text-3xl md:text-4xl leading-tight tracking-tighter">
                    {{ $sapa }}, <span class="text-teal-300">{{ explode(' ', $user->name)[0] }}</span>
                </h2>
                @if($user->posyandu?->pedukuhan)
                <p class="text-teal-50/70 font-medium text-base flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-300" style="font-size:20px;">location_on</span>
                    {{ $user->posyandu->pedukuhan->name }}
                </p>
                @endif
            </div>
            <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                @can('create', App\Models\Patient::class)
                <a href="{{ route('admin.patients.create') }}"
                   class="bg-white group text-teal-900 font-black px-6 py-4 rounded-2xl hover:bg-teal-50 transition-all shadow-lg shadow-teal-950/10 flex items-center justify-center gap-2 text-xs tracking-widest uppercase btn-mobile">
                    <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">person_add</span>
                    Tambah Warga
                </a>
                @endcan
                @can('create', App\Models\Patient::class)
                <a href="{{ route('admin.medical-records.create') }}"
                   class="bg-teal-700/30 backdrop-blur-md border border-white/30 text-white font-black px-6 py-4 rounded-2xl hover:bg-white/10 transition-all flex items-center justify-center gap-2 text-xs tracking-widest uppercase btn-mobile">
                    <span class="material-symbols-outlined text-[20px]">note_add</span>
                    Input Rekam Medis
                </a>
                @endcan
            </div>
        </div>
    </section>
    

    {{-- KPI Stats Grid - Lebih Besar dan Mudah Dibaca --}}
    <section class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-8 stats-grid-mobile">
        @php
        $stats = [
            [
                'label' => 'Balita',
                'value' => $totalBalita,
                'icon'  => 'child_care',
                'icon_bg' => '#dbeafe',
                'icon_color' => '#2563eb',
            ],
            [
                'label' => 'Ibu Hamil',
                'value' => $totalIbuHamil,
                'icon'  => 'pregnant_woman',
                'icon_bg' => '#fce7f3',
                'icon_color' => '#db2777',
            ],
            [
                'label' => 'Remaja',
                'value' => $totalRemaja,
                'icon'  => 'groups',
                'icon_bg' => '#e0e7ff',
                'icon_color' => '#4f46e5',
            ],
            [
                'label' => 'Lansia',
                'value' => $totalLansia,
                'icon'  => 'elderly',
                'icon_bg' => '#ffedd5',
                'icon_color' => '#ea580c',
            ],
            [
                'label' => 'Kunjungan',
                'value' => $kunjunganBaru,
                'icon'  => 'how_to_reg',
                'icon_bg' => '#d1fae5',
                'icon_color' => '#059669',
            ],
            [
                'label' => 'Jadwal Aktif',
                'value' => $jadwalAktif,
                'icon'  => 'event_available',
                'icon_bg' => '#f0fdf4',
                'icon_color' => '#16a34a',
            ],
        ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white rounded-2xl border-0 p-5 md:p-6 shadow-lg shadow-slate-200/40 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-500 group card-mobile relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 -mr-10 -mt-10 rounded-full transition-transform group-hover:scale-150 duration-700" 
                 style="background: {{ $s['icon_bg'] }}; opacity: 0.15;"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-inner"
                         style="background:{{ $s['icon_bg'] }}; color:{{ $s['icon_color'] }};">
                        <span class="material-symbols-outlined text-[24px]">{{ $s['icon'] }}</span>
                    </div>
                </div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">{{ $s['label'] }}</p>
                <h3 class="font-black text-slate-900 text-3xl md:text-4xl tracking-tighter leading-none">{{ $s['value'] }}</h3>
            </div>
        </div>
        @endforeach
    </section>

    {{-- Main Content: Table + Sidebar --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Activity Records Table (2/3) --}}
        <section class="lg:col-span-2 flex flex-col gap-6">
            {{-- Status Gizi Alert (Existing) --}}
            <div class="bg-white rounded-2xl border shadow-sm overflow-hidden flex flex-col card-mobile" style="border-color:#CBD5E1;">
                <div class="px-4 md:px-6 py-5 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3" style="border-color:#E2E8F0; background:#F8FAFC;">
                    <div>
                        <h3 class="font-black text-slate-900 flex items-center gap-2 text-xl md:text-2xl" style="letter-spacing:-0.02em;">
                            <span class="material-symbols-outlined text-amber-500" style="font-size:32px;">warning</span>
                            Status Gizi Perlu Perhatian
                        </h3>
                        <p class="text-slate-600 text-sm md:text-base font-bold mt-1" style="line-height:1.5;">Daftar balita dengan status Stunting atau Gizi Buruk</p>
                    </div>
                </div>

                <div class="overflow-x-auto flex-1 table-responsive-mobile">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-slate-50 text-xs md:text-sm font-black text-slate-600 uppercase tracking-wide">
                            <tr>
                                <th class="px-4 md:px-6 py-4 text-left whitespace-nowrap">Nama Lengkap</th>
                                <th class="px-4 md:px-6 py-4 text-left whitespace-nowrap">Usia</th>
                                <th class="px-4 md:px-6 py-4 text-left whitespace-nowrap">Status Gizi</th>
                                <th class="px-4 md:px-6 py-4 text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm md:text-base">
                            @forelse($balitaStunting as $balita)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 md:px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 md:w-8 md:h-8 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                                             style="background:#fee2e2; color:#dc2626;">
                                            {{ strtoupper(substr($balita->full_name, 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-gray-900">{{ $balita->full_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 md:px-6 py-4 text-gray-700 font-semibold">{{ $balita->age }}</td>
                                <td class="px-4 md:px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-bold"
                                          style="background:#fef2f2; color:#991b1b; border:2px solid #f87171;">
                                        <span class="material-symbols-outlined" style="font-size:18px;">priority_high</span>
                                        Stunting
                                    </span>
                                </td>
                                <td class="px-4 md:px-6 py-4 text-right">
                                    <a href="{{ route('admin.patients.show', $balita->id) }}"
                                       class="text-teal-700 hover:text-teal-900 font-bold text-sm md:text-base transition inline-flex items-center gap-1">
                                       Detail 
                                       <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 md:px-6 py-10 text-center">
                                    <p class="text-sm font-bold text-gray-500">Tidak ada data saat ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Ringkasan Aktivitas Terkini (NEW) --}}
            <div class="bg-white rounded-2xl border shadow-sm overflow-hidden flex flex-col card-mobile" style="border-color:#CBD5E1;">
                <div class="px-4 md:px-6 py-5 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3" style="border-color:#E2E8F0; background:#F8FAFC;">
                    <div>
                        <h3 class="font-black text-slate-900 flex items-center gap-2 text-xl md:text-2xl" style="letter-spacing:-0.02em;">
                            <span class="material-symbols-outlined text-teal-600" style="font-size:32px;">history</span>
                            Ringkasan Aktivitas Terkini
                        </h3>
                        <p class="text-slate-600 text-sm md:text-base font-bold mt-1" style="line-height:1.5;">Catatan rekam medis terbaru di sistem</p>
                    </div>
                </div>

                <div class="overflow-x-auto flex-1 table-responsive-mobile">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-slate-50 text-xs md:text-sm font-black text-slate-600 uppercase tracking-wide">
                            <tr>
                                <th class="px-4 md:px-6 py-4 text-left whitespace-nowrap">Warga</th>
                                <th class="px-4 md:px-6 py-4 text-left whitespace-nowrap">Tgl Kunjungan</th>
                                <th class="px-4 md:px-6 py-4 text-left whitespace-nowrap">Posyandu</th>
                                <th class="px-4 md:px-6 py-4 text-left whitespace-nowrap">Kader</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm md:text-base">
                            @forelse($recentActivities as $activity)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 md:px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900">{{ $activity->patient->full_name }}</span>
                                        <span class="text-xs text-slate-500 font-medium capitalize">{{ $activity->patient->category }}</span>
                                    </div>
                                </td>
                                <td class="px-4 md:px-6 py-4 text-gray-700 font-semibold">{{ $activity->visit_date->format('d/m/Y') }}</td>
                                <td class="px-4 md:px-6 py-4">
                                    <span class="px-2 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold">
                                        {{ $activity->patient->posyandu->name }}
                                    </span>
                                </td>
                                <td class="px-4 md:px-6 py-4 text-gray-600 font-medium">{{ $activity->user->name ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 md:px-6 py-14 text-center text-gray-500 font-bold">Belum ada aktivitas terekam.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Right Sidebar (1/3) - Lebih Besar dan Jelas --}}
        <aside class="flex flex-col gap-5">

            {{-- Upcoming Schedule Card --}}
            <div class="bg-white rounded-2xl border shadow-sm p-5 md:p-6 card-mobile" style="border-color:#CBD5E1;">
                <h3 class="font-black text-slate-900 mb-5 flex items-center gap-2 text-lg md:text-xl">
                    <span class="material-symbols-outlined text-teal-600 text-[28px]">calendar_month</span>
                    Jadwal Terdekat
                </h3>

                @if($upcomingSchedule)
                <div class="bg-gray-50 rounded-xl p-4 md:p-5 border-2 border-gray-200">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="rounded-xl p-3 md:p-4 text-center min-w-[60px] md:min-w-[54px] flex-shrink-0 text-white"
                             style="background: linear-gradient(135deg,#006a61,#00897b);">
                            <div class="text-xs md:text-sm font-bold uppercase opacity-90 leading-none mb-1">
                                {{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->translatedFormat('M') }}
                            </div>
                            <div class="text-3xl md:text-2xl font-black leading-none">
                                {{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->format('d') }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-900 text-base md:text-sm leading-tight mb-2">{{ $upcomingSchedule->title }}</h4>
                            <p class="text-sm md:text-xs text-gray-600 flex items-center gap-1.5" style="line-height:1.5;">
                                <span class="material-symbols-outlined" style="font-size:18px;">schedule</span>
                                {{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->format('H:i') }}
                                – {{ \Carbon\Carbon::parse($upcomingSchedule->end_time)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    @if($upcomingSchedule->location)
                    <p class="text-sm md:text-xs text-gray-600 flex items-start gap-2 mt-3 pt-3 border-t-2 border-gray-200" style="line-height:1.5;">
                        <span class="material-symbols-outlined text-gray-500 flex-shrink-0" style="font-size:18px; margin-top:1px;">location_on</span>
                        {{ $upcomingSchedule->location }}
                    </p>
                    @endif
                    <a href="{{ route('admin.schedules.index') }}"
                       class="mt-4 w-full flex items-center justify-center gap-2 py-3.5 md:py-2.5 rounded-xl border-2 font-bold text-sm md:text-base transition"
                       style="border-color:#00685f; color:#00685f;"
                       onmouseenter="this.style.background='#f0fdf4';"
                       onmouseleave="this.style.background='transparent';">
                        <span class="material-symbols-outlined" style="font-size:20px;">event</span>
                        Lihat Semua Jadwal
                    </a>
                </div>
                @else
                <div class="text-center py-10 text-gray-400">
                    <span class="material-symbols-outlined block mb-3" style="font-size:44px;">event_busy</span>
                    <p class="text-sm md:text-xs font-bold text-gray-500">Belum ada jadwal mendatang</p>
                    <a href="{{ route('admin.schedules.create') }}"
                       class="mt-3 inline-block text-teal-700 hover:text-teal-900 text-sm md:text-xs font-bold">+ Buat Jadwal</a>
                </div>
                @endif
            </div>

            {{-- Grafik Donat --}}
            <div class="bg-white rounded-2xl border shadow-sm p-5 md:p-6 flex-1 card-mobile" style="border-color:#CBD5E1;">
                <h3 class="font-bold text-gray-900 mb-1 text-lg md:text-base">Distribusi Status Gizi</h3>
                <p class="text-sm md:text-xs text-gray-500 mb-4" style="line-height:1.5;">Rekam medis terkini per balita</p>
                <div class="relative w-full" style="height:200px;">
                    <canvas id="nutritionStatusChart"></canvas>
                </div>
            </div>
            {{-- Breakdown per Unit (khusus SuperAdmin) --}}
            @if(auth()->user()->isSuperAdmin())
            <div class="bg-white rounded-2xl border shadow-sm p-5 md:p-6 card-mobile" style="border-color:#CBD5E1;">
                <h3 class="font-black text-slate-900 mb-4 flex items-center gap-2 text-lg md:text-xl">
                    <span class="material-symbols-outlined text-indigo-600 text-[28px]">domain</span>
                    Sasaran per Unit
                </h3>
                <div class="space-y-3">
                    @foreach($posyanduStats as $pStat)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <div>
                            <p class="font-bold text-slate-800 text-sm md:text-base">{{ $pStat->name }}</p>
                            <p class="text-xs text-slate-500 font-medium">{{ $pStat->pedukuhan->name ?? 'Wilayah Luar' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-black text-slate-900">{{ $pStat->patients_count }}</span>
                            <p class="text-[10px] uppercase font-black text-slate-400 tracking-tighter">Warga</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>
    </div>

    {{-- Chart Tren Penimbangan - Lebih Besar --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 md:p-6 mb-8 overflow-hidden card-mobile">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-black text-slate-900 text-lg md:text-base">Tren Penimbangan Bulanan</h3>
                <p class="text-sm md:text-xs text-slate-500 font-bold mt-1" style="line-height:1.5;">Jumlah kunjungan rekam medis dalam 12 bulan terakhir</p>
            </div>
        </div>
        <div class="w-full overflow-x-auto">
            <div class="min-w-[600px] h-[280px] md:h-[260px] relative">
                <canvas id="monthlyWeighingChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Quick Actions - Tombol Lebih Besar untuk Ibu-Ibu --}}
    <div class="bg-white rounded-2xl border shadow-sm p-5 md:p-6 card-mobile" style="border-color:#CBD5E1;">
        <h3 class="font-bold text-gray-900 mb-1 text-lg md:text-base">Akses Cepat</h3>
        <p class="text-sm md:text-xs text-gray-500 mb-5" style="line-height:1.5;">Pintasan ke halaman utama</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @php
            $shortcuts = [
                ['href' => route('admin.patients.index'),        'icon' => 'groups',         'label' => 'Data Warga',        'sub' => 'Lihat semua sasaran', 'bg'=>'#dbeafe','color'=>'#1d4ed8'],
                ['href' => route('admin.schedules.index'),       'icon' => 'calendar_month',  'label' => 'Jadwal Kegiatan',   'sub' => 'Lihat jadwal aktif',  'bg'=>'#d1fae5','color'=>'#065f46'],
                ['href' => route('admin.medical-records.index'), 'icon' => 'clinical_notes',  'label' => 'Rekam Medis',       'sub' => 'Buku KMS & pemeriksaan','bg'=>'#ede9fe','color'=>'#6d28d9'],
                ['href' => route('admin.articles.index'),        'icon' => 'newspaper',       'label' => 'Artikel & Edukasi', 'sub' => 'Kelola konten info',  'bg'=>'#fce7f3','color'=>'#be185d'],
            ];
            @endphp
            @foreach($shortcuts as $s)
            <a href="{{ $s['href'] }}"
               class="flex items-center gap-3 md:gap-4 p-4 md:p-5 rounded-xl border-2 border-transparent transition-all group hover:border-gray-200 hover:shadow-md"
               onmouseenter="this.style.background='#F8FAFC';"
               onmouseleave="this.style.background='transparent';">
                <div class="w-12 h-12 md:w-10 md:h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:{{ $s['bg'] }}; color:{{ $s['color'] }};">
                    <span class="material-symbols-outlined" style="font-size:24px;">{{ $s['icon'] }}</span>
                </div>
                <div class="min-w-0">
                    <p class="font-bold text-gray-900 text-base md:text-sm truncate">{{ $s['label'] }}</p>
                    <p class="text-gray-500 text-sm md:text-xs truncate mt-1" style="line-height:1.4;">{{ $s['sub'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Donut Chart - Status Gizi
        const nutritionCtx = document.getElementById('nutritionStatusChart');
        if (nutritionCtx) {
            const nd = @json($nutritionStatusDistribution);
            const cMap = {
                'Normal':'#10b981','Gizi Kurang':'#f59e0b',
                'Gizi Lebih':'#f97316','Gizi Buruk/Stunting':'#ef4444',
                'Tidak Dapat Dihitung':'#94a3b8'
            };
            new Chart(nutritionCtx, {
                type: 'doughnut',
                data: {
                    labels: nd.labels,
                    datasets: [{ data: nd.data, backgroundColor: nd.labels.map(l=>cMap[l]||'#94a3b8'), borderWidth: 2, borderColor:'#fff' }]
                },
                options: {
                    responsive:true, maintainAspectRatio:false, cutout:'72%',
                    plugins: {
                        legend: { position:'bottom', labels:{ padding:12, usePointStyle:true, pointStyle:'circle', font:{size:10} } },
                        tooltip: { callbacks: { label: c => {
                            const t = c.dataset.data.reduce((a,b)=>a+b,0);
                            return `${c.label}: ${c.parsed} (${t>0?((c.parsed/t)*100).toFixed(1):0}%)`;
                        }}}
                    }
                }
            });
        }

        // Line Chart - Tren Penimbangan
        const weighCtx = document.getElementById('monthlyWeighingChart');
        if (weighCtx) {
            const wd = @json($monthlyWeighingData);
            const g = weighCtx.getContext('2d').createLinearGradient(0,0,0,220);
            g.addColorStop(0,'rgba(0,106,97,0.2)');
            g.addColorStop(1,'rgba(0,106,97,0)');
            new Chart(weighCtx, {
                type:'line',
                data: {
                    labels: wd.labels,
                    datasets: [{
                        label:'Penimbangan',
                        data: wd.data,
                        borderColor:'#00685f', backgroundColor:g,
                        borderWidth:3, fill:true, tension:0.4,
                        pointRadius:4, pointHoverRadius:6,
                        pointBackgroundColor:'#fff', pointBorderColor:'#00685f', pointBorderWidth:2
                    }]
                },
                options: {
                    responsive:true, maintainAspectRatio:false,
                    plugins: {
                        legend:{display:false},
                        tooltip:{ mode:'index', intersect:false, backgroundColor:'#1e293b', padding:10, cornerRadius:8, displayColors:false }
                    },
                    scales: {
                        y:{ beginAtZero:true, grid:{color:'#f1f5f9'}, border:{display:false} },
                        x:{ grid:{display:false}, border:{display:false} }
                    },
                    interaction:{ mode:'nearest', axis:'x', intersect:false }
                }
            });
        }
    });
    </script>
    @endpush
</div>
