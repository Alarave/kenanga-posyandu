@extends('layouts.admin-layout')

@section('title', 'Audit Log Aktivitas')
@section('admin-title', 'Audit Log Aktivitas')

@section('admin-actions')
<div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
    <div class="w-9 h-9 rounded-xl bg-primary-container flex items-center justify-center text-primary shadow-inner">
        <span class="material-symbols-outlined text-[20px]">history</span>
    </div>
    <div class="pr-4">
        <p class="text-[9px] font-black text-outline-variant uppercase tracking-widest leading-none mb-1">Status Sistem</p>
        <p class="text-xs font-black text-on-surface leading-none flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-lg bg-green-500 animate-pulse"></span>
            Audit Aktif
        </p>
    </div>
</div>
@endsection

@section('admin-content')
<div class="space-y-8">
    {{-- ── Stats Bento Grid ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                [
                    'label' => 'Total Log',
                    'value' => $totalStats['total'],
                    'icon' => 'list_alt',
                    'color' => 'indigo',
                    'desc' => 'Seluruh rekaman aktivitas',
                    'gradient' => 'from-indigo-500/10 to-blue-500/5',
                    'icon_bg' => 'bg-secondary-container text-secondary border border-indigo-100'
                ],
                [
                    'label' => 'Aksi Create',
                    'value' => $totalStats['create'],
                    'icon' => 'add_circle',
                    'color' => 'emerald',
                    'desc' => 'Data baru ditambahkan',
                    'gradient' => 'from-emerald-500/10 to-teal-500/5',
                    'icon_bg' => 'bg-emerald-50 text-primary border border-emerald-100'
                ],
                [
                    'label' => 'Aksi Update',
                    'value' => $totalStats['update'],
                    'icon' => 'edit_square',
                    'color' => 'amber',
                    'desc' => 'Perubahan data sistem',
                    'gradient' => 'from-amber-500/10 to-orange-500/5',
                    'icon_bg' => 'bg-amber-50 text-amber-600 border border-amber-100'
                ],
                [
                    'label' => 'Aksi Delete',
                    'value' => $totalStats['delete'],
                    'icon' => 'delete_forever',
                    'color' => 'rose',
                    'desc' => 'Penghapusan data sistem',
                    'gradient' => 'from-rose-500/10 to-red-500/5',
                    'icon_bg' => 'bg-error-container text-error border border-rose-100'
                ],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bento-card p-6 group relative overflow-hidden bg-white border border-slate-100 rounded-2xl transition-all duration-300 hover:shadow-xl hover:shadow-slate-200/50">
            <div class="absolute inset-0 bg-gradient-to-br {{ $s['gradient'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110 duration-500 shadow-sm {{ $s['icon_bg'] }}">
                        <span class="material-symbols-outlined text-[26px]">{{ $s['icon'] }}</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline-variant uppercase tracking-widest mt-1">Audit</span>
                </div>
                <div class="mt-6">
                    <p class="text-xs font-black text-outline-variant uppercase tracking-wider mb-1">{{ $s['label'] }}</p>
                    <h3 class="text-4xl font-extrabold text-on-surface tracking-tight">{{ number_format($s['value']) }}</h3>
                    <p class="text-[11px] text-outline-variant font-medium mt-2">{{ $s['desc'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Filters Panel ── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 rounded-lg bg-primary-container text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[18px]">manage_search</span>
            </div>
            <div>
                <h4 class="text-sm font-black text-on-surface uppercase tracking-wider">Filter Pencarian</h4>
                <p class="text-xs text-outline-variant font-medium">Saring data log audit berdasarkan parameter spesifik</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6 gap-6">
            {{-- Search Input --}}
            <div class="space-y-2">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Pencarian</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant" style="font-size:20px;">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari deskripsi..." 
                           class="w-full h-12 pl-11 pr-4 rounded-xl border border-outline-variant bg-surface-container-low/50 text-sm font-bold text-on-surface focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>
            </div>

            {{-- User Select --}}
            <div class="space-y-2">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Pengguna</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant" style="font-size:20px; z-index:10;">person</span>
                    <select name="user_id" class="w-full h-12 pl-11 pr-4 rounded-xl border border-outline-variant bg-surface-container-low/50 text-sm font-bold text-on-surface focus:outline-none focus:border-primary focus:bg-white transition-all appearance-none">
                        <option value="">Semua Kader / System</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ request('user_id') == $user->user_id ? 'selected' : '' }}>
                                {{ $user->user_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant pointer-events-none" style="font-size:18px;">expand_more</span>
                </div>
            </div>

            {{-- Action Type Select --}}
            <div class="space-y-2">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Jenis Aksi</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant" style="font-size:20px; z-index:10;">bolt</span>
                    <select name="action_type" class="w-full h-12 pl-11 pr-4 rounded-xl border border-outline-variant bg-surface-container-low/50 text-sm font-bold text-on-surface focus:outline-none focus:border-primary focus:bg-white transition-all appearance-none">
                        <option value="">Semua Aksi</option>
                        @foreach($actionTypes as $type)
                            <option value="{{ $type }}" {{ request('action_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant pointer-events-none" style="font-size:18px;">expand_more</span>
                </div>
            </div>

            {{-- Start Date --}}
            <div class="space-y-2">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Tgl Mulai</label>
                <div class="relative">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full h-12 px-4 rounded-xl border border-outline-variant bg-surface-container-low/50 text-sm font-bold text-on-surface focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>
            </div>

            {{-- End Date --}}
            <div class="space-y-2">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Tgl Akhir</label>
                <div class="relative">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="w-full h-12 px-4 rounded-xl border border-outline-variant bg-surface-container-low/50 text-sm font-bold text-on-surface focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>
            </div>

            {{-- Filter buttons --}}
            <div class="flex items-end gap-3">
                <button type="submit" class="flex-1 h-12 bg-primary text-white rounded-xl font-bold uppercase tracking-wider text-xs hover:bg-teal-700 transition-all shadow-md shadow-teal-600/15 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span>
                    Filter
                </button>
                <a href="{{ route('admin.activity-logs.index') }}" 
                   title="Reset Filter"
                   class="w-12 h-12 bg-surface-container text-outline rounded-xl flex items-center justify-center hover:bg-surface-container-high hover:text-on-surface transition-all group">
                    <span class="material-symbols-outlined group-hover:rotate-180 transition-transform duration-500">restart_alt</span>
                </a>
            </div>
        </form>
    </div>

    {{-- ── Main Table Card ── --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-label-lg text-outline-variant uppercase whitespace-nowrap text-xs font-black tracking-widest">Waktu & Tanggal</th>
                        <th class="px-6 py-4 text-label-lg text-outline-variant uppercase whitespace-nowrap text-xs font-black tracking-widest">Pelaku</th>
                        <th class="px-6 py-4 text-label-lg text-outline-variant uppercase whitespace-nowrap text-xs font-black tracking-widest">Tipe Aksi</th>
                        <th class="px-6 py-4 text-label-lg text-outline-variant uppercase whitespace-nowrap text-xs font-black tracking-widest">Entitas</th>
                        <th class="px-6 py-4 text-label-lg text-outline-variant uppercase whitespace-nowrap text-xs font-black tracking-widest">IP Address</th>
                        <th class="px-6 py-4 text-label-lg text-outline-variant uppercase text-right whitespace-nowrap text-xs font-black tracking-widest">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($activityLogs as $log)
                    <tr class="hover:bg-surface-container-low/80 transition-all group">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-on-surface">{{ $log->created_at->format('H:i:s') }}</span>
                                <span class="text-[10px] font-bold text-outline-variant uppercase tracking-tighter">{{ $log->created_at->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3 min-w-[150px]">
                                <div class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant font-extrabold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($log->user_name ?? 'SY', 0, 2)) }}
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[13px] font-black text-on-surface truncate block max-w-[120px] md:max-w-[180px]" title="{{ $log->user_name ?? 'System' }}">
                                        {{ $log->user_name ?? 'System' }}
                                    </span>
                                    <span class="text-[10px] font-black text-primary uppercase tracking-widest">{{ $log->role ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            @php
                                $badgeStyle = match($log->action_type) {
                                    'create' => 'bg-emerald-50 text-emerald-700 border-emerald-100/80',
                                    'update' => 'bg-amber-50 text-amber-700 border-amber-100/80',
                                    'delete', 'login_failed' => 'bg-error-container text-rose-700 border-rose-100/80',
                                    'login', 'logout' => 'bg-secondary-container text-indigo-700 border-indigo-100/80',
                                    default => 'bg-surface-container-low text-on-surface-variant border-slate-100',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg border {{ $badgeStyle }} text-[10px] font-black uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-lg bg-current mr-1.5"></span>
                                {{ $log->action_type }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                // Extract entity name from stored JSON payload (avoids N+1 queries)
                                $payload = $log->new_values ?? $log->old_values ?? [];
                                $entityName = $payload['full_name']
                                    ?? $payload['name']
                                    ?? $payload['title']
                                    ?? null;
                            @endphp
                            <div class="flex flex-col min-w-[120px]">
                                <span class="text-xs font-bold text-on-surface-variant truncate block max-w-[150px]">
                                    {{ $log->entity_type ? class_basename($log->entity_type) : '-' }}
                                </span>
                                @if($entityName)
                                    <span class="text-[11px] font-bold text-on-primary-container truncate block max-w-[150px]" title="{{ $entityName }}">
                                        {{ $entityName }}
                                    </span>
                                @else
                                    <span class="text-[9px] font-medium text-outline-variant uppercase tracking-tighter">
                                        ID #{{ $log->entity_id ?? 'N/A' }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="font-mono text-xs font-bold text-outline bg-surface-container-low border border-slate-100 px-2 py-1 rounded-lg">
                                {{ $log->ip_address }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right whitespace-nowrap">
                            <a href="{{ route('admin.activity-logs.show', $log) }}" 
                               class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-surface-container-low hover:bg-primary-container border border-slate-100 hover:border-teal-100 text-outline hover:text-primary hover:shadow-md hover:shadow-teal-600/5 transition-all duration-200">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-surface-container-low rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-200 text-[40px]">history</span>
                                </div>
                                <p class="text-outline-variant font-bold">Belum ada log aktivitas yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- ── Pagination ── --}}
        @if($activityLogs->hasPages())
        <div class="px-8 py-6 bg-surface-container-low/50 border-t border-slate-100">
            {{ $activityLogs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
