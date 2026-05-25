# Halaman Pemilihan Kategori Warga Baru Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Menampilkan halaman pemilihan kategori (Balita, Ibu Hamil, Lansia) ketika pengguna menekan tombol "Tambah Warga", sebelum menampilkan formulir pendaftaran.

**Architecture:** Modifikasi method `create()` pada `PatientController` untuk menyaring keberadaan parameter query `category`. Jika tidak ada, tampilkan blade view pemilihan kategori baru `select-category.blade.php`; jika ada, tampilkan form pendaftaran `create.blade.php` seperti biasa dengan inisialisasi state Alpine yang sesuai.

**Tech Stack:** PHP, Laravel 10+, Tailwind CSS, Livewire, Alpine.js, Pest PHP

---

### Task 1: Tulis Test Kasus untuk Pemilihan Kategori

**Files:**
- Modify: `tests/Feature/Admin/PatientManagementTest.php`

**Step 1: Tulis test kasus baru**
Tambahkan dua test kasus berikut ke dalam blok `describe('CRUD pasien - Read')` di `tests/Feature/Admin/PatientManagementTest.php`.

```php
    it('menampilkan halaman pemilihan kategori jika parameter category tidak ada', function () {
        $this->actingAs($this->admin1);

        $response = $this->get('/admin/patients/create');

        $response->assertOk();
        $response->assertViewIs('livewire.admin.patient-management.select-category');
    });

    it('menampilkan form pendaftaran jika parameter category ada', function () {
        $this->actingAs($this->admin1);

        $response = $this->get('/admin/patients/create?category=balita');

        $response->assertOk();
        $response->assertViewIs('livewire.admin.patient-management.create');
    });
```

**Step 2: Jalankan test untuk memverifikasi kegagalannya**
Run: `php artisan test --filter="menampilkan halaman pemilihan kategori"`
Expected: FAIL karena view `select-category` belum ada dan controller belum mengarahkan ke sana.

---

### Task 2: Buat Halaman Pemilihan Kategori (View)

**Files:**
- Create: `resources/views/livewire/admin/patient-management/select-category.blade.php`

**Step 3: Tulis minimal implementasi**
Buat file `select-category.blade.php` dengan grid pemilihan kategori Balita, Ibu Hamil, dan Lansia yang terintegrasi dengan layout admin.

