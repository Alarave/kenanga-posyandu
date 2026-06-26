<div class="space-y-8">
    {{-- Premium Header Section --}}
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-teal-600 via-emerald-600 to-teal-700 p-8 md:p-10 shadow-2xl shadow-teal-900/20">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-400/10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div class="space-y-3">
                {{-- Title & Subtitle with Icon --}}
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shrink-0 border border-white/30 shadow-lg">
                        <span class="material-symbols-outlined text-white text-[32px]">groups</span>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-black tracking-tight text-white leading-tight">
                            Manajemen Data Warga
                        </h1>
                        <p class="text-base font-medium text-teal-100 mt-2 max-w-xl">
                            Kelola data penduduk wilayah Anda dengan sistem terintegrasi untuk layanan posyandu yang lebih baik.
                        </p>
                    </div>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3 items-center lg:ml-auto">
                @can('create', App\Models\Patient::class)
                <a href="{{ route('admin.patients.import') }}" 
                   class="group flex items-center gap-2.5 px-6 py-4 rounded-2xl bg-white/15 backdrop-blur-md border border-white/30 text-white font-semibold text-sm hover:bg-white/25 hover:border-white/50 transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg">
                    <span class="material-symbols-outlined text-[22px] group-hover:rotate-12 transition-transform">publish</span>
                    <span>Import Data</span>
                </a>
                
                <a href="{{ route('admin.patients.create') }}" 
                   class="group flex items-center gap-2.5 px-6 py-4 rounded-2xl bg-white text-teal-700 font-bold text-sm hover:bg-teal-50 transition-all duration-300 hover:scale-105 active:scale-95 shadow-xl shadow-black/20">
                    <span class="material-symbols-outlined text-[22px]">add_circle</span>
                    <span>Tambah Warga Baru</span>
                </a>
                @endcan
            </div>
        </div>
    </div>

    @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="p-6 bg-amber-50 border border-amber-200 rounded-4xl text-sm flex flex-col gap-3 shadow-sm animate-in slide-in-from-top-4 duration-300">
            <div class="flex items-center gap-3 text-amber-800 font-black">
                <span class="material-symbols-outlined text-amber-600 text-[24px]">warning</span>
                <span>Detail Catatan/Peringatan Proses Import:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-amber-700 font-semibold pl-2 max-h-60 overflow-y-auto">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── Summary Statistics Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-8 gap-4">
        @php
            $stats = [
                ['key' => 'bayi', 'label' => 'Bayi', 'sub' => '0-11 bln', 'icon' => 'baby_changing_station', 'color' => 'blue', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                ['key' => 'baduta', 'label' => 'Baduta', 'sub' => '12-23 bln', 'icon' => 'child_friendly', 'color' => 'blue', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                ['key' => 'balita', 'label' => 'Balita', 'sub' => '24-59 bln', 'icon' => 'child_care', 'color' => 'teal', 'bg' => 'bg-teal-50', 'text' => 'text-teal-600'],
                ['key' => 'anak_sekolah', 'label' => 'Sekolah', 'sub' => '6-9 th', 'icon' => 'school', 'color' => 'indigo', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                ['key' => 'ibu_hamil', 'label' => 'Hamil', 'sub' => 'Bumil', 'icon' => 'pregnant_woman', 'color' => 'rose', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600'],
                ['key' => 'remaja', 'label' => 'Remaja', 'sub' => '10-18 th', 'icon' => 'emoji_people', 'color' => 'purple', 'bg' => 'bg-purple-50', 'text' => 'text-purple-600'],
                ['key' => 'lansia', 'label' => 'Lansia', 'sub' => '60+ th', 'icon' => 'elderly', 'color' => 'amber', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
                ['key' => 'umum', 'label' => 'Umum', 'sub' => 'Dewasa', 'icon' => 'groups', 'color' => 'slate', 'bg' => 'bg-slate-50', 'text' => 'text-slate-600'],
            ];
        @endphp
        
        @foreach($stats as $stat)
        <div class="group relative bg-white rounded-3xl p-5 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-{{ $stat['color'] }}-100/50 hover:border-{{ $stat['color'] }}-200 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
            {{-- Hover gradient background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-{{ $stat['color'] }}-50/0 to-{{ $stat['color'] }}-50/0 group-hover:from-{{ $stat['color'] }}-50/80 group-hover:to-{{ $stat['color'] }}-50/30 transition-all duration-500"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-2xl {{ $stat['bg'] }} {{ $stat['text'] }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined text-[22px]">{{ $stat['icon'] }}</span>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-black text-slate-800 leading-none" style="font-variant-numeric: tabular-nums;">
                        {{ App\Models\Patient::where('category', $stat['key'])->count() }}
                    </p>
                    <p class="text-[10px] font-semibold text-slate-400">{{ $stat['sub'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Search & Filter Bar ── --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-lg shadow-slate-200/50 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            {{-- Search Input --}}
            <div class="flex-1 relative group">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 z-10">
                    <span class="material-symbols-outlined text-slate-400 group-focus-within:text-teal-600 transition-colors">search</span>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari berdasarkan NIK atau nama warga..."
                       class="w-full h-14 pl-14 pr-12 bg-slate-50 border-2 border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition-all duration-300">
                
                {{-- Loading Spinner --}}
                <div wire:loading wire:target="search" class="absolute right-5 top-1/2 -translate-y-1/2">
                    <svg class="animate-spin h-6 w-6 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                @if($search)
                <button wire:click="$set('search', '')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg p-1.5 transition-all">
                    <span class="material-symbols-outlined text-[20px]">cancel</span>
                </button>
                @endif
            </div>

            {{-- Category Filter Dropdown --}}
            <div class="w-full lg:w-64">
                <div class="relative">
                    <select wire:model.live="category"
                            class="w-full h-14 pl-5 pr-10 bg-slate-50 border-2 border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition-all duration-300 appearance-none cursor-pointer">
                        <option value="all">📋 Semua Kategori</option>
                        <option value="bayi">👶 Bayi</option>
                        <option value="baduta">🧒 Baduta</option>
                        <option value="balita">👣 Balita</option>
                        <option value="anak_sekolah">🎓 Anak Sekolah</option>
                        <option value="ibu_hamil">🤰 Ibu Hamil</option>
                        <option value="remaja">🧑 Remaja</option>
                        <option value="lansia">👴 Lansia</option>
                        <option value="umum">👤 Umum</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                </div>
            </div>

            @if($search || $category !== 'all')
            <button wire:click="resetFilters"
                    class="h-14 px-6 flex items-center gap-2.5 bg-red-50 border-2 border-red-200 text-red-600 font-bold text-sm rounded-2xl hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-300 hover:scale-105 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">refresh</span>
                <span>Reset Filter</span>
            </button>
            @endif
        </div>
    </section>

    {{-- Flash Messages --}}
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    {{-- ── Data Table ── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
        {{-- Table Header Info --}}
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-white to-slate-50/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">table_chart</span>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800">Daftar Warga Terdaftar</h3>
                    <p class="text-xs font-semibold text-slate-400">Total {{ $patients->total() }} data ditampilkan</p>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-50 via-slate-50/80 to-transparent border-b border-slate-200">
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">person</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Warga</span>
                                    <span class="text-[10px] font-semibold text-slate-400">Nama & NIK</span>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">categorize</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Kategori</span>
                                    <span class="text-[10px] font-semibold text-slate-400">Klasifikasi</span>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">local_hospital</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Informasi</span>
                                    <span class="text-[10px] font-semibold text-slate-400">Posyandu & Usia</span>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Aksi</span>
                                    <span class="text-[10px] font-semibold text-slate-400">Pengaturan</span>
                                </div>
                                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">settings</span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $patient)
                    @php
                        $initials = strtoupper(substr($patient->full_name, 0, 2));
                        $catConfig = [
                            'bayi'         => ['label' => 'Bayi', 'color' => 'blue', 'bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'baby_changing_station'],
                            'baduta'       => ['label' => 'Baduta', 'color' => 'blue', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-300', 'icon' => 'child_friendly'],
                            'balita'       => ['label' => 'Balita', 'color' => 'teal', 'bg' => 'bg-teal-50', 'text' => 'text-teal-700', 'border' => 'border-teal-200', 'icon' => 'child_care'],
                            'anak_sekolah' => ['label' => 'Sekolah', 'color' => 'indigo', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'icon' => 'school'],
                            'ibu_hamil'    => ['label' => 'Hamil', 'color' => 'rose', 'bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'icon' => 'pregnant_woman'],
                            'remaja'       => ['label' => 'Remaja', 'color' => 'purple', 'bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'emoji_people'],
                            'lansia'       => ['label' => 'Lansia', 'color' => 'amber', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'elderly'],
                            'umum'         => ['label' => 'Umum', 'color' => 'slate', 'bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'icon' => 'person'],
                        ];
                        $config = $catConfig[$patient->category] ?? $catConfig['umum'];
                    @endphp
                    <tr class="group hover:bg-gradient-to-r hover:from-teal-50/30 hover:to-transparent transition-all duration-300" wire:key="patient-{{ $patient->id }}">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                @if($patient->profile_photo)
                                    <img src="{{ asset('storage/' . $patient->profile_photo) }}" 
                                         class="h-14 w-14 rounded-2xl object-cover border-2 border-white shadow-lg group-hover:scale-105 group-hover:shadow-xl transition-all duration-300"
                                         alt="{{ $patient->full_name }}">
                                @else
                                    <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 text-white flex items-center justify-center font-black text-lg border-2 border-white shadow-lg group-hover:scale-105 group-hover:shadow-xl transition-all duration-300">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="font-bold text-slate-800 text-base truncate group-hover:text-teal-700 transition-colors">{{ $patient->full_name }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-mono font-semibold uppercase tracking-wider">
                                            <span class="material-symbols-outlined text-[12px]">badge</span>
                                            {{ $patient->id_number }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wide border-2 {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} shadow-sm group-hover:shadow-md transition-shadow">
                                <span class="material-symbols-outlined text-[16px]">{{ $config['icon'] }}</span>
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="space-y-2">
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200">
                                    <span class="material-symbols-outlined text-[16px] text-teal-600">local_pharmacy</span>
                                    <span class="text-sm font-bold text-slate-700">{{ $patient->posyandu->name ?? '—' }}</span>
                                </div>
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 ml-1">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">calendar_today</span>
                                    <span class="text-xs font-semibold text-slate-600">{{ $patient->age }} tahun</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-2">
                                {{-- View Detail --}}
                                <a href="{{ route('admin.patients.show', $patient->id) }}" 
                                   class="group/btn relative w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 border-2 border-slate-200 text-slate-500 hover:bg-teal-500 hover:text-white hover:border-teal-500 hover:shadow-lg hover:shadow-teal-200 transition-all duration-300 hover:scale-110 active:scale-95"
                                   title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[20px] group-hover/btn:scale-125 transition-transform">visibility</span>
                                </a>

                                {{-- Edit --}}
                                @can('update', $patient)
                                <a href="{{ route('admin.patients.edit', $patient->id) }}" 
                                   class="group/btn relative w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 border-2 border-slate-200 text-slate-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 hover:shadow-lg hover:shadow-amber-200 transition-all duration-300 hover:scale-110 active:scale-95"
                                   title="Edit Data">
                                    <span class="material-symbols-outlined text-[20px] group-hover/btn:rotate-12 transition-transform">edit</span>
                                </a>
                                @endcan

                                {{-- Delete --}}
                                @can('delete', $patient)
                                <button wire:click="confirmDelete({{ $patient->id }})" 
                                        class="group/btn relative w-11 h-11 flex items-center justify-center rounded-2xl bg-red-50 border-2 border-red-200 text-red-400 hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-lg hover:shadow-red-200 transition-all duration-300 hover:scale-110 active:scale-95"
                                        title="Hapus Data">
                                    <span class="material-symbols-outlined text-[20px] group-hover/btn:scale-125 transition-transform">delete</span>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-24 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center shadow-inner">
                                    <span class="material-symbols-outlined text-[72px] text-slate-300">person_off</span>
                                </div>
                                <div class="text-center">
                                    <p class="text-lg font-black text-slate-500 uppercase tracking-widest mb-2">Data Kosong</p>
                                    <p class="text-sm font-medium text-slate-400 max-w-md mx-auto">Belum ada data warga yang terdaftar. Silakan tambahkan data warga baru atau import dari file Excel.</p>
                                </div>
                                @can('create', App\Models\Patient::class)
                                <div class="flex gap-3 mt-2">
                                    <a href="{{ route('admin.patients.create') }}" 
                                       class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-teal-500 text-white font-bold text-sm hover:bg-teal-600 transition-all duration-300 hover:scale-105 shadow-lg shadow-teal-200">
                                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                        <span>Tambah Warga</span>
                                    </a>
                                    <a href="{{ route('admin.patients.import') }}" 
                                       class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200 transition-all duration-300 hover:scale-105">
                                        <span class="material-symbols-outlined text-[18px]">publish</span>
                                        <span>Import Data</span>
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Pagination ── --}}
    <div class="px-6 py-4 bg-white border-t border-slate-100">
        <x-layouts.ui.pagination :paginator="$patients" />
    </div>

    {{-- ── Delete Confirmation Modal ── --}}
    <div x-data="{ open: @entangle('showDeleteModal') }">
        <x-modals.confirm-modal
            title="Hapus Data Warga"
            message="Apakah Anda yakin ingin menghapus data warga ini?"
            sub-message="Seluruh riwayat pemeriksaan medis warga ini juga akan dihapus secara permanen."
            type="danger"
            confirm-text="Ya, Hapus Permanen"
        >
            <x-slot:footer>
                <x-button @click="open = false" variant="outline">Batal</x-button>
                <x-button wire:click="deletePatient" variant="danger" icon="delete">Ya, Hapus</x-button>
            </x-slot:footer>
        </x-modals.confirm-modal>
    </div>
</div>
