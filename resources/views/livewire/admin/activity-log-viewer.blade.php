<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Log Aktivitas</h1>

        <!-- Filter Section -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Filter</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Start Date Filter -->
                <div>
                    <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai
                    </label>
                    <input 
                        type="date" 
                        id="startDate"
                        wire:model.live="startDate"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- End Date Filter -->
                <div>
                    <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Akhir
                    </label>
                    <input 
                        type="date" 
                        id="endDate"
                        wire:model.live="endDate"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Action Type Filter -->
                <div>
                    <label for="actionType" class="block text-sm font-medium text-gray-700 mb-1">
                        Jenis Aksi
                    </label>
                    <select 
                        id="actionType"
                        wire:model.live="actionType"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Semua Jenis Aksi</option>
                        @foreach($actionTypes as $type)
                            <option value="{{ $type }}">{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- User Name Filter -->
                <div>
                    <label for="userName" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Pengguna
                    </label>
                    <input 
                        type="text" 
                        id="userName"
                        wire:model.live.debounce.500ms="userName"
                        placeholder="Cari nama pengguna..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>
            </div>

            <!-- Reset Button -->
            <div class="mt-4">
                <button 
                    wire:click="resetFilters"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px]"
                >
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Activity Logs Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Waktu
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Pengguna
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Jenis Aksi
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            IP Address
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activityLogs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->user_name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($log->role === 'superadmin') bg-purple-100 text-purple-800
                                    @elseif($log->role === 'admin') bg-blue-100 text-blue-800
                                    @elseif($log->role === 'coordinator') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($log->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if(str_contains($log->action_type, 'create')) bg-green-100 text-green-800
                                    @elseif(str_contains($log->action_type, 'update')) bg-yellow-100 text-yellow-800
                                    @elseif(str_contains($log->action_type, 'delete')) bg-red-100 text-red-800
                                    @elseif(str_contains($log->action_type, 'unauthorized')) bg-red-100 text-red-800
                                    @elseif(str_contains($log->action_type, 'login')) bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $log->action_type)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $log->description }}
                                @if($log->entity_type && $log->entity_id)
                                    <span class="text-xs text-gray-500">
                                        ({{ $log->entity_type }} #{{ $log->entity_id }})
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->ip_address }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Tidak ada log aktivitas yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $activityLogs->links() }}
        </div>
    </div>
</div>
