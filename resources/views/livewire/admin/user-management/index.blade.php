<div class="p-container-padding lg:px-section-margin py-8 flex flex-col gap-card-gap max-w-[1440px] mx-auto w-full">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-l-4 border-primary pl-4 py-1">
        <div>
            <h2 class="font-display-sm text-display-sm text-on-surface mb-1">Manajemen Akses &amp; Pengguna</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Kelola hak akses dan akun kader posyandu.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 px-6 py-2 border border-secondary text-secondary rounded-lg font-label-md text-label-md hover:bg-secondary-container hover:text-on-secondary-container transition-colors">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person_add</span> Tambah Pengguna
        </a>
    </div>

    <!-- Alerts Row -->
    @if (session()->has('success'))
    <div class="flex flex-col gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
        <div class="flex items-center gap-3 p-4 bg-[#f0fdf4] border border-[#bbf7d0] rounded-2xl text-[#166534]">
            <span class="material-symbols-outlined text-[#16a34a]">check_circle</span>
            <span class="font-body-md text-body-md">{{ session('success') }}</span>
        </div>
    </div>
    @endif
    
    @if (session()->has('error'))
    <div class="flex flex-col gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
        <div class="flex items-center gap-3 p-4 bg-error-container border border-error/50 rounded-2xl text-on-error-container">
            <span class="material-symbols-outlined text-error">error</span>
            <span class="font-body-md text-body-md">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="glass-panel p-6 rounded-2xl card-shadow hover-card-shadow transition-all flex flex-col gap-2">
            <div class="flex justify-between items-start">
                <span class="font-label-md text-label-md text-on-surface-variant">Total Pengguna</span>
                <div class="p-2 bg-primary-container/20 rounded-full text-primary">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                </div>
            </div>
            <span class="font-display-sm text-display-sm text-on-surface">{{ $totalUsers }}</span>
        </div>
        <!-- Card 2 -->
        <div class="glass-panel p-6 rounded-2xl card-shadow hover-card-shadow transition-all flex flex-col gap-2">
            <div class="flex justify-between items-start">
                <span class="font-label-md text-label-md text-on-surface-variant">Kader Aktif</span>
                <div class="p-2 bg-[#dcfce7] rounded-full text-[#16a34a]">
                    <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                </div>
            </div>
            <span class="font-display-sm text-display-sm text-on-surface">{{ App\Models\User::where('role', 'kader')->where('is_active', true)->count() }}</span>
        </div>
        <!-- Card 3 -->
        <div class="glass-panel p-6 rounded-2xl card-shadow hover-card-shadow transition-all flex flex-col gap-2">
            <div class="flex justify-between items-start">
                <span class="font-label-md text-label-md text-on-surface-variant">Unit Terdaftar</span>
                <div class="p-2 bg-secondary-fixed rounded-full text-secondary">
                    <span class="material-symbols-outlined text-[20px]">apartment</span>
                </div>
            </div>
            <span class="font-display-sm text-display-sm text-on-surface">{{ $totalPosyandu }}</span>
        </div>
        <!-- Card 4 -->
        <div class="glass-panel p-6 rounded-2xl card-shadow hover-card-shadow transition-all flex flex-col gap-2">
            <div class="flex justify-between items-start">
                <span class="font-label-md text-label-md text-error">Akun Nonaktif</span>
                <div class="p-2 bg-error-container rounded-full text-error">
                    <span class="material-symbols-outlined text-[20px]">person_off</span>
                </div>
            </div>
            <span class="font-display-sm text-display-sm text-error">{{ $inactiveUsers }}</span>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="glass-panel card-shadow rounded-2xl overflow-hidden flex flex-col mt-2">
        <!-- Search & Filters -->
        <div class="p-4 border-b border-outline-variant bg-transparent flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex-1 flex items-center gap-2 px-4 py-2 bg-surface-container rounded-lg w-full md:max-w-md">
    <span class="material-symbols-outlined text-outline">search</span>
    <input wire:model.live.debounce.300ms="search" class="bg-transparent border-none focus:ring-0 w-full font-body-md text-body-md text-on-surface placeholder-outline-variant outline-none" placeholder="Cari nama atau email..." type="text"/>
