<div class="space-y-8 p-6 md:p-8 pt-4">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8 relative">
        <div class="relative pl-6 z-10">
            {{-- Vertical Glowing Bar --}}
            <div class="absolute left-0 top-1 bottom-1 w-1.5 bg-linear-to-b from-teal-400 to-emerald-300 rounded-lg shadow-[0_0_12px_rgba(45,212,191,0.6)]"></div>
            
            <div class="flex flex-col gap-3">
                <div>
                    <h1 class="font-display-sm md:font-display-lg text-display-sm-mobile md:text-display-lg text-teal-700 mb-2 tracking-tight">
                        Rekap & Laporan
                    </h1>
                    <p class="text-sm font-medium text-outline mt-3">Analisis data kunjungan dan status kesehatan warga secara komprehensif.</p>
                </div>
            </div>
        </div>
        
        {{-- Decorative Background Glow --}}
        <div class="absolute right-0 top-0 w-64 h-64 bg-teal-400/5 rounded-lg blur-3xl -z-10 pointer-events-none"></div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 bg-emerald-50/80 backdrop-blur-sm border border-emerald-100 text-emerald-800 rounded-2xl text-sm font-medium shadow-sm animate-fade-in">
            <span class="material-symbols-outlined text-emerald-500 text-[22px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-5 py-4 bg-error-container/80 backdrop-blur-sm border border-rose-100 text-rose-800 rounded-2xl text-sm font-medium shadow-sm animate-fade-in">
            <span class="material-symbols-outlined text-error text-[22px]">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Filter Section (Glassmorphism & Floating Style) ── --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] p-6 relative overflow-hidden">
        {{-- Inner subtle glow --}}
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-teal-500/5 rounded-lg blur-3xl pointer-events-none"></div>
        
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined text-teal-600 text-[20px]">filter_list</span>
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Filter Laporan</h3>
        </div>
        
        <div class="flex flex-wrap items-end gap-5 relative z-10">
            {{-- Pilih Posyandu (superadmin only) --}}
            @if(auth()->user()->isSuperAdmin())
            <div class="flex-1 min-w-50">
                <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest ml-1 mb-2">Posyandu</label>
                <x-forms.select-input wire:model.live="selectedPosyanduId" class="rounded-2xl! bg-slate-50/50! focus:bg-white! border-slate-100! shadow-inner-sm transition-all focus:border-teal-500!">
                    <option value="">Semua Posyandu</option>
                    @foreach($posyandus as $pos)
                        <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                    @endforeach
                </x-forms.select-input>
            </div>
            @endif

            {{-- Tanggal Mulai --}}
            <div class="flex-1 min-w-35">
                <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest ml-1 mb-2">Periode Mulai</label>
                <input type="month" wire:model.live="startPeriod" class="w-full h-12 px-4 rounded-2xl border-2 border-slate-100 bg-slate-50/50 text-sm font-semibold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-0 transition-all">
            </div>

            {{-- Divider --}}
            <div class="hidden md:flex items-center justify-center w-6 h-12 pb-2">
                <span class="material-symbols-outlined text-slate-300">arrow_right_alt</span>
            </div>

            {{-- Tanggal Akhir --}}
            <div class="flex-1 min-w-35">
                <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest ml-1 mb-2">Periode Selesai</label>
                <input type="month" wire:model.live="endPeriod" class="w-full h-12 px-4 rounded-2xl border-2 border-slate-100 bg-slate-50/50 text-sm font-semibold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-0 transition-all">
            </div>

            {{-- Tombol Tampilkan --}}
            <button wire:click="generateReport"
                    wire:loading.attr="disabled"
                    class="h-12 px-8 bg-linear-to-r from-teal-600 to-emerald-500 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 shadow-[0_8px_16px_-6px_rgba(13,148,136,0.4)]">
                <span wire:loading.remove wire:target="generateReport" class="material-symbols-outlined text-[18px]">magic_button</span>
                <svg wire:loading wire:target="generateReport" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span wire:loading.remove wire:target="generateReport">Analisis</span>
                <span wire:loading wire:target="generateReport">Proses...</span>
            </button>
        </div>
    </section>

    {{-- ── Stats Cards ── --}}
    @if($reportGenerated)
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

        {{-- Total Kunjungan --}}
        <div class="group bg-white rounded-3xl border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg hover:border-emerald-250">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100/50 px-2.5 py-1 rounded-full w-fit">
                    <span class="material-symbols-outlined text-[16px]">group</span>
                    <span class="text-[9px] font-black uppercase tracking-wider">Bulan Ini</span>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest">Total Kunjungan</p>
                <h3 class="text-3xl font-black text-slate-800 mt-2 mb-1 tracking-tight leading-none">{{ $totalKunjungan }}</h3>
                <p class="text-[10px] text-slate-400 font-semibold mt-1.5">{{ $periodLabel }}</p>
            </div>
        </div>

        {{-- Balita Stunting --}}
        <div class="group bg-white rounded-3xl border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg hover:border-rose-250">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-1.5 bg-rose-50 text-rose-700 border border-rose-100/50 px-2.5 py-1 rounded-full w-fit">
                    <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1;">warning</span>
                    <span class="text-[9px] font-black uppercase tracking-wider">Perhatian</span>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest">Balita Stunting</p>
                <h3 class="text-3xl font-black text-slate-800 mt-2 mb-1 tracking-tight leading-none">{{ $balitaStunting }}</h3>
                <p class="text-[10px] text-slate-400 font-semibold mt-1.5">Ditemukan bulan ini</p>
            </div>
        </div>

        {{-- Ibu Hamil --}}
        <div class="group bg-white rounded-3xl border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg hover:border-sky-250">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-1.5 bg-sky-50 text-sky-700 border border-sky-100/50 px-2.5 py-1 rounded-full w-fit">
                    <span class="material-symbols-outlined text-[16px]">female</span>
                    <span class="text-[9px] font-black uppercase tracking-wider">Terdaftar</span>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest">Ibu Hamil</p>
                <h3 class="text-3xl font-black text-slate-800 mt-2 mb-1 tracking-tight leading-none">{{ $totalIbuHamil }}</h3>
                <p class="text-[10px] text-slate-400 font-semibold mt-1.5">Terdaftar aktif</p>
            </div>
        </div>

        {{-- Cakupan Vitamin A --}}
        <div class="group bg-white rounded-3xl border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg hover:border-amber-250">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-100/50 px-2.5 py-1 rounded-full w-fit">
                    <span class="material-symbols-outlined text-[16px]">medication</span>
                    <span class="text-[9px] font-black uppercase tracking-wider">Target: 95%</span>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest">Cakupan Vitamin A</p>
                <h3 class="text-3xl font-black text-slate-800 mt-2 mb-1 tracking-tight leading-none">{{ $cakupanVitaminA }}%</h3>
                <p class="text-[10px] text-slate-400 font-semibold mt-1.5">Capaian posyandu</p>
            </div>
        </div>

        {{-- Lansia --}}
        <div class="group bg-white rounded-3xl border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg hover:border-indigo-250">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-1.5 bg-indigo-50 text-indigo-700 border border-indigo-100/50 px-2.5 py-1 rounded-full w-fit">
                    <span class="material-symbols-outlined text-[16px]">elderly</span>
                    <span class="text-[9px] font-black uppercase tracking-wider">Terdaftar</span>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest">Lansia</p>
                <h3 class="text-3xl font-black text-slate-800 mt-2 mb-1 tracking-tight leading-none">{{ $totalLansia }}</h3>
                <p class="text-[10px] text-slate-400 font-semibold mt-1.5">Terdaftar aktif</p>
            </div>
        </div>

    </section>

    {{-- ── Tabel Detail Kunjungan (Redesigned) ── --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] overflow-hidden flex flex-col">

        {{-- Header Tabel --}}
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex flex-wrap justify-between items-center gap-6">
            <div>
                <h2 class="text-headline-sm font-black text-slate-800 tracking-tight">Detail Kunjungan</h2>
                <p class="text-[13px] text-slate-500 font-medium mt-1"><span class="font-bold text-teal-600">{{ $posyanduName }}</span> • {{ $periodLabel }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                {{-- Ekspor Excel --}}
                <button wire:click="exportExcel"
                        wire:loading.attr="disabled"
                        wire:target="exportExcel"
                        class="h-11 px-5 bg-white border border-outline-variant text-on-surface-variant rounded-xl text-sm font-bold hover:border-emerald-500 hover:text-primary active:scale-95 transition-all flex items-center gap-2 shadow-sm group">
                    <span wire:loading.remove wire:target="exportExcel" class="material-symbols-outlined text-[18px] text-emerald-500 group-hover:scale-110 transition-transform">description</span>
                    <svg wire:loading wire:target="exportExcel" class="animate-spin h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>Excel</span>
                </button>

                {{-- Ekspor PDF --}}
                <button wire:click="exportPdf"
                        wire:loading.attr="disabled"
                        wire:target="exportPdf"
                        class="h-11 px-5 bg-white border border-outline-variant text-on-surface-variant rounded-xl text-sm font-bold hover:border-error hover:text-error active:scale-95 transition-all flex items-center gap-2 shadow-sm group">
                    <span wire:loading.remove wire:target="exportPdf" class="material-symbols-outlined text-[18px] text-error group-hover:scale-110 transition-transform">picture_as_pdf</span>
                    <svg wire:loading wire:target="exportPdf" class="animate-spin h-4 w-4 text-error" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>PDF</span>
                </button>
            </div>
        </div>

        {{-- Search & Sort Section --}}
        <div class="px-6 lg:px-8 py-5 border-b border-slate-100 bg-white">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4 w-full">
                {{-- Search Input --}}
                <div class="relative w-full lg:max-w-xs xl:max-w-sm group">
                    <div class="absolute inset-y-0 left-0 w-10 flex items-center justify-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-350 group-focus-within:text-teal-500 transition-colors text-[20px]">search</span>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" 
                           placeholder="Cari Nama/NIK..."
                           class="w-full pl-10 pr-4 h-11 rounded-2xl border border-slate-200 bg-slate-50/50 text-[13px] font-semibold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all shadow-sm">
                </div>

                {{-- Filter Posyandu (Hanya untuk Superadmin) --}}
                @if(auth()->user()->isSuperAdmin())
                <div class="w-full lg:w-48 shrink-0">
                    <div class="relative">
                        <select wire:model.live="selectedPosyanduId" 
                                class="w-full h-11 pl-4 pr-10 rounded-2xl border border-slate-200 bg-slate-50/50 text-[13px] font-bold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all appearance-none shadow-sm">
                            <option value="">Semua Posyandu</option>
                            @foreach($posyandus as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-450">
                            <span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Filter Bulan --}}
                <div class="w-full lg:w-44 shrink-0">
                    <div class="relative">
                        <select wire:model.live="filterMonth" 
                                class="w-full h-11 pl-4 pr-10 rounded-2xl border border-slate-200 bg-slate-50/50 text-[13px] font-bold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all appearance-none shadow-sm">
                            <option value="">Semua Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-450">
                            <span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>
                        </div>
                    </div>
                </div>

                {{-- Filter Kategori --}}
                <div class="w-full lg:w-44 shrink-0">
                    <div class="relative">
                        <select wire:model.live="filterCategory" 
                                class="w-full h-11 pl-4 pr-10 rounded-2xl border border-slate-200 bg-slate-50/50 text-[13px] font-bold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all appearance-none shadow-sm">
                            <option value="">Semua Kategori</option>
                            <option value="balita">Balita</option>
                            <option value="ibu_hamil">Ibu Hamil</option>
                            <option value="lansia">Lansia</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-450">
                            <span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sort Options Row --}}
            <div class="flex items-center gap-3 overflow-x-auto hide-scrollbar w-full pb-1">
                <span class="text-[10px] font-black text-slate-450 uppercase tracking-widest whitespace-nowrap shrink-0">Urutkan:</span>
            
                {{-- Sort by Patient Name --}}
                <div class="flex bg-slate-100/80 p-1 rounded-xl">
                    <button wire:click="$set('sortBy', 'patient_name_asc')"
                            @class(['px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap flex items-center gap-1', 
                                    'bg-white text-teal-600 shadow-sm border border-slate-100/10' => $sortBy === 'patient_name_asc',
                                    'text-slate-500 hover:text-slate-800' => $sortBy !== 'patient_name_asc'])>
                        <span class="material-symbols-outlined text-[14px]">sort_by_alpha</span> A-Z
                    </button>
                    <button wire:click="$set('sortBy', 'patient_name_desc')"
                            @class(['px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap flex items-center gap-1', 
                                    'bg-white text-teal-600 shadow-sm border border-slate-100/10' => $sortBy === 'patient_name_desc',
                                    'text-slate-500 hover:text-slate-800' => $sortBy !== 'patient_name_desc'])>
                        <span class="material-symbols-outlined text-[14px]">sort_by_alpha</span> Z-A
                    </button>
                </div>

                {{-- Sort by Visit Date --}}
                <div class="flex bg-slate-100/80 p-1 rounded-xl">
                    <button wire:click="$set('sortBy', 'visit_date_desc')"
                            @class(['px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap flex items-center gap-1', 
                                    'bg-white text-teal-600 shadow-sm border border-slate-100/10' => $sortBy === 'visit_date_desc',
                                    'text-slate-500 hover:text-slate-800' => $sortBy !== 'visit_date_desc'])>
                        <span class="material-symbols-outlined text-[14px]">event_available</span> Terbaru
                    </button>
                    <button wire:click="$set('sortBy', 'visit_date_asc')"
                            @class(['px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap flex items-center gap-1', 
                                    'bg-white text-teal-600 shadow-sm border border-slate-100/10' => $sortBy === 'visit_date_asc',
                                    'text-slate-500 hover:text-slate-800' => $sortBy !== 'visit_date_asc'])>
                        <span class="material-symbols-outlined text-[14px]">history_toggle_off</span> Terlama
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest w-16">No</th>
                        <th class="px-6 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest">Nama & NIK</th>
                        <th class="px-6 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest">Usia</th>
                        <th class="px-6 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest">Kunjungan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest">Pengukuran</th>
                        <th class="px-6 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest">Status Gizi</th>
                        <th class="px-6 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest text-center">Tindakan</th>
                        <th class="px-8 py-4 text-[10px] font-black text-outline-variant uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50">
                    @forelse($records as $index => $record)
                    <tr class="hover:bg-slate-50 transition-colors group bg-white">
                        <td class="px-8 py-5 text-sm font-bold text-outline-variant">
                            {{ ($records->currentPage() - 1) * $records->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $cat = $record->patient->category ?? 'Lainnya';
                                $catColor = match(strtolower($cat)) {
                                    'bayi', 'baduta', 'balita' => 'text-emerald-700 bg-emerald-50/60 border-emerald-200/80',
                                    'ibu hamil', 'ibu_hamil' => 'text-sky-700 bg-sky-50/60 border-sky-200/80',
                                    'lansia' => 'text-amber-700 bg-amber-50/60 border-amber-200/80',
                                    default => 'text-slate-650 bg-slate-50/60 border-slate-200'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $catColor }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ match(strtolower($cat)) {
                                    'bayi', 'baduta', 'balita' => 'bg-emerald-500',
                                    'ibu hamil', 'ibu_hamil' => 'bg-sky-500',
                                    'lansia' => 'bg-amber-500',
                                    default => 'bg-slate-400'
                                } }}"></span>
                                {{ str_replace('_', ' ', $cat) }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                @if($record->patient?->profile_photo)
                                    <img src="{{ asset('storage/' . $record->patient->profile_photo) }}" class="h-9 w-9 rounded-xl object-cover border border-slate-100 flex-shrink-0">
                                @else
                                    @php
                                        $initials = $record->patient ? strtoupper(substr($record->patient->full_name, 0, 2)) : '-';
                                    @endphp
                                    <div class="h-9 w-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs flex-shrink-0 font-sans border border-slate-200/50">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-sm text-slate-800">{{ $record->patient->full_name ?? '-' }}</div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[11px] font-medium text-outline font-mono">{{ $record->patient->id_number ?? '' }}</span>
                                        @if(auth()->user()->isSuperAdmin() && !$selectedPosyanduId)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 text-[9px] font-bold border border-slate-200">
                                                {{ $record->patient->posyandu->name ?? '-' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($record->patient?->birth_date)
                                @php
                                    $cat = strtolower($record->patient->category ?? '');
                                    $birthDate = $record->patient->birth_date;
                                    $ageStr = '';
                                    if (in_array($cat, ['bayi', 'baduta', 'balita'])) {
                                        $ageStr = floor($birthDate->diffInMonths(now())) . ' Bln';
                                    } else {
                                        $years = (int) $birthDate->diffInYears(now());
                                        $months = (int) ($birthDate->diffInMonths(now()) % 12);
                                        if ($years > 0) {
                                            $ageStr = $years . ' Thn';
                                            if ($months > 0) {
                                                $ageStr .= ' ' . $months . ' Bln';
                                            }
                                        } else {
                                            $ageStr = $months . ' Bln';
                                        }
                                    }
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-50 text-slate-600 text-xs font-black border border-slate-100">
                                    {{ $ageStr }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-sm font-semibold text-slate-600">
                            {{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3.5 bg-slate-50/60 px-3.5 py-2 rounded-2xl border border-slate-100/50 w-fit">
                                <div class="flex items-center gap-1">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">BB</span>
                                    <span class="text-xs font-black text-slate-800">{{ $record->weight ? number_format($record->weight, 1) : '-' }} <span class="text-[10px] font-medium text-slate-450">kg</span></span>
                                </div>
                                <div class="w-px h-3 bg-slate-200"></div>
                                <div class="flex items-center gap-1">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">TB</span>
                                    <span class="text-xs font-black text-slate-800">{{ $record->height ? number_format($record->height, 1) : '-' }} <span class="text-[10px] font-medium text-slate-450">cm</span></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $status = $record->nutrition_status ?? null;
                                $badgeStyle = match($status ? strtolower(trim($status)) : null) {
                                    'normal', 'gizi baik', 'baik' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20',
                                    'gizi kurang', 'kurang' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20',
                                    'gizi lebih', 'lebih', 'berisiko gizi lebih', 'obesitas' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-600/20',
                                    'gizi buruk/stunting', 'gizi buruk', 'buruk', 'stunting' => 'bg-error-container text-rose-700 ring-1 ring-rose-600/20',
                                    default => 'bg-surface-container text-outline ring-1 ring-slate-400/20',
                                };
                                $icon = match($status ? strtolower(trim($status)) : null) {
                                    'gizi buruk/stunting', 'gizi buruk', 'buruk', 'stunting' => 'trending_down',
                                    'gizi kurang', 'kurang' => 'trending_down',
                                    'gizi lebih', 'lebih', 'berisiko gizi lebih', 'obesitas' => 'trending_up',
                                    'normal', 'gizi baik', 'baik' => 'check_circle',
                                    default => 'horizontal_rule',
                                };
                            @endphp
                            @if($status)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[11px] font-bold {{ $badgeStyle }}">
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1;">{{ $icon }}</span>
                                {{ $status }}
                            </span>
                            @else
                            <span class="text-xs text-outline-variant">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2.5">
                                @if($record->vitamin_a)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black border border-emerald-100/80">
                                        <span class="material-symbols-outlined text-[13px] font-black">check</span>
                                        Vit A
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full bg-slate-50 text-slate-400 text-[10px] font-black border border-slate-100">
                                        <span class="material-symbols-outlined text-[13px]">close</span>
                                        Vit A
                                    </span>
                                @endif

                                @if($record->pill_fe)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black border border-indigo-100/80">
                                        <span class="material-symbols-outlined text-[13px] font-black">check</span>
                                        Pil FE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full bg-slate-50 text-slate-400 text-[10px] font-black border border-slate-100">
                                        <span class="material-symbols-outlined text-[13px]">close</span>
                                        Pil FE
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('admin.reports.individual', ['patient' => $record->patient_id, 'start_month' => $startMonth, 'start_year' => $startYear, 'end_month' => $endMonth, 'end_year' => $endYear]) }}"
                               class="inline-flex items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm px-4 py-2.5 text-xs font-black text-slate-650 hover:bg-teal-50 hover:text-teal-700 hover:border-teal-300 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-[18px]">assignment_ind</span>
                                <span class="ml-1.5">Rapor</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4 text-outline-variant">
                                <div class="w-20 h-20 rounded-2xl bg-surface-container-low flex items-center justify-center border border-slate-100">
                                    <span class="material-symbols-outlined text-[40px] text-slate-300">search_off</span>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-on-surface-variant">Tidak ada data kunjungan</p>
                                    <p class="text-sm mt-1">Tidak ditemukan rekam medis untuk periode {{ $periodLabel }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($records instanceof \Illuminate\Pagination\LengthAwarePaginator && $records->hasPages())
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            <x-layouts.ui.pagination :paginator="$records" label="data" />
        </div>
        @elseif($records->count() > 0)
        <div class="p-4 border-t border-outline-variant">
            <p class="text-sm font-medium text-outline">Menampilkan total <span class="font-bold text-on-surface-variant">{{ $total }}</span> data</p>
        </div>
        @endif

    </section>
    @else
    {{-- Empty State --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] p-12 mt-8 text-center">
        <div class="flex flex-col items-center justify-center gap-4">
            <div class="w-20 h-20 rounded-2xl bg-teal-50 flex items-center justify-center border border-teal-100 mb-2">
                <span class="material-symbols-outlined text-[40px] text-teal-500" style="font-variation-settings:'FILL' 1;">analytics</span>
            </div>
            <div>
                <h2 class="text-headline-md font-black text-slate-800 tracking-tight">Pilih Periode Laporan</h2>
                <p class="text-sm font-medium text-slate-500 mt-2 max-w-md mx-auto leading-relaxed">Pilih posyandu, bulan, and tahun pada filter di atas lalu klik <span class="font-bold text-teal-650">Analisis</span> untuk menghasilkan rekap dan laporan detail.</p>
            </div>
        </div>
    </section>
    @endif

</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('download-file', (data) => {
            const link = document.createElement('a');
            link.href = data.url;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>
@endpush
