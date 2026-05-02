# Codebase Cleanup & Modernization Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Remove dead code, fix broken middleware, and consolidate CSS into a unified Tailwind v4 architecture.

**Architecture:** Deletions of unused files, configuration updates in bootstrap/app.php, and migration of Tailwind configuration into the CSS @theme block.

**Tech Stack:** Laravel 12, Livewire, Tailwind CSS v4, PHP 8.2.

---

### Task 1: Dead Controller and Auth View Removal
**Files:**
- Delete: `app/Http/Controllers/API/`
- Delete: `app/Http/Controllers/Auth/RegisterController.php`
- Delete: `resources/views/auth/register.blade.php`
- Delete: `resources/views/livewire/auth/`

**Step 1: Verify files exist**
Run: `ls app/Http/Controllers/API`, `ls app/Http/Controllers/Auth/RegisterController.php`
Expected: Files are listed.

**Step 2: Delete files**
Run: `rm -r app/Http/Controllers/API`, `rm app/Http/Controllers/Auth/RegisterController.php`, `rm resources/views/auth/register.blade.php`, `rm -r resources/views/livewire/auth/`

**Step 3: Verify deletion**
Run: `ls app/Http/Controllers/API`
Expected: "ls: cannot access ...: No such file or directory"

**Step 4: Commit**
```bash
git add .
git commit -m "cleanup: remove dead controllers and auth views"
```

---

### Task 2: Dead Livewire Component Removal
**Files:**
- Delete: `app/Livewire/Auth/`

**Step 1: Delete directory**
Run: `rm -r app/Livewire/Auth/`

**Step 2: Verify deletion**
Run: `ls app/Livewire/Auth/`
Expected: "ls: cannot access ...: No such file or directory"

**Step 3: Commit**
```bash
git add .
git commit -m "cleanup: remove dead auth Livewire components"
```

---

### Task 3: Fix Broken Middleware Aliases
**Files:**
- Modify: `bootstrap/app.php`

**Step 1: Remove dead aliases**
Target lines in `bootstrap/app.php`:
```php
'medical' => \App\Http\Middleware\MedicalMiddleware::class,
'coordinator' => \App\Http\Middleware\CoordinatorMiddleware::class,
'staff' => \App\Http\Middleware\StaffMiddleware::class,
'patient' => \App\Http\Middleware\PatientMiddleware::class,
'partner' => \App\Http\Middleware\PartnerMiddleware::class,
```

**Step 2: Verify application health**
Run: `php artisan route:list`
Expected: No "Class not found" errors.

**Step 3: Commit**
```bash
git add bootstrap/app.php
git commit -m "fix: remove non-existent middleware aliases from bootstrap/app.php"
```

---

### Task 4: CSS Consolidation (Tailwind v4)
**Files:**
- Modify: `resources/css/app.css`
- Delete: `tailwind.config.js`

**Step 1: Migrate unique tokens**
Ensure `resources/css/app.css` `@theme` block includes all custom colors and font settings from `tailwind.config.js`. Resolve the `#CBD5E1` vs `#475569` inconsistency for `border-high-contrast` using `#475569`.

**Step 2: Delete config file**
Run: `rm tailwind.config.js`

**Step 3: Verify build**
Run: `npm run build`
Expected: Successful compilation without errors.

**Step 4: Commit**
```bash
git add .
git commit -m "style: consolidate CSS tokens into app.css and remove tailwind.config.js"
```

---

### Task 5: Globals CSS Cleanup
**Files:**
- Modify: `resources/css/globals.css`

**Step 1: Remove redundant styles**
Delete the `::-webkit-scrollbar` block (lines 109-122).

**Step 2: Standardize variables**
Update `hsl(var(--p))` references to `var(--color-primary)` where applicable.

**Step 3: Commit**
```bash
git add resources/css/globals.css
git commit -m "style: cleanup redundant scrollbar and standardize variables in globals.css"
```

---

### Task 6: Refresh & Verification
**Step 1: Update .env.example**
Mirror all non-secret keys from `.env`.

**Step 2: Run cleanup commands**
Run: `php artisan optimize:clear`, `composer dump-autoload`

**Step 3: Final Commit**
```bash
git add .env.example
git commit -m "chore: update .env.example and refresh application state"
```
