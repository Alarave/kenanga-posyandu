# Dynamic Role & Permission Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Membangun sistem manajemen hak akses berbasis database (Dynamic RBAC) yang memungkinkan Superadmin mengatur izin (permissions) untuk role Admin dan Kader melalui antarmuka web.

**Architecture:** Menggunakan pola *Role-Based Access Control* (RBAC) dengan tabel `roles`, `permissions`, dan pivot `role_has_permissions`. Implementasi `Gate::before` digunakan untuk memberikan akses penuh otomatis kepada Superadmin, sementara role lain divalidasi berdasarkan data di database.

**Tech Stack:** Laravel 12, Livewire, Tailwind CSS, MySQL.

---

### Task 1: Database Schema for Roles & Permissions

**Files:**
- [NEW] `database/migrations/2026_05_10_000001_create_roles_and_permissions_tables.php`

**Step 1: Create the migration file**
Buat migrasi untuk tabel `roles`, `permissions`, dan tabel pivot `role_has_permissions`.

**Step 2: Run migration**
Run: `php artisan migrate`

---

### Task 2: Models and Trait Implementation

**Files:**
- [NEW] `app/Models/Role.php`
- [NEW] `app/Models/Permission.php`
- [MODIFY] `app/Models/User.php`

**Step 1: Create Models**
Buat model `Role` dan `Permission` dengan relasi `belongsToMany`.

**Step 2: Add Permission Logic to User Model**
Tambahkan method `hasPermissionTo($permission)` ke dalam model `User`.

---

### Task 3: Superadmin Bypass Logic

**Files:**
- [MODIFY] `app/Providers/AppServiceProvider.php`

**Step 1: Implement Gate::before**
Daftarkan bypass global di method `boot()`.

---

### Task 4: Permission Seeding

**Files:**
- [NEW] `database/seeders/RolesAndPermissionsSeeder.php`

---

### Task 5: Management UI (Livewire Component)

**Files:**
- [NEW] `app/Livewire/Admin/Settings/RolePermissionManagement.php`
- [NEW] `resources/views/livewire/admin/settings/role-permission-management.blade.php`

---

### Task 6: Secure Routing

**Files:**
- [MODIFY] `routes/web.php`

---

### Task 7: Refactor Policies to be Dynamic

**Files:**
- [MODIFY] `app/Policies/MedicalRecordPolicy.php`
- [MODIFY] `app/Policies/PatientPolicy.php`
