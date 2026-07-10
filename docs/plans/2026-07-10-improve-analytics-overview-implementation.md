# Peningkatan Halaman Overview Analytics Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Meningkatkan halaman Overview Analytics di Posyandu Kenanga dengan menambahkan widget visualisasi Target vs Realisasi Kehadiran, Ringkasan Status Gizi & Imunisasi Balita, Rangkuman Risiko Kesehatan Lansia & Ibu Hamil, serta Live Health Alerts Feed kasus kritis.

**Architecture:** Data pendukung akan dihitung di backend [Analytics.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Analytics.php) (termasuk query Live Health Alerts yang real-time). Halaman frontend [analytics.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/analytics.blade.php) akan disusun ulang menggunakan layout grid 3 kolom pada desktop untuk menampilkan visualisasi data dalam bentuk progress bar berwarna dinamis, badge risiko kesehatan, dan daftar alert yang dapat diklik.

**Tech Stack:** PHP (Laravel 11), Livewire v3, Alpine.js, Tailwind CSS.

---

### Task 1: Backend Integration & Logic

**Files:**
- Modify: [Analytics.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Analytics.php)
- Test: [AdminAnalyticsTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/AdminAnalyticsTest.php)

**Step 1: Write the failing test**
Tambahkan test baru di `tests/Feature/AdminAnalyticsTest.php` untuk memastikan property `liveHealthAlerts` diset dan menampung data rekam medis berisiko tinggi secara benar:
```php
test('analytics component loads live health alerts for high risk cases', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Pasien Balita berisiko stunting
    $balita = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
        'full_name' => 'Balita Berisiko',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $balita->id,
        'stunting_status' => 'Pendek',
        'visit_date' => now(),
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->assertSet('activeTab', 'overview')
        ->assertPropertyExists('liveHealthAlerts')
        ->assertSee('Balita Berisiko');
});
```

**Step 2: Run test to verify it fails**
Run: `php artisan test tests/Feature/AdminAnalyticsTest.php`
Expected: FAIL karena property `liveHealthAlerts` belum didefinisikan di controller.

**Step 3: Write minimal implementation**
1. Di [Analytics.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Analytics.php), tambahkan property:
   `public array $liveHealthAlerts = [];`
