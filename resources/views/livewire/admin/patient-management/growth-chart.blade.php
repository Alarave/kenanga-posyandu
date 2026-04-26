@extends('layouts.admin-layout')

<div>
    @section('admin-title') Grafik Pertumbuhan: {{ $patient->full_name }} @endsection

    @section('admin-actions')
        <x-button href="{{ route('admin.patients.index') }}" variant="outline" icon="arrow_back">
            Kembali
        </x-button>
    @endsection

    @section('admin-content')
    <div class="p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Buku KIA Digital</h2>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Standar Antropometri WHO 2006</p>
            </div>
            
            <div class="flex bg-slate-100 p-1.5 rounded-2xl w-full md:w-auto shadow-inner">
                <button 
                    wire:click="switchChart('wfa')"
                    wire:key="btn-wfa"
                    class="flex-1 md:flex-none px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.15em] rounded-xl transition-all duration-300 {{ $activeChart === 'wfa' ? 'bg-white shadow-md text-teal-600 scale-100' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50' }}"
                >
                    BB / Umur
                </button>
                <button 
                    wire:click="switchChart('hfa')"
                    wire:key="btn-hfa"
                    class="flex-1 md:flex-none px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.15em] rounded-xl transition-all duration-300 {{ $activeChart === 'hfa' ? 'bg-white shadow-md text-teal-600 scale-100' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50' }}"
                >
                    TB / Umur
                </button>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-6 md:p-8 shadow-sm relative overflow-hidden group" style="height: 520px;">
            <canvas id="growthChart" wire:ignore></canvas>
            
            <div wire:loading class="absolute inset-0 bg-white/90 backdrop-blur-md flex items-center justify-center z-20 transition-all">
                <div class="flex flex-col items-center gap-4">
                    <div class="relative w-12 h-12">
                        <div class="absolute inset-0 rounded-full border-4 border-teal-100"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-teal-500 border-t-transparent animate-spin"></div>
                    </div>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] animate-pulse">Menghitung Data...</span>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-teal-50/40 rounded-3xl border border-teal-100/30 group hover:bg-teal-50 transition-all duration-500">
                <span class="text-[10px] font-black text-teal-600 uppercase tracking-[0.2em] block mb-2">Usia Saat Ini</span>
                <p class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ $patient->age_in_months }} <span class="text-sm font-bold text-slate-400 uppercase tracking-widest ml-1">Bulan</span>
                </p>
            </div>
            <div class="p-6 bg-amber-50/40 rounded-3xl border border-amber-100/30 group hover:bg-amber-50 transition-all duration-500">
                <span class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em] block mb-2">Berat Terakhir</span>
                <p class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ $patient->medicalRecords()->latest()->first()?->weight ?? '-' }} <span class="text-sm font-bold text-slate-400 uppercase tracking-widest ml-1">kg</span>
                </p>
            </div>
            <div class="p-6 bg-purple-50/40 rounded-3xl border border-purple-100/30 group hover:bg-purple-50 transition-all duration-500">
                <span class="text-[10px] font-black text-purple-600 uppercase tracking-[0.2em] block mb-2">Tinggi Terakhir</span>
                <p class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ $patient->medicalRecords()->latest()->first()?->height ?? '-' }} <span class="text-sm font-bold text-slate-400 uppercase tracking-widest ml-1">cm</span>
                </p>
            </div>
        </div>
    </div>
    @endsection

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
                                font: { family: 'Public Sans', weight: '900', size: 9 },
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
                                font: { family: 'Public Sans', weight: '900', size: 9 },
                                padding: 10,
                                color: '#94a3b8'
                            },
                            grid: { color: '#f8fafc', lineWidth: 2 },
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
                                padding: 30,
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
                            padding: 20,
                            cornerRadius: 24,
                            displayColors: true,
                            boxPadding: 8,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y.toFixed(2);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                });
            }
        };

        // Initial load
        initChart($wire.chartData);

        // Listen for updates
        $wire.on('chart-updated', (data) => {
            initChart(data[0]);
        });
    </script>
    @endscript
</div>