```html
@extends('layouts.admin-layout')

@section('admin-title') @endsection

@section('admin-content')
<div class="w-full space-y-10 pb-24">
    <div class="flex items-center justify-between px-4">
        <div class="bg-white/80 backdrop-blur-md px-8 py-4 rounded-[2rem] border border-white shadow-sm flex items-center gap-4">
            <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Tambah Warga Baru</h2>
        </div>
        <x-button href="{{ route('admin.patients.index') }}" variant="ghost" class="!bg-white border border-slate-200 !rounded-2xl !px-6 h-14 font-black">
            <span class="material-symbols-outlined mr-2 text-[24px]">arrow_back</span> Kembali
        </x-button>
    </div>

    <div class="flex flex-col items-center justify-center py-12 px-4 bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] mx-4">
        <div class="text-center mb-12">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-[0.2em] mb-3">Pilih Kategori Pendaftaran</h3>
            <p class="text-xs font-bold text-slate-400">Silakan pilih salah satu kategori di bawah ini untuk melanjutkan pengisian data warga.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-5xl">
            <!-- Category: Balita -->
            <a href="{{ route('admin.patients.create', array_merge(request()->query(), ['category' => 'balita'])) }}" class="group flex flex-col items-center p-8 bg-slate-50/50 border border-slate-200/60 rounded-[2.5rem] hover:border-primary hover:bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 text-center">
                <div class="w-20 h-20 mb-6 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-sm border border-teal-100">
                    <span class="material-symbols-outlined text-[40px]" style="font-variation-settings: 'FILL' 1;">child_care</span>
                </div>
                <h3 class="text-lg font-black text-slate-800 mb-3 group-hover:text-primary transition-colors">Balita</h3>
                <p class="text-xs font-semibold text-slate-400 mb-8 leading-relaxed max-w-[240px]">Pendaftaran untuk bayi dan anak di bawah lima tahun untuk pemantauan tumbuh kembang dan imunisasi.</p>
                <div class="mt-auto px-6 py-2.5 rounded-xl bg-slate-100 text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:bg-primary group-hover:text-white transition-colors">
                    Pilih Kategori
                </div>
            </a>

            <!-- Category: Ibu Hamil -->
            <a href="{{ route('admin.patients.create', array_merge(request()->query(), ['category' => 'ibu_hamil'])) }}" class="group flex flex-col items-center p-8 bg-slate-50/50 border border-slate-200/60 rounded-[2.5rem] hover:border-primary hover:bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 text-center">
                <div class="w-20 h-20 mb-6 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-sm border border-pink-100">
                    <span class="material-symbols-outlined text-[40px]" style="font-variation-settings: 'FILL' 1;">pregnant_woman</span>
                </div>
                <h3 class="text-lg font-black text-slate-800 mb-3 group-hover:text-primary transition-colors">Ibu Hamil</h3>
                <p class="text-xs font-semibold text-slate-400 mb-8 leading-relaxed max-w-[240px]">Pendaftaran untuk pendampingan masa kehamilan, pemeriksaan rutin, dan persiapan persalinan.</p>
                <div class="mt-auto px-6 py-2.5 rounded-xl bg-slate-100 text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:bg-primary group-hover:text-white transition-colors">
                    Pilih Kategori
                </div>
            </a>

            <!-- Category: Lansia -->
            <a href="{{ route('admin.patients.create', array_merge(request()->query(), ['category' => 'lansia'])) }}" class="group flex flex-col items-center p-8 bg-slate-50/50 border border-slate-200/60 rounded-[2.5rem] hover:border-primary hover:bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 text-center">
                <div class="w-20 h-20 mb-6 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-sm border border-amber-100">
                    <span class="material-symbols-outlined text-[40px]" style="font-variation-settings: 'FILL' 1;">elderly</span>
                </div>
                <h3 class="text-lg font-black text-slate-800 mb-3 group-hover:text-primary transition-colors">Lansia</h3>
                <p class="text-xs font-semibold text-slate-400 mb-8 leading-relaxed max-w-[240px]">Pendaftaran untuk warga lanjut usia guna pemeriksaan kesehatan rutin dan program kesejahteraan lansia.</p>
                <div class="mt-auto px-6 py-2.5 rounded-xl bg-slate-100 text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:bg-primary group-hover:text-white transition-colors">
                    Pilih Kategori
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
```

**Step 4: Commit**
```bash
git add resources/views/livewire/admin/patient-management/select-category.blade.php
git commit -m "feat: add select-category blade view"
```

---

### Task 3: Modifikasi Controller & Form Create

**Files:**
- Modify: `app/Http/Controllers/Web/PatientController.php`
- Modify: `resources/views/livewire/admin/patient-management/create.blade.php`

**Step 3: Tulis minimal implementasi**
1. Modifikasi `app/Http/Controllers/Web/PatientController.php`:
   - Tambah parameter `Request $request` pada `create`.
   - Cek jika `$request->has('category')`. Jika tidak, return view `livewire.admin.patient-management.select-category`.

```php
    /**
     * Show the form for creating a new patient.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Patient::class);

        if (!$request->has('category')) {
            return view('livewire.admin.patient-management.select-category');
        }

        $pedukuhans = \App\Models\Pedukuhan::all();
        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.patient-management.create', compact('pedukuhans', 'posyandus'));
    }
```

2. Modifikasi `resources/views/livewire/admin/patient-management/create.blade.php`:
   - Ubah inisialisasi state Alpine `category` (baris 8):
   ```javascript
   category: '{{ old('category', request('category', 'balita')) }}',
   ```
   - Ubah pre-select unit posyandu di field `posyandu_id` (baris 313):
   ```html
   <x-forms.select-input name="posyandu_id" placeholder="" value="{{ old('posyandu_id', request('posyandu_id')) }}" required>
   ```

**Step 4: Jalankan test untuk memverifikasi keberhasilannya**
Run: `php artisan test --filter="PatientManagementTest"`
Expected: PASS (Semua tes lulus, termasuk tes baru kita)

**Step 5: Commit**
```bash
git add app/Http/Controllers/Web/PatientController.php resources/views/livewire/admin/patient-management/create.blade.php tests/Feature/Admin/PatientManagementTest.php
git commit -m "feat: integrate select-category page in controller and view"
```
