<div class="relative w-full lg:max-w-2xl" 
     x-data="{ open: false }" 
     @click.away="open = false"
     @keydown.escape.window="open = false"
     wire:ignore.self
     wire:key="global-search-root">
    {{-- Search Input Group --}}
    <div class="relative group">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-600 transition-colors pointer-events-none" style="font-size:14px;"></i>
        <input 
            wire:model.live.debounce.300ms="search"
            @focus="open = true"
            @keydown.slash.window="if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') { $event.preventDefault(); $el.focus(); }"
            type="text" 
            placeholder="Cari pasien, rekam medis, jadwal, artikel... "
            class="w-full h-11 pl-11 pr-4 rounded-2xl border-2 border-slate-100 bg-slate-50 text-slate-700 placeholder-slate-400 text-[14px] font-bold focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-400 focus:bg-white transition-all duration-300 shadow-sm hover:shadow-md"
        >
        
        {{-- Loading Spinner --}}
        <div wire:loading class="absolute right-4 top-1/2 -translate-y-1/2">
            <svg class="animate-spin h-5 w-5 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    {{-- Dropdown Results --}}
    <div 
        x-show="open && $wire.search.length >= 2"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-cloak
        class="absolute mt-3 w-full bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-100 overflow-hidden z-50 p-2"
    >
        @if(count($results['patients']) > 0 || count($results['schedules']) > 0 || count($results['articles']) > 0 || count($results['records']) > 0 || count($results['users']) > 0)
            <div class="max-h-125 overflow-y-auto space-y-1">
                {{-- Patients Section --}}
                @if(count($results['patients']) > 0)
                    <div>
                        <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pasien Terdaftar</div>
                        @foreach($results['patients'] as $patient)
                            <a href="{{ route('admin.patients.show', $patient->id) }}" class="flex items-center gap-3.5 p-2.5 hover:bg-slate-50 rounded-2xl transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600 font-black text-sm group-hover:bg-teal-100 group-hover:scale-105 transition-all">
                                    {{ substr($patient->full_name, 0, 1) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[14px] font-black text-slate-900 leading-tight group-hover:text-teal-600 transition-colors">{{ $patient->full_name }}</p>
                                    <p class="text-[11px] text-slate-500 font-bold mt-0.5 tracking-tight">{{ $patient->id_number }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Records Section --}}
                @if(count($results['records']) > 0)
                    <div>
                        <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Rekam Medis Terbaru</div>
                        @foreach($results['records'] as $record)
                            <a href="{{ route('admin.medical-records.show', $record->id) }}" class="flex items-center gap-3.5 p-2.5 hover:bg-slate-50 rounded-2xl transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-100 group-hover:scale-105 transition-all">
                                    <i class="fas fa-file-medical text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[14px] font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">RM: {{ $record->patient->full_name }}</p>
                                    <p class="text-[11px] text-slate-500 font-bold mt-0.5 tracking-tight">{{ $record->visit_date?->format('d M Y') ?? 'Baru' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Users Section --}}
                @if(count($results['users']) > 0)
                    <div>
                        <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Pengguna / Kader</div>
                        @foreach($results['users'] as $user)
                            <a href="#" class="flex items-center gap-3.5 p-2.5 hover:bg-slate-50 rounded-2xl transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 group-hover:bg-violet-100 group-hover:scale-105 transition-all font-black text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[14px] font-black text-slate-900 leading-tight group-hover:text-violet-600 transition-colors">{{ $user->name }}</p>
                                    <p class="text-slate-500 font-bold mt-0.5 uppercase tracking-widest text-[9px]">{{ $user->role ?? 'Kader' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Schedules Section --}}
                @if(count($results['schedules']) > 0)
                    <div>
                        <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Agenda Posyandu</div>
                        @foreach($results['schedules'] as $schedule)
                            <a href="{{ route('admin.schedules.index') }}" class="flex items-center gap-3.5 p-2.5 hover:bg-slate-50 rounded-2xl transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-100 group-hover:scale-105 transition-all">
                                    <i class="fas fa-calendar-alt text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[14px] font-black text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $schedule->title }}</p>
                                    <p class="text-[11px] text-slate-500 font-bold mt-0.5 tracking-tight">{{ $schedule->location }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Articles Section --}}
                @if(count($results['articles']) > 0)
                    <div>
                        <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Artikel Edukasi</div>
                        @foreach($results['articles'] as $article)
                            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3.5 p-2.5 hover:bg-slate-50 rounded-2xl transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-100 group-hover:scale-105 transition-all">
                                    <i class="fas fa-newspaper text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[14px] font-black text-slate-900 leading-tight group-hover:text-amber-600 transition-colors truncate max-w-75">{{ $article->title }}</p>
                                    <p class="text-[11px] text-slate-500 font-bold mt-0.5 tracking-tight">Update Terakhir</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <i class="fas fa-search text-slate-300 text-xl"></i>
                </div>
                <p class="text-[15px] font-black text-slate-900">Hasil tidak ditemukan</p>
                <p class="text-[12px] text-slate-500 mt-1 font-medium">Coba gunakan kata kunci lain seperti nama pasien atau NIK.</p>
            </div>
        @endif
    </div>
</div>
