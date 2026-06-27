<div class="flex-1 p-container-padding flex flex-col gap-section-margin w-full">
    <!-- Header Section -->
    <section class="flex flex-col gap-4 md:flex-row md:items-end justify-between">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2 font-label-sm text-label-sm text-outline">
                <span class="">Beranda</span>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-medium">Manajemen Wilayah</span>
            </div>
            <h1 class="font-display-sm md:font-display-lg text-display-sm-mobile md:text-display-lg text-teal-700 mb-2 tracking-tight">Manajemen Wilayah Pedukuhan</h1>
        </div>
        <a href="{{ route('admin.pedukuhans.create') }}" class="bg-primary text-on-primary px-5 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm whitespace-nowrap">
            <span class="material-symbols-outlined">add_location</span>
            Tambah Pedukuhan Baru
        </a>
    </section>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
        <span class="material-symbols-outlined text-green-600 text-[20px]" style="font-variation-settings:'FILL' 1;">check_circle</span>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-error text-red-800 rounded-xl text-sm font-medium">
        <span class="material-symbols-outlined text-error text-[20px]">error</span>
        {{ session('error') }}
    </div>
    @endif

    @php
        $totalPedukuhan = $pedukuhans->total();
        $totalPosyandu  = \App\Models\Posyandu::count();
        $totalWarga     = \App\Models\Patient::count();
    @endphp

    <!-- Summary Stats Section -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-card-gap">
        <div class="bg-surface-container-lowest rounded-lg border border-outline-variant p-card-gap flex items-center justify-between shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,104,95,0.08)] hover:border-primary transition-all group">
            <div class="flex flex-col gap-1">
                <span class="font-label-md text-label-md text-on-surface-variant">Total Pedukuhan</span>
                <span class="font-display-sm text-display-sm text-on-surface">{{ $totalPedukuhan }}</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center group-hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-primary text-[28px]">maps_home_work</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest rounded-lg border border-outline-variant p-card-gap flex items-center justify-between shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,104,95,0.08)] hover:border-primary transition-all group">
            <div class="flex flex-col gap-1">
                <span class="font-label-md text-label-md text-on-surface-variant">Unit Posyandu</span>
                <span class="font-display-sm text-display-sm text-on-surface">{{ $totalPosyandu }}</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center group-hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-primary text-[28px]">home_health</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest rounded-lg border border-outline-variant p-card-gap flex items-center justify-between shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,104,95,0.08)] hover:border-primary transition-all group">
            <div class="flex flex-col gap-1">
                <span class="font-label-md text-label-md text-on-surface-variant">Warga Terdata</span>
                <span class="font-display-sm text-display-sm text-on-surface">{{ number_format($totalWarga) }}</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center group-hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-primary text-[28px]">groups</span>
            </div>
        </div>
    </section>

    <!-- Data Table Section -->
    <section class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden flex flex-col">
        <!-- Table Toolbar -->
        <div class="p-card-gap border-b border-outline-variant flex flex-col md:flex-row justify-between items-center gap-4 bg-surface-bright">
            <h2 class="font-headline-sm text-headline-sm text-on-surface hidden md:block">Daftar Wilayah</h2>
            <div class="flex w-full md:w-auto items-center gap-2">
                <div class="relative w-full md:w-80">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant">search</span>
                    <input wire:model.live.debounce.300ms="search" class="w-full pl-10 pr-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-shadow placeholder:text-outline-variant" placeholder="Cari nama pedukuhan atau kode pos..." type="text">
                </div>
                @if($search)
                <button wire:click="$set('search', '')" class="p-2 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors bg-surface-container-lowest" title="Reset Filter">
                    <span class="material-symbols-outlined">filter_list_off</span>
                </button>
                @endif
            </div>
        </div>
        
        <!-- Table -->
        <x-layouts.ui.table>
            <x-slot:head>
                <th class="py-4 px-6 font-semibold">Nama Pedukuhan</th>
                <th class="py-4 px-6 font-semibold">Kode Pos</th>
                <th class="py-4 px-6 font-semibold">Unit Posyandu</th>
                <th class="py-4 px-6 font-semibold">Total Warga</th>
                <th class="py-4 px-6 font-semibold text-center">Aksi</th>
            </x-slot:head>

            <x-slot:body>
                @forelse($pedukuhans as $pedukuhan)
                @php
                    $initial = strtoupper(substr($pedukuhan->name, 0, 2));
                    $colors  = ['primary','secondary','tertiary'];
                    $color   = $colors[($pedukuhan->id - 1) % count($colors)];
                    $totalWargaPedukuhan = \App\Models\Patient::whereHas('posyandu', fn($q) => $q->where('pedukuhan_id', $pedukuhan->id))->count();
                    
                    $bgClass = $color === 'primary' ? 'bg-primary-container text-primary' : 
                              ($color === 'secondary' ? 'bg-secondary-container text-secondary' : 'bg-tertiary-container text-tertiary');
                @endphp
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="py-4 px-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg {{ $bgClass }} flex items-center justify-center font-bold text-lg">
                            {{ $initial }}
                        </div>
                        <span class="font-medium text-on-surface">{{ $pedukuhan->name }}</span>
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ $pedukuhan->postal_code ?? '—' }}</td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-secondary-container text-on-secondary-container border border-secondary/20">
                            {{ $pedukuhan->posyandus_count ?? $pedukuhan->posyandus()->count() }} Unit
                        </span>
                    </td>
                    <td class="py-4 px-6">{{ number_format($totalWargaPedukuhan) }}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.pedukuhans.show', $pedukuhan->id) }}" class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container rounded-md transition-colors" title="Lihat Detail">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </a>
                            <a href="{{ route('admin.pedukuhans.edit', $pedukuhan->id) }}" class="p-1.5 text-on-surface-variant hover:text-secondary hover:bg-secondary-container rounded-md transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('admin.pedukuhans.destroy', $pedukuhan->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pedukuhan \'{{ addslashes($pedukuhan->name) }}\'? Semua data posyandu terkait akan terpengaruh.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container rounded-md transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 px-6 text-center">
                        <div class="flex flex-col items-center gap-3 text-outline-variant">
                            <span class="material-symbols-outlined text-[48px] text-slate-300">location_off</span>
                            <p class="text-sm font-semibold text-outline">Belum ada data pedukuhan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </x-slot:body>
        </x-layouts.ui.table>
        
        <!-- Pagination -->
        {{ $pedukuhans->links() }}
        
    </section>

    <!-- Footer Banner -->
    <section class="mt-4">
        <div class="relative bg-primary rounded-xl p-card-gap md:p-8 overflow-hidden shadow-md group border border-primary-fixed-dim/20">
            <div class="absolute inset-0 bg-gradient-to-r from-primary to-primary-container opacity-90 z-0"></div>
            <!-- Abstract map pattern background -->
            <div class="absolute inset-0 opacity-20 mix-blend-overlay z-0" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDkwDCoSHeadjSdDNEnapKqOE8k7wYyOj8zwUIRfN6cgDr4blN0VlwvPjeud_9irDHUl0UjV6bJHhCldwk8BRRHBQi6AE07Cs2kI6LKVJhtNCGn7lo2-LA1v9NSrYEihlDnHz-28OhF7ScH5ZDdr35LgfvPJ8s27Kjn9Wktsoi9-VDGlu5_VWypwrjBZyu5wEWl_vmpTb7tnAwVzE17zQcPujppTTDGzQVV0N39My8kZhaExg4gQ5RZV7X8v4KDY24JHTMaEgX7oOM');"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex flex-col gap-2 max-w-lg text-on-primary">
                    <h3 class="font-headline-md text-headline-md font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-[28px]">explore</span>
                        Visualisasi Wilayah
                    </h3>
                    <p class="font-body-md text-body-md text-on-primary-container/80">
                        Pantau sebaran Unit Posyandu dan kepadatan data kesehatan warga melalui peta interaktif untuk pengambilan keputusan yang lebih tepat sasaran.
                    </p>
                </div>
                <a href="{{ route('admin.posyandu.index') }}" class="bg-surface-container-lowest text-primary px-6 py-3 rounded-lg font-label-md text-label-md shadow-sm hover:bg-surface-container-high transition-colors flex items-center justify-center gap-2 w-full md:w-auto">
                    Lihat Peta Sebaran
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
</div>
