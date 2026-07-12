<div class="space-y-8 animate-fadeIn">
    <style>
        .metabolic-card:hover .hover-text-hipertensi { color: #dc2626 !important; }
        .metabolic-card:hover .hover-text-gula { color: #d97706 !important; }
        .metabolic-card:hover .hover-text-kolesterol { color: #2563eb !important; }
        .metabolic-card:hover .hover-text-asam { color: #7c3aed !important; }
    </style>

    {{-- Metabolic Risks Grid (AL-03 to AL-06) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Hipertensi --}}
        <div wire:click="$parent.drillDown('Lansia - Hipertensi', 'lansia_hipertensi', {{ $selectedMonth ?: 'null' }})"
             class="relative overflow-hidden bg-gradient-to-br from-white to-rose-50/10 rounded-3xl p-6 border border-rose-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-rose-100/40 hover:-translate-y-1 hover:border-rose-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group metabolic-card">
            
            {{-- Background Watermark Icon --}}
            <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-rose-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">monitor_heart</span>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-rose-100 group-hover:text-rose-750">
                        <span class="material-symbols-outlined text-[24px]">monitor_heart</span>
                    </div>
                    <span class="text-[10px] font-black text-rose-700 uppercase tracking-widest bg-rose-50 px-2.5 py-1 rounded-lg">Hipertensi</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-black text-rose-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $metabolicRisks['hipertensi'] }}</span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-4 leading-relaxed">Lansia dengan tekanan darah &ge; 140/90 mmHg</p>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between pr-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider transition-colors duration-300 hover-text-hipertensi">Terdeteksi otomatis rekam medis</span>
                <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-hipertensi">arrow_forward</span>
            </div>
        </div>

        {{-- Hiperglikemia --}}
        <div wire:click="$parent.drillDown('Lansia - Hiperglikemia', 'lansia_hiperglikemia', {{ $selectedMonth ?: 'null' }})"
             class="relative overflow-hidden bg-gradient-to-br from-white to-amber-50/10 rounded-3xl p-6 border border-amber-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-amber-100/40 hover:-translate-y-1 hover:border-amber-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group metabolic-card">
            
            {{-- Background Watermark Icon --}}
            <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-amber-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">bloodtype</span>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-amber-100 group-hover:text-amber-750">
                        <span class="material-symbols-outlined text-[24px]">bloodtype</span>
                    </div>
                    <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest bg-amber-50 px-2.5 py-1 rounded-lg">Gula Darah</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-black text-amber-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $metabolicRisks['gula'] }}</span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-4 leading-relaxed">Lansia dengan kadar GDS/Gula Darah &ge; 200 mg/dL</p>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between pr-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider transition-colors duration-300 hover-text-gula">Kasus hiperglikemia aktif</span>
                <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-gula">arrow_forward</span>
            </div>
        </div>

        {{-- Kolesterol Tinggi --}}
        <div wire:click="$parent.drillDown('Lansia - Hiperkolesterolemia', 'lansia_hiperkolesterolemia', {{ $selectedMonth ?: 'null' }})"
             class="relative overflow-hidden bg-gradient-to-br from-white to-blue-50/10 rounded-3xl p-6 border border-blue-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-blue-100/40 hover:-translate-y-1 hover:border-blue-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group metabolic-card">
            
            {{-- Background Watermark Icon --}}
            <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-blue-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">heart_broken</span>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-blue-100 group-hover:text-blue-750">
                        <span class="material-symbols-outlined text-[24px]">heart_broken</span>
                    </div>
                    <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest bg-blue-50 px-2.5 py-1 rounded-lg">Kolesterol</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-black text-blue-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $metabolicRisks['kolesterol'] }}</span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-4 leading-relaxed">Lansia dengan kadar Kolesterol &ge; 200 mg/dL</p>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between pr-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider transition-colors duration-300 hover-text-kolesterol">Pemeriksaan berkala</span>
                <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-kolesterol">arrow_forward</span>
            </div>
        </div>

        {{-- Asam Urat Tinggi --}}
        <div wire:click="$parent.drillDown('Lansia - Hiperurisemia', 'lansia_hiperurisemia', {{ $selectedMonth ?: 'null' }})"
             class="relative overflow-hidden bg-gradient-to-br from-white to-purple-50/10 rounded-3xl p-6 border border-purple-100 shadow-xs flex flex-col justify-between hover:shadow-lg hover:shadow-purple-100/40 hover:-translate-y-1 hover:border-purple-300 transition-all duration-300 cursor-pointer select-none active:scale-[0.98] group metabolic-card">
            
            {{-- Background Watermark Icon --}}
            <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-[120px] text-purple-500 opacity-[0.04] transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 pointer-events-none">medical_services</span>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-200/50 shadow-xs transition-all duration-300 group-hover:scale-110 group-hover:bg-purple-100 group-hover:text-purple-750">
                        <span class="material-symbols-outlined text-[24px]">medical_services</span>
                    </div>
                    <span class="text-[10px] font-black text-purple-700 uppercase tracking-widest bg-purple-50 px-2.5 py-1 rounded-lg">Asam Urat</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-black text-purple-600 tracking-tight transition-transform duration-300 group-hover:scale-105 inline-block">{{ $metabolicRisks['asamUrat'] }}</span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-4 leading-relaxed">Lansia dengan kadar Asam Urat &ge; 7.0 mg/dL</p>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between pr-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider transition-colors duration-300 hover-text-asam">Deteksi pencegahan gout</span>
                <span class="material-symbols-outlined text-[14px] !w-auto !overflow-visible text-slate-400 transition-all duration-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 hover-text-asam">arrow_forward</span>
            </div>
        </div>
    </div>

    {{-- Demographic, IMT & Independence Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        {{-- AL-01: Kategori Umur --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-indigo-600 text-[26px]">elderly</span>
                    <h3 class="text-lg font-bold text-slate-900">Kategori Usia Lansia</h3>
                </div>
                <p class="text-xs text-slate-500 font-semibold mb-6">Distribusi kelompok usia lansia aktif terdaftar</p>
                
                <div class="space-y-4">
                    @php
                        $uTotal = array_sum($ageCategories);
                        $praPct = $uTotal > 0 ? round(($ageCategories['pra'] / $uTotal) * 100) : 0;
                        $lanPct = $uTotal > 0 ? round(($ageCategories['lansia'] / $uTotal) * 100) : 0;
                        $resPct = $uTotal > 0 ? round(($ageCategories['resti'] / $uTotal) * 100) : 0;
                    @endphp
                    <div wire:click="$parent.drillDown('Kategori Usia Lansia: Pra-Lansia (45 - 59 Tahun)', 'lansia_age_pra')"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors"
                         title="Klik untuk melihat daftar pra-lansia">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span class="hover:underline hover:text-indigo-600">Pra-Lansia (45 - 59 Tahun)</span>
                            <span class="text-slate-900 font-extrabold">{{ $ageCategories['pra'] }} Jiwa ({{ $praPct }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width: {{ $praPct }}%; background-color: #818cf8;"></div>
                        </div>
                    </div>
                    <div wire:click="$parent.drillDown('Kategori Usia Lansia: Lansia (60 - 69 Tahun)', 'lansia_age_lansia')"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors"
                         title="Klik untuk melihat daftar lansia">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span class="hover:underline hover:text-indigo-600">Lansia (60 - 69 Tahun)</span>
                            <span class="text-slate-900 font-extrabold">{{ $ageCategories['lansia'] }} Jiwa ({{ $lanPct }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width: {{ $lanPct }}%; background-color: #6366f1;"></div>
                        </div>
                    </div>
                    <div wire:click="$parent.drillDown('Kategori Usia Lansia: Risiko Tinggi (70+ Tahun)', 'lansia_age_resti')"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors"
                         title="Klik untuk melihat daftar lansia resiko tinggi">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span class="hover:underline hover:text-indigo-600">Lansia Risiko Tinggi (70+ Tahun)</span>
                            <span class="text-slate-900 font-extrabold">{{ $ageCategories['resti'] }} Jiwa ({{ $resPct }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width: {{ $resPct }}%; background-color: #4338ca;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- AL-02: IMT --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-teal-600 text-[26px]">scale</span>
                    <h3 class="text-lg font-bold text-slate-900">Status Indeks Massa Tubuh (IMT)</h3>
                </div>
                <p class="text-xs text-slate-500 font-semibold mb-6">Status berat badan lansia berdasarkan data pemeriksaan terbaru</p>
                
                <div class="space-y-3">
                    @php
                        $imtTotal = array_sum($imtStats);
                        $kurangPct = $imtTotal > 0 ? round(($imtStats['kurang'] / $imtTotal) * 100) : 0;
                        $normalPct = $imtTotal > 0 ? round(($imtStats['normal'] / $imtTotal) * 100) : 0;
                        $lebihPct = $imtTotal > 0 ? round(($imtStats['lebih'] / $imtTotal) * 100) : 0;
                        $obesitasPct = $imtTotal > 0 ? round(($imtStats['obesitas'] / $imtTotal) * 100) : 0;
                    @endphp
                    <div wire:click="$parent.drillDown('IMT Lansia: Kekurangan Berat (IMT < 18.5)', 'lansia_imt_kurang')"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors"
                         title="Klik untuk melihat daftar lansia dengan kekurangan berat">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span class="hover:underline hover:text-teal-600">Kekurangan Berat (IMT &lt; 18.5)</span>
                            <span class="text-slate-900 font-extrabold">{{ $imtStats['kurang'] }} Jiwa ({{ $kurangPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $kurangPct }}%"></div>
                        </div>
                    </div>
                    <div wire:click="$parent.drillDown('IMT Lansia: Berat Badan Normal (18.5 - 24.9)', 'lansia_imt_normal')"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors"
                         title="Klik untuk melihat daftar lansia dengan berat badan normal">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span class="hover:underline hover:text-teal-600">Berat Badan Normal (18.5 - 24.9)</span>
                            <span class="text-slate-900 font-extrabold">{{ $imtStats['normal'] }} Jiwa ({{ $normalPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-teal-500 rounded-full" style="width: {{ $normalPct }}%"></div>
                        </div>
                    </div>
                    <div wire:click="$parent.drillDown('IMT Lansia: Kelebihan Berat (25.0 - 26.9)', 'lansia_imt_lebih')"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors"
                         title="Klik untuk melihat daftar lansia dengan kelebihan berat">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span class="hover:underline hover:text-teal-600">Kelebihan Berat (25.0 - 26.9)</span>
                            <span class="text-slate-900 font-extrabold">{{ $imtStats['lebih'] }} Jiwa ({{ $lebihPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-orange-400 rounded-full" style="width: {{ $lebihPct }}%"></div>
                        </div>
                    </div>
                    <div wire:click="$parent.drillDown('IMT Lansia: Obesitas (IMT >= 27)', 'lansia_imt_obesitas')"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors"
                         title="Klik untuk melihat daftar lansia dengan obesitas">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span class="hover:underline hover:text-rose-700">Obesitas (IMT &ge; 27)</span>
                            <span class="text-slate-900 font-extrabold">{{ $imtStats['obesitas'] }} Jiwa ({{ $obesitasPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-rose-500 rounded-full" style="width: {{ $obesitasPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Row 3: Gangguan Indra & Rujukan Lansia --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        {{-- Gangguan Indra --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between relative overflow-hidden">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-teal-600 text-[26px]">medical_information</span>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Gangguan Indra</h3>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">Analisis fungsi indera sensorik lansia</p>
                    </div>
                </div>

                <div class="space-y-4">

                    {{-- Gangguan Penglihatan --}}
                    <div wire:click="$parent.drillDown('Lansia - Gangguan Penglihatan', 'lansia_eye_issue', {{ $selectedMonth ?: 'null' }})"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors group/item"
                         title="Klik untuk melihat daftar lansia dengan gangguan penglihatan">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span class="hover:underline hover:text-indigo-600 transition-colors">Gangguan Penglihatan</span>
                            <span class="text-slate-900 font-extrabold">{{ $sensoryObesityStats['eyeIssue'] }} Jiwa ({{ $sensoryObesityStats['eyePct'] }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full transition-all" style="width: {{ $sensoryObesityStats['eyePct'] }}%"></div>
                        </div>
                    </div>

                    {{-- Gangguan Pendengaran --}}
                    <div wire:click="$parent.drillDown('Lansia - Gangguan Pendengaran', 'lansia_ear_issue', {{ $selectedMonth ?: 'null' }})"
                         class="cursor-pointer hover:bg-slate-50 px-2 -mx-2 py-1 rounded-xl transition-colors group/item"
                         title="Klik untuk melihat daftar lansia dengan gangguan pendengaran">
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span class="hover:underline hover:text-pink-600 transition-colors">Gangguan Pendengaran</span>
                            <span class="text-slate-900 font-extrabold">{{ $sensoryObesityStats['earIssue'] }} Jiwa ({{ $sensoryObesityStats['earPct'] }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-pink-500 rounded-full transition-all" style="width: {{ $sensoryObesityStats['earPct'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Skrining Khusus Lansia & Rujukan --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between relative overflow-hidden">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-purple-600 text-[26px]">clinical_notes</span>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Skrining Khusus &amp; Rujukan</h3>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">Deteksi risiko PPOK, TBC, kesehatan jiwa, dan log rujukan aktif</p>
                    </div>
                </div>

                {{-- Mini progress bars for PUMA, TBC, Mental --}}
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <div wire:click="$parent.drillDown('Lansia - Risiko PPOK (PUMA)', 'lansia_puma_risk', {{ $selectedMonth ?: 'null' }})"
                         class="bg-rose-50/50 border border-rose-100 hover:bg-rose-50/80 hover:border-rose-300 transition-all rounded-2xl p-3 text-center cursor-pointer group/card">
                        <span class="block text-[9px] font-black text-rose-700 uppercase tracking-wider mb-1">PUMA (Paru)</span>
                        <span class="text-xl font-black text-rose-600 block">{{ $specialScreeningReferralStats['pumaCount'] }}</span>
                        <span class="text-[9px] font-extrabold text-rose-500 block mt-0.5">{{ $specialScreeningReferralStats['pumaPct'] }}% Berisiko</span>
                    </div>

                    <div wire:click="$parent.drillDown('Lansia - Terduga Gejala TBC', 'lansia_tbc_risk', {{ $selectedMonth ?: 'null' }})"
                         class="bg-amber-50/50 border border-amber-100 hover:bg-amber-50/80 hover:border-amber-300 transition-all rounded-2xl p-3 text-center cursor-pointer group/card">
                        <span class="block text-[9px] font-black text-amber-700 uppercase tracking-wider mb-1">Skrining TBC</span>
                        <span class="text-xl font-black text-amber-600 block">{{ $specialScreeningReferralStats['tbcCount'] }}</span>
                        <span class="text-[9px] font-extrabold text-amber-500 block mt-0.5">{{ $specialScreeningReferralStats['tbcPct'] }}% Gejala</span>
                    </div>

                    <div wire:click="$parent.drillDown('Lansia - Risiko Kesehatan Jiwa', 'lansia_mental_risk', {{ $selectedMonth ?: 'null' }})"
                         class="bg-purple-50/50 border border-purple-100 hover:bg-purple-50/80 hover:border-purple-300 transition-all rounded-2xl p-3 text-center cursor-pointer group/card">
                        <span class="block text-[9px] font-black text-purple-700 uppercase tracking-wider mb-1">Skrining Jiwa</span>
                        <span class="text-xl font-black text-purple-600 block">{{ $specialScreeningReferralStats['mentalCount'] }}</span>
                        <span class="text-[9px] font-extrabold text-purple-500 block mt-0.5">{{ $specialScreeningReferralStats['mentalPct'] }}% Gejala</span>
                    </div>
                </div>

                {{-- Referral Log Table/List --}}
                <div class="mt-2">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        Rujukan Medis Terbaru
                    </h4>
                    <div class="border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/50">
                        @forelse($specialScreeningReferralStats['referrals'] as $ref)
                            <div class="px-4 py-2.5 border-b border-slate-100 last:border-0 flex items-center justify-between text-xs transition-colors hover:bg-slate-50">
                                <div>
                                    <span class="font-extrabold text-slate-800 block">{{ $ref['name'] }}</span>
                                    <span class="text-[10px] text-slate-500 block truncate max-w-[200px]" title="{{ $ref['reason'] }}">{{ $ref['reason'] }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-slate-400 block font-bold text-[10px]">{{ $ref['date'] }}</span>
                                    <span class="text-slate-650 font-black block text-[10px]">{{ $ref['posyandu'] }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-400 text-xs font-semibold">
                                Tidak ada log rujukan medis lansia pada periode ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lansia Metabolic Risk Chart --}}
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200 shadow-xs mt-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">Tren Risiko Metabolik Lansia</h3>
                <p class="text-xs md:text-sm text-slate-500 font-semibold mt-1">Tren prevalensi bulanan risiko kesehatan metabolik pada lansia: Hipertensi, Hiperglikemia, Hiperkolesterolemia, dan Hiperurisemia</p>
            </div>
            <button onclick="downloadChart(lansiaMetabolicChart, 'tren_risiko_metabolik_lansia')" class="shrink-0 p-2.5 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                <span class="material-symbols-outlined text-[20px]">download</span>
            </button>
        </div>

        {{-- Legend badges --}}
        <div class="flex flex-wrap gap-3 mb-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-200/60">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span>
                <span class="text-xs font-bold text-rose-700">Hipertensi (&ge;140/90 mmHg)</span>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200/60">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                <span class="text-xs font-bold text-amber-700">Hiperglikemia (&ge;200 mg/dL)</span>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-blue-50 border border-blue-200/60">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>
                <span class="text-xs font-bold text-blue-700">Hiperkolesterolemia (&ge;200 mg/dL)</span>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-purple-50 border border-purple-200/60">
                <span class="w-2.5 h-2.5 rounded-full bg-purple-500 inline-block"></span>
                <span class="text-xs font-bold text-purple-700">Hiperurisemia (&ge;7.0 mg/dL)</span>
            </div>
        </div>

        <div class="relative h-96">
            <canvas id="lansiaMetabolicChart" wire:ignore></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-lansiaMetabolicChart">
                <span class="material-symbols-outlined text-rose-600 text-4xl mb-2">error</span>
                <p class="text-sm font-extrabold text-slate-800">Gagal memuat data grafik</p>
                <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
            </div>
        </div>
    </div>
</div>
