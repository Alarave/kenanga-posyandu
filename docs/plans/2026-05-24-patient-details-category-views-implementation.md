# [Feature Name] Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Render a customized profile detail page for each patient category (Balita/Children, Ibu Hamil/Pregnant Mothers, Lansia/Elderly, and General/Others) on `/admin/patients/{id}`, utilizing a dynamic theme engine and clean, isolated Blade partial views.

**Architecture:** We will define a dynamic theme mapping variable at the top of the main `details.blade.php` template. Based on the patient's category, we will apply themed CSS classes and render the appropriate Blade partial using `@include`.

**Tech Stack:** Laravel, Tailwind CSS, Blade Templates, Livewire (for embedded growth charts)

---

### Task 1: Dynamic Theme Setup in Main View
**Files:**
- Modify: `resources/views/livewire/admin/patient-management/details.blade.php`

**Step 1: Write failing test**
In `tests/Feature/Admin/PatientManagementTest.php`, add:
```php
it('menampilkan tema warna sesuai kategori pasien', function () {
    $this->actingAs($this->admin1);
    
    // Test Balita
    $this->patient1->update(['category' => 'balita']);
    $response = $this->get("/admin/patients/{$this->patient1->id}");
    $response->assertSee('from-teal-600 to-emerald-500');

    // Test Lansia
    $this->patient1->update(['category' => 'lansia']);
    $response = $this->get("/admin/patients/{$this->patient1->id}");
    $response->assertSee('from-amber-600 to-orange-500');

    // Test Ibu Hamil
    $this->patient1->update(['category' => 'ibu_hamil']);
    $response = $this->get("/admin/patients/{$this->patient1->id}");
    $response->assertSee('from-rose-500 to-pink-500');
});
```

**Step 2: Run test to verify failure**
Run: `php artisan test --filter="menampilkan tema warna sesuai kategori pasien"`
Expected: FAIL (cannot find specific gradient themes on the page)

**Step 3: Implement dynamic theme logic**
Define the theme config mapping array at the top of `details.blade.php` and replace hardcoded teal styling classes with `$theme['gradient']`, `$theme['text']`, `$theme['shadow']`, and `$theme['bg-light']`.

**Step 4: Run test to verify it passes**
Run: `php artisan test --filter="menampilkan tema warna sesuai kategori pasien"`
Expected: PASS

**Step 5: Commit**
```bash
git add resources/views/livewire/admin/patient-management/details.blade.php tests/Feature/Admin/PatientManagementTest.php
git commit -m "feat(patients): implement dynamic theme colors based on patient category"
```

---

### Task 2: Implement Balita Blade Partial
**Files:**
- Create: `resources/views/livewire/admin/patient-management/details/balita.blade.php`
- Modify: `resources/views/livewire/admin/patient-management/details.blade.php`

**Step 1: Write failing test**
In `tests/Feature/Admin/PatientManagementTest.php`, add:
```php
it('menampilkan detail spesifik balita', function () {
    $this->actingAs($this->admin1);
    $this->patient1->update([
        'category' => 'balita',
        'father_name' => 'Ayah Antigravity',
        'mother_name' => 'Ibu Antigravity',
        'kia_book_ownership' => true
    ]);
    
    $response = $this->get("/admin/patients/{$this->patient1->id}");
    $response->assertSee('Ayah Antigravity');
    $response->assertSee('Ibu Antigravity');
    $response->assertSee('Buku KIA');
    $response->assertSee('Kartu Imunisasi');
});
```

**Step 2: Run test to verify failure**
Run: `php artisan test --filter="menampilkan detail spesifik balita"`
Expected: FAIL

**Step 3: Implement Balita partial view**
Create `resources/views/livewire/admin/patient-management/details/balita.blade.php` and move child-specific content there. In `details.blade.php`, include it conditionally:
```php
@include('livewire.admin.patient-management.details.' . $theme['partial'])
```

**Step 4: Run test to verify it passes**
Run: `php artisan test --filter="menampilkan detail spesifik balita"`
Expected: PASS

**Step 5: Commit**
```bash
git add resources/views/livewire/admin/patient-management/details/balita.blade.php resources/views/livewire/admin/patient-management/details.blade.php
git commit -m "feat(patients): implement Balita patient details partial view"
```

---

### Task 3: Implement Lansia Blade Partial
**Files:**
- Create: `resources/views/livewire/admin/patient-management/details/lansia.blade.php`

**Step 1: Write failing test**
In `tests/Feature/Admin/PatientManagementTest.php`, add:
```php
it('menampilkan detail spesifik lansia', function () {
    $this->actingAs($this->admin1);
    $this->patient1->update([
        'category' => 'lansia',
        'historical_diseases' => 'Diabetes Mellitus',
    ]);
    $this->patient1->medicalRecords()->create([
        'visit_date' => now()->format('Y-m-d'),
        'systolic_bp' => 120,
        'diastolic_bp' => 80,
        'blood_sugar' => 110,
        'cholesterol' => 190,
        'uric_acid' => 5.2,
        'current_medication' => 'Metformin',
        'measurement_method' => 'recumbent', // fallback
    ]);

    $response = $this->get("/admin/patients/{$this->patient1->id}");
    $response->assertSee('Diabetes Mellitus');
    $response->assertSee('Metformin');
    $response->assertSee('Tekanan Darah');
    $response->assertSee('Gula Darah');
});
```

