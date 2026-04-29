@extends('layouts.admin')

@section('title', 'Audit Log Aktivitas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Audit Log Aktivitas</h1>
            <p class="text-gray-600 mt-1">Pantau dan audit semua aktivitas pengguna dalam sistem</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Total Aktivitas</div>
            <div class="text-2xl font-bold text-blue-600">{{ $activityLogs->total() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Create</div>
            <div class="text-2xl font-bold text-green-600">
                {{ $activityLogs->where('action_type', 'create')->count() }}
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Update</div>
            <div class="text-2xl font-bold text-yellow-600">
                {{ $activityLogs->where('action_type', 'update')->count() }}
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Delete</div>
            <div class="text-2xl font-bold text-red-600">
                {{ $activityLogs->where('action_type', 'delete')->count() }}
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Deskripsi atau user..." 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- User Filter -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pengguna</label>
                <select name="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}" {{ request('user_id') == $user->user_id ? 'selected' : '' }}>
                            {{ $user->user_name }} ({{ $user->role }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Type Filter -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Aksi</label>
                <select name="action_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Aksi</option>
                    @foreach($actionTypes as $type)
                        <option value="{{ $type }}" {{ request('action_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Start Date -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- End Date -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-5 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Filter
                </button>
                <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Activity Logs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entitas</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($activityLogs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <div class="font-medium text-gray-900">{{ $log->user_name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $log->role }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $badgeColor = match($log->action_type) {
                                    'create' => 'bg-green-100 text-green-800',
                                    'update' => 'bg-yellow-100 text-yellow-800',
                                    'delete' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColor }}">
                                {{ ucfirst($log->action_type) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                            @if($log->entity_type)
                                {{ class_basename($log->entity_type) }}
                                @if($log->entity_id)
                                    #{{ $log->entity_id }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 max-w-xs truncate">
                            {{ $log->description }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->ip_address }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.activity-logs.show', $log) }}" 
                                class="text-blue-600 hover:text-blue-900">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada aktivitas yang ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($activityLogs->hasPages())
        <div class="mt-4">
            {{ $activityLogs->links() }}
        </div>
    @endif
</div>
@endsection
