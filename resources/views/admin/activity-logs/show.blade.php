@extends('layouts.admin')

@section('title', 'Detail Audit Log')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.activity-logs.index') }}" class="text-blue-600 hover:text-blue-900 mb-2 inline-block">
            ← Kembali ke Daftar Audit Log
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Detail Aktivitas</h1>
    </div>

    <!-- Activity Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Umum</h2>
        </div>
        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal & Waktu</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->created_at->format('d M Y H:i:s') }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Jenis Aksi</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @php
                            $badgeColor = match($activityLog->action_type) {
                                'create' => 'bg-green-100 text-green-800',
                                'update' => 'bg-yellow-100 text-yellow-800',
                                'delete' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColor }}">
                            {{ ucfirst($activityLog->action_type) }}
                        </span>
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Pengguna</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->user_name ?? 'N/A' }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->role }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->ip_address }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">User Agent</dt>
                    <dd class="mt-1 text-sm text-gray-900 break-all">{{ $activityLog->user_agent }}</dd>
                </div>

                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->description }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Entitas</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if($activityLog->entity_type)
                            {{ class_basename($activityLog->entity_type) }}
                            @if($activityLog->entity_id)
                                #{{ $activityLog->entity_id }}
                            @endif
                        @else
                            -
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Old Values -->
    @if($activityLog->old_values)
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-red-50 border-b border-red-200">
                <h2 class="text-lg font-semibold text-red-900">Data Sebelum Perubahan (Old Values)</h2>
            </div>
            <div class="px-6 py-4">
                <pre class="bg-gray-50 p-4 rounded-md overflow-x-auto text-sm"><code>{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
            </div>
        </div>
    @endif

    <!-- New Values -->
    @if($activityLog->new_values)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-green-50 border-b border-green-200">
                <h2 class="text-lg font-semibold text-green-900">Data Setelah Perubahan (New Values)</h2>
            </div>
            <div class="px-6 py-4">
                <pre class="bg-gray-50 p-4 rounded-md overflow-x-auto text-sm"><code>{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
            </div>
        </div>
    @endif
</div>
@endsection
