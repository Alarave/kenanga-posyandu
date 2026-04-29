@extends('layouts.admin-layout')

@section('admin-title') Rekam Medis Bulanan @endsection

@section('admin-actions')
    @can('create', App\Models\MedicalRecord::class)
    <x-button href="{{ route('admin.medical-records.create') }}" variant="secondary" icon="note_add">
        Tambah Rekam Medis
    </x-button>
    @endcan
@endsection

@section('admin-content')
<div wire:key="medical-records-root">
    <div class="space-y-6">
        
        {{-- ── Search & Filter Bar ── --}}
        <section class="bg-slate-50/50 p-4 border-b border-slate-100">
            <div class="flex flex-wrap items-center gap-4">
                {{-- Search Input (Livewire) --}}
                <div class="flex-1 min-w-[280px] relative group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-600 transition-colors">search</span>
                    <input type="text" wire:model.live.debounce.150ms="search"
                           placeholder="Cari nama warga..."
                           class="w-full h-12 pl-12 pr-4 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all">
                </div>

                {{-- Posyandu Filter (Superadmin Only) --}}
                @if(auth()->user()->isSuperAdmin())
                <div class="w-full sm:w-auto min-w-[200px]">
                    <select wire:model.live="posyandu_id"
                            class="w-full h-12 px-4 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all appearance-none cursor-pointer">
                        <option value="">Semua Posyandu</option>
                        @foreach(\App\Models\Posyandu::all() as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if($search || $posyandu_id)
                <button wire:click="$set('search', ''); $set('posyandu_id', '');"
                        class="h-12 px-4 flex items-center gap-2 text-red-500 font-bold text-xs uppercase tracking-widest hover:bg-red-50 rounded-xl transition-all">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                    Reset
                </button>
                @endif
            </div>
        </section>

        {{-- ── Data Table ── --}}
        <x-table>
            <thead class="bg-slate-50/80 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-left">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-left">Warga / Pasien</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-left">Antropometri</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Petugas</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($medicalRecords as $record)
                <tr class="group hover:bg-slate-50/50 transition-colors" wire:key="record-{{ $record->id }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-slate-700 text-sm">
                            {{ $record->visit_date ? \Carbon\Carbon::parse($record->visit_date)->format('d M Y') : '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center font-black text-xs border border-teal-100">
                                {{ strtoupper(substr($record->patient->full_name ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">{{ $record->patient->full_name ?? 'Tidak Diketahui' }}</div>
                                <div class="text-[11px] text-slate-400 font-semibold uppercase mt-0.5">
                                    {{ $record->patient->category ?? '-' }} · {{ $record->patient->age ?? '?' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-black text-slate-400 uppercase tracking-tighter w-6">BB:</span>
                                <span class="text-sm font-bold text-slate-700">{{ $record->weight ?? '-' }} kg</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-black text-slate-400 uppercase tracking-tighter w-6">TB:</span>
                                <span class="text-sm font-bold text-slate-700">{{ $record->height ?? '-' }} cm</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-sm font-semibold text-slate-700">{{ $record->user->name ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <x-button href="{{ route('admin.medical-records.show', $record->id) }}" variant="ghost" size="sm">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </x-button>
                            @can('update', $record)
                            <x-button href="{{ route('admin.medical-records.edit', $record->id) }}" variant="ghost" size="sm">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </x-button>
                            @endcan
                            
                            @can('delete', $record)
                            <form action="{{ route('admin.medical-records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl text-red-500 hover:bg-red-50 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-24 text-center">
                        <div class="flex flex-col items-center gap-4 text-slate-300">
                            <span class="material-symbols-outlined text-[64px]">medical_information</span>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Tidak ada rekam medis ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </x-table>

        {{-- ── Pagination ── --}}
        <div class="px-6 py-4 bg-slate-50">
            {{ $medicalRecords->links() }}
        </div>
    </div>
</div>
@endsection