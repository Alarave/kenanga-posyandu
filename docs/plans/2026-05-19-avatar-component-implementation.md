# Reusable Premium Avatar Component Implementation Plan

> **For Antigravity:** REQUIRED SUB-SKILL: Load executing-plans to implement this plan task-by-task.

**Goal:** Implement a highly customizable and reusable Laravel Blade Avatar Component (`<x-avatar>`) featuring fallback initials generation and animated active status indicators.

**Architecture:** We will build a new Blade Component inside the core components library. It will support parameters matching the React design (`src`, `alt`, `size`, `status`, `name`) and dynamically map responsive Tailwind CSS v4 styling. We will write automated Pest tests, make them pass, and then replace all inline navigation avatars with the new `<x-avatar>` component.

**Tech Stack:** Laravel, Blade, Pest PHP, Tailwind CSS v4.

---

### Task 1: Create failing Pest test for the Avatar component

**Files:**
- Create: `tests/Feature/Components/AvatarTest.php`

**Step 1: Write the failing Pest test**
Create the component unit test checking both image-based and name-initials fallback renderings, custom sizes, and active status animations.

```php
<?php

use Illuminate\Support\Facades\Blade;

test('avatar component renders image when src is provided', function () {
    $html = Blade::render('<x-avatar src="https://example.com/photo.jpg" alt="Ahmad" size="large" status="online" />');

    // Assert container sizes are large
    expect($html)->toContain('h-12 w-12');
    // Assert image tag is present
    expect($html)->toContain('src="https://example.com/photo.jpg"');
    expect($html)->toContain('alt="Ahmad"');
    // Assert status indicator is online (emerald) and has ping animation
    expect($html)->toContain('bg-emerald-500');
    expect($html)->toContain('animate-ping');
});

test('avatar component renders initials fallback when src is missing', function () {
    $html = Blade::render('<x-avatar name="Budi Santoso" size="medium" status="busy" />');

    // Assert container sizes are medium
    expect($html)->toContain('h-10 w-10');
    // Assert initials are generated correctly
    expect($html)->toContain('BS');
    // Assert no image tag is rendered
    expect($html)->not->toContain('<img');
    // Assert status indicator is busy (rose)
    expect($html)->toContain('bg-rose-500');
    expect($html)->not->toContain('animate-ping');
});
```

**Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/Components/AvatarTest.php`
Expected: FAIL due to component `<x-avatar>` not found / class not resolved.

---

### Task 2: Implement the Reusable Blade Component

**Files:**
- Create: `resources/views/components/avatar.blade.php`

**Step 1: Write the full Blade implementation**
Write the complete rendering logic with size maps, status color maps, initials generator, and premium online indicator micro-ping animation.

```html
@props([
    'src' => null,
    'alt' => 'User Avatar',
    'size' => 'medium',
    'status' => 'none',
    'name' => null,
])

@php
    $sizeClasses = [
        'xsmall'  => 'h-6 w-6 min-w-6 max-w-6',
        'small'   => 'h-8 w-8 min-w-8 max-w-8',
        'medium'  => 'h-10 w-10 min-w-10 max-w-10',
        'large'   => 'h-12 w-12 min-w-12 max-w-12',
        'xlarge'  => 'h-14 w-14 min-w-14 max-w-14',
        'xxlarge' => 'h-16 w-16 min-w-16 max-w-16',
    ];

    $fontSizeClasses = [
        'xsmall'  => 'text-[9px]',
        'small'   => 'text-[11px]',
        'medium'  => 'text-[13px]',
        'large'   => 'text-[15px]',
        'xlarge'  => 'text-[18px]',
        'xxlarge' => 'text-[20px]',
    ];

    $statusSizeClasses = [
        'xsmall'  => 'h-1.5 w-1.5 max-w-1.5',
        'small'   => 'h-2 w-2 max-w-2',
        'medium'  => 'h-2.5 w-2.5 max-w-2.5',
        'large'   => 'h-3 w-3 max-w-3',
        'xlarge'  => 'h-3.5 w-3.5 max-w-3.5',
        'xxlarge' => 'h-4 w-4 max-w-4',
    ];

    $statusColorClasses = [
        'online'  => 'bg-emerald-500',
        'offline' => 'bg-slate-400',
        'busy'    => 'bg-rose-500',
    ];

    $containerClass = $sizeClasses[$size] ?? $sizeClasses['medium'];
    $fontSizeClass = $fontSizeClasses[$size] ?? $fontSizeClasses['medium'];
    $statusSizeClass = $statusSizeClasses[$size] ?? $statusSizeClasses['medium'];
    $statusColorClass = $statusColorClasses[$status] ?? '';

    // Generate initials (1-2 letters)
    $initials = 'A';
    if ($name) {
        $words = explode(' ', preg_replace('/\s+/', ' ', trim($name)));
        if (count($words) >= 2) {
            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $initials = strtoupper(substr($words[0] ?? 'A', 0, 2));
        }
    }
