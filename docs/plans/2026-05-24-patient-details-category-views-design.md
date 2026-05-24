# Design: Category-Specific Patient Details Layouts

We will design and implement a highly tailored, visually premium patient detail page (`/admin/patients/{id}`) that changes its layouts, theme colors, and displayed medical metrics depending on the patient's category: **Balita** (including bayi and baduta), **Ibu Hamil**, **Lansia**, and **Umum** (general/others).

---

## 1. Theme Configuration & Colors

We will map theme configurations dynamically based on the patient's category at the top of the detail page.

| Category | Theme | Header Gradient | BG Light | Text Color | Icon |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Balita** (`bayi`, `baduta`, `balita`) | Teal / Emerald | `from-teal-600 to-emerald-500` | `bg-teal-50` | `text-teal-600` | `child_care` |
| **Lansia** (`lansia`) | Amber / Orange | `from-amber-600 to-orange-500` | `bg-amber-50` | `text-amber-600` | `elderly` |
| **Ibu Hamil** (`ibu_hamil`) | Rose / Pink | `from-rose-500 to-pink-500` | `bg-rose-50` | `text-rose-600` | `pregnant_woman` |
| **Umum / Others** (`umum`, `remaja`, etc.) | Indigo / Slate | `from-indigo-600 to-slate-500` | `bg-indigo-50` | `text-indigo-600` | `person` |

---

## 2. Layout Structure & Blade Partials

To prevent a massive, complex file, we will keep the common header, breadcrumbs, and basic info (photo, gender, age, contact) in `details.blade.php`, and dynamically include category-specific cards:

- **Balita Detail Partial** (`details/partials/balita.blade.php`):
  - Parents' names (Father/Mother) and KIA Book ownership card.
  - Last weight & height.
  - Health Attention: Vitamin A schedule & missing vaccinations.
  - Immunization Card (kelengkapan vaksinasi).
  - Child Growth Chart (WHO standard).

- **Lansia Detail Partial** (`details/partials/lansia.blade.php`):
  - RT Domisili & historical diseases (riwayat penyakit dahulu).
  - Health Attention: Blood pressure status (hypo/hypertension check), blood sugar status (diabetes check), uric acid, and cholesterol alerts.
  - Current medications card.
  - Last measurement metrics.
  - Health Trend Chart (blood pressure/blood sugar history tracker).

- **Ibu Hamil Detail Partial** (`details/partials/ibu_hamil.blade.php`):
  - Husband/spouse name, family size, economic status.
  - Health Attention: LILA (Lingkar Lengan Atas) check (< 23.5 cm warning for Chronic Energy Deficiency / KEK), anemia check (Fe tablets consumed), and blood pressure monitoring.
  - Current pregnancy timeline and risk alerts.
  - Pregnancy History Chart (weight/blood pressure tracker).

- **Umum / Others Detail Partial** (`details/partials/umum.blade.php`):
  - Basic socio-economic details (education, job, independence status, house conditions).
  - General health history timeline.

---

## 3. Implementation Workflow

1. Extract category-specific bento grids into respective Blade partials in `resources/views/livewire/admin/patient-management/details/`.
2. Refactor `details.blade.php` to define the dynamic `$theme` array based on the category.
3. Update `details.blade.php` to use the dynamic theme classes for page gradients, shadow borders, and text accents.
4. Replace the hardcoded bento grid section with `@include('livewire.admin.patient-management.details.partials.' . $theme['partial_name'])`.