</div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select wire:model.live="role" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md text-on-surface focus:ring-primary focus:border-primary outline-none">
                    <option value="">Semua Role</option>
                    @foreach(App\Models\User::getRoles() as $r)
                        <option value="{{ $r }}">{{ $r === 'superadmin' ? 'Admin RW' : ucfirst($r) }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="status" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md text-on-surface focus:ring-primary focus:border-primary outline-none">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
                
                @if($search || $role || $status)
                <button wire:click="$set('search', ''); $set('role', ''); $set('status', '');" class="p-2 text-error hover:bg-error-container rounded-lg transition-colors border border-outline-variant flex items-center justify-center" title="Reset Filters">
                    <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container/50 text-on-surface font-label-md text-label-md border-b border-outline-variant">
                        <th class="p-4 font-semibold w-1/3">Detail User</th>
                        <th class="p-4 font-semibold">Role</th>
                        <th class="p-4 font-semibold">Unit Penugasan</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant bg-transparent">
                    @forelse($users as $user)
                    <tr class="hover:bg-surface-container-low transition-colors" wire:key="user-{{ $user->id }}">
                        <td class="p-4 flex items-center gap-3">
                            @php
                                // Assign colors dynamically based on user id modulo for a beautiful look like the mockup
                                $colors = ['bg-[#0ea5e9]', 'bg-[#f59e0b]', 'bg-[#94a3b8]', 'bg-primary', 'bg-secondary', 'bg-tertiary'];
                                $color = $colors[$user->id % count($colors)];
                            @endphp
                            <div class="w-10 h-10 rounded-2xl {{ $color }} text-white flex items-center justify-center font-bold font-label-md">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-body-md text-body-md font-medium text-on-surface">{{ $user->name }}</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            @if($user->isSuperAdmin())
                                <span class="px-3 py-1 bg-inverse-surface text-inverse-on-surface rounded-md font-label-sm text-label-sm">Admin RW</span>
                            @else
                                <div class="flex items-center gap-3">
                                    <label class="relative inline-flex items-center cursor-pointer group/toggle">
                                        <input type="checkbox" 
                                               wire:click="toggleRole({{ $user->id }})"
                                               class="sr-only peer" 
                                               {{ $user->isAdmin() ? 'checked' : '' }}>
                                        <div class="w-9 h-5 bg-surface-container-high peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                                    </label>
                                    <span class="font-label-sm text-label-sm {{ $user->isAdmin() ? 'text-primary' : 'text-on-surface-variant' }}">
                                        {{ $user->isAdmin() ? 'Administrator' : 'Kader' }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="p-4 font-body-md text-body-md text-on-surface">{{ $user->posyandu->name ?? 'Semua Unit' }}</td>
                        <td class="p-4">
                            @if($user->is_active)
                            <div class="flex items-center gap-2 px-3 py-1 bg-[#dcfce7] text-[#16a34a] rounded-full w-max border border-[#bbf7d0]">
                                <div class="w-2 h-2 rounded-full bg-[#16a34a] animate-pulse-fast"></div>
                                <span class="font-label-sm text-label-sm font-semibold">Aktif</span>
                            </div>
                            @else
                            <div class="flex items-center gap-2 px-3 py-1 bg-error-container text-on-error-container rounded-full w-max border border-error/20">
                                <div class="w-2 h-2 rounded-full bg-error"></div>
                                <span class="font-label-sm text-label-sm font-semibold">Nonaktif</span>
                            </div>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="p-2 bg-surface-container hover:bg-primary hover:text-white rounded-2xl transition-colors text-on-surface-variant flex items-center justify-center" title="Lihat">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 bg-surface-container hover:bg-secondary hover:text-white rounded-2xl transition-colors text-on-surface-variant flex items-center justify-center" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Yakin ingin menghapus pengguna ini?" class="p-2 bg-surface-container hover:bg-error hover:text-white rounded-2xl transition-colors text-error flex items-center justify-center" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center">
                            <div class="flex flex-col items-center gap-3 text-on-surface-variant opacity-60">
                                <span class="material-symbols-outlined text-[48px]">person_off</span>
                                <p class="text-sm font-bold uppercase tracking-widest">Tidak ada pengguna ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $users->links() }}
    </div>
</div>
