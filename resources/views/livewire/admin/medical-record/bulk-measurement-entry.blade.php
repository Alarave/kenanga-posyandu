<div>
    @section('admin-title') 
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 shadow-sm border border-teal-100">
                <span class="material-symbols-outlined">analytics</span>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 leading-tight">Penimbangan Massal</h1>
                <div class="flex items-center gap-3 mt-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Entry Cepat Data Antropometri</p>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <p class="text-[10px] font-black text-teal-600 uppercase tracking-widest">{{ count($measurements) }} Balita dalam daftar</p>
                </div>
            </div>
        </div>
    @endsection

    @section('admin-actions')
        <x-button href="{{ route('admin.medical-records.index') }}" variant="outline" size="sm" icon="arrow_back">
            Kembali
        </x-button>
    @endsection

    <div class="space-y-8 pb-32">
        {{-- Search & Global Filters Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-4 space-y-4">
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px]">calendar_month</span>
                            Tanggal Kunjungan
                        </label>
                        <input type="date" wire:model.live="visit_date" 
                            class="w-full bg-slate-50 border-slate-100 rounded-2xl text-sm font-black focus:ring-teal-500 focus:border-teal-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px]">location_on</span>
                            Posyandu
                        </label>
                        <select wire:model.live="posyandu_id" 
                            class="w-full bg-slate-50 border-slate-100 rounded-2xl text-sm font-black focus:ring-teal-500 focus:border-teal-500 transition-all">
                            <option value="">-- Pilih Posyandu --</option>
                            @foreach($posyandus as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button wire:click="loadAllPatients" 
                            wire:loading.attr="disabled"
                            class="w-full h-16 flex items-center justify-center gap-3 bg-teal-600 hover:bg-teal-500 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-teal-500/20 transition-all active:scale-95 disabled:opacity-50">
                        <span class="material-symbols-outlined" wire:loading.remove wire:target="loadAllPatients">group_add</span>
                        <span class="material-symbols-outlined animate-spin" wire:loading wire:target="loadAllPatients">sync</span>
                        Muat Antrian Balita
                    </button>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-slate-900 p-8 rounded-[3rem] shadow-xl relative group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl -mr-32 -mt-32 group-hover:bg-teal-500/20 transition-all duration-700 pointer-events-none"></div>
                    
                    <div class="relative space-y-4">
                        <label class="text-[10px] font-black text-teal-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">person_search</span>
                            Cari & Tambah Balita ke Daftar
                        </label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search" 
                                placeholder="Ketik nama atau NIK balita..." 
                                class="w-full bg-white/10 border-white/10 rounded-3xl text-white placeholder-white/30 text-lg font-bold focus:ring-teal-500 focus:border-teal-500 py-4 pl-14 shadow-2xl transition-all">
                            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-white/50">
                                <span class="material-symbols-outlined text-[24px]">search</span>
                            </div>
                        </div>

                        @if(count($searchResults) > 0)
                            <div class="absolute z-50 left-0 right-0 mt-4 bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden ring-8 ring-teal-500/5">
                                @foreach($searchResults as $result)
                                    <button wire:click="addPatient({{ $result->id }})" class="w-full flex items-center justify-between p-5 hover:bg-teal-50 text-left transition-all border-b border-slate-50 last:border-0 group">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl bg-teal-100/50 flex items-center justify-center text-teal-600 group-hover:rotate-12 transition-transform">
                                                <span class="material-symbols-outlined text-[24px]">child_care</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-slate-900 leading-tight">{{ $result->full_name }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">NIK: {{ $result->id_number }} • {{ $result->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-teal-500 group-hover:text-white transition-all">
                                            <span class="material-symbols-outlined">add</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Entry Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($measurements as $index => $m)
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative group hover:border-teal-200 hover:shadow-xl hover:shadow-teal-500/5 transition-all duration-500 animate-in fade-in slide-in-from-bottom-4">
                    <button wire:click="removePatient({{ $index }})" class="absolute top-6 right-6 w-8 h-8 rounded-xl bg-slate-50 text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all flex items-center justify-center group/del">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>

                    <div class="flex items-center gap-4 mb-8">
                        <div @class([
                            'w-14 h-14 rounded-[1.25rem] flex items-center justify-center shadow-inner border',
                            'bg-blue-50 text-blue-500 border-blue-100' => $m['gender'] === 'male',
                            'bg-rose-50 text-rose-500 border-rose-100' => $m['gender'] === 'female',
                        ])>
                            <span class="material-symbols-outlined text-[32px]">
                                {{ $m['gender'] === 'male' ? 'boy' : 'girl' }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 group-hover:text-teal-600 transition-colors">{{ $m['full_name'] }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] font-black px-2 py-0.5 rounded-lg bg-teal-50 text-teal-600 border border-teal-100 uppercase">
                                    {{ $m['age_months'] }} Bulan
                                </span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">
                                    {{ $m['parent_name'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Berat (kg)</label>
                            <input type="number" step="0.01" wire:model.live.debounce.500ms="measurements.{{ $index }}.weight" 
                                tabindex="{{ ($index * 2) + 1 }}"
                                class="w-full bg-slate-50 border-slate-100 rounded-3xl text-2xl font-black focus:ring-teal-500 focus:border-teal-500 py-5 text-center placeholder-slate-200 transition-all hover:bg-slate-100/50 shadow-inner"
                                placeholder="0.00">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tinggi (cm)</label>
                            <input type="number" step="0.1" wire:model.live.debounce.500ms="measurements.{{ $index }}.height" 
                                tabindex="{{ ($index * 2) + 2 }}"
                                class="w-full bg-slate-50 border-slate-100 rounded-3xl text-2xl font-black focus:ring-teal-500 focus:border-teal-500 py-5 text-center placeholder-slate-200 transition-all hover:bg-slate-100/50 shadow-inner"
                                placeholder="0.0">
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-2">
                        @if(isset($m['status_bbu']))
                            <div @class([
                                'px-3 py-1.5 rounded-2xl text-[9px] font-black uppercase tracking-tighter border shadow-sm',
                                'bg-emerald-50 text-emerald-600 border-emerald-100' => str_contains($m['status_bbu'], 'Baik'),
                                'bg-amber-50 text-amber-600 border-amber-100' => str_contains($m['status_bbu'], 'Kurang'),
                                'bg-red-50 text-red-600 border-red-100' => str_contains($m['status_bbu'], 'Buruk'),
                                'bg-blue-50 text-blue-600 border-blue-100' => str_contains($m['status_bbu'], 'Lebih'),
                            ])>
                                BB/U: {{ $m['status_bbu'] }}
                            </div>
                        @endif
                        @if(isset($m['status_bbtb']))
                            <div @class([
                                'px-3 py-1.5 rounded-2xl text-[9px] font-black uppercase tracking-tighter border shadow-sm',
                                'bg-emerald-50 text-emerald-600 border-emerald-100' => str_contains($m['status_bbtb'], 'Normal'),
                                'bg-amber-50 text-amber-600 border-amber-100' => str_contains($m['status_bbtb'], 'Kurus'),
                                'bg-red-50 text-red-600 border-red-100' => str_contains($m['status_bbtb'], 'Sangat Kurus'),
                                'bg-purple-50 text-purple-600 border-purple-100' => str_contains($m['status_bbtb'], 'Gemuk'),
                            ])>
                                BB/TB: {{ $m['status_bbtb'] }}
                            </div>
                        @endif
                        @if(isset($m['status_tbu']))
                            <div @class([
                                'px-3 py-1.5 rounded-2xl text-[9px] font-black uppercase tracking-tighter border shadow-sm',
                                'bg-emerald-50 text-emerald-600 border-emerald-100' => str_contains($m['status_tbu'], 'Normal'),
                                'bg-red-50 text-red-600 border-red-100' => str_contains($m['status_tbu'], 'Pendek') || str_contains($m['status_tbu'], 'Sangat Pendek'),
                                'bg-blue-50 text-blue-600 border-blue-100' => str_contains($m['status_tbu'], 'Tinggi'),
                            ])>
                                TB/U: {{ $m['status_tbu'] }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-50 flex items-center justify-between">
                        <select wire:model="measurements.{{ $index }}.measurement_method" 
                            class="bg-transparent border-none p-0 text-[10px] font-black text-slate-400 uppercase focus:ring-0 cursor-pointer hover:text-teal-600 transition-colors">
                            <option value="recumbent">Posisi: Terlentang</option>
                            <option value="standing">Posisi: Berdiri</option>
                        </select>
                        <div class="flex items-center gap-2">
                            <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Sesi Sebelumnya:</p>
                            <p class="text-[10px] font-black text-slate-500">{{ $m['last_weight'] }}kg / {{ $m['last_height'] }}cm</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-[3rem] p-20 shadow-sm border border-slate-100 text-center">
                    <div class="relative w-32 h-32 mx-auto mb-8">
                        <div class="w-full h-full rounded-[3rem] bg-slate-50 flex items-center justify-center text-slate-200">
                            <span class="material-symbols-outlined text-[64px]">inventory</span>
                        </div>
                        <div class="absolute -right-2 -bottom-2 w-12 h-12 rounded-3xl bg-white shadow-xl flex items-center justify-center text-teal-500 border border-teal-50">
                            <span class="material-symbols-outlined text-[24px]">search</span>
                        </div>
                    </div>
                    <h2 class="text-xl font-black text-slate-800">Daftar Pengukuran Kosong</h2>
                    <p class="mt-4 text-xs font-bold text-slate-400 uppercase tracking-widest max-w-sm mx-auto leading-loose">
                        Silahkan cari nama balita menggunakan kotak pencarian di atas untuk mulai memasukkan data penimbangan.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Floating Action Bar --}}
    @if(count($measurements) > 0)
        <div class="fixed bottom-10 left-1/2 -translate-x-1/2 w-full max-w-2xl px-6 z-50">
            <div class="bg-slate-900/90 backdrop-blur-2xl rounded-[3rem] p-4 shadow-2xl shadow-teal-500/20 border border-white/10 flex items-center justify-between">
                <div class="flex items-center gap-4 pl-4">
                    <div class="flex -space-x-3">
                        @foreach(array_slice($measurements, 0, 3) as $m)
                            <div @class([
                                'w-10 h-10 rounded-full border-4 border-slate-900 flex items-center justify-center text-[14px]',
                                'bg-blue-500 text-white' => $m['gender'] === 'male',
                                'bg-rose-500 text-white' => $m['gender'] === 'female',
                            ])>
                                <span class="material-symbols-outlined">{{ $m['gender'] === 'male' ? 'boy' : 'girl' }}</span>
                            </div>
                        @endforeach
                        @if(count($measurements) > 3)
                            <div class="w-10 h-10 rounded-full border-4 border-slate-900 bg-slate-800 text-white flex items-center justify-center text-[10px] font-black">
                                +{{ count($measurements) - 3 }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-black text-white leading-tight">{{ count($measurements) }} Balita Siap Simpan</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Total Sesi: {{ date('F Y') }}</p>
                    </div>
                </div>

                <button wire:click="save" class="group bg-teal-500 hover:bg-teal-400 text-white px-8 py-4 rounded-[2rem] text-xs font-black uppercase tracking-widest shadow-xl transition-all active:scale-95 flex items-center gap-3">
                    Simpan Sekarang
                    <span class="material-symbols-outlined group-hover:translate-x-2 transition-transform">arrow_forward</span>
                </button>
            </div>
        </div>
    @endif
</div>
