<div>
    <div class="space-y-8 animate-fadeIn">
        <style>
            .pregnancy-card:hover .hover-text-amber { color: #d97706 !important; }
            .pregnancy-card:hover .hover-text-rose { color: #dc2626 !important; }
            .pregnancy-card:hover .hover-text-teal { color: #0d9488 !important; }
            .pregnancy-card:hover .hover-text-purple { color: #7c3aed !important; }
        </style>

        {{-- Stats Grid Ibu Hamil --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Card 1: AH-02 & 03: Pregnancy Safety --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Risiko Tinggi &amp; 4T', 'pregnancy_high_risk', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 hover:border-emerald-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-emerald-500 opacity-[0.03] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">shield</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-emerald-100">
                            <span class="material-symbols-outlined text-[24px]">shield</span>
                        </div>
                        <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest bg-emerald-50 px-2.5 py-1 rounded-lg">Risiko Rendah</span>
                    </div>
                    <div class="flex items-center justify-between w-full mb-3">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-emerald-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $riskStats['normal'] }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu</span>
                        </div>
                        @php
                            $totalRisk = $riskStats['normal'] + $riskStats['highRisk'];
                            $riskPercentage = $totalRisk > 0 ? round(($riskStats['normal'] / $totalRisk) * 100) : 100;
                        @endphp
                        <span class="text-xs font-extrabold text-emerald-750 bg-emerald-100/60 px-2.5 py-1 rounded-lg">{{ $riskPercentage }}% Aman</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 leading-relaxed">Ibu hamil usia aman (20-35 tahun) &amp; tinggi badan ideal (&ge; 145 cm).</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-teal">Risiko Tinggi &amp; 4T:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-amber-700 font-extrabold bg-amber-50 px-2.5 py-0.5 rounded-lg text-xs">{{ $riskStats['highRisk'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] text-slate-400 opacity-0 group-hover:opacity-100 hover-text-teal transition-opacity">arrow_forward</span>
                    </div>
                </div>
            </div>

            {{-- Card 2: AH-07: KEK --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Kasus KEK', 'pregnancy_kek', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 hover:border-purple-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-purple-500 opacity-[0.03] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">straighten</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-purple-100">
                            <span class="material-symbols-outlined text-[24px]">straighten</span>
                        </div>
                        <span class="text-[10px] font-black text-purple-700 uppercase tracking-widest bg-purple-50 px-2.5 py-1 rounded-lg">Gizi Ibu Hamil</span>
                    </div>
                    <div class="flex items-center justify-between w-full mb-3">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-purple-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $kekStats['normal'] }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu</span>
                        </div>
                        @php
                            $kekPercentage = $kekStats['total'] > 0 ? round(($kekStats['normal'] / $kekStats['total']) * 100) : 100;
                        @endphp
                        <span class="text-xs font-extrabold text-purple-750 bg-purple-100/60 px-2.5 py-1 rounded-lg">{{ $kekPercentage }}% Normal</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 leading-relaxed">Ibu hamil dengan lingkar lengan atas (LILA) normal (&ge; 23.5 cm) bebas KEK.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-purple">Kasus KEK:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-purple-700 font-extrabold bg-purple-50 px-2.5 py-0.5 rounded-lg text-xs">{{ $kekStats['kek'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] text-slate-400 opacity-0 group-hover:opacity-100 hover-text-purple transition-opacity">arrow_forward</span>
                    </div>
                </div>
            </div>
    
            {{-- Card 3: AH-06: Tekanan Darah --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Kasus Hipertensi', 'pregnancy_hypertension', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 hover:border-rose-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-rose-500 opacity-[0.03] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">monitor_heart</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-rose-100">
                            <span class="material-symbols-outlined text-[24px]">monitor_heart</span>
                        </div>
                        <span class="text-[10px] font-black text-rose-700 uppercase tracking-widest bg-rose-50 px-2.5 py-1 rounded-lg">Tekanan Darah Sehat</span>
                    </div>
                    <div class="flex items-center justify-between w-full mb-3">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-rose-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $hypertensionStats['normal'] }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu</span>
                        </div>
                        @php
                            $bpPercentage = $hypertensionStats['total'] > 0 ? round(($hypertensionStats['normal'] / $hypertensionStats['total']) * 100) : 100;
                        @endphp
                        <span class="text-xs font-extrabold text-rose-750 bg-rose-100/60 px-2.5 py-1 rounded-lg">{{ $bpPercentage }}% Normal</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 leading-relaxed">Ibu hamil dengan tekanan darah normal (&lt; 140/90 mmHg) bebas preeklamsia.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-rose">Kasus Hipertensi:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-rose-700 font-extrabold bg-rose-50 px-2.5 py-0.5 rounded-lg text-xs">{{ $hypertensionStats['hypertension'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] text-slate-400 opacity-0 group-hover:opacity-100 hover-text-rose transition-opacity">arrow_forward</span>
                    </div>
                </div>
            </div>

            {{-- Card 4: AH-08: Skrining TBC --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Skrining Gejala TBC', 'pregnancy_tbc', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 hover:border-amber-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-amber-500 opacity-[0.03] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">clinical_notes</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-amber-100">
                            <span class="material-symbols-outlined text-[24px]">clinical_notes</span>
                        </div>
                        <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest bg-amber-50 px-2.5 py-1 rounded-lg">Skrining TBC</span>
                    </div>
                    <div class="flex items-center justify-between w-full mb-3">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-amber-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $tbcStats['normal'] }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu</span>
                        </div>
                        @php
                            $tbcPercentage = $tbcStats['total'] > 0 ? round(($tbcStats['normal'] / $tbcStats['total']) * 100) : 100;
                        @endphp
                        <span class="text-xs font-extrabold text-amber-750 bg-amber-100/60 px-2.5 py-1 rounded-lg">{{ $tbcPercentage }}% Sehat</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 leading-relaxed">Ibu hamil bebas dari indikasi gejala TBC (Batuk, Demam, BB turun, Kontak TBC).</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-amber">Gejala TBC:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-amber-700 font-extrabold bg-amber-50 px-2.5 py-0.5 rounded-lg text-xs">{{ $tbcStats['tbc'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] text-slate-400 opacity-0 group-hover:opacity-100 hover-text-amber transition-opacity">arrow_forward</span>
                    </div>
                </div>
            </div>

            {{-- Card 5: AH-04: TTD --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Pemberian Tablet Fe', 'pregnancy_tablet_fe', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 hover:border-teal-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-teal-500 opacity-[0.03] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">pill</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-teal-50 text-teal-650 flex items-center justify-center border border-teal-100 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-teal-100">
                            <span class="material-symbols-outlined text-[24px]">pill</span>
                        </div>
                        <span class="text-[10px] font-black text-teal-700 uppercase tracking-widest bg-teal-50 px-2.5 py-1 rounded-lg">Cakupan TTD</span>
                    </div>
                    @php
                        $totalTtd = $ttdStats['received'] + $ttdStats['notReceived'];
                        $ttdPercentage = $totalTtd > 0 ? round(($ttdStats['received'] / $totalTtd) * 100) : 0;
                    @endphp
                    <div class="flex items-center justify-between w-full mb-3">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-teal-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $ttdPercentage }}%</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Distribusi Zat Besi</span>
                    </div>
                    
                    {{-- Mini Progress Bar --}}
                    <div class="mt-1 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-teal-500 h-full rounded-full transition-all duration-500" style="width: {{ $ttdPercentage }}%"></div>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-teal">Belum Menerima:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-rose-700 font-extrabold bg-rose-50 px-2.5 py-0.5 rounded-lg text-xs">{{ $ttdStats['notReceived'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] text-slate-400 opacity-0 group-hover:opacity-100 hover-text-teal transition-opacity">arrow_forward</span>
                    </div>
                </div>
            </div>

            {{-- Card 6: Usia Kehamilan Rata-rata --}}
            <div class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-pink-500 opacity-[0.03] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">schedule</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center border border-pink-100 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-pink-100">
                            <span class="material-symbols-outlined text-[24px]">schedule</span>
                        </div>
                        <span class="text-[10px] font-black text-pink-700 uppercase tracking-widest bg-pink-50 px-2.5 py-1 rounded-lg">Usia Kehamilan</span>
                    </div>
                    <div class="flex items-baseline gap-1.5 mb-3">
                        <span class="text-4xl font-black text-slate-800 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $rataRataUsiaKehamilan }}</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Minggu (Rata-rata)</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 leading-relaxed">Rata-rata usia kandungan dari seluruh ibu hamil aktif yang terdata di posyandu.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500">Ibu Hamil Aktif:</span>
                    <div class="flex items-center gap-2">
                        @php $totalBumil = array_sum($trimesterStats); @endphp
                        <span class="text-pink-700 font-extrabold bg-pink-50 px-2.5 py-0.5 rounded-lg text-xs">{{ $totalBumil }} Ibu</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2: Usia Kehamilan & Kepatuhan Kunjungan ANC --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            {{-- Usia Kehamilan (Trimester) --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs relative overflow-hidden flex flex-col justify-between">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-pink-50/50 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 tracking-tight">Usia Kehamilan</h3>
                            <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Proporsi ibu hamil per trimester</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600 border border-pink-100/50">
                            <span class="material-symbols-outlined text-[16px]">pregnant_woman</span>
                        </div>
                    </div>

                    @php
                        $totalBumil = array_sum($trimesterStats);
                        $isEmptyBumil = $totalBumil === 0;
                    @endphp

                    <div x-data="{
                        chart: null,
                        hiddenItems: [],
                        isEmpty: {{ $isEmptyBumil ? 'true' : 'false' }},
                        init() {
                            if (typeof Chart === 'undefined') { setTimeout(() => this.init(), 100); return; }
                            if (this.isEmpty) return;
                            const data = [
                                {{ $trimesterStats['T1'] ?? 0 }},
                                {{ $trimesterStats['T2'] ?? 0 }},
                                {{ $trimesterStats['T3'] ?? 0 }}
                            ];
                            const labels = ['Trimester 1', 'Trimester 2', 'Trimester 3'];
                            const colors = ['#f472b6', '#db2777', '#9d174d']; // Soft, Med, Dark Pink
                    
                            this.chart = new Chart(this.$refs.canvas, {
                                type: 'doughnut',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: data,
                                        backgroundColor: colors,
                                        borderWidth: 2,
                                        borderColor: '#ffffff',
                                        hoverOffset: 6
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '75%',
                                    animation: { duration: 800, easing: 'easeOutQuart' },
                                    onClick: (event, activeElements) => {
                                        if (activeElements && activeElements.length > 0) {
                                            const index = activeElements[0].index;
                                            const types = ['pregnancy_trimester_1', 'pregnancy_trimester_2', 'pregnancy_trimester_3'];
                                            const labels = ['Trimester I (1 - 13 Minggu)', 'Trimester II (14 - 27 Minggu)', 'Trimester III (28 Minggu - Lahir)'];
                                            $wire.$parent.drillDown(labels[index], types[index], null);
                                        }
                                    },
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            cornerRadius: 8,
                                            padding: 8,
                                            bodyFont: { family: '\'Public Sans\', sans-serif', size: 11 }
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
                    }" 
                    wire:key="trimester-chart-container-{{ $selectedYear }}-{{ $selectedMonth ?? 'all' }}-{{ $selectedPosyandu ?? 'all' }}"
                    wire:ignore 
                    class="relative flex justify-center mb-4 h-36">
                        <canvas x-show="!isEmpty" x-ref="canvas"></canvas>
                        <div x-show="!isEmpty" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-2xl font-black text-slate-800 leading-none" style="font-variant-numeric:tabular-nums;">{{ $rataRataUsiaKehamilan }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5 text-center">Minggu<br>(Rata-rata)</span>
                        </div>
                        <template x-if="isEmpty">
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined text-[24px] mb-1 opacity-50">pie_chart</span>
                                <span class="text-xs font-semibold">Belum ada data</span>
                            </div>
                        </template>
                    </div>

                    {{-- Legend --}}
                    <div class="space-y-1.5 pt-3 border-t border-slate-100 max-h-40 overflow-y-auto pr-1">
                        @foreach ([
                            'T1' => ['label' => 'Trimester 1', 'sub' => '0–13 mg', 'color' => '#f472b6'],
                            'T2' => ['label' => 'Trimester 2', 'sub' => '14–27 mg', 'color' => '#db2777'],
                            'T3' => ['label' => 'Trimester 3', 'sub' => '28+ mg', 'color' => '#9d174d'],
                        ] as $key => $info)
                            @php
                                $count = $trimesterStats[$key] ?? 0;
                                $percentage = $totalBumil > 0 ? round(($count / $totalBumil) * 100, 1) : 0;
                            @endphp
                            <div class="flex flex-col gap-1 text-[11px]">
                                <div class="flex items-center gap-2" :class="hiddenItems.includes({{ array_search($key, ['T1', 'T2', 'T3']) }}) ? 'opacity-40' : ''">
                                    <span class="w-2 h-2 rounded-full shrink-0 cursor-pointer" style="background:{{ $info['color'] }}" @click="toggleVisibility({{ array_search($key, ['T1', 'T2', 'T3']) }})"></span>
                                    <span class="text-slate-650 flex-1 truncate font-medium cursor-pointer hover:text-pink-600 hover:underline" wire:click="$parent.drillDown('{{ $info['label'] === 'Trimester 1' ? 'Trimester I (1 - 13 Minggu)' : ($info['label'] === 'Trimester 2' ? 'Trimester II (14 - 27 Minggu)' : 'Trimester III (28 Minggu - Lahir)') }}', '{{ $info['label'] === 'Trimester 1' ? 'pregnancy_trimester_1' : ($info['label'] === 'Trimester 2' ? 'pregnancy_trimester_2' : 'pregnancy_trimester_3') }}', null)">
                                        {{ $info['label'] }} <span class="text-[9px] text-slate-400 font-normal">({{ $info['sub'] }})</span>
                                    </span>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-slate-400 text-[9px]">{{ $count }} Bumil</span>
                                        <span class="font-bold text-slate-700 w-8 text-right">{{ $percentage }}%</span>
                                        <button wire:click="$parent.drillDown('{{ $info['label'] === 'Trimester 1' ? 'Trimester I (1 - 13 Minggu)' : ($info['label'] === 'Trimester 2' ? 'Trimester II (14 - 27 Minggu)' : 'Trimester III (28 Minggu - Lahir)') }}', '{{ $info['label'] === 'Trimester 1' ? 'pregnancy_trimester_1' : ($info['label'] === 'Trimester 2' ? 'pregnancy_trimester_2' : 'pregnancy_trimester_3') }}', null)" class="w-6 h-6 flex items-center justify-center rounded bg-slate-50 hover:bg-pink-50 text-slate-400 hover:text-pink-600 transition-colors" title="Detail Bumil">
                                            <span class="material-symbols-outlined text-[13px]">visibility</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kepatuhan Kunjungan ANC --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center border border-indigo-100/50">
                                <span class="material-symbols-outlined text-[18px]">stethoscope</span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight">Kepatuhan Kunjungan ANC</h3>
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Tingkat kunjungan minimal standar K1 sampai K6</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach([
                            'k1' => ['label' => 'K1 (TM 1)', 'trimester' => 'Trimester I', 'desc' => 'Deteksi faktor risiko awal janin', 'color' => 'rose'], 
                            'k2' => ['label' => 'K2 (TM 1)', 'trimester' => 'Trimester I', 'desc' => 'Skrining perkembangan janin', 'color' => 'rose'], 
                            'k3' => ['label' => 'K3 (TM 2)', 'trimester' => 'Trimester II', 'desc' => 'Tekanan darah &amp; kadar Hb rutin', 'color' => 'amber'], 
                            'k4' => ['label' => 'K4 (TM 2)', 'trimester' => 'Trimester II', 'desc' => 'Deteksi risiko preeklamsia', 'color' => 'amber'], 
                            'k5' => ['label' => 'K5 (TM 3)', 'trimester' => 'Trimester III', 'desc' => 'Perencanaan persalinan aman', 'color' => 'emerald'], 
                            'k6' => ['label' => 'K6 (TM 3)', 'trimester' => 'Trimester III', 'desc' => 'Pemeriksaan posisi akhir janin', 'color' => 'emerald']
                        ] as $key => $info)
                        <div wire:click="$parent.drillDown('Ibu Hamil - Kunjungan {{ strtoupper($key) }}', 'pregnancy_{{ $key }}', {{ $selectedMonth ?? 'null' }})"
                                 class="p-3 bg-gradient-to-br from-white to-slate-50 border border-slate-200/50 rounded-xl flex flex-col justify-between transition-all duration-300 hover:shadow-sm hover:border-slate-350 hover:-translate-y-0.5 cursor-pointer select-none active:scale-[0.98] group">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[8px] font-black text-{{ $info['color'] }}-700 uppercase tracking-widest bg-{{ $info['color'] }}-50 px-1.5 py-0.5 rounded">{{ $info['trimester'] }}</span>
                                </div>
                                <h4 class="text-[11px] font-extrabold text-slate-900 tracking-tight">{{ $info['label'] }}</h4>
                                <p class="text-[8.5px] font-semibold text-slate-400 mt-0.5 leading-tight">{{ $info['desc'] }}</p>
                            </div>
                            <div class="flex items-baseline gap-1 mt-2.5">
                                <span class="text-xl font-black text-slate-800 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $ancStats[$key] ?? 0 }}</span>
                                <span class="text-[9px] font-bold text-slate-400">Ibu</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 3: Pemantauan Berat Badan & IMT + Penyuluhan & Rujukan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            {{-- Pemantauan Berat Badan & IMT --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-650 flex items-center justify-center border border-teal-100">
                                <span class="material-symbols-outlined text-[18px]">scale</span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight">Pemantauan Berat Badan &amp; IMT</h3>
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Analisis kenaikan berat badan &amp; plotting IMT KIA</p>
                            </div>
                        </div>
                    </div>

                    {{-- Weight Gain Metrics --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-center">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider block">Rata-rata BB Awal</span>
                            <span class="text-lg font-black text-slate-700 mt-1 block">{{ $weightBmiStats['avgStarting'] > 0 ? $weightBmiStats['avgStarting'] . ' kg' : '-' }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-center">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider block">Rata-rata BB Sekarang</span>
                            <span class="text-lg font-black text-slate-700 mt-1 block">{{ $weightBmiStats['avgCurrent'] > 0 ? $weightBmiStats['avgCurrent'] . ' kg' : '-' }}</span>
                        </div>
                        <div class="p-3 bg-emerald-50/50 border border-emerald-100 rounded-xl text-center">
                            <span class="text-[9px] font-black text-emerald-700 uppercase tracking-wider block">Rata-rata Kenaikan</span>
                            <span class="text-lg font-black text-emerald-600 mt-1 block">+{{ $weightBmiStats['avgGain'] }} kg</span>
                        </div>
                    </div>

                    {{-- IMT Distribution List --}}
                    <div>
                        <h4 class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wider">Plotting IMT (Buku KIA)</h4>
                        <div class="space-y-2.5">
                            @php
                                $imtDistribution = $weightBmiStats['imtDistribution'];
                                $totalImt = array_sum($imtDistribution);
                            @endphp
                            @foreach(['Normal' => 'bg-emerald-500', 'Kurus' => 'bg-amber-500', 'Gemuk' => 'bg-orange-500', 'Obesitas' => 'bg-rose-500'] as $key => $colorClass)
                                @php
                                    $count = $imtDistribution[$key] ?? 0;
                                    $percent = $totalImt > 0 ? round(($count / $totalImt) * 100) : 0;
                                @endphp
                                <div wire:click="$parent.drillDown('IMT {{ $key }}', 'pregnancy_imt_{{ strtolower($key) }}', null)" 
                                     class="cursor-pointer hover:bg-slate-50/80 rounded-xl p-2.5 transition-all group">
                                    <div class="flex justify-between items-center text-[11px] mb-1.5">
                                        <span class="font-bold text-slate-600 group-hover:text-teal-650 transition-colors">{{ $key }}</span>
                                        <div class="flex items-center gap-1">
                                            <span class="font-extrabold text-slate-800 group-hover:text-teal-700 transition-colors">{{ $count }} Ibu ({{ $percent }}%)</span>
                                            <span class="material-symbols-outlined text-[12px] text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="{{ $colorClass }} h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Penyuluhan & Rujukan --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center border border-pink-100">
                                <span class="material-symbols-outlined text-[18px]">forum</span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight">Penyuluhan &amp; Rujukan</h3>
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Partisipasi kelas bumil &amp; log rujukan medis</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Left side of Panel: Partisipasi Kelas & Topik Terpopuler --}}
                        <div class="space-y-4">
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Partisipasi Kelas Ibu Hamil</h4>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-black text-slate-800">{{ $counselingReferralStats['classPercentage'] }}%</span>
                                    <span class="text-[10px] font-bold text-slate-400">Ikut Kelas</span>
                                </div>
                                <div class="mt-2 text-[10px] text-slate-500 font-semibold">
                                    {{ $counselingReferralStats['joinedClass'] }} dari {{ $counselingReferralStats['totalClassPatients'] }} Ibu hamil berpartisipasi.
                                </div>
                            </div>

                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2.5">Topik Penyuluhan Terpopuler</h4>
                                <div class="space-y-1.5">
                                    @forelse($counselingReferralStats['topTopics'] as $topic => $count)
                                        <div wire:click="$parent.drillDown('Penyuluhan: {{ $topic }}', 'pregnancy_counseling_topic', null, '{{ $topic }}')" 
                                             class="flex items-center justify-between text-xs p-1.5 bg-slate-50/50 hover:bg-slate-100 border border-slate-100 hover:border-slate-200 cursor-pointer rounded-lg transition-all group">
                                            <span class="truncate font-semibold text-slate-650 flex-1 pr-2 group-hover:text-teal-650 transition-colors" title="{{ $topic }}">{{ $topic }}</span>
                                            <div class="flex items-center gap-1.5 shrink-0">
                                                <span class="font-extrabold text-slate-700 bg-white border border-slate-200 group-hover:border-teal-200 group-hover:text-teal-700 px-2 py-0.5 rounded text-[10px] transition-colors">{{ $count }}x</span>
                                                <span class="material-symbols-outlined text-[12px] text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                                            </div>
                                        </div>
                                    @empty
                                        <span class="text-slate-400 text-xs font-semibold block text-center py-2">Belum ada penyuluhan</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Right side of Panel: Catatan Rujukan --}}
                        <div class="border-l border-slate-100 pl-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Log Rujukan Terbaru</h4>
                                <span class="text-[10px] font-extrabold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">{{ $counselingReferralStats['totalReferrals'] }} Kasus</span>
                            </div>
                            <div class="space-y-2">
                                @forelse($counselingReferralStats['referrals'] as $ref)
                                    <div class="p-2 bg-rose-50/20 border border-rose-100/50 rounded-xl flex flex-col gap-1">
                                        <div class="flex justify-between items-center text-[10px]">
                                            <span class="font-black text-slate-700 truncate max-w-[100px]">{{ $ref['patient_name'] }}</span>
                                            <span class="text-slate-400 font-semibold">{{ $ref['visit_date'] }}</span>
                                        </div>
                                        <p class="text-[10px] text-rose-700 font-semibold leading-relaxed line-clamp-2" title="{{ $ref['anc_referral'] }}">{{ $ref['anc_referral'] }}</p>
                                    </div>
                                @empty
                                    <div class="h-28 flex flex-col items-center justify-center text-slate-400">
                                        <span class="material-symbols-outlined text-[20px] mb-1 opacity-50">check_circle</span>
                                        <span class="text-[10px] font-semibold">Tidak ada rujukan aktif</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 4: Tren Kepatuhan &amp; Risiko --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs mt-6 w-full">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Tren Kepatuhan &amp; Risiko Ibu Hamil</h3>
                    <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Tren kuantitatif bulanan kepatuhan suplemen zat besi dan risiko tinggi kasus hipertensi</p>
                </div>
                <button onclick="downloadChart(pregnancyRiskChart, 'tren_kepatuhan_risiko_ibu_hamil')" class="shrink-0 p-2 text-slate-500 hover:text-slate-800 rounded-lg bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                    <span class="material-symbols-outlined text-[16px]">download</span>
                </button>
            </div>
            <div class="relative min-h-[300px] lg:min-h-[350px]">
                <canvas id="pregnancyRiskChart" wire:ignore></canvas>
            </div>
        </div>

        {{-- Tabel Pemantauan Klinis Ibu Hamil --}}
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200 shadow-xs mt-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">Pemantauan Klinis Ibu Hamil</h3>
                    <p class="text-xs md:text-sm text-slate-500 font-semibold mt-1">Daftar lengkap perkembangan kesehatan klinis ibu hamil aktif</p>
                </div>
                
                {{-- Search Bar --}}
                <div class="w-full md:w-72 relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cari nama ibu hamil..." 
                           class="w-full h-10 pl-10 pr-4 bg-slate-50/50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 text-xs font-semibold text-slate-700 placeholder-slate-400 rounded-xl transition-all">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1150px] text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Ibu Hamil</th>
                            <th class="px-6 py-4">Usia Hamil</th>
                            <th class="px-6 py-4">HPL / Taksiran</th>
                            <th class="px-6 py-4 text-center">LILA</th>
                            <th class="px-6 py-4 text-center">Tekanan Darah</th>
                            <th class="px-6 py-4 text-center">ANC</th>
                            <th class="px-6 py-4 text-center">Tablet Fe</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        @forelse($maternalTableData as $row)
                            <tr class="hover:bg-slate-50/50 transition-colors" wire:key="maternal-row-{{ $row['id'] }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-full bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">pregnant_woman</span>
                                        </div>
                                        <div class="flex flex-col gap-0.5">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-semibold text-slate-800 tracking-tight whitespace-nowrap">{{ $row['name'] }}</span>
                                                @if($row['is_high_risk'])
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-amber-50 border border-amber-200 text-[9px] font-black text-amber-700 cursor-help whitespace-nowrap" title="Risiko Tinggi: {{ $row['risk_reasons'] }}">
                                                        <span class="material-symbols-outlined text-[10px] text-amber-500">warning</span>
                                                        Risiko
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-slate-400 font-medium whitespace-nowrap">Usia: {{ $row['age'] }} thn &bull; {{ $row['posyandu_name'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-700 font-extrabold text-xs">
                                    @if($row['gestational_age'] === '-')
                                        <span class="text-slate-350 font-bold">-</span>
                                    @else
                                        {{ $row['gestational_age'] }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($row['hpl'] === '-')
                                        <span class="text-slate-350 font-bold">-</span>
                                    @else
                                        <span class="text-slate-700 font-black text-xs">{{ $row['hpl'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row['lila'] === '-')
                                        <span class="text-slate-350 font-bold">-</span>
                                    @else
                                        <div class="flex flex-col items-center justify-center gap-0.5">
                                            <span class="font-extrabold text-xs {{ $row['is_kek'] ? 'text-rose-600' : 'text-slate-700' }}">{{ $row['lila'] }} cm</span>
                                            @if($row['is_kek'])
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-rose-50 text-[9px] font-black text-rose-600 border border-rose-100 uppercase tracking-wider">KEK</span>
                                            @else
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-emerald-50 text-[9px] font-black text-emerald-600 border border-emerald-100 uppercase tracking-wider">Normal</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row['bp'] === '-')
                                        <span class="text-slate-350 font-bold">-</span>
                                    @else
                                        <div class="flex flex-col items-center justify-center gap-0.5">
                                            <span class="font-extrabold text-xs {{ $row['is_hypertension'] ? 'text-rose-600' : 'text-slate-700' }}">{{ $row['bp'] }} mmHg</span>
                                            @if($row['is_hypertension'])
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-rose-50 text-[9px] font-black text-rose-600 border border-rose-100 uppercase tracking-wider">Hipertensi</span>
                                            @else
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-emerald-50 text-[9px] font-black text-emerald-600 border border-emerald-100 uppercase tracking-wider">Normal</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center justify-center gap-0.5">
                                        <span class="font-bold text-xs text-slate-700">{{ $row['anc_count'] }} Kali</span>
                                        <span class="inline-flex px-1.5 py-0.5 rounded bg-blue-50 text-[9px] font-black text-blue-600 border border-blue-100 uppercase tracking-wider">K{{ min(6, max(1, $row['anc_count'])) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row['ttd_received'] === 'Ya')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-250 text-xs font-bold text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Menerima
                                        </span>
                                    @elseif($row['ttd_received'] === 'Tidak')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 border border-rose-250 text-xs font-bold text-rose-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Belum
                                        </span>
                                    @else
                                        <span class="text-slate-350 font-bold">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end">
                                        <a href="{{ route('admin.patients.show', $row['id']) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 border border-slate-200 text-slate-500 hover:bg-teal-500 hover:text-white hover:border-teal-500 transition-all shadow-xs" title="Buka Detail Profil">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-slate-400 text-sm">
                                    Tidak ada data ibu hamil yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