@endphp

<div class="relative rounded-full flex-shrink-0 {{ $containerClass }}">
    @if($src)
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            class="object-cover w-full h-full rounded-full shadow-inner border border-slate-100 dark:border-slate-800"
            loading="lazy"
        />
    @else
        <div class="w-full h-full rounded-full flex items-center justify-center text-white font-black shadow-sm select-none {{ $fontSizeClass }}"
             style="background: linear-gradient(135deg, #1e293b 0%, #475569 100%);">
            {{ $initials }}
        </div>
    @endif

    {{-- Status Indicator --}}
    @if($status !== 'none' && isset($statusColorClasses[$status]))
        <span class="absolute bottom-0 right-0 flex {{ $statusSizeClass }}">
            {{-- Pulsating effect for Online status --}}
            @if($status === 'online')
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            @endif
            {{-- Solid indicator dot --}}
            <span class="relative inline-flex rounded-full border-[1.5px] border-white dark:border-slate-900 w-full h-full {{ $statusColorClass }}"></span>
        </span>
    @endif
</div>
```

**Step 2: Run test to verify it passes**
Run: `vendor/bin/pest tests/Feature/Components/AvatarTest.php`
Expected: PASS.

---

### Task 3: Refactor the Sidebar user footer to use the Avatar component

**Files:**
- Modify: `resources/views/components/layouts/app/sidebar.blade.php:153-159`

**Step 1: Replace inline sidebar avatar with <x-avatar>**
Replace the old inline gradient div representing initials with our new reusable Blade component.

Before:
```html
        <div class="flex items-center gap-3 p-2 rounded-xl transition-all duration-200 cursor-pointer hover:bg-slate-50">
            {{-- Avatar --}}
            <div class="w-8 h-8 rounded-lg flex-shrink-0 flex items-center justify-center text-white font-bold text-xs shadow-sm"
                 style="background:linear-gradient(135deg,#1e293b 0%,#475569 100%); font-size:11px;">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
```

After:
```html
        <div class="flex items-center gap-3 p-2 rounded-xl transition-all duration-200 cursor-pointer hover:bg-slate-50">
            {{-- Avatar --}}
            <x-avatar :name="Auth::user()->name" size="small" status="online" />
```

---

### Task 4: Refactor App Navbar Profile Dropdown to use the Avatar component

**Files:**
- Modify: `resources/views/components/layouts/app/navbar.blade.php:50-55`, `86-90`

**Step 1: Replace navbar inline avatars with <x-avatar>**
Replace both the header trigger avatar and the internal dropdown card avatar with the component.

Trigger replacement before:
```html
                {{-- Avatar with Ring --}}
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black flex-shrink-0 shadow-lg relative group-hover:rotate-3 transition-transform"
                     style="background:{{ $avatarGrad }}; font-size:13px; letter-spacing:.05em;">
                    {{ $initials }}
                    <div class="absolute inset-0 rounded-xl border-2 border-white/20"></div>
                </div>
```

Trigger replacement after:
```html
                {{-- Avatar with Ring --}}
                <x-avatar :name="$name" size="medium" status="online" />
```

Card section replacement before:
```html
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-black shadow-lg"
                             style="background:{{ $avatarGrad }}; font-size:13px;">
                            {{ $initials }}
                        </div>
```

Card section replacement after:
```html
                        <x-avatar :name="$name" size="medium" />
```

---

### Task 5: Refactor UI Navbar Profile Dropdown to use the Avatar component

**Files:**
- Modify: `resources/views/components/layouts/ui/navbar.blade.php:87-92`, `124-128`

**Step 1: Replace UI navbar inline avatars with <x-avatar>**
Perform the same replacement for the UI layout navigation.

Trigger replacement after:
```html
                {{-- Avatar with Ring --}}
                <x-avatar :name="$name" size="medium" status="online" />
```

Card section replacement after:
```html
                        <x-avatar :name="$name" size="medium" />
```

---

### Task 6: Verify and Git Commit

**Step 1: Run complete component tests**
Run: `vendor/bin/pest tests/Feature/Components/AvatarTest.php`
Expected: PASS.

**Step 2: Commit all files**
Add all new and modified files to git and create a clean feature commit.
Run:
```bash
git add docs/plans/2026-05-19-avatar-component-design.md docs/plans/2026-05-19-avatar-component-implementation.md tests/Feature/Components/AvatarTest.php resources/views/components/avatar.blade.php resources/views/components/layouts/app/sidebar.blade.php resources/views/components/layouts/app/navbar.blade.php resources/views/components/layouts/ui/navbar.blade.php
git commit -m "feat: add reusable premium Avatar component with status indicator and initials fallback"
```