**Step 2: Run test to verify failure**
Run: `php artisan test --filter="menampilkan detail spesifik lansia"`
Expected: FAIL

**Step 3: Implement Lansia partial view**
Create `resources/views/livewire/admin/patient-management/details/lansia.blade.php` with layout displaying blood pressure, blood sugar, uric acid, cholesterol, historical diseases, current medication, and the health trend chart.

**Step 4: Run test to verify it passes**
Run: `php artisan test --filter="menampilkan detail spesifik lansia"`
Expected: PASS

**Step 5: Commit**
```bash
git add resources/views/livewire/admin/patient-management/details/lansia.blade.php
git commit -m "feat(patients): implement Lansia patient details partial view"
```

---

### Task 4: Implement Ibu Hamil Blade Partial
**Files:**
- Create: `resources/views/livewire/admin/patient-management/details/ibu_hamil.blade.php`

**Step 1: Write failing test**
In `tests/Feature/Admin/PatientManagementTest.php`, add:
```php
it('menampilkan detail spesifik ibu hamil', function () {
    $this->actingAs($this->admin1);
    $this->patient1->update([
        'category' => 'ibu_hamil',
        'parent_name' => 'Suami Antigravity',
        'is_pregnant' => true
    ]);
    $this->patient1->medicalRecords()->create([
        'visit_date' => now()->format('Y-m-d'),
        'lila' => 22.0, // indicating KEK / Chronic Energy Deficiency
        'weight' => 60.5,
        'height' => 155.0,
        'measurement_method' => 'recumbent',
    ]);

    $response = $this->get("/admin/patients/{$this->patient1->id}");
    $response->assertSee('Suami Antigravity');
    $response->assertSee('LILA');
    $response->assertSee('Risiko KEK'); // Alert for low LILA
});
```

**Step 2: Run test to verify failure**
Run: `php artisan test --filter="menampilkan detail spesifik ibu hamil"`
Expected: FAIL

**Step 3: Implement Ibu Hamil partial view**
Create `resources/views/livewire/admin/patient-management/details/ibu_hamil.blade.php` including pregnancy timeline, KEK risk alerts (LILA < 23.5 cm), husband/spouse name, and pregnancy statistics.

**Step 4: Run test to verify it passes**
Run: `php artisan test --filter="menampilkan detail spesifik ibu hamil"`
Expected: PASS

**Step 5: Commit**
```bash
git add resources/views/livewire/admin/patient-management/details/ibu_hamil.blade.php
git commit -m "feat(patients): implement Ibu Hamil patient details partial view"
```

---

### Task 5: Implement Umum Blade Partial
**Files:**
- Create: `resources/views/livewire/admin/patient-management/details/umum.blade.php`

**Step 1: Write failing test**
In `tests/Feature/Admin/PatientManagementTest.php`, add:
```php
it('menampilkan detail spesifik umum', function () {
    $this->actingAs($this->admin1);
    $this->patient1->update([
        'category' => 'umum',
        'education' => 'SMA',
        'job' => 'Wiraswasta',
    ]);

    $response = $this->get("/admin/patients/{$this->patient1->id}");
    $response->assertSee('SMA');
    $response->assertSee('Wiraswasta');
});
```

**Step 2: Run test to verify failure**
Run: `php artisan test --filter="menampilkan detail spesifik umum"`
Expected: FAIL

**Step 3: Implement Umum partial view**
Create `resources/views/livewire/admin/patient-management/details/umum.blade.php` to display generic socio-economic and basic general history metadata.

**Step 4: Run test to verify it passes**
Run: `php artisan test --filter="menampilkan detail spesifik umum"`
Expected: PASS

**Step 5: Commit**
```bash
git add resources/views/livewire/admin/patient-management/details/umum.blade.php
git commit -m "feat(patients): implement Umum patient details partial view"
```

---

## Verification Plan

### Automated Tests
Run the entire Patient Management suite to verify everything passes:
- `php artisan test --filter=PatientManagementTest`

### Manual Verification
1. Login to the Posyandu admin panel.
2. Visit `/admin/patients`.
3. Click a **Balita** patient. Verify the Teal theme gradient and the Immunization and Growth Chart panels.
4. Click a **Lansia** patient. Verify the Amber theme gradient, Posbindu metrics, medications list, and the Health Trend Chart.
5. Click an **Ibu Hamil** patient. Verify the Rose theme gradient, LILA metric, husband's name, and pregnancy warnings.
