@extends('layouts.admin-layout')

@section('admin-title') Buku KIA Digital: {{ $patient->full_name }} @endsection

@section('admin-actions')
    <x-button href="{{ route('admin.patients.index') }}" variant="outline" icon="arrow_back">
        Kembali
    </x-button>
@endsection

@section('admin-content')
<div wire:key="growth-chart-root" class="space-y-6">
    
    {{-- ── Patient Profile Header Card ── --}}
    <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 w-64 h-64 bg-teal-50 rounded-full -mr-20 -mt-20 transition-transform group-hover:scale-110 duration-700 opacity-50"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="w-32 h-32 rounded-[2rem] bg-teal-100 flex items-center justify-center text-teal-600 shadow-inner border-4 border-white">
                <span class="material-symbols-outlined text-[64px]">child_care</span>
            </div>
            
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">{{ $patient->full_name }}</h2>
                    <span class="px-4 py-1 rounded-full bg-teal-500 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-teal-500/20">
                        {{ str_replace('_', ' ', $patient->category) }}
                    </span>
                </div>
                <div class="flex flex-wrap justify-center md:justify-start gap-6 text-slate-500 text-sm font-bold">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-teal-500">fingerprint</span>
                        NIK: {{ $patient->id_number }}
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-teal-500">cake</span>
                        {{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') }}
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-teal-500">location_on</span>
                        {{ $patient->posyandu->name ?? 'Unit Belum Terdaftar' }}
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 text-center min-w-[160px]">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Gizi</p>
                <p class="text-xl font-black text-emerald-600 leading-none">Normal</p>
                <div class="w-full bg-emerald-100 h-1.5 rounded-full mt-3 overflow-hidden">
                    <div class="bg-emerald-500 h-full w-[85%] rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Main Content Tabs ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- Left: Tab Content (Charts) --}}
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-200 rounded-[2.5rem] p-6 md:p-8 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                    <div>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight">Grafik Antropometri WHO</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pantau tumbuh kembang setiap bulan</p>
                    </div>
                    
                    <div class="flex bg-slate-100 p-1.5 rounded-2xl w-full sm:w-auto shadow-inner" x-data="{ active: '{{ $activeChart }}' }">
                        <button 
                            type="button"
                            x-on:click="active = 'wfa'; $wire.switchChart('wfa')" 
                            :class="active === 'wfa' ? 'bg-white shadow-md text-teal-600' : 'text-slate-500 hover:bg-white/50'"
                            class="flex-1 px-5 py-2 text-[10px] font-black uppercase tracking-[0.15em] rounded-xl transition-all duration-300"
                        >
                            BB / U
                        </button>
                        <button 
                            type="button"
                            x-on:click="active = 'hfa'; $wire.switchChart('hfa')" 
                            :class="active === 'hfa' ? 'bg-white shadow-md text-teal-600' : 'text-slate-500 hover:bg-white/50'"
                            class="flex-1 px-5 py-2 text-[10px] font-black uppercase tracking-[0.15em] rounded-xl transition-all duration-300"
                        >
                            TB / U
                        </button>
                    </div>
                </div>

                <div class="relative" style="height: 400px;">
                    <canvas id="growthChart" wire:ignore></canvas>
                    <div wire:loading class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-10 rounded-3xl transition-all">
                        <div class="animate-spin rounded-full h-12 w-12 border-4 border-teal-500 border-t-transparent"></div>
                    </div>
                </div>
            </div>

            {{-- History Mini-Table --}}
            <div class="bg-white border border-slate-200 rounded-[2.5rem] p-6 md:p-8 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-slate-800 tracking-tight">Riwayat Pemeriksaan Terakhir</h3>
                    <a href="#" class="text-[10px] font-black text-teal-600 uppercase tracking-widest hover:underline">Lihat Semua →</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-50">
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Kunjungan</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Berat</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tinggi</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">LILA</th>
                                <th class="pb-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($patient->medicalRecords()->latest()->limit(5)->get() as $record)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 text-sm font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($record->visit_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="py-4 text-sm font-black text-slate-900">{{ $record->weight }} kg</td>
                                <td class="py-4 text-sm font-black text-slate-900">{{ $record->height }} cm</td>
                                <td class="py-4 text-sm font-bold text-slate-500">{{ $record->lila ?? '-' }} cm</td>
                                <td class="py-4 text-right">
                                    <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-wider">Sehat</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Sidebar Stats & Info --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Summary Bento --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="p-6 bg-teal-50 rounded-[2rem] border border-teal-100 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-shadow">
                    <span class="material-symbols-outlined text-teal-600 mb-2">cake</span>
                    <p class="text-[9px] font-black text-teal-600/60 uppercase tracking-widest">Usia</p>
                    <p class="text-xl font-black text-teal-900">{{ $patient->age_in_months }} Bln</p>
                </div>
                <div class="p-6 bg-blue-50 rounded-[2rem] border border-blue-100 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-shadow">
                    <span class="material-symbols-outlined text-blue-600 mb-2">vaccines</span>
                    <p class="text-[9px] font-black text-blue-600/60 uppercase tracking-widest">Imunisasi</p>
                    <p class="text-xl font-black text-blue-900">8/12</p>
                </div>
            </div>

            {{-- Health Pass Card --}}
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-200">
                <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Digital Health Pass</span>
                        <span class="material-symbols-outlined text-teal-400">qr_code_2</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Terakhir Diperiksa</p>
                                <p class="text-sm font-bold">{{ $patient->medicalRecords()->latest()->first()?->visit_date ? \Carbon\Carbon::parse($patient->medicalRecords()->latest()->first()->visit_date)->translatedFormat('d M Y') : 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Oleh Kader</p>
                                <p class="text-sm font-bold">{{ $patient->medicalRecords()->latest()->first()?->user?->name ?? 'Sistem' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="bg-amber-50 border border-amber-100 rounded-[2.5rem] p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                    </div>
                    <h4 class="font-black text-slate-800 text-sm uppercase tracking-widest">Tips Kesehatan</h4>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">
                    "Pastikan {{ explode(' ', $patient->full_name)[0] }} mendapatkan asupan protein hewani dan ASI eksklusif hingga usia 2 tahun untuk mencegah stunting."
                </p>
            </div>
        </div>
    </div>

    @script
    <script>
        let chartInstance = null;

        const initChart = (data) => {
            const ctx = document.getElementById('growthChart');
            if (!ctx) return;

            if (chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 1000, easing: 'easeOutQuart' },
                    interaction: { intersect: false, mode: 'index' },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'USIA (BULAN)',
                                font: { family: 'Public Sans', weight: '900', size: 8 },
                                padding: 10,
                                color: '#94a3b8'
                            },
                            grid: { display: false },
                            ticks: { 
                                font: { family: 'Public Sans', size: 10, weight: '700' },
                                color: '#64748b'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'NILAI (KG / CM)',
                                font: { family: 'Public Sans', weight: '900', size: 8 },
                                padding: 10,
                                color: '#94a3b8'
                            },
                            grid: { color: '#f8fafc', lineWidth: 1 },
                            ticks: { 
                                font: { family: 'Public Sans', size: 10, weight: '700' },
                                color: '#64748b'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { 
                                usePointStyle: true, 
                                padding: 25,
                                font: { family: 'Public Sans', size: 10, weight: '800' },
                                color: '#475569'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.98)',
                            titleColor: '#0f172a',
                            titleFont: { family: 'Public Sans', weight: '900', size: 13 },
                            bodyColor: '#475569',
                            bodyFont: { family: 'Public Sans', size: 12, weight: '600' },
                            borderColor: '#f1f5f9',
                            borderWidth: 1,
                            padding: 15,
                            cornerRadius: 20,
                            displayColors: true,
                            boxPadding: 8
                        }
                    }
                }
            });
        };

        initChart($wire.chartData);

        $wire.on('chart-updated', (data) => {
            // Livewire v3 passes data as an array of arguments
            const chartData = Array.isArray(data) ? data[0] : data;
            if (chartData) {
                initChart(chartData);
            }
        });
    </script>
    @endscript
</div>
@endsection

