<div>
    @section('admin-title') Dashboard @endsection

    {{-- Material Symbols CDN (for icons used in this design) --}}
    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400; }
        .material-icons-filled { font-variation-settings: 'FILL' 1, 'wght' 500; }
    </style>
    @endpush

    @php
        $hour = now()->hour;
        $sapa = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
        $user = Auth::user();
        $posyanduName = $user->posyandu?->name ?? 'Posyandu';
    @endphp

    {{-- Hero Banner --}}
    <section class="rounded-2xl p-8 text-white relative overflow-hidden shadow-sm mb-8"
             style="background: linear-gradient(135deg, #006a61 0%, #00897b 60%, #00b0a0 100%);">
        {{-- Decorative circle --}}
        <div class="absolute right-0 top-0 w-72 h-72 rounded-full opacity-20"
             style="background: rgba(255,255,255,0.3); transform: translate(40%, -30%);"></div>
        <div class="absolute right-16 bottom-0 w-40 h-40 rounded-full opacity-10"
             style="background: rgba(255,255,255,0.5); transform: translateY(50%);"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="font-bold text-white mb-1" style="font-size:28px; letter-spacing:-0.01em;">
                    {{ $sapa }}, {{ explode(' ', $user->name)[0] }} 👋
                </h2>
                <p class="text-green-100 font-medium" style="font-size:15px;">
                    <span class="material-symbols-outlined align-middle" style="font-size:16px; vertical-align:-3px;">location_on</span>
                    {{ $posyanduName }}
                    @if($user->posyandu?->pedukuhan)
                        · {{ $user->posyandu->pedukuhan->name }}
                    @endif
                </p>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                @can('create', App\Models\Patient::class)
                <a href="{{ route('admin.patients.create') }}"
                   class="bg-white font-semibold px-5 py-2.5 rounded-xl hover:bg-green-50 transition-colors shadow-sm flex items-center gap-2 text-sm"
                   style="color:#00685f;">
                    <span class="material-symbols-outlined" style="font-size:18px;">person_add</span>
                    Tambah Warga
                </a>
                @endcan
                @can('create', App\Models\Patient::class)
                <a href="{{ route('admin.medical-records.create') }}"
                   class="border border-white/40 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-white/10 transition-colors shadow-sm flex items-center gap-2 text-sm">
                    <span class="material-symbols-outlined" style="font-size:18px;">note_add</span>
                    Input Rekam Medis
                </a>
                @endcan
            </div>
        </div>
    </section>

    {{-- KPI Stats Grid --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @php
        $stats = [
            [
                'label' => 'Total Balita',
                'value' => $totalBalita,
                'icon'  => 'child_care',
                'badge' => 'Terdata',
                'badge_class' => 'bg-blue-50 text-blue-600',
                'icon_bg' => '#dbeafe',
                'icon_color' => '#2563eb',
            ],
            [
                'label' => 'Total Ibu Hamil',
                'value' => $totalIbuHamil,
                'icon'  => 'pregnant_woman',
                'badge' => 'Terdata',
                'badge_class' => 'bg-pink-50 text-pink-600',
                'icon_bg' => '#fce7f3',
                'icon_color' => '#db2777',
            ],
            [
                'label' => 'Kunjungan Bulan Ini',
                'value' => $kunjunganBaru,
                'icon'  => 'how_to_reg',
                'badge' => 'Bulan Ini',
                'badge_class' => 'bg-teal-50 text-teal-600',
                'icon_bg' => '#d1fae5',
                'icon_color' => '#059669',
            ],
            [
                'label' => 'Jadwal Aktif',
                'value' => $jadwalAktif,
                'icon'  => 'event_available',
                'badge' => 'Aktif',
                'badge_class' => 'bg-green-100 text-green-700',
                'icon_bg' => '#f0fdf4',
                'icon_color' => '#16a34a',
            ],
        ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white rounded-2xl border p-6 shadow-sm hover:shadow-md transition-shadow"
             style="border-color:#CBD5E1;">
            <div class="flex items-start justify-between mb-5">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                     style="background:{{ $s['icon_bg'] }}; color:{{ $s['icon_color'] }};">
                    <span class="material-symbols-outlined" style="font-size:22px; font-variation-settings:'FILL' 1;">{{ $s['icon'] }}</span>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $s['badge_class'] }}">
                    {{ $s['badge'] }}
                </span>
            </div>
            <p class="text-slate-500 text-sm font-black uppercase tracking-[0.1em] mb-2">{{ $s['label'] }}</p>
            <h3 class="font-black text-slate-900" style="font-size:42px; line-height:1; letter-spacing:-0.03em;">{{ $s['value'] }}</h3>
        </div>
        @endforeach
    </section>

    {{-- Main Content: Table + Sidebar --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Nutrition Alert Table (2/3) --}}
        <section class="lg:col-span-2 bg-white rounded-2xl border shadow-sm overflow-hidden flex flex-col" style="border-color:#CBD5E1;">
            <div class="px-6 py-5 border-b flex justify-between items-center" style="border-color:#E2E8F0; background:#F8FAFC;">
                <div>
                    <h3 class="font-black text-slate-900 flex items-center gap-2" style="font-size:22px; letter-spacing:-0.02em;">
                        <span class="material-symbols-outlined text-amber-500" style="font-size:28px; font-variation-settings:'FILL' 1;">warning</span>
                        Status Gizi Perlu Perhatian
                    </h3>
                    <p class="text-slate-500 text-sm font-bold mt-1">Daftar balita dengan status Stunting atau Gizi Buruk</p>
                </div>
                <a href="{{ route('admin.patients.index', ['category' => 'balita']) }}"
                   class="text-teal-600 hover:text-teal-800 text-sm font-semibold transition">Lihat Semua →</a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-slate-50 text-[11px] font-black text-slate-500 uppercase tracking-[0.15em]">
                        <tr>
                            <th class="px-6 py-4 text-left">Nama Lengkap</th>
                            <th class="px-6 py-4 text-left">Usia</th>
                            <th class="px-6 py-4 text-left">Status Gizi</th>
                            <th class="px-6 py-4 text-left">Terakhir Periksa</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($balitaStunting as $balita)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                         style="background:#fee2e2; color:#dc2626;">
                                        {{ strtoupper(substr($balita->full_name, 0, 2)) }}
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $balita->full_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-medium">{{ $balita->age }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                      style="background:#fef2f2; color:#991b1b; border:1px solid #f87171;">
                                    <span class="material-symbols-outlined" style="font-size:14px; font-variation-settings:'FILL' 1;">priority_high</span>
                                    Stunting
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $balita->medicalRecords->first()?->visit_date?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.patients.show', $balita->id) }}"
                                   class="text-teal-600 hover:text-teal-800 font-semibold text-xs transition">Detail →</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <span class="material-symbols-outlined text-green-400 block mb-2" style="font-size:40px; font-variation-settings:'FILL' 1;">check_circle</span>
                                <p class="text-sm font-semibold text-gray-500">Bagus! Tidak ada balita dengan status Stunting saat ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Right Sidebar (1/3) --}}
        <aside class="flex flex-col gap-5">

            {{-- Upcoming Schedule Card --}}
            <div class="bg-white rounded-2xl border shadow-sm p-6" style="border-color:#CBD5E1;">
                <h3 class="font-black text-slate-900 mb-6 flex items-center gap-2" style="font-size:20px;">
                    <span class="material-symbols-outlined text-teal-600 text-[24px]">calendar_month</span>
                    Jadwal Terdekat
                </h3>

                @if($upcomingSchedule)
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="rounded-xl p-3 text-center min-w-[54px] flex-shrink-0 text-white"
                             style="background: linear-gradient(135deg,#006a61,#00897b);">
                            <div class="text-xs font-bold uppercase opacity-80 leading-none mb-1">
                                {{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->translatedFormat('M') }}
                            </div>
                            <div class="text-2xl font-black leading-none">
                                {{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->format('d') }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-900 text-sm leading-tight mb-1">{{ $upcomingSchedule->title }}</h4>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <span class="material-symbols-outlined" style="font-size:14px;">schedule</span>
                                {{ \Carbon\Carbon::parse($upcomingSchedule->start_time)->format('H:i') }}
                                – {{ \Carbon\Carbon::parse($upcomingSchedule->end_time)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    @if($upcomingSchedule->location)
                    <p class="text-xs text-gray-500 flex items-start gap-1.5 mt-2 pt-3 border-t border-gray-200">
                        <span class="material-symbols-outlined text-gray-400 flex-shrink-0" style="font-size:14px; margin-top:1px;">location_on</span>
                        {{ $upcomingSchedule->location }}
                    </p>
                    @endif
                    <a href="{{ route('admin.schedules.index') }}"
                       class="mt-4 w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border font-semibold text-sm transition"
                       style="border-color:#00685f; color:#00685f;"
                       onmouseenter="this.style.background='#f0fdf4';"
                       onmouseleave="this.style.background='transparent';">
                        <span class="material-symbols-outlined" style="font-size:16px;">event</span>
                        Lihat Semua Jadwal
                    </a>
                </div>
                @else
                <div class="text-center py-8 text-gray-400">
                    <span class="material-symbols-outlined block mb-2" style="font-size:36px;">event_busy</span>
                    <p class="text-xs font-medium">Belum ada jadwal mendatang</p>
                    <a href="{{ route('admin.schedules.create') }}"
                       class="mt-2 inline-block text-teal-600 hover:text-teal-800 text-xs font-semibold">+ Buat Jadwal</a>
                </div>
                @endif
            </div>

            {{-- Grafik Donat --}}
            <div class="bg-white rounded-2xl border shadow-sm p-6 flex-1" style="border-color:#CBD5E1;">
                <h3 class="font-bold text-gray-900 mb-1" style="font-size:16px;">Distribusi Status Gizi</h3>
                <p class="text-xs text-gray-400 mb-4">Rekam medis terkini per balita</p>
                <div class="relative w-full" style="height:180px;">
                    <canvas id="nutritionStatusChart"></canvas>
                </div>
            </div>
        </aside>
    </div>

    {{-- Chart Tren Penimbangan --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-8 overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-black text-slate-900" style="font-size:16px;">Tren Penimbangan Bulanan</h3>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Jumlah kunjungan rekam medis dalam 12 bulan terakhir</p>
            </div>
        </div>
        <div class="w-full overflow-x-auto">
            <div class="min-w-[600px] h-[260px] relative">
                <canvas id="monthlyWeighingChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6" style="border-color:#CBD5E1;">
        <h3 class="font-bold text-gray-900 mb-1" style="font-size:16px;">Akses Cepat</h3>
        <p class="text-xs text-gray-400 mb-5">Pintasan ke halaman utama</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
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
               class="flex items-center gap-3 p-4 rounded-xl border border-transparent transition-all group hover:border-gray-200 hover:shadow-sm"
               onmouseenter="this.style.background='#F8FAFC';"
               onmouseleave="this.style.background='transparent';">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:{{ $s['bg'] }}; color:{{ $s['color'] }};">
                    <span class="material-symbols-outlined" style="font-size:18px; font-variation-settings:'FILL' 1;">{{ $s['icon'] }}</span>
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $s['label'] }}</p>
                    <p class="text-gray-400 text-xs truncate mt-0.5">{{ $s['sub'] }}</p>
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