2. Tambahkan method `loadLiveHealthAlerts()`:
   ```php
   protected function loadLiveHealthAlerts(): void
   {
       /** @var \App\Models\User $user */
       $user = Auth::user();
       $posyanduId = $user->isSuperAdmin() ? $this->selectedPosyandu : $user->posyandu_id;

       $alertQuery = MedicalRecord::query()
           ->with(['patient.posyandu'])
           ->where(function ($q) {
               // Balita risk
               $q->where(function ($sub) {
                   $sub->whereHas('patient', fn ($pq) => $pq->whereIn('category', ['balita', 'bayi', 'baduta']))
                       ->where(fn ($sq) => $sq->whereIn('nutrition_status', ['Gizi Buruk', 'Berat Badan Sangat Kurang', 'Sangat Kurang'])
                                               ->orWhereIn('wasting_status', ['Gizi Buruk', 'Sangat Kurang'])
                                               ->orWhereIn('stunting_status', ['Pendek', 'Sangat Pendek']));
               })
               // Ibu Hamil risk
               ->orWhere(function ($sub) {
                   $sub->whereHas('patient', fn ($pq) => $pq->where('category', 'ibu_hamil'))
                       ->where(fn ($sq) => $sq->where('systolic_bp', '>=', 140)
                                               ->orWhere('diastolic_bp', '>=', 90)
                                               ->orWhere(fn ($aq) => $aq->whereNotNull('hemoglobin')->where('hemoglobin', '<', 11)->where('hemoglobin', '>', 0))
                                               ->orWhere(fn ($lq) => $lq->whereNotNull('upper_arm_circumference')->where('upper_arm_circumference', '>', 0)->where('upper_arm_circumference', '<', 23.5)));
               })
               // Lansia risk
               ->orWhere(function ($sub) {
                   $sub->whereHas('patient', fn ($pq) => $pq->where('category', 'lansia'))
                       ->where(fn ($sq) => $sq->where('systolic_bp', '>=', 140)
                                               ->orWhere('diastolic_bp', '>=', 90)
                                               ->orWhere('blood_sugar', '>=', 200)
                                               ->orWhere('cholesterol', '>=', 200)
                                               ->orWhere('uric_acid', '>=', 7.0));
               });
           });

       $alertQuery = $this->applyPosyanduScope($alertQuery, $posyanduId);

       $this->liveHealthAlerts = $alertQuery->orderBy('visit_date', 'desc')
           ->orderBy('id', 'desc')
           ->limit(5)
           ->get()
           ->map(function ($r) {
               $reasons = [];
               $category = $r->patient?->category;

               if (in_array($category, ['balita', 'bayi', 'baduta'])) {
                   $gizi = $r->nutrition_status;
                   $wasting = $r->wasting_status;
                   $stunting = $r->stunting_status;
                   if (in_array($gizi, ['Gizi Buruk', 'Berat Badan Sangat Kurang', 'Sangat Kurang'])) $reasons[] = "BB/U: " . $gizi;
                   if (in_array($wasting, ['Gizi Buruk', 'Sangat Kurang'])) $reasons[] = "Wasting: " . $wasting;
                   if (in_array($stunting, ['Pendek', 'Sangat Pendek'])) $reasons[] = "Stunting: " . $stunting;
               } elseif ($category === 'ibu_hamil') {
                   if ($r->systolic_bp >= 140 || $r->diastolic_bp >= 90) $reasons[] = "Tensi Tinggi: {$r->systolic_bp}/{$r->diastolic_bp} mmHg";
                   if ($r->hemoglobin && $r->hemoglobin < 11 && $r->hemoglobin > 0) $reasons[] = "Anemia (Hb: {$r->hemoglobin} g/dL)";
                   if ($r->upper_arm_circumference && $r->upper_arm_circumference < 23.5 && $r->upper_arm_circumference > 0) $reasons[] = "KEK (LILA: {$r->upper_arm_circumference} cm)";
               } elseif ($category === 'lansia') {
                   if ($r->systolic_bp >= 140 || $r->diastolic_bp >= 90) $reasons[] = "Tensi Tinggi: {$r->systolic_bp}/{$r->diastolic_bp} mmHg";
                   if ($r->blood_sugar >= 200) $reasons[] = "Gula Darah: {$r->blood_sugar} mg/dL";
                   if ($r->cholesterol >= 200) $reasons[] = "Kolesterol: {$r->cholesterol} mg/dL";
                   if ($r->uric_acid >= 7.0) $reasons[] = "Asam Urat: {$r->uric_acid} mg/dL";
               }

               return [
                   'id' => $r->id,
                   'patient_id' => $r->patient_id,
                   'patient_name' => $r->patient?->full_name ?? 'Warga Tanpa Nama',
                   'patient_category' => match($category) {
                       'balita', 'bayi', 'baduta' => 'Balita',
                       'ibu_hamil' => 'Ibu Hamil',
                       'lansia' => 'Lansia',
                       default => ucfirst($category ?? '-')
                   },
                   'posyandu_name' => $r->patient?->posyandu?->name ?? '-',
                   'visit_date' => $r->visit_date ? $r->visit_date->format('d M Y') : '-',
                   'reasons' => $reasons,
               ];
           })->toArray();
   }
   ```
3. Di dalam method `loadData()`, panggil `$this->loadLiveHealthAlerts();` tepat setelah pemrosesan variabel utama selesai (misalnya sebelum data recent records).

**Step 4: Run test to verify it passes**
Run: `php artisan test tests/Feature/AdminAnalyticsTest.php`
Expected: PASS

**Step 5: Commit**
```bash
git add app/Livewire/Admin/Analytics.php tests/Feature/AdminAnalyticsTest.php
git commit -m "feat(analytics): calculate live health alerts at backend"
```

---

### Task 2: Frontend Integration & Grid Layout

**Files:**
- Modify: [analytics.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/analytics.blade.php)

