# Ibu Hamil Analytics Improvement Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Improve the Ibu Hamil analytics dashboard scorecards to focus on positive health achievements, display clearer progress metrics, and implement a premium visual frontend design.

**Architecture:** Update the computed data in `IbuHamilAnalytics.php` to calculate normal hemoglobin levels and supplement coverage percentages. Then, update the Blade layout in `ibu-hamil-analytics.blade.php` with custom CSS, interactive hover classes, dynamic borders, and a mini progress bar for coverage.

**Tech Stack:** PHP, Laravel, Livewire v3, Tailwind CSS, Alpine.js

---

### Task 1: Write Tests for New Component Data and Behavior

**Files:**
- Modify: [AdminAnalyticsTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/AdminAnalyticsTest.php)

**Step 1: Write the failing test**
We will add a test verifying that the `IbuHamilAnalytics` component correctly computes normal Hb count and TTD coverage percentage, and that it renders these values correctly.

Add the following test at the end of [AdminAnalyticsTest.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/tests/Feature/AdminAnalyticsTest.php):

```php
test('ibu hamil analytics component computes correct health scorecards and coverage metrics', function () {
    $pedukuhan = \App\Models\Pedukuhan::factory()->create();
    $posyandu = \App\Models\Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = \App\Models\User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Patient 1: High risk (Age 18), Hb normal (12), Fe received (1)
    $p1 = \App\Models\Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'status_mutasi' => 'aktif',
        'birth_date' => now()->subYears(18),
    ]);
    \App\Models\MedicalRecord::factory()->create([
        'patient_id' => $p1->id,
        'visit_date' => now(),
        'hemoglobin' => 12,
        'nakes_gives_fe_mms' => 1,
        'height' => 150,
    ]);

    // Patient 2: Normal risk (Age 25), Hb anemia (10), Fe not received (0)
    $p2 = \App\Models\Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'status_mutasi' => 'aktif',
        'birth_date' => now()->subYears(25),
    ]);
    \App\Models\MedicalRecord::factory()->create([
        'patient_id' => $p2->id,
        'visit_date' => now(),
        'hemoglobin' => 10,
        'nakes_gives_fe_mms' => 0,
        'height' => 150,
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Admin\Analytics\IbuHamilAnalytics::class, [
        'selectedYear' => now()->year,
        'selectedMonth' => now()->month,
        'selectedPosyandu' => $posyandu->id
    ])
    ->assertSeeHtml('RISIKO RENDAH')
    ->assertSeeHtml('HEMOGLOBIN SEHAT')
    ->assertSeeHtml('CAKUPAN TTD')
    ->assertSeeHtml('50%'); // 1 out of 2 received Fe (50% coverage)
});
```

**Step 2: Run test to verify it fails**
Run: `php artisan test tests/Feature/AdminAnalyticsTest.php`
Expected: FAIL with missing HTML outputs (like "RISIKO RENDAH" or "HEMOGLOBIN SEHAT").

---

### Task 2: Update Component Code in IbuHamilAnalytics

**Files:**
- Modify: [IbuHamilAnalytics.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Analytics/IbuHamilAnalytics.php)

**Step 1: Modify computed properties and render values**
Update `anemiaStats()` to return details about normal Hb cases:
```php
    // AH-06: Anemia
    #[\Livewire\Attributes\Computed]
    public function anemiaStats()
    {
        $records = $this->applyPosyanduScope(\App\Models\MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $anemia = $records->whereNotNull('hemoglobin')->where('hemoglobin', '<', 11)->count();
        $totalWithHb = $records->whereNotNull('hemoglobin')->count();
        $normal = $totalWithHb - $anemia;

        return [
            'anemia' => $anemia,
            'normal' => $normal,
            'total' => $totalWithHb,
        ];
    }
```

Update `render()` to pass `anemiaStats` array and `anemiaCount` (as integer count for backwards-compatibility):
```php
    public function render()
    {
        $anemiaData = $this->anemiaStats();

        return view('livewire.admin.analytics.ibu-hamil-analytics', [
            'trimesterStats' => $this->trimesterStats(),
            'riskStats' => $this->riskStats(),
            'anemiaCount' => $anemiaData['anemia'],
            'anemiaStats' => $anemiaData,
            'ttdStats' => $this->ttdStats(),
            'ancStats' => $this->ancStats(),
        ]);
    }
```

**Step 2: Run test to verify it still fails**
Run: `php artisan test tests/Feature/AdminAnalyticsTest.php`
Expected: Still FAIL with missing HTML outputs (blade file is not modified yet).

**Step 3: Commit component change**
Run: `git commit -am "feat: update IbuHamilAnalytics component to compute normal Hb stats"`

---

### Task 3: Implement Premium Design in Blade File

**Files:**
- Modify: [ibu-hamil-analytics.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/analytics/ibu-hamil-analytics.blade.php)

**Step 1: Implement new design and texts**
We will replace the three scorecard cards with our new health scorecard design:
- Card 1: **Tingkat Keamanan Kehamilan**
  - Show `$riskStats['normal']` as the main number of low-risk/normal pregnancies.
  - Calculate normal percentage: `($total = $riskStats['normal'] + $riskStats['highRisk']) > 0 ? round(($riskStats['normal'] / $total) * 100) : 100`.
  - Display `$riskStats['highRisk']` in the bottom bar as a warning.
- Card 2: **Indeks Hemoglobin Sehat**
  - Show `$anemiaStats['normal']` as the main number of normal Hb pregnancies.
  - Calculate normal percentage: `$anemiaStats['total'] > 0 ? round(($anemiaStats['normal'] / $anemiaStats['total']) * 100) : 100`.
  - Display `$anemiaStats['anemia']` in the bottom bar as a warning.
- Card 3: **Cakupan Suplemen Fe & MMS**
  - Calculate coverage percentage: `($total = $ttdStats['received'] + $ttdStats['notReceived']) > 0 ? round(($ttdStats['received'] / $total) * 100) : 0`.
  - Show this percentage as the main number.
  - Display a sleek CSS progress bar mapping this percentage.
  - Display `$ttdStats['notReceived']` in the bottom bar as a warning.

Let's use beautiful icons (`shield` for security/protection, `bloodtype` or `water_drop` for Hb/blood, `pill` or `medication` for TTD).
We will add high quality style variants and hover transition effects.

**Step 2: Run test to verify it passes**
Run: `php artisan test tests/Feature/AdminAnalyticsTest.php`
Expected: PASS

**Step 3: Commit Blade changes**
Run: `git commit -am "feat: implement premium card designs and copywriting for Ibu Hamil analytics"`
