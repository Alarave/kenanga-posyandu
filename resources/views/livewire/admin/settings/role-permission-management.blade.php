<div class="space-y-6">
    {{-- Header Section --}}
    <div class="relative mb-10">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative">
            <div class="space-y-2">
                <div class="flex items-start gap-4">
                    <div class="w-1.5 h-12 bg-gradient-to-b from-teal-500 to-emerald-400 rounded-full mt-1 hidden sm:block"></div>
                    <div>
                        <h1 class="text-3xl font-black tracking-tight leading-none text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-emerald-500">
                            Konfigurasi Hak Akses
                        </h1>
                        <p class="text-sm font-bold text-slate-900 mt-2 flex items-center gap-2">
                            Kelola matriks izin (permissions) untuk setiap peran (roles) secara dinamis.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-teal-700 bg-teal-50 rounded-2xl border border-teal-100 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('message') }}
        </div>
    @endif

    {{-- ── Matrix Table ── --}}
    <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-900 uppercase tracking-widest min-w-[250px]">Fitur / Izin</th>
                        @foreach($roles as $role)
                            <th class="px-8 py-5 text-center text-[10px] font-black text-slate-900 uppercase tracking-widest">{{ $role->display_name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($permissions as $permission)
                    <tr class="group hover:bg-teal-50/30 transition-all duration-300">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-900">{{ $permission->description }}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $permission->name }}</span>
                            </div>
                        </td>
                        @foreach($roles as $role)
                        <td class="px-8 py-6 text-center">
                            <label class="relative inline-flex items-center cursor-pointer group/toggle">
                                <input type="checkbox" 
                                       wire:click="togglePermission({{ $role->id }}, {{ $permission->id }})"
                                       class="sr-only peer" 
                                       {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                            </label>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Info Card ── --}}
    <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <span class="material-symbols-outlined text-[120px]">security</span>
        </div>
        <div class="relative z-10 max-w-2xl">
            <h3 class="text-xl font-black mb-4">Informasi Keamanan</h3>
            <p class="text-slate-400 text-sm leading-relaxed mb-6 font-medium">
                Perubahan pada matriks hak akses ini akan langsung berdampak pada seluruh pengguna dengan peran tersebut. 
                <span class="text-teal-400 font-bold underline">Admin RW</span> memiliki akses tak terbatas ke seluruh sistem dan tidak dipengaruhi oleh pengaturan pada matriks ini.
            </p>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-xl border border-white/10">
                    <div class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Live Sync Active</span>
                </div>
            </div>
        </div>
    </div>
</div>
