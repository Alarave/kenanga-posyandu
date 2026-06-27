@extends('layouts.admin-layout')

@section('title', 'Detail Log Aktivitas')
@section('admin-title', 'Detail Log Aktivitas')

@section('admin-actions')
<a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-outline uppercase tracking-widest hover:text-primary transition-colors group">
    <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
    Kembali ke Daftar
</a>
@endsection

@section('admin-content')
<div class="space-y-8">
    {{-- Header Summary Bar --}}
    @php
        // Resolve entity display name from entity_type class
        $entityDisplayName = null;
        if ($activityLog->entity_type && $activityLog->entity_id) {
            try {
                $entityModel = app($activityLog->entity_type)->find($activityLog->entity_id);
                if ($entityModel) {
                    $entityDisplayName = $entityModel->full_name
                        ?? $entityModel->name
                        ?? $entityModel->title
                        ?? null;
                }
            } catch (\Throwable $e) {
                // Entity class might not exist or be deleted
                $entityDisplayName = null;
            }
        }
    @endphp

    @php
        $badgeStyle = match($activityLog->action_type) {
            'create' => 'bg-emerald-50 text-emerald-700 border-emerald-100/85',
            'update' => 'bg-amber-50 text-amber-700 border-amber-100/85',
            'delete', 'login_failed' => 'bg-error-container text-rose-700 border-rose-100/85',
            'login', 'logout' => 'bg-secondary-container text-indigo-700 border-indigo-100/85',
            default => 'bg-surface-container-low text-on-surface-variant border-slate-100',
        };
    @endphp

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-6 bg-white border border-slate-100 rounded-2xl shadow-sm gap-4">
        <div>
            <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">ID Audit Log</span>
            <h3 class="text-headline-sm font-extrabold text-on-surface">#{{ $activityLog->id }}</h3>
        </div>
        <div class="flex items-center gap-3">
            <div class="inline-flex items-center px-4 py-2 rounded-xl border {{ $badgeStyle }} shadow-sm">
                <span class="w-2 h-2 rounded-lg bg-current mr-2 animate-pulse"></span>
                <span class="text-xs font-black uppercase tracking-wider">{{ $activityLog->action_type }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- ── Left Side: General Info & Diff Viewer ── --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
                <h3 class="text-sm font-black text-on-surface uppercase tracking-wider mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">info</span>
                    Informasi Umum
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <div class="space-y-1.5">
                        <p class="text-[11px] font-black text-outline-variant uppercase tracking-widest">Waktu Kejadian</p>
                        <p class="text-base font-black text-on-surface leading-tight">{{ $activityLog->created_at->format('d M Y, H:i:s') }}</p>
                        <p class="text-xs font-bold text-outline-variant italic">{{ $activityLog->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="space-y-1.5">
                        <p class="text-[11px] font-black text-outline-variant uppercase tracking-widest">IP Address</p>
                        <p class="text-base font-mono font-bold text-slate-850 bg-slate-55 border border-slate-100/50 px-2 py-0.5 rounded-lg inline-block leading-none mt-1">{{ $activityLog->ip_address }}</p>
                        <p class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mt-1">Akses Jaringan</p>
                    </div>

                    <div class="space-y-1.5">
                        <p class="text-[11px] font-black text-outline-variant uppercase tracking-widest">Entitas Terdampak</p>
                        <div class="flex items-center gap-3 mt-1">
                            <div class="w-10 h-10 rounded-xl bg-surface-container-low border border-slate-100 flex items-center justify-center text-outline">
                                <span class="material-symbols-outlined">database</span>
                            </div>
                            <div>
                                <p class="text-sm font-black text-on-surface">{{ $activityLog->entity_type ? class_basename($activityLog->entity_type) : 'Global System' }}</p>
                                @if($entityDisplayName)
                                    <p class="text-sm font-bold text-on-surface-variant leading-tight">{{ $entityDisplayName }}</p>
                                    <p class="text-[10px] font-medium text-outline-variant uppercase tracking-wider">ID #{{ $activityLog->entity_id }}</p>
                                @elseif($activityLog->entity_id)
                                    <p class="text-xs font-bold text-primary uppercase tracking-widest">ID #{{ $activityLog->entity_id }}</p>
                                    @if($activityLog->action_type === 'delete')
                                        <p class="text-[10px] text-rose-400 italic font-medium">(Data telah dihapus)</p>
                                    @endif
                                @else
                                    <p class="text-xs font-bold text-outline-variant uppercase tracking-widest">N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5 md:col-span-2">
                        <p class="text-[11px] font-black text-outline-variant uppercase tracking-widest">Deskripsi Perubahan</p>
                        <div class="p-4 bg-surface-container-low rounded-2xl border border-slate-100 mt-1">
                            <p class="text-sm font-bold text-on-surface-variant leading-relaxed">{{ $activityLog->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Alpine.js Visual Diff / JSON payload ── --}}
            @php
                $ignoredKeys = ['id', 'user_id', 'password', 'remember_token', 'created_at', 'updated_at', 'id_number_hash', 'email_verified_at'];
                $oldValues = $activityLog->old_values ?? [];
                $newValues = $activityLog->new_values ?? [];

                $diff = [];
                if ($activityLog->action_type === 'create') {
                    foreach ($newValues as $key => $val) {
                        if (!in_array($key, $ignoredKeys)) {
                            $diff[$key] = [
                                'old' => null,
                                'new' => $val,
                                'changed' => true
                            ];
                        }
                    }
                } elseif ($activityLog->action_type === 'delete') {
                    foreach ($oldValues as $key => $val) {
                        if (!in_array($key, $ignoredKeys)) {
                            $diff[$key] = [
                                'old' => $val,
                                'new' => null,
                                'changed' => true
                            ];
                        }
                    }
                } else {
                    $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
                    foreach ($allKeys as $key) {
                        if (!in_array($key, $ignoredKeys)) {
                            $oldVal = $oldValues[$key] ?? null;
                            $newVal = $newValues[$key] ?? null;
                            if ($oldVal !== $newVal) {
                                $diff[$key] = [
                                    'old' => $oldVal,
                                    'new' => $newVal,
                                    'changed' => true
                                ];
                            }
                        }
                    }
                }

                $displayVal = function($val) {
                    if (is_null($val)) return '-';
                    if (is_bool($val)) return $val ? 'true' : 'false';
                    if (is_array($val)) return json_encode($val, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    return (string) $val;
                };
            @endphp

            <div x-data="{ viewMode: 'diff' }" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5 mb-6">
                    <h3 class="text-sm font-black text-on-surface uppercase tracking-wider flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">compare</span>
                        Perubahan Data
                    </h3>
                    
                    <div class="flex gap-2 bg-surface-container-low p-1 rounded-xl self-start">
                        <button x-on:click="viewMode = 'diff'" 
                                x-bind:class="viewMode === 'diff' ? 'bg-white text-primary shadow-sm' : 'text-outline hover:text-on-surface'"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">difference</span>
                            Visual Diff
                        </button>
                        <button x-on:click="viewMode = 'raw'" 
                                x-bind:class="viewMode === 'raw' ? 'bg-white text-primary shadow-sm' : 'text-outline hover:text-on-surface'"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">code</span>
                            Raw JSON
                        </button>
                    </div>
                </div>

                {{-- Visual Diff Viewer --}}
                <div x-show="viewMode === 'diff'" class="space-y-4">
                    @if(count($diff) > 0)
                    <div class="border border-slate-100 rounded-2xl overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low/50 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-black text-outline-variant uppercase tracking-wider">Kolom / Field</th>
                                    <th class="px-6 py-4 text-xs font-black text-outline-variant uppercase tracking-wider">Sebelum</th>
                                    <th class="px-6 py-4 text-xs font-black text-outline-variant uppercase tracking-wider">Sesudah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($diff as $field => $data)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-xs font-bold text-on-surface-variant bg-surface-container px-2 py-1 rounded-md">
                                            {{ $field }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(!is_null($data['old']))
                                            <span class="line-through text-xs font-bold text-error bg-error-container border border-rose-100/50 px-2.5 py-1 rounded-lg inline-block whitespace-pre-line">
                                                {{ $displayVal($data['old']) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-outline-variant italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(!is_null($data['new']))
                                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100/50 px-2.5 py-1 rounded-lg inline-block whitespace-pre-line">
                                                {{ $displayVal($data['new']) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-outline-variant italic">Dihapus</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="py-12 border-2 border-dashed border-slate-100 rounded-2xl text-center">
                        <span class="material-symbols-outlined text-slate-300 text-[36px] mb-2">check_circle</span>
                        <p class="text-outline-variant text-sm font-bold">Tidak ada perubahan data atribut (Metadata umum).</p>
                    </div>
                    @endif
                </div>

                {{-- Raw JSON Viewer --}}
                <div x-show="viewMode === 'raw'" class="space-y-6" x-cloak>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Old Values --}}
                        <div class="space-y-2">
                            <h4 class="text-xs font-black text-error uppercase tracking-widest flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">history</span>
                                Payload Data Lama
                            </h4>
                            <div class="bg-inverse-surface rounded-2xl p-5 overflow-hidden border border-slate-800">
                                @if($activityLog->old_values)
                                <pre class="text-[11px] font-mono text-slate-300 overflow-x-auto leading-relaxed max-h-[300px] custom-scrollbar"><code>{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                @else
                                <p class="text-outline font-mono text-[11px] italic">Tidak ada payload data lama.</p>
                                @endif
                            </div>
                        </div>

                        {{-- New Values --}}
                        <div class="space-y-2">
                            <h4 class="text-xs font-black text-primary uppercase tracking-widest flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">update</span>
                                Payload Data Baru
                            </h4>
                            <div class="bg-inverse-surface rounded-2xl p-5 overflow-hidden border border-slate-800">
                                @if($activityLog->new_values)
                                <pre class="text-[11px] font-mono text-slate-300 overflow-x-auto leading-relaxed max-h-[300px] custom-scrollbar"><code>{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                @else
                                <p class="text-outline font-mono text-[11px] italic">Tidak ada payload data baru.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right Side: User & Agent Info ── --}}
        <div class="space-y-8">
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
                <h3 class="text-sm font-black text-on-surface uppercase tracking-wider mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Pelaku Aksi
                </h3>
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 rounded-[1.8rem] bg-gradient-to-br from-slate-800 to-slate-900 text-white flex items-center justify-center text-headline-md font-black shadow-lg">
                        {{ strtoupper(substr($activityLog->user_name ?? 'SY', 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="text-body-lg font-black text-on-surface">{{ $activityLog->user_name ?? 'System' }}</h4>
                        <p class="text-xs font-black text-primary uppercase tracking-widest mt-1">{{ $activityLog->role ?? 'N/A' }}</p>
                    </div>
                    <div class="w-full pt-4 border-t border-slate-50 space-y-3">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-outline-variant uppercase tracking-wider">Metode Akses</span>
                            <span class="text-on-surface">Dashboard Web</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
                <h3 class="text-xs font-black text-outline-variant uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">devices</span>
                    Informasi Perangkat
                </h3>
                <div class="p-4 bg-surface-container-low rounded-2xl border border-slate-100">
                    <p class="text-[11px] font-mono text-outline break-all leading-relaxed italic">
                        {{ $activityLog->user_agent }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
