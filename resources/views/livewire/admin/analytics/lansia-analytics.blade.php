<div class="space-y-8 animate-fadeIn">
    {{-- Metabolic Risks Grid (AL-03 to AL-06) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Hipertensi --}}
        <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-rose-450 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-error-container text-error flex items-center justify-center border border-rose-100 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-[26px]">monitor_heart</span>
                </div>
                <span class="text-label-sm text-outline uppercase tracking-wider">Hipertensi</span>
            </div>
            <div class="space-y-1">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-on-surface tracking-tight">{{ $metabolicRisks['hipertensi'] }}</span>
                    <span class="text-body-sm font-semibold text-outline">Lansia</span>
                </div>
                <h4 class="text-body-md font-bold text-on-surface">Tekanan Darah Tinggi</h4>
                <p class="text-xs text-outline leading-relaxed">Kasus dengan TD &ge; 140/90 mmHg terdeteksi pada pemeriksaan rekam medis periode ini.</p>
            </div>
            <div class="mt-4 pt-3 border-t border-outline-variant/10 text-[11px] font-bold text-outline">
                Skrining kardiovaskular berkala
            </div>
        </div>
 
        {{-- Hiperglikemia --}}
        <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-amber-400 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-[26px]">bloodtype</span>
                </div>
                <span class="text-label-sm text-outline uppercase tracking-wider">Gula Darah Tinggi</span>
            </div>
            <div class="space-y-1">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-on-surface tracking-tight">{{ $metabolicRisks['gula'] }}</span>
                    <span class="text-body-sm font-semibold text-outline">Lansia</span>
                </div>
                <h4 class="text-body-md font-bold text-on-surface">Hiperglikemia</h4>
                <p class="text-xs text-outline leading-relaxed">Lansia dengan kadar Gula Darah Sewaktu (GDS) &ge; 200 mg/dL pada periode ini.</p>
            </div>
            <div class="mt-4 pt-3 border-t border-outline-variant/10 text-[11px] font-bold text-outline">
                Deteksi risiko diabetes mellitus
            </div>
        </div>
 
        {{-- Kolesterol Tinggi --}}
        <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-blue-400 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-secondary flex items-center justify-center border border-blue-100 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-[26px]">heart_broken</span>
                </div>
                <span class="text-label-sm text-outline uppercase tracking-wider">Kolesterol Tinggi</span>
            </div>
            <div class="space-y-1">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-on-surface tracking-tight">{{ $metabolicRisks['kolesterol'] }}</span>
                    <span class="text-body-sm font-semibold text-outline">Lansia</span>
                </div>
                <h4 class="text-body-md font-bold text-on-surface">Hiperkolesterolemia</h4>
                <p class="text-xs text-outline leading-relaxed">Lansia dengan kadar kolesterol total &ge; 200 mg/dL hasil uji laboratorium.</p>
            </div>
            <div class="mt-4 pt-3 border-t border-outline-variant/10 text-[11px] font-bold text-outline">
                Pemantauan lipid darah rutin
            </div>
        </div>
 
        {{-- Asam Urat Tinggi --}}
        <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-purple-400 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-650 flex items-center justify-center border border-purple-100 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-[26px]">medical_services</span>
                </div>
                <span class="text-label-sm text-outline uppercase tracking-wider">Asam Urat Tinggi</span>
            </div>
            <div class="space-y-1">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-on-surface tracking-tight">{{ $metabolicRisks['asamUrat'] }}</span>
                    <span class="text-body-sm font-semibold text-outline">Lansia</span>
                </div>
                <h4 class="text-body-md font-bold text-on-surface">Hiperurisemia</h4>
                <p class="text-xs text-outline leading-relaxed">Kadar asam urat &ge; 7.0 mg/dL terdeteksi pada pemeriksaan periode ini.</p>
            </div>
            <div class="mt-4 pt-3 border-t border-outline-variant/10 text-[11px] font-bold text-outline">
                Pencegahan penyakit gout arthritis
            </div>
        </div>
    </div>
 
    {{-- Demographic, IMT & Independence Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        
        {{-- AL-01: Kategori Umur --}}
        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 border border-outline-variant/40 shadow-md flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-secondary text-[26px]">badge</span>
                    <h3 class="text-body-lg font-bold text-on-surface">Kategori Usia Lansia</h3>
                </div>
                <p class="text-sm text-outline font-medium mb-6">Kelompok usia lansia yang melakukan kunjungan di periode ini</p>
                
                <div class="space-y-5">
                    @php
                        $uTotal = array_sum($ageCategories);
                        $praPct = $uTotal > 0 ? round(($ageCategories['pra'] / $uTotal) * 100) : 0;
                        $lanPct = $uTotal > 0 ? round(($ageCategories['lansia'] / $uTotal) * 100) : 0;
                        $resPct = $uTotal > 0 ? round(($ageCategories['resti'] / $uTotal) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                            <span>Pra-Lansia <span class="text-xs font-semibold text-outline">(45 - 59 Th)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $ageCategories['pra'] }} Jiwa ({{ $praPct }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-indigo-400 rounded-lg transition-all duration-500" style="width: {{ $praPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                            <span>Lansia <span class="text-xs font-semibold text-outline">(60 - 69 Th)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $ageCategories['lansia'] }} Jiwa ({{ $lanPct }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-indigo-550 rounded-lg transition-all duration-500" style="width: {{ $lanPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                            <span>Lansia Risti <span class="text-xs font-semibold text-outline">(70+ Th)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $ageCategories['resti'] }} Jiwa ({{ $resPct }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-indigo-750 rounded-lg transition-all duration-500" style="width: {{ $resPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        {{-- AL-02: IMT --}}
        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 border border-outline-variant/40 shadow-md flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary text-[26px]">scale</span>
                    <h3 class="text-body-lg font-bold text-on-surface">Indeks Massa Tubuh (IMT)</h3>
                </div>
                <p class="text-sm text-outline font-medium mb-6">Status berat badan lansia berdasarkan data pemeriksaan terbaru</p>
                
                <div class="space-y-4">
                    @php
                        $imtTotal = array_sum($imtStats);
                        $kurangPct = $imtTotal > 0 ? round(($imtStats['kurang'] / $imtTotal) * 100) : 0;
                        $normalPct = $imtTotal > 0 ? round(($imtStats['normal'] / $imtTotal) * 100) : 0;
                        $lebihPct = $imtTotal > 0 ? round(($imtStats['lebih'] / $imtTotal) * 100) : 0;
                        $obesitasPct = $imtTotal > 0 ? round(($imtStats['obesitas'] / $imtTotal) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-on-surface-variant mb-1.5">
                            <span>Kekurangan <span class="text-[10px] text-outline font-semibold">(IMT &lt; 18.5)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $imtStats['kurang'] }} Jiwa ({{ $kurangPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-amber-400 rounded-lg transition-all duration-500" style="width: {{ $kurangPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-on-surface-variant mb-1.5">
                            <span>Normal <span class="text-[10px] text-outline font-semibold">(18.5 - 24.9)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $imtStats['normal'] }} Jiwa ({{ $normalPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-primary rounded-lg transition-all duration-500" style="width: {{ $normalPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-on-surface-variant mb-1.5">
                            <span>Kelebihan <span class="text-[10px] text-outline font-semibold">(25.0 - 26.9)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $imtStats['lebih'] }} Jiwa ({{ $lebihPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-orange-400 rounded-lg transition-all duration-500" style="width: {{ $lebihPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-on-surface-variant mb-1.5">
                            <span>Obesitas <span class="text-[10px] text-outline font-semibold">(&ge; 27)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $imtStats['obesitas'] }} Jiwa ({{ $obesitasPct }}%)</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-rose-500 rounded-lg transition-all duration-500" style="width: {{ $obesitasPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        {{-- AL-07: Kemandirian --}}
        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 border border-outline-variant/40 shadow-md flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-amber-500 text-[26px]">accessibility_new</span>
                    <h3 class="text-body-lg font-bold text-on-surface">Tingkat Kemandirian</h3>
                </div>
                <p class="text-sm text-outline font-medium mb-6">Status tingkat aktivitas fungsional harian dari lansia berkunjung</p>
                
                <div class="space-y-5">
                    @php
                        $indTotal = array_sum($independenceStats);
                        $aPct = $indTotal > 0 ? round(($independenceStats['a'] / $indTotal) * 100) : 0;
                        $bPct = $indTotal > 0 ? round(($independenceStats['b'] / $indTotal) * 100) : 0;
                        $cPct = $indTotal > 0 ? round(($independenceStats['c'] / $indTotal) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                            <span>Kategori A <span class="text-xs font-semibold text-outline">(Mandiri Penuh)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $independenceStats['a'] }} Jiwa ({{ $aPct }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-primary rounded-lg transition-all duration-500" style="width: {{ $aPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                            <span>Kategori B <span class="text-xs font-semibold text-outline">(Ketergantungan Sebagian)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $independenceStats['b'] }} Jiwa ({{ $bPct }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-amber-500 rounded-lg transition-all duration-500" style="width: {{ $bPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                            <span>Kategori C <span class="text-xs font-semibold text-outline">(Ketergantungan Total)</span></span>
                            <span class="text-on-surface font-extrabold">{{ $independenceStats['c'] }} Jiwa ({{ $cPct }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                            <div class="h-full bg-rose-500 rounded-lg transition-all duration-500" style="width: {{ $cPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    {{-- Lansia Metabolic Risk Chart --}}
    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 border border-outline-variant/40 shadow-md mt-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-body-lg font-bold text-on-surface">Tren Risiko Metabolik Lansia</h3>
                <p class="text-xs text-outline font-medium mt-1">Komparasi data historis kasus Hipertensi, Gula Darah, Kolesterol, dan Asam Urat Tinggi</p>
            </div>
            <button onclick="downloadChart(lansiaMetabolicChart, 'tren_risiko_metabolik_lansia')" class="p-2.5 text-outline hover:text-on-surface rounded-xl bg-surface-container-low border border-outline-variant transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                <span class="material-symbols-outlined text-[18px]">download</span>
            </button>
        </div>
        <div class="relative h-96">
            <canvas id="lansiaMetabolicChart" wire:ignore></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-lansiaMetabolicChart">
                <span class="material-symbols-outlined text-rose-650 text-4xl mb-2">error</span>
                <p class="text-sm font-extrabold text-on-surface">Gagal memuat data grafik</p>
                <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-inverse-surface text-white rounded-xl text-label-sm tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
            </div>
        </div>
    </div>
</div>
