# Design Document: Codebase Cleanup & Modernization (2026-05-03)

## Goal
The goal of this cleanup is to remove dead code, fix configuration errors, and consolidate the fragmented CSS architecture into a single, modern Tailwind v4 source of truth. This will improve project maintainability, performance, and developer experience.

## Scope

### 1. Dead Code Removal
- **Controllers**:
    - Remove `app/Http/Controllers/API/` directory (redundant API endpoints).
    - Remove `app/Http/Controllers/Auth/RegisterController.php` (public registration is disabled).
- **Livewire Components**:
    - Remove `app/Livewire/Auth/` directory (dead auth components).
- **Views**:
    - Remove `resources/views/auth/register.blade.php`.
    - Remove `resources/views/livewire/auth/` directory.

### 2. Middleware correction
- **File**: `bootstrap/app.php`
- **Action**: Remove aliases for non-existent middleware classes:
    - `medical`
    - `coordinator`
    - `staff`
    - `patient`
    - `partner`
- **Validation**: Verify that all remaining aliases point to existing files in `app/Http/Middleware/`.

### 3. CSS Architecture Consolidation
- **Transition to Tailwind v4**:
    - Migrate all custom design tokens (colors, fonts, sizes) from `tailwind.config.js` to the `@theme` block in `resources/css/app.css`.
    - **Delete** `tailwind.config.js` to avoid conflicting configurations.
- **`globals.css` Cleanup**:
    - Remove redundant `::-webkit-scrollbar` definitions that conflict with `app.css`.
    - Standardize color variables (resolve `hsl()` vs `oklch()`/hex conflicts).
- **`app.css` Refinement**:
    - Ensure `@theme` block contains a complete and consistent set of tokens.
    - Resolve the inconsistency in `--color-border-high-contrast` (currently `#CBD5E1` in config vs `#475569` in CSS).

### 4. Project Health
- **`.env.example`**: Update to mirror the structure of `.env` (ensuring all necessary keys are documented).
- **Refresh**:
    - Run `php artisan optimize:clear` to purge cached configurations and views.
    - Run `composer dump-autoload` to clean up the class map after deletions.

## Success Criteria
1. Application loads without errors (no "class not found" for missing middleware).
2. All UI elements maintain their "premium" look and feel after CSS consolidation.
3. No dead files remain in the specified directories.
4. `tailwind.config.js` is removed and Tailwind v4 features are fully utilized.

## Risk Assessment
- **UI Breakage**: Consolidating CSS tokens might cause subtle color or spacing changes. 
- **Mitigation**: Perform a visual check of key pages (Dashboard, Patient Management) after the merge.
