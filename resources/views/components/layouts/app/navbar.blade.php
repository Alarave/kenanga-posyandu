{{-- ── Navbar Shell ── --}}
<header id="topNavbar"
    class="sticky top-0 z-40 flex items-center justify-between h-16 px-4 md:px-6
           bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-[0_1px_3px_0_rgb(0,0,0,.04)]
           transition-shadow duration-200"
    style="font-family:'Public Sans','Inter',sans-serif;">

    {{-- ── LEFT: Mobile toggle + Search ── --}}
    <div class="flex items-center gap-4 flex-1 min-w-0">

        {{-- Mobile hamburger --}}
        <button id="mobileSidebarToggle"
            class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl
                   text-slate-500 border border-slate-200 hover:bg-slate-50
                   active:scale-95 transition-all duration-150 flex-shrink-0">
            <i class="fas fa-bars" style="font-size:14px;"></i>
        </button>

        {{-- Global Search (Moved to Left) --}}
        <div class="hidden lg:block w-full max-w-2xl">
            @livewire('global-search')
        </div>
    </div>

    {{-- ── RIGHT: Notif · Profile ── --}}
    <div class="flex items-center gap-2 md:gap-3 flex-shrink-0" x-data="{ notifOpen: false, profileOpen: false }" @keydown.escape.window="profileOpen = false; notifOpen = false" wire:ignore.self>

        {{-- ── Mobile search toggle ── --}}
        <button id="mobileSearchBtn"
            class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl
                   text-slate-500 border border-slate-200 hover:bg-slate-50
                   active:scale-95 transition-all duration-150">
            <i class="fas fa-search" style="font-size:13px;"></i>
        </button>

        {{-- ── Notification bell (Super Admin Only) ── --}}
        @if(auth()->user()->isSuperAdmin())
            @livewire('shared.notification-bell')
        @endif

        {{-- ── Divider ── --}}
        <div class="hidden sm:block w-px h-6 bg-slate-100 mx-1"></div>

        {{-- ── Profile dropdown ── --}}
        <div class="relative">
            <button @click="profileOpen = !profileOpen; notifOpen = false"
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
                       border border-slate-100 overflow-hidden z-50 p-2">

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
                    @foreach($menuItems as $item)
                    <a href="{{ $item['href'] }}"
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

                {{-- Logout Button (Smaller) --}}
                <div class="mt-2 pt-2 border-t border-slate-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full h-11 flex items-center gap-3.5 px-3 bg-red-50 text-red-600
                                   hover:bg-red-600 hover:text-white rounded-xl transition-all duration-300 group font-black shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm group-hover:bg-red-500 group-hover:text-white transition-all flex-shrink-0">
                                <i class="fas fa-power-off text-[12px]"></i>
                            </div>
                            <span class="text-[13px] uppercase tracking-widest">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>

{{-- ── Mobile Search Bar (slide-down) ── --}}
<div id="mobileSearchBar"
    class="hidden lg:hidden px-4 py-2.5 bg-white border-b border-slate-100 shadow-sm">
    <div class="relative">
        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"
           style="font-size:12px;"></i>
        <input type="text"
            placeholder="Cari pasien, jadwal, artikel…"
            class="w-full h-9 pl-9 pr-4 rounded-xl border border-slate-200 bg-slate-50
                   text-slate-700 placeholder-slate-400 text-[13px] font-medium
                   focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300
                   focus:bg-white transition-all">
    </div>
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