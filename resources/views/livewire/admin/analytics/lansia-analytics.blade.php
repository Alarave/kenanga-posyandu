<div class="space-y-8 animate-fadeIn">
    {{-- Metabolic Risks Grid (AL-03 to AL-06) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Hipertensi --}}
        <div class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-350 group">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100/50 shadow-xs transition-transform duration-300 group-hover:scale-105">
                        <span class="material-symbols-outlined text-[24px]">monitor_heart</span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-105/60 px-2 py-0.5 rounded-md font-sans">Hipertensi</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $metabolicRisks['hipertensi'] }}</span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-3 leading-relaxed">Lansia dengan tekanan darah &ge; 140/90 mmHg</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-105 text-[10px] font-black text-slate-400 uppercase tracking-wide">
                *Terdeteksi otomatis rekam medis
            </div>
        </div>

        {{-- Hiperglikemia --}}
        <div class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-350 group">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100/50 shadow-xs transition-transform duration-300 group-hover:scale-105">
                        <span class="material-symbols-outlined text-[24px]">bloodtype</span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-105/60 px-2 py-0.5 rounded-md">Gula Darah</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $metabolicRisks['gula'] }}</span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-3 leading-relaxed">Lansia dengan kadar GDS/Gula Darah &ge; 200 mg/dL</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-105 text-[10px] font-black text-slate-400 uppercase tracking-wide">
                *Kasus hiperglikemia aktif
            </div>
        </div>

        {{-- Kolesterol Tinggi --}}
        <div class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-350 group">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100/50 shadow-xs transition-transform duration-300 group-hover:scale-105">
                        <span class="material-symbols-outlined text-[24px]">heart_broken</span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-105/60 px-2 py-0.5 rounded-md">Kolesterol</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $metabolicRisks['kolesterol'] }}</span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-3 leading-relaxed">Lansia dengan kadar Kolesterol &ge; 200 mg/dL</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-105 text-[10px] font-black text-slate-400 uppercase tracking-wide">
                *Pemeriksaan berkala
            </div>
        </div>

        {{-- Asam Urat Tinggi --}}
        <div class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-350 group">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100/50 shadow-xs transition-transform duration-300 group-hover:scale-105">
                        <span class="material-symbols-outlined text-[24px]">medical_services</span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-105/60 px-2 py-0.5 rounded-md">Asam Urat</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $metabolicRisks['asamUrat'] }}</span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lansia</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-3 leading-relaxed">Lansia dengan kadar Asam Urat &ge; 7.0 mg/dL</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-105 text-[10px] font-black text-slate-400 uppercase tracking-wide">
                *Deteksi pencegahan gout
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
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span>Pra-Lansia (45 - 59 Tahun)</span>
                            <span class="text-slate-900 font-extrabold">{{ $ageCategories['pra'] }} Jiwa ({{ $praPct }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-400 rounded-full" style="width: {{ $praPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span>Lansia (60 - 69 Tahun)</span>
                            <span class="text-slate-900 font-extrabold">{{ $ageCategories['lansia'] }} Jiwa ({{ $lanPct }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $lanPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span>Lansia Risiko Tinggi (70+ Tahun)</span>
                            <span class="text-slate-900 font-extrabold">{{ $ageCategories['resti'] }} Jiwa ({{ $resPct }}%)</span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-650 rounded-full" style="width: {{ $resPct }}%"></div>
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
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span>Kekurangan Berat (IMT &lt; 18.5)</span>
                            <span class="text-slate-900 font-extrabold">{{ $imtStats['kurang'] }} Jiwa ({{ $kurangPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $kurangPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span>Berat Badan Normal (18.5 - 24.9)</span>
                            <span class="text-slate-900 font-extrabold">{{ $imtStats['normal'] }} Jiwa ({{ $normalPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-teal-500 rounded-full" style="width: {{ $normalPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span>Kelebihan Berat (25.0 - 26.9)</span>
                            <span class="text-slate-900 font-extrabold">{{ $imtStats['lebih'] }} Jiwa ({{ $lebihPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-orange-400 rounded-full" style="width: {{ $lebihPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1">
                            <span>Obesitas (IMT &ge; 27)</span>
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
