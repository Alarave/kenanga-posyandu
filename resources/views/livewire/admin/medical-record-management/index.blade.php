<div class="space-y-6" wire:key="medical-records-root">
    {{-- Header Section (Replicated style) --}}
    <div class="relative mb-10">
        {{-- Decorative Background Element --}}
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-primary/5 rounded-lg blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative">
            <div class="space-y-2">

                {{-- Title & Subtitle --}}
                <div class="max-w-2xl relative z-10">
                    <h1 class="font-display-sm md:font-display-lg text-display-sm-mobile md:text-display-lg text-teal-700 mb-2 tracking-tight">Manajemen Rekam Medis</h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">Kelola data kunjungan dan rekam kesehatan warga secara sistematis.</p>
                </div>
            </div>
            
            {{-- Action Buttons with Better Styling --}}
            <div class="flex flex-wrap gap-3 items-center justify-end flex-1">
                @can('create', App\Models\MedicalRecord::class)
                <a href="{{ route('admin.medical-records.bulk') }}" 
                   class="flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-white border border-slate-100 text-xs font-black uppercase tracking-widest text-on-surface-variant hover:text-primary hover:border-primary hover:shadow-lg hover:shadow-teal-500/5 transition-all group/btn">
                    <span class="material-symbols-outlined text-[20px] text-outline-variant group-hover/btn:text-teal-500 transition-colors">assignment_turned_in</span>
                    Bulan Penimbangan
                </a>
                @endcan
                
                @can('create', App\Models\MedicalRecord::class)
                <a href="{{ route('admin.medical-records.create') }}" 
                   class="flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-linear-to-br from-teal-600 to-emerald-500 text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-teal-200 hover:shadow-teal-300 hover:-translate-y-0.5 transition-all group/add">
                    <span class="material-symbols-outlined text-[20px] group-hover/add:rotate-90 transition-transform duration-500">add_circle</span>
                    Tambah Rekam Medis
                </a>
                @endcan
            </div>
        </div>
    </div>

    {{-- ── Search & Filter Bento ── --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-4 shadow-sm flex flex-col gap-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 flex-1">
                {{-- Search Input --}}
                <div class="flex-1 flex items-center gap-2 px-4 py-2 bg-surface-container rounded-lg w-full md:max-w-md">
    <span class="material-symbols-outlined text-outline">search</span>
    <input wire:model.live.debounce.150ms="search" class="bg-transparent border-none focus:ring-0 w-full font-body-md text-body-md text-on-surface placeholder-outline-variant outline-none" placeholder="Cari nama warga atau NIK..." type="text"/>
</div>

                {{-- Posyandu Filter --}}
                @if(auth()->user()->isSuperAdmin())
                <div class="w-48">
                    <x-forms.select-input wire:model.live="posyandu_id" placeholder="Seluruh Unit" :placeholderDisabled="false" value="{{ $posyandu_id }}" class="h-12! rounded-2xl! bg-surface-container-low/50! border-slate-100! text-xs! font-black! uppercase! tracking-widest! text-on-surface-variant! focus:border-primary! pr-10">
                        @foreach(\App\Models\Posyandu::all() as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </x-forms.select-input>
                </div>
                @endif
            </div>
            
            @if($search || $posyandu_id)
                <button wire:click="$set('search', ''); $set('posyandu_id', '');"
                        class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] hover:text-error transition-colors px-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    Reset Filter
                </button>
            @endif
        </div>

        {{-- Sort Options Row --}}
        <div class="flex items-center gap-2 flex-wrap pb-2 border-t border-slate-50 pt-4">
            <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest mr-2">Urutkan:</span>
            
            {{-- Sort by Patient Name --}}
            <div class="flex gap-1">
                <button wire:click="$set('sortBy', 'patient_name_asc')"
                        @class(['px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all', 
                                'bg-teal-100 text-primary ring-1 ring-teal-200' => $sortBy === 'patient_name_asc',
                                'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' => $sortBy !== 'patient_name_asc'])
                        title="Nama A-Z">
                    <span class="material-symbols-outlined text-[12px]">sort_by_alpha</span>
                </button>
                <button wire:click="$set('sortBy', 'patient_name_desc')"
                        @class(['px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all', 
                                'bg-teal-100 text-primary ring-1 ring-teal-200' => $sortBy === 'patient_name_desc',
                                'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' => $sortBy !== 'patient_name_desc'])
                        title="Nama Z-A">
                    <span class="material-symbols-outlined text-[12px]">sort_by_alpha</span><span class="text-[8px] ml-0.5">↓</span>
                </button>
            </div>

            {{-- Sort by Visit Date --}}
            <div class="flex gap-1">
                <button wire:click="$set('sortBy', 'visit_date_asc')"
                        @class(['px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all', 
                                'bg-teal-100 text-primary ring-1 ring-teal-200' => $sortBy === 'visit_date_asc',
                                'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' => $sortBy !== 'visit_date_asc'])
                        title="Tanggal Lama - Baru">
                    <span class="material-symbols-outlined text-[12px]">calendar_month</span>
                </button>
                <button wire:click="$set('sortBy', 'visit_date_desc')"
                        @class(['px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all', 
                                'bg-teal-100 text-primary ring-1 ring-teal-200' => $sortBy === 'visit_date_desc',
                                'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' => $sortBy !== 'visit_date_desc'])
                        title="Tanggal Baru - Lama">
                    <span class="material-symbols-outlined text-[12px]">calendar_month</span><span class="text-[8px] ml-0.5">↓</span>
                </button>
            </div>

            {{-- Sort by Updated Date --}}
            <div class="flex gap-1">
                <button wire:click="$set('sortBy', 'updated_at_asc')"
                        @class(['px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all', 
                                'bg-teal-100 text-primary ring-1 ring-teal-200' => $sortBy === 'updated_at_asc',
                                'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' => $sortBy !== 'updated_at_asc'])
                        title="Edit Lama - Baru">
                    <span class="material-symbols-outlined text-[12px]">update</span>
                </button>
                <button wire:click="$set('sortBy', 'updated_at_desc')"
                        @class(['px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all', 
                                'bg-teal-100 text-primary ring-1 ring-teal-200' => $sortBy === 'updated_at_desc',
                                'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' => $sortBy !== 'updated_at_desc'])
                        title="Edit Baru - Lama">
                    <span class="material-symbols-outlined text-[12px]">update</span><span class="text-[8px] ml-0.5">↓</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Data Table ── --}}
    <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-left text-[10px] font-black text-on-surface uppercase tracking-widest">Waktu Kunjungan</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-on-surface uppercase tracking-widest">Pasien</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-on-surface uppercase tracking-widest">Antropometri</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black text-on-surface uppercase tracking-widest">Petugas</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black text-on-surface uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($medicalRecords as $record)
                    <tr class="group hover:bg-primary-container/30 transition-all duration-300" wire:key="record-{{ $record->id }}">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-on-surface">
                                    {{ $record->visit_date ? \Carbon\Carbon::parse($record->visit_date)->format('d M Y') : '-' }}
                                </span>
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest mt-1">Visit ID: #{{ $record->id }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center font-black text-sm border border-teal-100 group-hover:bg-primary group-hover:text-white transition-all duration-500">
                                    {{ strtoupper(substr($record->patient->full_name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-black text-on-surface">{{ $record->patient->full_name ?? 'Tidak Diketahui' }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        @php
                                            $cat = $record->patient->category ?? 'balita';
                                            $catLabels = [
                                                'ibu_hamil' => 'Ibu Hamil',
                                                'lansia' => 'Lansia',
                                                'balita' => 'Balita',
                                                'bayi' => 'Bayi',
                                                'baduta' => 'Baduta',
                                                'anak_sekolah' => 'Anak Sekolah'
                                            ];
                                            $catColors = [
                                                'ibu_hamil' => 'text-pink-600 bg-pink-50 border border-pink-100',
                                                'lansia' => 'text-purple-600 bg-purple-50 border border-purple-100',
                                                'balita' => 'text-secondary bg-blue-50 border border-blue-100',
                                                'bayi' => 'text-sky-600 bg-sky-50 border border-sky-100',
                                                'baduta' => 'text-secondary bg-secondary-container border border-indigo-100',
                                                'anak_sekolah' => 'text-primary bg-emerald-50 border border-emerald-100',
                                            ];
                                            $label = $catLabels[$cat] ?? ucfirst(str_replace('_', ' ', $cat));
                                            $colorClass = $catColors[$cat] ?? 'text-primary bg-primary-container border border-teal-100';
                                        @endphp
                                        <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-lg {{ $colorClass }}">
                                            {{ $label }}
                                        </span>
                                        <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest">
                                            Age: {{ $record->patient->age ?? '?' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex gap-4">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest">Weight</span>
                                    <span class="text-sm font-black text-on-surface">{{ $record->weight ?? '-' }} <small class="text-outline-variant font-bold ml-0.5">kg</small></span>
                                </div>
                                <div class="w-px h-8 bg-surface-container"></div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest">Height</span>
                                    <span class="text-sm font-black text-on-surface">{{ $record->height ?? '-' }} <small class="text-outline-variant font-bold ml-0.5">cm</small></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-on-surface-variant">{{ $record->user->name ?? '-' }}</span>
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest mt-1">Kader</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-1 group-hover:translate-y-0">
                                <a href="{{ route('admin.medical-records.show', $record->id) }}" 
                                   class="w-10 h-10 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-outline-variant hover:text-primary hover:border-primary hover:shadow-lg transition-all">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>
                                @can('update', $record)
                                <a href="{{ route('admin.medical-records.edit', $record->id) }}" 
                                   class="w-10 h-10 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-outline-variant hover:text-secondary hover:border-secondary hover:shadow-lg transition-all">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                @endcan
                                
                                @can('delete', $record)
                                <form action="{{ route('admin.medical-records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-outline-variant hover:text-error hover:border-error hover:shadow-lg transition-all">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 rounded-lg bg-surface-container-low flex items-center justify-center text-slate-200">
                                    <span class="material-symbols-outlined text-[48px]">medical_information</span>
                                </div>
                                <p class="text-[10px] font-black text-outline-variant uppercase tracking-widest">Tidak ada rekam medis ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($medicalRecords->hasPages())
        <div class="px-8 py-6 bg-surface-container-low border-t border-slate-100">
            {{ $medicalRecords->links() }}
        </div>
        @endif
    </div>
</div>