**Step 1: Replace old Overview tab structure**
Ubah bagian `@if($activeTab === 'overview')` di [analytics.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/analytics.blade.php).
Gantikan dengan struktur grid berikut:
```html
    @if($activeTab === 'overview')
        {{-- ================= OVERVIEW TAB ================= --}}
        <div class="space-y-4 sm:space-y-6 animate-fadeIn">
            {{-- Stats Grid: 2 cols mobile, 4 cols desktop --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                ... (KPI Cards yang sudah ada tetap dipertahaman) ...
            </div>

            {{-- New Layout: Grid 3 Kolom responsif (Desktop: 2 kolom utama di kiri, 1 sidebar di kanan) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                
                {{-- Kiri: Analitik Kehadiran & Grafik Tren (Span-2) --}}
                <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                    
                    {{-- Widget 1: Realisasi Kehadiran --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-xs">
                        <div class="mb-4">
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-teal-600 text-[20px]">how_to_reg</span>
                                Target vs Realisasi Kehadiran Pasien
                            </h3>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Persentase keaktifan kunjungan warga terdaftar di periode terpilih</p>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach([
                                ['label' => 'Balita & Anak', 'visited' => $balitaBerkunjung, 'total' => $totalBalita, 'color' => 'bg-teal-500', 'text' => 'text-teal-700', 'bg' => 'bg-teal-50', 'icon' => 'child_care'],
                                ['label' => 'Ibu Hamil', 'visited' => $ibuHamilBerkunjung, 'total' => $totalIbuHamil, 'color' => 'bg-rose-500', 'text' => 'text-rose-700', 'bg' => 'bg-rose-50', 'icon' => 'pregnant_woman'],
                                ['label' => 'Lansia', 'visited' => $lansiaBerkunjung, 'total' => $totalLansia, 'color' => 'bg-indigo-500', 'text' => 'text-indigo-700', 'bg' => 'bg-indigo-50', 'icon' => 'elderly']
                            ] as $item)
                                @php
                                    $pct = $item['total'] > 0 ? round(($item['visited'] / $item['total']) * 100, 1) : 0;
                                    // Dinamis warna bar
                                    $barColor = $pct >= 75 ? 'bg-emerald-500' : ($pct >= 40 ? 'bg-amber-500' : 'bg-rose-500');
                                @endphp
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between text-xs sm:text-sm font-bold text-slate-700">
                                        <span class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px] text-slate-400">{{ $item['icon'] }}</span>
                                            <span>{{ $item['label'] }}</span>
                                        </span>
                                        <span>
                                            <span class="font-extrabold text-slate-900">{{ $pct }}%</span>
                                            <span class="text-slate-400 font-semibold">({{ $item['visited'] }} / {{ $item['total'] }})</span>
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                        <div class="{{ $barColor }} h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Widget 2: Combined Monthly Visits Trend (Grafik yang sudah ada) --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-slate-200 shadow-xs">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                    <span class="material-symbols-outlined text-teal-600 text-[20px]">insights</span>
                                    Tren Kunjungan Bulanan Gabungan
                                </h3>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">Perbandingan tren frekuensi kunjungan pasien per kategori di posyandu</p>
                            </div>
                            <button onclick="downloadChart(visitsTrendChart, 'tren_kunjungan')" class="p-2 text-slate-500 hover:text-slate-800 rounded-xl bg-slate-50 border border-slate-300 transition-colors shadow-xs cursor-pointer flex items-center justify-center" title="Unduh Gambar Grafik">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                            </button>
                        </div>
                        <div class="relative h-80 sm:h-96">
                            <canvas id="visitsTrendChart" wire:ignore></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 rounded-2xl" id="error-visitsTrendChart">
                                <span class="material-symbols-outlined text-rose-600 text-4xl mb-2">error</span>
                                <p class="text-sm font-extrabold text-slate-800">Gagal memuat data grafik</p>
                                <button onclick="initCharts()" class="mt-3 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 cursor-pointer">Coba Lagi</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Rangkuman Indikator Kesehatan & Umpan Kasus Risiko (Span-1) --}}
                <div class="space-y-4 sm:space-y-6">
                    
                    {{-- Widget 3: Rangkuman Indikator Kesehatan Utama --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-xs">
                        <div class="mb-4">
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-teal-600 text-[20px]">clinical_notes</span>
                                Indikator Kesehatan Utama
                            </h3>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Ringkasan parameter klinis pasien dari pemeriksaan terbaru</p>
                        </div>
                        
                        <div class="space-y-4">
                            {{-- Balita --}}
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Balita & Anak
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Prevalensi Stunting</p>
                                        <p class="text-base font-black text-slate-800 mt-0.5">{{ $stuntingRate }}%</p>
                                    </div>
                                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Imunisasi Dasar</p>
                                        <p class="text-base font-black text-slate-800 mt-0.5">{{ $cakupanImunisasi }}%</p>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Ibu Hamil --}}
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ibu Hamil
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Risiko Hipertensi</p>
                                        <p class="text-base font-black text-slate-800 mt-0.5">{{ $hypertensionRiskRate }}%</p>
                                    </div>
                                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Kepatuhan Fe</p>
                                        <p class="text-base font-black text-slate-800 mt-0.5">{{ $feComplianceRate }}%</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Lansia --}}
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Lanjut Usia
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Hipertensi</p>
                                        <p class="text-base font-black text-slate-800 mt-0.5">{{ $lansiaHypertensionRate }}%</p>
                                    </div>
                                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Hiperglikemia</p>
                                        <p class="text-base font-black text-slate-800 mt-0.5">{{ $lansiaHyperglycemiaRate }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Widget 4: Live Health Alerts Feed --}}
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-xs flex flex-col">
                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                    <span class="material-symbols-outlined text-rose-600 text-[20px] animate-pulse">warning</span>
                                    Live Health Alerts
                                </h3>
                                <span class="text-[9px] font-black uppercase tracking-wider bg-rose-50 text-rose-700 px-2 py-0.5 rounded-full border border-rose-200">Kasus Kritis</span>
                            </div>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">5 kasus pemeriksaan berisiko kesehatan tinggi terbaru</p>
                        </div>
                        
                        <div class="space-y-3 flex-1">
                            @forelse($liveHealthAlerts as $alert)
                                <div class="p-3 rounded-xl border border-rose-100 bg-rose-50/30 flex flex-col gap-1.5 transition-all hover:bg-rose-50/60">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-slate-800">{{ $alert['patient_name'] }}</span>
                                        <span class="text-[9px] font-extrabold uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600">
                                            {{ $alert['patient_category'] }}
                                        </span>
                                    </div>
                                    
                                    {{-- Reasons pills --}}
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($alert['reasons'] as $reason)
                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-rose-100 text-rose-700">{{ $reason }}</span>
                                        @endforeach
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-[10px] text-slate-400 font-semibold border-t border-rose-100/50 pt-1.5 mt-0.5">
                                        <span>Pos: {{ $alert['posyandu_name'] }}</span>
                                        <span>{{ $alert['visit_date'] }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 text-center text-slate-400">
                                    <span class="material-symbols-outlined text-emerald-500 text-4xl mb-2">check_circle</span>
                                    <p class="text-xs font-bold text-slate-700">Seluruh Warga Sehat!</p>
                                    <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Tidak terdeteksi adanya kasus berisiko tinggi baru</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
```

**Step 2: Save and Compile**
Pastikan tidak ada sintaks error di PHP Blade.

**Step 3: Commit**
```bash
git add resources/views/livewire/admin/analytics.blade.php
git commit -m "feat(analytics): render target vs realisasi, health summary, and live alerts on Overview tab"
```

---

### Task 3: Verification

**Step 1: Run automated tests**
Run: `php artisan test tests/Feature/AdminAnalyticsTest.php`
Expected: Semua pengujian analytics berjalan dengan sukses (PASS).

**Step 2: Manual testing**
1. Buka halaman `/admin/analytics` di web browser lokal.
2. Verifikasi tab Overview menampilkan 4 kartu KPI, kolom kiri (Kehadiran dan Grafik Tren), dan kolom kanan (Indikator Kesehatan Utama dan Live Health Alerts).
3. Ubah filter Tahun/Bulan/Posyandu di bagian atas, pastikan data Kehadiran dan Indikator Kesehatan ter-update secara dinamis, sementara Live Health Alerts tetap memuat kasus-kasus terbaru (live) di bawah Posyandu terkait.
