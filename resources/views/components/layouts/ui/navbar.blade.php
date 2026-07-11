{{-- ═══════════════════════════════════════════════════════════
    Posyandu — Top Navigation Bar
    Sticky header with search, notifications & profile dropdown
═══════════════════════════════════════════════════════════ --}}
@php
    $user = Auth::user();
    $name = $user->name ?? 'Admin';
    $initials = strtoupper(substr($name, 0, 1)) . (str_contains($name, ' ') ? strtoupper(substr(strstr($name, ' '), 1, 1)) : '');

    $role = $user ? $user->role_label : 'Admin';

    // Role badge colour
    $badgeClass = match(true) {
        $user?->isSuperAdmin()          => 'bg-violet-100 text-violet-700',
        $user?->isAdmin()               => 'bg-blue-100 text-blue-700',
        $user?->isKader()               => 'bg-emerald-100 text-emerald-700',
        default                         => 'bg-slate-100 text-slate-600',
    };

    // Avatar gradient
    $avatarGrad = match(true) {
        $user?->isSuperAdmin()          => 'linear-gradient(135deg,#7c3aed 0%,#a78bfa 100%)',
        $user?->isAdmin()               => 'linear-gradient(135deg,#1e40af 0%,#3b82f6 100%)',
        $user?->isKader()               => 'linear-gradient(135deg,#065f46 0%,#10b981 100%)',
        default                         => 'linear-gradient(135deg,#1e293b 0%,#475569 100%)',
    };
@endphp

