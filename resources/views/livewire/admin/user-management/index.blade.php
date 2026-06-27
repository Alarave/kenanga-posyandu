<div class="space-y-6">
    {{-- Header Section (Standardized with other components) --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
        <div class="relative pl-6">
            {{-- Vertical Bar --}}
            <div class="absolute left-0 top-1 bottom-1 w-1.5 bg-primary rounded-lg"></div>
            
            <div class="flex flex-col gap-4">
                <div>
                    <h1 class="text-display-sm tracking-tight text-on-surface">Manajemen Akses & Pengguna</h1>
                    <p class="text-sm font-bold text-on-surface mt-2">Kelola hak akses dan akun kader posyandu.</p>
                </div>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-3 items-center">
            <x-button href="{{ route('admin.users.create') }}" variant="secondary" icon="person_add">
                Tambah Pengguna
            </x-button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-on-primary-container bg-primary-container rounded-2xl border border-primary flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-on-error-container bg-error-container rounded-2xl border border-error flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
            <span class="material-symbols-outlined text-[20px]">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats Row ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant shadow-sm">
            <div class="text-[9px] font-black text-outline-variant uppercase tracking-widest mb-1">Total Pengguna</div>
            <div class="text-headline-md font-black text-on-surface">{{ $totalUsers }}</div>
        </div>
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant shadow-sm">
            <div class="text-[9px] font-black text-outline-variant uppercase tracking-widest mb-1">Kader Aktif</div>
            <div class="text-headline-md font-black text-on-surface">{{ App\Models\User::where('role', 'kader')->where('is_active', true)->count() }}</div>
        </div>
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant shadow-sm">
            <div class="text-[9px] font-black text-outline-variant uppercase tracking-widest mb-1">Unit Terdaftar</div>
            <div class="text-headline-md font-black text-on-surface">{{ $totalPosyandu }}</div>
        </div>
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant shadow-sm">
            <div class="text-[9px] font-black text-outline-variant uppercase tracking-widest mb-1">Akun Nonaktif</div>
            <div class="text-headline-md font-black text-error">{{ $inactiveUsers }}</div>
        </div>
    </div>

    {{-- ── Search & Filter Bar ── --}}
    <section class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            {{-- Unified Search --}}
            <div class="flex-1 min-w-[280px] relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant group-focus-within:text-primary transition-colors pointer-events-none">search</span>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama atau email..."
                       class="search-input-premium w-full">
            </div>

            {{-- Role Filter --}}
            <div class="w-full sm:w-auto min-w-[180px]">
                <x-forms.select-input 
                    wire:model.live="role"
                    placeholder="Semua Role"
                    :placeholderDisabled="false"
                    value="{{ $role }}"
                >
                    @foreach(App\Models\User::getRoles() as $r)
                        <option value="{{ $r }}">{{ $r === 'superadmin' ? 'Admin RW' : ucfirst($r) }}</option>
                    @endforeach
                </x-forms.select-input>
            </div>

            {{-- Status Filter --}}
            <div class="w-full sm:w-auto min-w-[150px]">
                <x-forms.select-input 
                    wire:model.live="status"
                    placeholder="Semua Status"
                    :placeholderDisabled="false"
                    value="{{ $status }}"
                >
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </x-forms.select-input>
            </div>

            @if($search || $role || $status)
            <button wire:click="$set('search', ''); $set('role', ''); $set('status', '');"
                    class="h-12 px-4 flex items-center gap-2 text-error font-bold text-xs uppercase tracking-widest hover:bg-error-container rounded-2xl transition-all">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                Reset
            </button>
            @endif
        </div>
    </section>

    {{-- ── Data Table ── --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
        <x-table>
            <thead class="bg-surface-container-low/80 border-b border-outline-variant">
                <tr>
                    <th class="px-5 py-3 text-[10px] font-black text-on-surface uppercase tracking-widest text-center">Detail User</th>
                    <th class="px-5 py-3 text-[10px] font-black text-on-surface uppercase tracking-widest text-center">Role</th>
                    <th class="px-5 py-3 text-[10px] font-black text-on-surface uppercase tracking-widest text-center">Unit Penugasan</th>
                    <th class="px-5 py-3 text-[10px] font-black text-on-surface uppercase tracking-widest text-center">Status</th>
                    <th class="px-5 py-3 text-[10px] font-black text-on-surface uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="group hover:bg-surface-container-low/50 transition-colors" wire:key="user-{{ $user->id }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-2xl bg-primary-container text-primary flex items-center justify-center font-black text-xs border border-primary">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-bold text-on-surface text-sm leading-tight">{{ $user->name }}</div>
                                <div class="text-[11px] text-outline-variant font-semibold mt-0.5">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->isSuperAdmin())
                            <span class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider bg-inverse-surface text-white border border-slate-900">
                                Admin RW
                            </span>
                        @else
                            <div class="flex items-center gap-3">
                                <label class="relative inline-flex items-center cursor-pointer group/toggle">
                                    <input type="checkbox" 
                                           wire:click="toggleRole({{ $user->id }})"
                                           class="sr-only peer" 
                                           {{ $user->isAdmin() ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-surface-container-high peer-focus:outline-none rounded-lg peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-surface-container-lowest after:border-gray-300 after:border after:rounded-lg after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $user->isAdmin() ? 'text-primary' : 'text-outline-variant' }}">
                                    {{ $user->isAdmin() ? 'Administrator' : 'Kader' }}
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-[13px] font-semibold text-on-surface-variant">{{ $user->posyandu->name ?? 'Semua Unit' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1.5 text-green-600 text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded-lg bg-green-500 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-outline-variant text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded-lg bg-slate-300"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" 
                               class="w-11 h-11 flex items-center justify-center rounded-2xl bg-surface-container-low text-outline hover:bg-primary hover:text-white transition-all shadow-sm hover:shadow-teal-500/20 group/btn"
                               title="Lihat Detail">
                                <span class="material-symbols-outlined text-[22px]">visibility</span>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="w-11 h-11 flex items-center justify-center rounded-2xl bg-surface-container-low text-outline hover:bg-secondary hover:text-white transition-all shadow-sm hover:shadow-indigo-500/20 group/btn"
                               title="Edit User">
                                <span class="material-symbols-outlined text-[22px]">edit</span>
                            </a>
                            <button wire:click="delete({{ $user->id }})" 
                                    wire:confirm="Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan."
                                    class="w-11 h-11 flex items-center justify-center rounded-2xl bg-surface-container-low text-outline hover:bg-error hover:text-white transition-all shadow-sm hover:shadow-red-500/20 group/btn"
                                    title="Hapus User">
                                <span class="material-symbols-outlined text-[22px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-24 text-center">
                        <div class="flex flex-col items-center gap-4 text-slate-300">
                            <span class="material-symbols-outlined text-[64px]">person_off</span>
                            <p class="text-sm font-bold text-outline uppercase tracking-widest">Tidak ada user ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>

    {{-- ── Pagination ── --}}
    <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant">
        {{ $users->links() }}
    </div>
</div>
