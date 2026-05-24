# Medical Record Category Selection Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Introduce a category selection screen (Balita, Ibu Hamil, Lansia) for medical records creation, filter the available patients dropdown accordingly, and display category-specific fields.

**Architecture:** Route `/admin/medical-records/create` requests without a `category` parameter to a selection screen, filter patient lists in the controller dynamically using query parameters, and handle dynamic validation and display on the frontend using Alpine.js and conditional inputs.

**Tech Stack:** Laravel, Livewire (Volt), Blade, Alpine.js, TomSelect

---

### Task 1: Create Select Category View

**Files:**
- Create: [select-category.blade.php](file:///c:/Users/HP/kenanga-posyandu/resources/views/livewire/admin/medical-record-management/select-category.blade.php)

**Step 1: Write the category selection view**
Create a styled selection page with 3 cards: Balita, Ibu Hamil, and Lansia, redirecting to the creation route with `?category=...`.

**Step 2: Commit**
```bash
git add resources/views/livewire/admin/medical-record-management/select-category.blade.php
git commit -m "feat(medical-records): add select-category view for medical records"
```

---

### Task 2: Modify MedicalRecordController

**Files:**
- Modify: [MedicalRecordController.php](file:///c:/Users/HP/kenanga-posyandu/app/Http/Controllers/Web/MedicalRecordController.php)

**Step 1: Update the create method**
Add checks for the `category` query parameter. If absent, return the `select-category` view. If present, filter the patients list based on the chosen category:
- `balita` -> `['bayi', 'baduta', 'balita', 'anak_sekolah']`
- `ibu_hamil` -> `['ibu_hamil']`
- `lansia` -> `['lansia']`

**Step 2: Commit**
```bash
git add app/Http/Controllers/Web/MedicalRecordController.php
git commit -m "feat(medical-records): update controller to filter patients by category"
```

---

### Task 3: Modify MedicalRecordRequest

**Files:**
- Modify: [MedicalRecordRequest.php](file:///c:/Users/HP/kenanga-posyandu/app/Http/Requests/MedicalRecordRequest.php)

**Step 1: Make validation rules dynamic**
Read `patient_id` from input, retrieve the patient's category, and dynamically set `measurement_method` to `required` only for child categories. For other categories, set it to `nullable`.

**Step 2: Commit**
```bash
git add app/Http/Requests/MedicalRecordRequest.php
git commit -m "feat(medical-records): make validation rules dynamic based on patient category"
```

---

### Task 4: Modify Create Form View

**Files:**
- Modify: [create.blade.php](file:///c:/Users/HP/kenanga-posyandu/resources/views/livewire/admin/medical-record-management/create.blade.php)

**Step 1: Initialize Alpine category and add Ibu Hamil form section**
- Update Alpine `x-data` to set `category` default using `request('category')`.
- Wrap child-specific fields (TBC screening, Vitamin A, Vaccine, KPSP) in an `x-show="category === 'balita'"` block (or keep existing checks, making sure `ibu_hamil` is handled).
- Add the `ibu_hamil` section displaying `pill_fe` (Pill FE), and Systolic/Diastolic blood pressure.
- Hide `measurement_method` and other children-specific properties for `ibu_hamil` and `lansia`.

**Step 2: Commit**
```bash
git add resources/views/livewire/admin/medical-record-management/create.blade.php
git commit -m "feat(medical-records): update form layout and add pregnant mother fields"
```

---

### Task 5: Verify Changes

**Step 1: Run manual verification**
Verify that going to `/admin/medical-records/create` displays the category selector, and picking a category routes to the form with only relevant fields and patients showing.
