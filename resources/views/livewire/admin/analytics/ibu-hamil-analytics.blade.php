<div>
    <div class="space-y-8 animate-fadeIn">
        {{-- Stats Grid Ibu Hamil --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Card 1: 4T Risk --}}
            <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-amber-400 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-[28px]">warning</span>
                    </div>
                    <span class="text-label-sm text-outline uppercase tracking-wider">Risiko 4T</span>
                </div>
                <div class="space-y-1">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-on-surface tracking-tight">{{ $riskStats['highRisk'] }}</span>
                        <span class="text-body-sm font-semibold text-outline">Ibu</span>
                    </div>
                    <h4 class="text-body-md font-bold text-on-surface">Risiko Tinggi Terdeteksi</h4>
                    <p class="text-xs text-outline leading-relaxed">Kader disarankan memantau riwayat usia (<20 atau >35) dan tinggi badan (<145 cm).</p>
                </div>
                <div class="mt-4 pt-3 border-t border-outline-variant/10 flex justify-between text-[11px] font-bold text-outline">
                    <span>Kondisi Normal:</span>
                    <span class="text-on-surface font-extrabold">{{ $riskStats['normal'] }} Ibu</span>
                </div>
            </div>
    
            {{-- Card 2: Anemia Cases --}}
            <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-rose-450 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-error-container text-error flex items-center justify-center border border-rose-100 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-[28px]">water_drop</span>
                    </div>
                    <span class="text-label-sm text-outline uppercase tracking-wider">Kasus Anemia</span>
                </div>
                <div class="space-y-1">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-on-surface tracking-tight">{{ $anemiaCount }}</span>
                        <span class="text-body-sm font-semibold text-outline">Ibu</span>
                    </div>
                    <h4 class="text-body-md font-bold text-on-surface">Defisiensi Hemoglobin</h4>
                    <p class="text-xs text-outline leading-relaxed">Kadar Hb di bawah 11 g/dL berdasarkan hasil pemeriksaan klinis terbaru.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-outline-variant/10 text-[11px] font-bold text-outline">
                    Terdeteksi dari rekam medis periode ini
                </div>
            </div>
    
            {{-- Card 3: Tablet Fe --}}
            <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-teal-400 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center border border-teal-100 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-[28px]">pill</span>
                    </div>
                    <span class="text-label-sm text-outline uppercase tracking-wider">Pemberian TTD</span>
                </div>
                <div class="space-y-1">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-on-surface tracking-tight">{{ $ttdStats['received'] }}</span>
                        <span class="text-body-sm font-semibold text-outline">Ibu</span>
                    </div>
                    <h4 class="text-body-md font-bold text-on-surface">Tablet Fe / MMS Diterima</h4>
                    <p class="text-xs text-outline leading-relaxed">Ibu hamil yang telah mendapatkan suplemen penambah darah dari kader/nakes.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-outline-variant/10 flex justify-between text-[11px] font-bold text-outline">
                    <span>Belum Menerima:</span>
                    <span class="text-on-surface font-extrabold">{{ $ttdStats['notReceived'] }} Ibu</span>
                </div>
            </div>

            {{-- Card 4: KEK Risk (New) --}}
            <div class="relative overflow-hidden bg-white/85 backdrop-blur-md rounded-2xl p-6 border border-outline-variant/40 shadow-md transition-all duration-300 hover:shadow-lg hover:border-indigo-400 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-secondary-container text-secondary flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-[28px]">clinical_notes</span>
                    </div>
                    <span class="text-label-sm text-outline uppercase tracking-wider">Risiko KEK</span>
                </div>
                <div class="space-y-1">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-on-surface tracking-tight">{{ $kekStats['kek'] }}</span>
                        <span class="text-body-sm font-semibold text-outline">Ibu</span>
                    </div>
                    <h4 class="text-body-md font-bold text-on-surface">Kurang Energi Kronis</h4>
                    <p class="text-xs text-outline leading-relaxed">Pengukuran Lingkar Lengan Atas (LiLA) di bawah batas aman 23.5 cm.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-outline-variant/10 flex justify-between text-[11px] font-bold text-outline">
                    <span>LiLA Aman:</span>
                    <span class="text-on-surface font-extrabold">{{ $kekStats['normal'] }} Ibu</span>
                </div>
            </div>
        </div>

        {{-- Row 2: Detail Distribusi & Kunjungan --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">
            
            {{-- Trimester Distribution --}}
            <div class="lg:col-span-5 bg-white/80 backdrop-blur-md rounded-2xl p-8 border border-outline-variant/40 shadow-md flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-error text-[26px]">pregnant_woman</span>
                        <h3 class="text-body-lg font-bold text-on-surface">Tahapan Kehamilan (Trimester)</h3>
                    </div>
                    <p class="text-sm text-outline font-medium mb-6">Distribusi usia kehamilan berdasarkan kunjungan di periode ini</p>
                    
                    <div class="space-y-5">
                        @php
                            $tTotal = array_sum($trimesterStats);
                            $t1Pct = $tTotal > 0 ? round(($trimesterStats['T1'] / $tTotal) * 100) : 0;
                            $t2Pct = $tTotal > 0 ? round(($trimesterStats['T2'] / $tTotal) * 100) : 0;
                            $t3Pct = $tTotal > 0 ? round(($trimesterStats['T3'] / $tTotal) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                                <span>Trimester I <span class="text-xs font-semibold text-outline">(1 - 13 Mg)</span></span>
                                <span class="text-on-surface font-extrabold">{{ $trimesterStats['T1'] }} Ibu ({{ $t1Pct }}%)</span>
                            </div>
                            <div class="h-3.5 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                                <div class="h-full bg-linear-to-r from-rose-300 to-rose-450 rounded-lg transition-all duration-500" style="width: {{ $t1Pct }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                                <span>Trimester II <span class="text-xs font-semibold text-outline">(14 - 27 Mg)</span></span>
                                <span class="text-on-surface font-extrabold">{{ $trimesterStats['T2'] }} Ibu ({{ $t2Pct }}%)</span>
                            </div>
                            <div class="h-3.5 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                                <div class="h-full bg-linear-to-r from-rose-400 to-rose-550 rounded-lg transition-all duration-500" style="width: {{ $t2Pct }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-sm font-bold text-on-surface-variant mb-2">
                                <span>Trimester III <span class="text-xs font-semibold text-outline">(&ge; 28 Mg)</span></span>
                                <span class="text-on-surface font-extrabold">{{ $trimesterStats['T3'] }} Ibu ({{ $t3Pct }}%)</span>
                            </div>
                            <div class="h-3.5 w-full bg-surface-container rounded-lg overflow-hidden p-0.5 border border-outline-variant/10">
                                <div class="h-full bg-linear-to-r from-rose-500 to-rose-700 rounded-lg transition-all duration-500" style="width: {{ $t3Pct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
            {{-- ANC K1-K6 --}}
            <div class="lg:col-span-7 bg-white/80 backdrop-blur-md rounded-2xl p-8 border border-outline-variant/40 shadow-md flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-indigo-500 text-[26px]">stethoscope</span>
                        <h3 class="text-body-lg font-bold text-on-surface">Kepatuhan Kunjungan ANC</h3>
                    </div>
                    <p class="text-sm text-outline font-medium mb-6">Jumlah ibu hamil aktif yang telah melengkapi rekam medis kunjungan K1 s.d. K6</p>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach([
                            'k1' => ['label' => 'K1', 'desc' => 'Pertama'], 
                            'k2' => ['label' => 'K2', 'desc' => 'Kedua'], 
                            'k3' => ['label' => 'K3', 'desc' => 'Ketiga'], 
                            'k4' => ['label' => 'K4', 'desc' => 'Keempat'], 
                            'k5' => ['label' => 'K5', 'desc' => 'Kelima'], 
                            'k6' => ['label' => 'K6', 'desc' => 'Keenam']
                        ] as $key => $meta)
                        <div class="p-4 bg-surface-container-lowest border border-outline-variant/35 rounded-2xl flex flex-col justify-between shadow-xs hover:border-indigo-400 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-secondary bg-secondary-container px-2 py-0.5 rounded-md">{{ $meta['label'] }}</span>
                                <span class="text-[10px] text-outline font-semibold">{{ $meta['desc'] }}</span>
                            </div>
                            <div class="text-headline-md font-black text-on-surface mt-3 flex items-baseline gap-1">
                                {{ $ancStats[$key] ?? 0 }}
                                <span class="text-xs font-semibold text-outline">Ibu</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    
        {{-- Pregnancy Risk Trend Chart --}}
        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 border border-outline-variant/40 shadow-md mt-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-body-lg font-bold text-on-surface">Tren Kepatuhan & Risiko Ibu Hamil</h3>
                    <p class="text-xs text-outline font-medium mt-1">Menampilkan visualisasi tren bulanan data kepatuhan Tablet Fe dan Risiko Hipertensi</p>
                </div>
                <button onclick="downloadChart(pregnancyRiskChart, 'tren_risiko_ibu_hamil')" class="p-2.5 text-outline hover:text-on-surface rounded-xl bg-surface-container-low border border-outline-variant transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                </button>
            </div>
            <div class="relative h-96">
                <canvas id="pregnancyRiskChart" wire:ignore></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-pregnancyRiskChart">
                    <span class="material-symbols-outlined text-rose-650 text-4xl mb-2">error</span>
                    <p class="text-sm font-extrabold text-on-surface">Gagal memuat data grafik</p>
                    <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-inverse-surface text-white rounded-xl text-label-sm tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
                </div>
            </div>
        </div>
    </div>
</div>