{{-- ── Navbar Shell ── --}}
<header id="topNavbar"
    class="sticky top-0 z-40 flex items-center justify-between h-16 px-4 md:px-6
           bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-[0_1px_3px_0_rgb(0,0,0,.04)]
           transition-shadow duration-200"
    style="font-family:'Public Sans', 'Public Sans Fallback', 'Inter', sans-serif;">

    {{-- ── LEFT: Mobile toggle ── --}}
    <div class="flex items-center gap-3 flex-shrink-0">
        {{-- Mobile hamburger --}}
        <button id="mobileSidebarToggle"
            class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl
                   text-slate-500 border border-slate-200 hover:bg-slate-50
                   active:scale-95 transition-all duration-150 flex-shrink-0">
            <i class="fas fa-bars" style="font-size:14px;"></i>
        </button>
    </div>

    {{-- ── CENTER: Search bar (takes up remaining space) ── --}}
    <div class="flex-1 flex items-center px-2 md:px-4 min-w-0">
        {{-- Desktop search --}}
        <div class="hidden lg:block w-full max-w-lg">
            @livewire('global-search')
        </div>
        {{-- Mobile search toggle --}}
        <button id="mobileSearchBtn"
            class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl
                   text-slate-500 border border-slate-200 hover:bg-slate-50
                   active:scale-95 transition-all duration-150">
            <i class="fas fa-search" style="font-size:13px;"></i>
        </button>
    </div>

    {{-- ── RIGHT: Notif · Profile ── --}}
    <div class="flex items-center gap-2 md:gap-3 flex-shrink-0" x-data="{ profileOpen: false }" @keydown.escape.window="profileOpen = false; $dispatch('close-dropdowns')" @close-dropdowns.window="if ($event.detail !== 'profile') profileOpen = false" x-on:livewire:navigating.window="profileOpen = false" wire:ignore.self>

        {{-- ── Notification bell (Admin RW Only) ── --}}
        @if(auth()->user()->isSuperAdmin())
            @livewire('shared.notification-bell')
        @endif

        {{-- ── Divider ── --}}
        <div class="hidden sm:block w-px h-6 bg-slate-100 mx-1"></div>

        {{-- ── Profile dropdown ── --}}
        <div class="relative">
            <button @click="profileOpen = !profileOpen; if(profileOpen) $dispatch('close-dropdowns', 'profile')"
                class="flex items-center gap-3 pl-1.5 pr-4 py-1.5 rounded-[1.25rem]
                       hover:bg-slate-50 active:scale-95 transition-all duration-300 group bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-teal-100">

                {{-- Avatar with Ring --}}
                <x-avatar :name="$name" size="medium" status="online" />

                {{-- Name + role --}}
                <div class="hidden md:flex flex-col items-start leading-tight">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-slate-900 font-black text-[14px] tracking-tight">
                            {{ explode(' ', $name)[0] }}
                        </span>
                        <span class="px-2 py-0.5 rounded-lg {{ $badgeClass }} text-[9px] uppercase font-black tracking-widest shadow-sm">
                            {{ $role }}
                        </span>
                    </div>
                    <span class="text-slate-400 font-bold text-[10px] tracking-tight">{{ $user?->email }}</span>
                </div>

                <i class="fas fa-chevron-down text-slate-300 group-hover:text-teal-600 transition-all duration-300 hidden md:block"
                   :class="profileOpen ? 'rotate-180' : ''"
                   style="font-size:11px;"></i>
            </button>

            {{-- Profile dropdown panel (Compact & More Options) --}}
            <div x-show="profileOpen"
                @click.away="profileOpen = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                class="absolute right-0 mt-2.5 w-72 bg-white rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.12)]
                       border border-slate-100 overflow-hidden z-50 p-2"
                x-cloak>

                {{-- User Card Section (More Compact) --}}
                <div class="px-4 py-4 rounded-3xl mb-2 relative overflow-hidden group/card bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3.5 relative z-10">
                        <x-avatar :name="$name" size="medium" />
                        <div class="min-w-0">
                            <p class="text-slate-900 font-black text-[14px] truncate leading-tight mb-0.5">{{ $name }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[8.5px] font-black uppercase tracking-wider {{ $badgeClass }} shadow-sm">
                                {{ $role }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Menu items (Compact) --}}
                <div class="space-y-0.5">
                    @php
                        $menuItems = [
                            ['href' => route('dashboard'), 'icon' => 'fa-house', 'label' => 'Dashboard', 'color' => 'emerald'],
                            ['href' => route('admin.patients.index'), 'icon' => 'fa-users', 'label' => 'Data Warga', 'color' => 'blue'],
                            ['href' => route('admin.schedules.index'), 'icon' => 'fa-calendar-days', 'label' => 'Jadwal', 'color' => 'amber'],
                        ];
                        
                        if ($user?->isSuperAdmin() || $user?->isAdmin()) {
                            $menuItems[] = ['href' => route('admin.reports.index'), 'icon' => 'fa-chart-bar', 'label' => 'Laporan Bulanan', 'color' => 'violet'];
                        }
                        
                        if ($user?->isSuperAdmin()) {
                            $menuItems[] = ['href' => route('admin.activity-logs.index'), 'icon' => 'fa-clipboard-list', 'label' => 'Log Aktivitas', 'color' => 'indigo'];
                        }
                    @endphp

                    @foreach($menuItems as $item)
                    <a href="{{ $item['href'] }}"
                       @click="profileOpen = false"
                       class="flex items-center gap-3.5 px-3 py-2.5 text-slate-600 hover:bg-slate-50
                              hover:text-slate-900 rounded-xl transition-all group font-bold relative">
                        <div @class([
                            'w-8 h-8 rounded-lg flex items-center justify-center transition-all flex-shrink-0 shadow-sm',
                            'bg-emerald-50 text-emerald-600' => $item['color'] === 'emerald',
                            'bg-blue-50 text-blue-600' => $item['color'] === 'blue',
                            'bg-amber-50 text-amber-600' => $item['color'] === 'amber',
                            'bg-violet-50 text-violet-600' => $item['color'] === 'violet',
                            'bg-indigo-50 text-indigo-600' => $item['color'] === 'indigo',
                        ])>
                            <i class="fas {{ $item['icon'] }} text-[12px] group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span class="text-[13px] tracking-tight">{{ $item['label'] }}</span>
                        <i class="fas fa-chevron-right absolute right-3 opacity-0 group-hover:opacity-40 transition-opacity text-[9px]"></i>
                    </a>
                    @endforeach
                </div>

                {{-- Logout Button (Neat & Clean) --}}
                <div class="mt-2 pt-2 border-t border-slate-100">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3.5 px-3 py-2.5 text-slate-600 hover:bg-rose-50/60
                                       hover:text-rose-700 rounded-xl transition-all group font-bold relative text-left border-0">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all flex-shrink-0 shadow-sm bg-rose-50 text-rose-600 group-hover:bg-rose-100 group-hover:scale-110">
                                <i class="fas fa-right-from-bracket text-[12px] group-hover:scale-110 transition-transform"></i>
                            </div>
                            <span class="text-[13px] tracking-tight">Keluar dari Akun</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>

<div id="mobileSearchBar"
    class="hidden lg:hidden px-4 py-2.5 bg-white border-b border-slate-100 shadow-sm">
    @livewire('global-search')
</div>

{{-- ── Navbar JS ── --}}
<script>
(function () {
    // Mobile search toggle
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');
    const mobileSearchBar = document.getElementById('mobileSearchBar');
    if (mobileSearchBtn && mobileSearchBar) {
        mobileSearchBtn.addEventListener('click', function () {
            mobileSearchBar.classList.toggle('hidden');
            if (!mobileSearchBar.classList.contains('hidden')) {
                mobileSearchBar.querySelector('input')?.focus();
            }
        });
    }
})();
</script>
