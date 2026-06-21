# Merge Immunization Card View Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Merge the immunization coverage stats into the immunization card header on the child profile page and remove the duplicate coverage stats card from the quick stats row.

**Architecture:** We will modify `details/balita.blade.php` to calculate and render the immunization coverage ratio and completeness status badge in the card's header, and modify `growth-chart.blade.php` to remove the coverage card and change the quick stats grid from 3 to 2 columns.

**Tech Stack:** Laravel, Livewire, Tailwind CSS, Blade Templates

---

### Task 1: Update Immunization Card in Balita Details View

**Files:**
- Modify: `resources/views/livewire/admin/patient-management/details/balita.blade.php`
- Test: `tests/Feature/GrowthChartTest.php`

**Step 1: Write the failing test**

We will append a new test at the end of `tests/Feature/GrowthChartTest.php` that verifies that the immunization card displays the merged coverage and completeness status.

Add code to `tests/Feature/GrowthChartTest.php`:
```php
it('displays immunization completeness status and coverage in the immunization card header', function () {
    // Create a balita patient
    $patient = \App\Models\Patient::factory()->create([
        'posyandu_id' => $this->posyandu->id,
        'category' => 'balita',
        'birth_date' => now()->subMonths(6),
    ]);

    // Create one medical record with immunization
    \App\Models\MedicalRecord::factory()->create([
        'patient_id' => $patient->id,
        'user_id' => $this->admin->id,
        'visit_date' => now()->subMonths(2),
        'weight' => 7.5,
        'height' => 65.0,
        'immunization' => 'HB-0',
    ]);

    // Visit patient detail page
    $this->actingAs($this->admin)
        ->get(route('admin.patients.show', $patient))
        ->assertOk()
        ->assertSee('Kartu Imunisasi')
        ->assertSee('Belum Lengkap')
        ->assertSee('1 / 6 Vaksin');
});
```

**Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/GrowthChartTest.php`
Expected: FAIL because `details/balita.blade.php` does not calculate or show the status/ratio yet.

**Step 3: Write implementation**

Modify `resources/views/livewire/admin/patient-management/details/balita.blade.php` to:
1. Calculate `$receivedCount` and `$totalCount` at the top of the file:
```php
@php
    $receivedCount = 0;
    $totalCount = 0;
    $immunizationStatus = $patient->getImmunizationStatus();
    foreach ($immunizationStatus as $group) {
        foreach ($group['vaccines'] as $vax) {
            if ($vax['is_due']) {
                $totalCount++;
            }
            if ($vax['received']) {
                $receivedCount++;
            }
        }
    }
    if ($totalCount === 0) {
        $totalCount = 12;
    }
@endphp
```
2. Update the "Kartu Imunisasi" header layout to render the count and the status badge.

**Step 4: Run test to verify it passes**

Run: `php artisan test tests/Feature/GrowthChartTest.php`
Expected: PASS

**Step 5: Commit**

```bash
git add resources/views/livewire/admin/patient-management/details/balita.blade.php tests/Feature/GrowthChartTest.php
git commit -m "feat(patient-details): merge immunization coverage into immunization card header"
```

---

### Task 2: Remove Duplicate Stats Card from Growth Chart Quick Stats Row

**Files:**
- Modify: `resources/views/livewire/admin/patient-management/growth-chart.blade.php`
- Test: `tests/Feature/GrowthChartTest.php`

**Step 1: Write the failing/verifying test**

Append a new test to verify that the duplicate stats card is not shown in the growth chart.

Add code to `tests/Feature/GrowthChartTest.php`:
```php
it('does not display the duplicate immunization coverage card in growth chart quick stats', function () {
    // Create a balita patient
    $patient = \App\Models\Patient::factory()->create([
        'posyandu_id' => $this->posyandu->id,
        'category' => 'balita',
        'birth_date' => now()->subMonths(6),
    ]);

    // Test Livewire component does not render the stats card or contains only the remaining two cards
    \Livewire\Livewire::actingAs($this->admin)
        ->test(GrowthChart::class, ['patient' => $patient])
        ->assertDontSee('Capaian Imunisasi');
});
```

**Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/GrowthChartTest.php`
Expected: FAIL because "Capaian Imunisasi" is still rendered in `growth-chart.blade.php`.

**Step 3: Write implementation**

Modify `resources/views/livewire/admin/patient-management/growth-chart.blade.php`:
1. Remove the "Capaian Imunisasi" card from the stats grid.
2. Change the stats grid class from `grid-cols-1 md:grid-cols-3` to `grid-cols-1 md:grid-cols-2`.
3. Clean up the `$receivedCount` and `$totalCount` calculation logic at the top of the file.

**Step 4: Run test to verify it passes**

Run: `php artisan test tests/Feature/GrowthChartTest.php`
Expected: PASS

**Step 5: Commit**

```bash
git add resources/views/livewire/admin/patient-management/growth-chart.blade.php tests/Feature/GrowthChartTest.php
git commit -m "refactor(growth-chart): remove duplicate immunization coverage stats card"
```
