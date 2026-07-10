<div>
    <div class="space-y-8 animate-fadeIn">
        <style>
            .pregnancy-card:hover .hover-text-amber { color: #d97706 !important; }
            .pregnancy-card:hover .hover-text-rose { color: #dc2626 !important; }
            .pregnancy-card:hover .hover-text-teal { color: #0d9488 !important; }
            .pregnancy-card:hover .hover-text-purple { color: #7c3aed !important; }
        </style>

        {{-- Stats Grid Ibu Hamil --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- AH-02 & 03: Pregnancy Safety --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Risiko Tinggi &amp; 4T', 'pregnancy_high_risk', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-gradient-to-br from-white to-emerald-50/10 rounded-3xl p-6 border border-emerald-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-emerald-100/40 hover:-translate-y-1 hover:border-emerald-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-emerald-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">shield</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-emerald-100 group-hover:text-emerald-750">
                            <span class="material-symbols-outlined text-[26px]">shield</span>
                        </div>
                        <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest bg-emerald-50 px-2.5 py-1 rounded-lg">Risiko Rendah</span>
                    </div>
                    <div class="flex items-baseline justify-between w-full">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-emerald-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $riskStats['normal'] }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu Hamil</span>
                        </div>
                        @php
                            $totalRisk = $riskStats['normal'] + $riskStats['highRisk'];
                            $riskPercentage = $totalRisk > 0 ? round(($riskStats['normal'] / $totalRisk) * 100) : 100;
                        @endphp
                        <span class="text-xs font-extrabold text-emerald-750 bg-emerald-100/80 px-2 py-0.5 rounded-md">{{ $riskPercentage }}% Aman</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 mt-4 leading-relaxed">Ibu hamil dengan kondisi normal (usia aman 20-35 tahun &amp; tinggi badan ideal &ge; 145 cm).</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-teal">Risiko Tinggi &amp; 4T:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-amber-700 font-extrabold bg-amber-50 px-2.5 py-0.5 rounded-lg">{{ $riskStats['highRisk'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-teal">arrow_forward</span>
                    </div>
                </div>
            </div>

            {{-- AH-07: KEK (Kekurangan Energi Kronis) --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Kasus KEK', 'pregnancy_kek', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-gradient-to-br from-white to-purple-50/10 rounded-3xl p-6 border border-purple-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-purple-100/40 hover:-translate-y-1 hover:border-purple-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-purple-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">straighten</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-purple-100 group-hover:text-purple-750">
                            <span class="material-symbols-outlined text-[26px]">straighten</span>
                        </div>
                        <span class="text-[10px] font-black text-purple-700 uppercase tracking-widest bg-purple-50 px-2.5 py-1 rounded-lg">Gizi Ibu Hamil</span>
                    </div>
                    <div class="flex items-baseline justify-between w-full">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-purple-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $kekStats['normal'] }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu Hamil</span>
                        </div>
                        @php
                            $kekPercentage = $kekStats['total'] > 0 ? round(($kekStats['normal'] / $kekStats['total']) * 100) : 100;
                        @endphp
                        <span class="text-xs font-extrabold text-purple-750 bg-purple-100/80 px-2 py-0.5 rounded-md">{{ $kekPercentage }}% Normal</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 mt-4 leading-relaxed">Ibu hamil dengan lingkar lengan atas (LILA) sehat (&ge; 23.5 cm) bebas dari risiko KEK.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-purple">Kasus KEK:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-purple-700 font-extrabold bg-purple-50 px-2.5 py-0.5 rounded-lg">{{ $kekStats['kek'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-purple">arrow_forward</span>
                    </div>
                </div>
            </div>
    
            {{-- AH-06: Hemoglobin Index --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Kasus Anemia', 'pregnancy_anemia', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-gradient-to-br from-white to-rose-50/10 rounded-3xl p-6 border border-rose-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-rose-100/40 hover:-translate-y-1 hover:border-rose-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-rose-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">water_drop</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-rose-100 group-hover:text-rose-750">
                            <span class="material-symbols-outlined text-[26px]">water_drop</span>
                        </div>
                        <span class="text-[10px] font-black text-rose-700 uppercase tracking-widest bg-rose-50 px-2.5 py-1 rounded-lg">Hemoglobin Sehat</span>
                    </div>
                    <div class="flex items-baseline justify-between w-full">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-rose-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $anemiaStats['normal'] }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu Hamil</span>
                        </div>
                        @php
                            $anemiaPercentage = $anemiaStats['total'] > 0 ? round(($anemiaStats['normal'] / $anemiaStats['total']) * 100) : 100;
                        @endphp
                        <span class="text-xs font-extrabold text-rose-750 bg-rose-100/80 px-2 py-0.5 rounded-md">{{ $anemiaPercentage }}% Normal</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 mt-4 leading-relaxed">Ibu hamil dengan kadar Hemoglobin (Hb) aman (&ge; 11 g/dL) bebas dari anemia.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-rose">Kasus Anemia:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-rose-700 font-extrabold bg-rose-50 px-2.5 py-0.5 rounded-lg">{{ $anemiaStats['anemia'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-rose">arrow_forward</span>
                    </div>
                </div>
            </div>
    
            {{-- AH-04: TTD Coverage --}}
            <div wire:click="$parent.drillDown('Ibu Hamil - Pemberian Tablet Fe', 'pregnancy_tablet_fe', {{ $selectedMonth ?? 'null' }})"
                 class="relative overflow-hidden bg-gradient-to-br from-white to-teal-50/10 rounded-3xl p-6 border border-teal-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-teal-100/40 hover:-translate-y-1 hover:border-teal-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group pregnancy-card">
                
                {{-- Background Watermark Icon --}}
                <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-teal-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">pill</span>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-650 flex items-center justify-center border border-teal-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-teal-100 group-hover:text-teal-750">
                            <span class="material-symbols-outlined text-[26px]">pill</span>
                        </div>
                        <span class="text-[10px] font-black text-teal-700 uppercase tracking-widest bg-teal-50 px-2.5 py-1 rounded-lg">Cakupan TTD</span>
                    </div>
                    @php
                        $totalTtd = $ttdStats['received'] + $ttdStats['notReceived'];
                        $ttdPercentage = $totalTtd > 0 ? round(($ttdStats['received'] / $totalTtd) * 100) : 0;
                    @endphp
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-teal-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $ttdPercentage }}%</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cakupan Distribusi</span>
                    </div>
                    
                    {{-- Mini Progress Bar --}}
                    <div class="mt-3 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-teal-500 h-full rounded-full transition-all duration-500" style="width: {{ $ttdPercentage }}%"></div>
                    </div>

                    <p class="text-xs font-semibold text-slate-500 mt-3 leading-relaxed">Ibu hamil yang sudah menerima Tablet Tambah Darah (TTD) atau suplemen MMS.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center pr-2">
                    <span class="text-xs font-bold text-slate-500 transition-colors duration-300 hover-text-teal">Belum Menerima:</span>
                    <div class="flex items-center gap-2">
                        <span class="text-rose-700 font-extrabold bg-rose-50 px-2.5 py-0.5 rounded-lg">{{ $ttdStats['notReceived'] }} Ibu</span>
                        <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-teal">arrow_forward</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2: Detail Distribusi & Kunjungan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            {{-- AH-01: Trimester --}}
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center border border-rose-100/50">
                                <span class="material-symbols-outlined text-[24px]">pregnant_woman</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Distribusi Usia Kehamilan</h3>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">Sebaran tahapan trimester ibu hamil aktif saat ini</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        @php
                            $tTotal = array_sum($trimesterStats);
                            $t1Pct = $tTotal > 0 ? round(($trimesterStats['T1'] / $tTotal) * 100) : 0;
                            $t2Pct = $tTotal > 0 ? round(($trimesterStats['T2'] / $tTotal) * 100) : 0;
                            $t3Pct = $tTotal > 0 ? round(($trimesterStats['T3'] / $tTotal) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <div>
                                    <span class="text-xs font-extrabold text-slate-800">Trimester I <span class="text-[10px] font-bold text-slate-400">(1 - 13 Minggu)</span></span>
                                    <p class="text-[10px] text-slate-500 font-semibold mt-0.5">Fase krusial pembentukan organ vital janin</p>
                                </div>
                                <span class="text-xs font-black text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-lg">{{ $trimesterStats['T1'] }} Ibu ({{ $t1Pct }}%)</span>
                            </div>
                            <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-rose-300 to-rose-500 rounded-full" style="width: {{ $t1Pct }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <div>
                                    <span class="text-xs font-extrabold text-slate-800">Trimester II <span class="text-[10px] font-bold text-slate-400">(14 - 27 Minggu)</span></span>
                                    <p class="text-[10px] text-slate-500 font-semibold mt-0.5">Fase pertumbuhan fisik &amp; gerak aktif janin</p>
                                </div>
                                <span class="text-xs font-black text-amber-600 bg-amber-50 px-2.5 py-0.5 rounded-lg">{{ $trimesterStats['T2'] }} Ibu ({{ $t2Pct }}%)</span>
                            </div>
                            <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-300 to-amber-500 rounded-full" style="width: {{ $t2Pct }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <div>
                                    <span class="text-xs font-extrabold text-slate-800">Trimester III <span class="text-[10px] font-bold text-slate-400">(28 Minggu - Lahir)</span></span>
                                    <p class="text-[10px] text-slate-500 font-semibold mt-0.5">Fase pematangan organ &amp; persiapan kelahiran</p>
                                </div>
                                <span class="text-xs font-black text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-lg">{{ $trimesterStats['T3'] }} Ibu ({{ $t3Pct }}%)</span>
                            </div>
                            <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-300 to-emerald-500 rounded-full" style="width: {{ $t3Pct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AH-05: ANC K1-K6 --}}
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center border border-indigo-100/50">
                                <span class="material-symbols-outlined text-[24px]">stethoscope</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Kepatuhan Kunjungan ANC</h3>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">Tingkat kunjungan berkala minimal standar K1 sampai K6</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        @foreach([
                            'k1' => ['label' => 'K1 (TM 1)', 'trimester' => 'Trimester I', 'desc' => 'Deteksi faktor risiko awal janin', 'color' => 'rose'], 
                            'k2' => ['label' => 'K2 (TM 1)', 'trimester' => 'Trimester I', 'desc' => 'Skrining perkembangan janin', 'color' => 'rose'], 
                            'k3' => ['label' => 'K3 (TM 2)', 'trimester' => 'Trimester II', 'desc' => 'Tekanan darah &amp; kadar Hb rutin', 'color' => 'amber'], 
                            'k4' => ['label' => 'K4 (TM 2)', 'trimester' => 'Trimester II', 'desc' => 'Deteksi risiko preeklamsia', 'color' => 'amber'], 
                            'k5' => ['label' => 'K5 (TM 3)', 'trimester' => 'Trimester III', 'desc' => 'Perencanaan persalinan aman', 'color' => 'emerald'], 
                            'k6' => ['label' => 'K6 (TM 3)', 'trimester' => 'Trimester III', 'desc' => 'Pemeriksaan posisi akhir janin', 'color' => 'emerald']
                        ] as $key => $info)
                        <div wire:click="$parent.drillDown('Ibu Hamil - Kunjungan {{ strtoupper($key) }}', 'pregnancy_{{ $key }}', {{ $selectedMonth ?? 'null' }})"
                             class="p-4 bg-gradient-to-br from-white to-slate-50 border border-slate-200/60 rounded-2xl flex flex-col justify-between transition-all duration-300 hover:shadow-md hover:border-slate-350 hover:-translate-y-0.5 cursor-pointer select-none active:scale-[0.98] group">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[9px] font-black text-{{ $info['color'] }}-700 uppercase tracking-widest bg-{{ $info['color'] }}-50 px-2 py-0.5 rounded-md">{{ $info['trimester'] }}</span>
                                </div>
                                <h4 class="text-xs font-extrabold text-slate-900 tracking-tight">{{ $info['label'] }}</h4>
                                <p class="text-[9px] font-semibold text-slate-400 mt-1 leading-tight">{{ $info['desc'] }}</p>
                            </div>
                            <div class="flex items-baseline gap-1 mt-4">
                                <span class="text-2xl font-black text-slate-800 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $ancStats[$key] ?? 0 }}</span>
                                <span class="text-[10px] font-bold text-slate-400">Ibu</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200 shadow-xs mt-6">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">Tren Kepatuhan &amp; Risiko Ibu Hamil</h3>
                    <p class="text-xs md:text-sm text-slate-500 font-semibold mt-1">Tren prevalensi bulanan kepatuhan suplemen zat besi dan risiko tinggi usia kehamilan</p>
                </div>
                <button onclick="downloadChart(pregnancyRiskChart, 'tren_kepatuhan_risiko_ibu_hamil')" class="shrink-0 p-2.5 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                    <span class="material-symbols-outlined text-[20px]">download</span>
                </button>
            </div>
            <div class="relative h-85">
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
                <table class="w-full text-left">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:1px solid rgba(0,0,0,0.05);" class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Ibu Hamil</th>
                            <th class="px-6 py-4">Usia Hamil</th>
                            <th class="px-6 py-4">HPL / Taksiran</th>
                            <th class="px-6 py-4 text-center">LILA</th>
                            <th class="px-6 py-4 text-center">Hemoglobin</th>
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
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($row['name'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block text-sm font-semibold text-slate-800">{{ $row['name'] }}</span>
                                            <span class="text-xs text-slate-400 font-medium">Usia: {{ $row['age'] }} thn | {{ $row['posyandu_name'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-700 font-medium">{{ $row['gestational_age'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700 font-semibold">{{ $row['hpl'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row['lila'] === '-')
                                        <span class="text-slate-300">-</span>
                                    @else
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="font-bold {{ $row['is_kek'] ? 'text-rose-600' : 'text-slate-700' }}">{{ $row['lila'] }} cm</span>
                                            @if($row['is_kek'])
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-rose-50 text-[9px] font-extrabold text-rose-600 border border-rose-100 uppercase tracking-wider">KEK</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row['hb'] === '-')
                                        <span class="text-slate-300">-</span>
                                    @else
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="font-bold {{ $row['is_anemia'] ? 'text-rose-600' : 'text-slate-700' }}">{{ $row['hb'] }} g/dL</span>
                                            @if($row['is_anemia'])
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-rose-50 text-[9px] font-extrabold text-rose-600 border border-rose-100 uppercase tracking-wider">Anemia</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row['bp'] === '-')
                                        <span class="text-slate-300">-</span>
                                    @else
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="font-bold {{ $row['is_hypertension'] ? 'text-rose-600' : 'text-slate-700' }}">{{ $row['bp'] }} mmHg</span>
                                            @if($row['is_hypertension'])
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-rose-50 text-[9px] font-extrabold text-rose-600 border border-rose-100 uppercase tracking-wider">Hipertensi</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="font-bold text-slate-700">{{ $row['anc_count'] }} kali</span>
                                        <span class="inline-flex px-1.5 py-0.5 rounded bg-blue-50 text-[9px] font-extrabold text-blue-600 border border-blue-100 uppercase tracking-wider">ANC K{{ min(6, max(1, $row['anc_count'])) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="badge {{ $row['ttd_received'] === 'Ya' ? 'badge-teal' : 'badge-red' }}">{{ $row['ttd_received'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($row['is_high_risk'])
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-50 text-red-500 border border-red-100 hover:bg-red-100 transition-colors cursor-help" title="Risiko Tinggi: {{ $row['risk_reasons'] }}">
                                                <span class="material-symbols-outlined text-[15px]">warning</span>
                                            </span>
                                        @endif
                                        <a href="{{ route('admin.patients.show', $row['id']) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-teal-500 hover:text-white transition-all" title="Buka Detail Profil">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
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
