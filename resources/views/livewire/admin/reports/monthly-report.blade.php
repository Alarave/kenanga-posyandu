<div class="space-y-6">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
            <span class="material-symbols-outlined text-green-600 text-[20px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium">
            <span class="material-symbols-outlined text-red-600 text-[20px]">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Filter Section ── --}}
    <section class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Filter Laporan</h3>
        <div class="flex flex-wrap items-end gap-4">

            {{-- Pilih Posyandu (superadmin / coordinator only) --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->isCoordinator())
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Posyandu</label>
                <select wire:model="selectedPosyanduId"
                        class="w-full h-12 rounded-lg border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition">
                    @foreach($posyandus as $pos)
                        <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Pilih Bulan --}}
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Bulan</label>
                <select wire:model="selectedMonth"
                        class="w-full h-12 rounded-lg border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition">
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
            </div>

            {{-- Pilih Tahun --}}
            <div class="flex-1 min-w-[130px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Tahun</label>
                <select wire:model="selectedYear"
                        class="w-full h-12 rounded-lg border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition">
                    @for($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>

            {{-- Tombol Tampilkan --}}
            <button wire:click="generateReport"
                    wire:loading.attr="disabled"
                    class="h-12 px-8 bg-teal-600 text-white rounded-lg text-sm font-bold hover:bg-teal-700 active:scale-95 transition-all flex items-center gap-2 min-w-[140px] justify-center shadow-sm">
                <span wire:loading.remove wire:target="generateReport" class="material-symbols-outlined text-[18px]">search</span>
                <svg wire:loading wire:target="generateReport" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span wire:loading.remove wire:target="generateReport">Tampilkan</span>
                <span wire:loading wire:target="generateReport">Memuat...</span>
            </button>
        </div>
    </section>

    {{-- ── Stats Cards (hanya tampil setelah generate) ── --}}
    @if($reportGenerated)
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Total Kunjungan --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-teal-50 rounded-xl text-teal-600">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Bulan Ini</span>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Kunjungan</p>
            <h3 class="text-4xl font-black text-slate-900 mt-1 leading-tight">{{ $totalKunjungan }}</h3>
            <p class="text-xs text-slate-400 mt-2">{{ $monthName }} {{ $selectedYear }}</p>
        </div>

        {{-- Balita Stunting --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-red-50 rounded-xl text-red-500">
                    <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1;">warning</span>
                </div>
                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">Perhatian</span>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Balita Stunting</p>
            <h3 class="text-4xl font-black text-slate-900 mt-1 leading-tight">{{ $balitaStunting }}</h3>
            <p class="text-xs text-slate-400 mt-2">Ditemukan bulan ini</p>
        </div>

        {{-- Ibu Hamil --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 rounded-xl text-blue-500">
                    <span class="material-symbols-outlined text-[22px]">pregnant_woman</span>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Terdaftar</span>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ibu Hamil</p>
            <h3 class="text-4xl font-black text-slate-900 mt-1 leading-tight">{{ $totalIbuHamil }}</h3>
            <p class="text-xs text-slate-400 mt-2">Terdaftar aktif</p>
        </div>

        {{-- Cakupan Vitamin A --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-50 rounded-xl text-amber-500">
                    <span class="material-symbols-outlined text-[22px]">medication</span>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Target: 95%</span>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Cakupan Vitamin A</p>
            <h3 class="text-4xl font-black text-slate-900 mt-1 leading-tight">{{ $cakupanVitaminA }}%</h3>
            <p class="text-xs text-slate-400 mt-2">Capaian posyandu</p>
        </div>

    </section>

    {{-- ── Tabel Detail Kunjungan ── --}}
    <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header Tabel --}}
        <div class="px-6 py-4 border-b border-slate-200 flex flex-wrap justify-between items-center gap-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Data Detail Kunjungan</h2>
                <p class="text-sm text-slate-500 mt-0.5">{{ $monthName }} {{ $selectedYear }} — {{ $posyanduName }}</p>
            </div>
            <div class="flex gap-3">
                {{-- Ekspor Excel --}}
                <button wire:click="exportExcel"
                        wire:loading.attr="disabled"
                        wire:target="exportExcel"
                        class="h-11 px-5 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                    <span wire:loading.remove wire:target="exportExcel" class="material-symbols-outlined text-[18px]">description</span>
                    <svg wire:loading wire:target="exportExcel" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>Ekspor Excel</span>
                </button>

                {{-- Ekspor PDF --}}
                <button wire:click="exportPdf"
                        wire:loading.attr="disabled"
                        wire:target="exportPdf"
                        class="h-11 px-5 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                    <span wire:loading.remove wire:target="exportPdf" class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                    <svg wire:loading wire:target="exportPdf" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>Ekspor PDF</span>
                </button>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Balita</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Usia</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl Kunjungan</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Berat (kg)</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tinggi (cm)</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Gizi</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Vit. A</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Pill FE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $index => $record)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4 text-sm text-slate-500">
                            {{ ($records->currentPage() - 1) * $records->perPage() + $index + 1 }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-semibold text-sm text-slate-900">{{ $record->patient->full_name ?? '-' }}</div>
                            <div class="text-xs text-slate-400">{{ $record->patient->id_number ?? '' }}</div>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-700">
                            @if($record->patient?->birth_date)
                                {{ $record->patient->birth_date->diffInMonths(now()) }} Bln
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-700">
                            {{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-sm font-medium text-slate-900">
                            {{ $record->weight ? number_format($record->weight, 1) : '-' }}
                        </td>
                        <td class="px-5 py-4 text-sm font-medium text-slate-900">
                            {{ $record->height ? number_format($record->height, 1) : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $status = $record->nutrition_status ?? null;
                                $badgeClass = match($status) {
                                    'Normal'             => 'bg-green-50 text-green-700 border border-green-200',
                                    'Gizi Kurang'        => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'Gizi Lebih'         => 'bg-purple-50 text-purple-700 border border-purple-200',
                                    'Gizi Buruk/Stunting'=> 'bg-red-50 text-red-700 border border-red-200',
                                    default              => 'bg-slate-100 text-slate-500 border border-slate-200',
                                };
                                $icon = match($status) {
                                    'Gizi Buruk/Stunting' => 'priority_high',
                                    'Gizi Kurang'         => 'trending_down',
                                    'Gizi Lebih'          => 'trending_up',
                                    'Normal'              => 'check',
                                    default               => 'remove',
                                };
                            @endphp
                            @if($status)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                <span class="material-symbols-outlined text-[13px]">{{ $icon }}</span>
                                {{ $status }}
                            </span>
                            @else
                            <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($record->vitamin_a)
                                <span class="material-symbols-outlined text-green-500 text-[20px]" style="font-variation-settings:'FILL' 1;">check_circle</span>
                            @else
                                <span class="material-symbols-outlined text-slate-300 text-[20px]">cancel</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($record->pill_fe)
                                <span class="material-symbols-outlined text-green-500 text-[20px]" style="font-variation-settings:'FILL' 1;">check_circle</span>
                            @else
                                <span class="material-symbols-outlined text-slate-300 text-[20px]">cancel</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <span class="material-symbols-outlined text-[48px] text-slate-300">search_off</span>
                                <p class="text-sm font-medium">Tidak ada data kunjungan</p>
                                <p class="text-xs">Tidak ditemukan rekam medis untuk periode {{ $monthName }} {{ $selectedYear }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($records instanceof \Illuminate\Pagination\LengthAwarePaginator && $records->hasPages())
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-wrap justify-between items-center gap-4">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $records->firstItem() }}–{{ $records->lastItem() }} dari {{ $total }} data
            </p>
            <div class="flex items-center gap-1">
                {{-- Prev --}}
                <button wire:click="previousPage"
                        @disabled($records->onFirstPage())
                        class="w-9 h-9 flex items-center justify-center border border-slate-200 rounded-lg text-slate-500 hover:bg-white transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                </button>

                {{-- Page Numbers --}}
                @foreach($records->getUrlRange(max(1, $records->currentPage() - 2), min($records->lastPage(), $records->currentPage() + 2)) as $page => $url)
                    <button wire:click="gotoPage({{ $page }})"
                            class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-semibold transition-colors
                                {{ $page === $records->currentPage()
                                    ? 'bg-teal-600 text-white shadow-sm'
                                    : 'border border-slate-200 text-slate-600 hover:bg-white' }}">
                        {{ $page }}
                    </button>
                @endforeach

                {{-- Next --}}
                <button wire:click="nextPage"
                        @disabled($records->currentPage() === $records->lastPage())
                        class="w-9 h-9 flex items-center justify-center border border-slate-200 rounded-lg text-slate-500 hover:bg-white transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </button>
            </div>
        </div>
        @elseif($records->count() > 0)
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            <p class="text-sm text-slate-500">Menampilkan {{ $total }} data</p>
        </div>
        @endif

    </section>
    @else
    {{-- Empty State --}}
    <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-16 text-center">
        <div class="flex flex-col items-center gap-4 text-slate-400">
            <div class="w-20 h-20 rounded-2xl bg-teal-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-[40px] text-teal-400">assessment</span>
            </div>
            <div>
                <p class="text-base font-semibold text-slate-600">Pilih periode laporan</p>
                <p class="text-sm text-slate-400 mt-1">Pilih bulan, tahun, dan posyandu lalu klik <strong>Tampilkan</strong> untuk melihat laporan</p>
            </div>
        </div>
    </section>
    @endif

</div>

@push('scripts')
<script>
    // Handle file download event from Livewire
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
