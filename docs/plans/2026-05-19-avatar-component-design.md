# Design Specification: Reusable Premium Avatar Component

## Goal
Create a highly aesthetic, premium, and reusable Blade Component (`<x-avatar>`) in Laravel to display user avatar images, fallback initials with a linear gradient, and an active status indicator (online/offline/busy) with subtle animations.

---

## 1. Design Overview
The avatar component provides a standard UI element matching the React/Next.js properties but adapted to the Laravel Blade structure:
1. **Size Options**: Consistent tailwind spacing constraints for 6 custom sizes (`xsmall`, `small`, `medium`, `large`, `xlarge`, `xxlarge`).
2. **Dynamic Fallback**: If no image `src` is supplied, generate a 2-letter uppercase initials fallback and render it inside a premium dark slate gradient.
3. **Pulsating Status Indicators**: Absolute status badges with white borders (`dark:border-slate-900`) for:
   - `online` 🟢: Green/Emerald with a micro-ping animation.
   - `busy` 🔴: Pink/Rose solid indicator.
   - `offline` ⚪: Grey/Slate solid indicator.
   - `none` 🚫: Default empty state.

---

## 2. Component Blueprint

### 2.1. File Location
- **Component File**: `resources/views/components/avatar.blade.php`

### 2.2. Properties (Props)
- `src` (string|null): Profile image URL.
- `alt` (string): Description of the image.
- `size` (string): Sizing identifier (`xsmall` to `xxlarge`).
- `status` (string): User status dot type (`online`, `offline`, `busy`, `none`).
- `name` (string|null): Initials fallback generation key.

### 2.3. Sizing Grid Mapping
| Sizing Option | Container Dimensions | Status Badge Dimensions | Font Size (Fallback) |
|---|---|---|---|
| `xsmall` | `h-6 w-6` (24px) | `h-1.5 w-1.5` (6px) | `text-[9px]` |
| `small` | `h-8 w-8` (32px) | `h-2 w-2` (8px) | `text-[11px]` |
| `medium` | `h-10 w-10` (40px) | `h-2.5 w-2.5` (10px) | `text-[13px]` |
| `large` | `h-12 w-12` (48px) | `h-3 w-3` (12px) | `text-[15px]` |
| `xlarge` | `h-14 w-14` (56px) | `h-3.5 w-3.5` (14px) | `text-[18px]` |
| `xxlarge` | `h-16 w-16` (64px) | `h-4 w-4` (16px) | `text-[20px]` |

---

## 3. Integration Points
Once built, we will replace inline avatar placeholders in:
1. `resources/views/components/layouts/app/sidebar.blade.php` (User profile footer)
2. `resources/views/components/layouts/app/navbar.blade.php` (Header user dropdown toggle)
3. `resources/views/components/layouts/ui/navbar.blade.php` (Header UI navbar dropdown)
