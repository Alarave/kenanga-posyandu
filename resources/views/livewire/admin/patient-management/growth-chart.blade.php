<div wire:key="growth-chart-root" class="w-full space-y-12">
    
    @php
        $isMale = strtoupper($patient->gender) === 'L' || strtoupper($patient->gender) === 'M';
        $themeColor = $isMale ? 'bg-sky-600' : 'bg-pink-600';
    @endphp

    {{-- ── Section 1: Riwayat Pemeriksaan (Top Section) ── --}}
    <div class="bg-white rounded-[3rem] p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined text-[24px]">history</span>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-[0.2em]">Riwayat Pemeriksaan</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Data Antropometri Berkala</p>
                </div>
            </div>
            <a href="#" class="px-6 py-2.5 bg-slate-50 hover:bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase tracking-widest transition-all">Lihat Selengkapnya →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-50">
                        <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest pl-4">Tanggal Kunjungan</th>
                        <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Berat Badan</th>
                        <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tinggi Badan</th>
                        <th class="pb-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest pr-4">Status Gizi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($patient->medicalRecords()->latest()->limit(5)->get() as $record)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="py-6 pl-4">
                            <p class="text-[12px] font-black text-slate-700 mb-0.5">{{ \Carbon\Carbon::parse($record->visit_date)->translatedFormat('d F Y') }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Pemeriksaan Rutin</p>
                        </td>
                        <td class="py-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-lg font-black text-slate-900">{{ $record->weight }}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase">kg</span>
                            </div>
                        </td>
                        <td class="py-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-lg font-black text-slate-900">{{ $record->height }}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase">cm</span>
                            </div>
                        </td>
                        <td class="py-6 text-right pr-4">
                            <span @class([
                                'px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest inline-block shadow-sm',
                                'bg-emerald-50 text-emerald-600 border border-emerald-100' => str_contains($record->nutrition_status ?? '', 'Normal') || str_contains($record->nutrition_status ?? '', 'Baik'),
                                'bg-amber-50 text-amber-600 border border-amber-100' => str_contains($record->nutrition_status ?? '', 'Kurang'),
                                'bg-red-50 text-red-600 border border-red-100' => str_contains($record->nutrition_status ?? '', 'Buruk'),
                                'bg-slate-50 text-slate-400 border border-slate-100' => !$record->nutrition_status,
                            ])>
                                {{ $record->nutrition_status ?: 'Data N/A' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-12 text-center text-[11px] text-slate-400 font-bold uppercase tracking-[0.3em]">Belum ada data pemeriksaan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Section 2: Quick Stats Row ── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex items-center gap-6 group">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[32px]">vaccines</span>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Capaian Imunisasi</p>
                <p class="text-2xl font-black text-slate-800">8 <span class="text-sm text-slate-400">/ 12</span></p>
            </div>
        </div>

        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl group">
            <div class="absolute -right-16 -bottom-16 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div class="space-y-4">
                    <div class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/10 w-fit">
                        <span class="text-[9px] font-black uppercase tracking-[0.2em] text-teal-400">Digital Pass</span>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Terakhir Diperiksa</p>
                        <p class="text-sm font-black italic text-slate-200">
                            {{ $patient->medicalRecords()->latest()->first()?->visit_date ? \Carbon\Carbon::parse($patient->medicalRecords()->latest()->first()->visit_date)->translatedFormat('d F Y') : 'N/A' }}
                        </p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-teal-400 text-[40px] opacity-40">qr_code_2</span>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-orange-100 rounded-[2.5rem] p-8 relative overflow-hidden group shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-white text-orange-500 flex items-center justify-center shadow-md shrink-0">
                <span class="material-symbols-outlined text-[32px]">lightbulb</span>
            </div>
            <p class="text-[12px] text-orange-900 leading-relaxed font-bold italic relative z-10">"Pemberian MP-ASI bergizi setelah 6 bulan krusial."</p>
        </div>
    </div>

    {{-- ── Section 3: Grafik Pertumbuhan (Bottom Section) ── --}}
    <div class="bg-white rounded-[3rem] p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 overflow-hidden relative group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-teal-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-10 relative z-10">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-2 h-8 bg-gradient-to-b from-teal-500 to-emerald-600 rounded-full"></div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight uppercase">Grafik Analisis Pertumbuhan WHO</h3>
                </div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.3em] ml-5">Visualisasi Tren Antropometri Anak</p>
            </div>
            
            <div class="flex items-center p-1.5 bg-slate-50/50 backdrop-blur-md rounded-[2rem] border border-slate-100 shadow-inner">
                <button wire:click="switchChart('wfa')" 
                    @class([
                        'flex items-center gap-3 px-8 py-3 text-[11px] font-black uppercase tracking-widest rounded-full transition-all duration-500',
                        'bg-white shadow-[0_4px_15px_rgba(0,0,0,0.05)] text-teal-600 ring-1 ring-slate-100 scale-100' => $activeChart === 'wfa',
                        'text-slate-400 hover:text-slate-600 hover:bg-white/40 scale-95 opacity-70' => $activeChart !== 'wfa'
                    ])>
                    <span @class([
                        'w-8 h-8 rounded-xl flex items-center justify-center transition-colors',
                        'bg-teal-50 text-teal-600' => $activeChart === 'wfa',
                        'bg-slate-100 text-slate-400' => $activeChart !== 'wfa'
                    ])>
                        <span class="material-symbols-outlined text-[20px]">monitor_weight</span>
                    </span>
                    BB/U
                </button>
                <button wire:click="switchChart('hfa')" 
                    @class([
                        'flex items-center gap-3 px-8 py-3 text-[11px] font-black uppercase tracking-widest rounded-full transition-all duration-500',
                        'bg-white shadow-[0_4px_15px_rgba(0,0,0,0.05)] text-teal-600 ring-1 ring-slate-100 scale-100' => $activeChart === 'hfa',
                        'text-slate-400 hover:text-slate-600 hover:bg-white/40 scale-95 opacity-70' => $activeChart !== 'hfa'
                    ])>
                    <span @class([
                        'w-8 h-8 rounded-xl flex items-center justify-center transition-colors',
                        'bg-teal-50 text-teal-600' => $activeChart === 'hfa',
                        'bg-slate-100 text-slate-400' => $activeChart !== 'hfa'
                    ])>
                        <span class="material-symbols-outlined text-[20px]">straighten</span>
                    </span>
                    TB/U
                </button>
            </div>
        </div>

        <script>var initialGrowthData = @json($chartData);</script>
        <div class="relative rounded-[3rem] p-10 shadow-2xl transition-all duration-700 overflow-hidden" 
             style="height: 900px; background: {{ $isMale ? 'radial-gradient(circle at 0% 0%, #0f172a 0%, #1e3a8a 100%)' : 'radial-gradient(circle at 0% 0%, #4c0519 0%, #831843 100%)' }};"
             x-data="{ 
                chart: null,
                hasData: true,
                initChart(chartData) {
                    const ctx = document.getElementById('growthChartBottom');
                    if (!ctx || !window.Chart) return;
                    if (this.chart) this.chart.destroy();
                    
                    const data = chartData || null;
                    if (!data || !data.datasets || data.datasets.length === 0) {
                        this.hasData = false;
                        return;
                    }

                    this.hasData = true;
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: { duration: 2000, easing: 'easeOutQuart' },
                            interaction: { intersect: false, mode: 'index' },
                            scales: {
                                x: { 
                                    grid: { color: 'rgba(255,255,255,0.1)', drawBorder: false }, 
                                    ticks: { color: '#ffffff', font: { size: 11, weight: '800' } },
                                    title: { display: true, text: 'UMUR (BULAN)', color: '#ffffff', font: { weight: '900', size: 12, family: 'Inter' } }
                                },
                                y: { 
                                    grid: { color: 'rgba(255,255,255,0.1)', drawBorder: false }, 
                                    ticks: { color: '#ffffff', font: { size: 11, weight: '800' } },
                                    suggestedMin: data.datasets.some(d => d.label.includes('Tinggi')) ? 40 : 0,
                                    title: { display: true, text: data.datasets.some(d => d.label.includes('Tinggi')) ? 'TINGGI (CM)' : 'BERAT (KG)', color: '#ffffff', font: { weight: '900', size: 12, family: 'Inter' } }
                                }
                            },
                            plugins: {
                                legend: { position: 'bottom', labels: { boxWidth: 12, boxHeight: 12, usePointStyle: true, pointStyle: 'circle', color: '#ffffff', padding: 40, font: { weight: '800', size: 11 } } },
                                tooltip: { backgroundColor: 'rgba(15, 23, 42, 1)', padding: 20, cornerRadius: 20, usePointStyle: true, titleFont: { size: 16, weight: '900' }, bodyFont: { size: 14, weight: '700' } }
                            }
                        }
                    });
                }
             }"
             x-init="
                setTimeout(() => { if (typeof initialGrowthData !== 'undefined') initChart(initialGrowthData); }, 300);
                $wire.on('chart-updated', (data) => {
                    const rawData = Array.isArray(data) ? data[0] : data;
                    initChart(rawData);
                });
             "
        >
            <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(at 0% 0%, hsla(161, 84%, 39%, 0.5) 0px, transparent 50%), radial-gradient(at 100% 0%, hsla(188, 86%, 53%, 0.5) 0px, transparent 50%);"></div>
            <div class="relative w-full h-full z-10" wire:ignore>
                <canvas id="growthChartBottom" x-show="hasData"></canvas>
            </div>
            
            <div x-show="!hasData" class="absolute inset-0 flex flex-col items-center justify-center p-12 text-center z-20">
                <div class="w-24 h-24 rounded-[2.5rem] bg-white/10 backdrop-blur-md flex items-center justify-center text-white/30 mb-8 border border-white/10">
                    <span class="material-symbols-outlined text-[48px]">query_stats</span>
                </div>
                <h4 class="text-xl font-black text-white tracking-tight">Belum Ada Data Pengukuran</h4>
                <p class="text-xs text-white/50 font-bold max-w-[300px] mt-3 leading-relaxed">Grafik pertumbuhan akan tersedia setelah data antropometri ditambahkan.</p>
            </div>

            <div wire:loading wire:target="switchChart" class="absolute inset-0 bg-slate-900/60 backdrop-blur-xl flex items-center justify-center z-30 rounded-[3rem]">
                <div class="flex flex-col items-center gap-5">
                    <div class="w-16 h-16 border-4 border-teal-400 border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-[11px] font-black text-white uppercase tracking-[0.4em]">Sinkronisasi Analisis...</p>
                </div>
            </div>
        </div>
    </div>
</div>
