<div>
    @section('admin-title', '')

    <div class="w-full py-8">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-[2.5rem] shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="px-10 py-8 border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-950/20 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div
                        class="w-16 h-16 bg-indigo-50 dark:bg-indigo-950/40 rounded-3xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-sm border border-indigo-100 dark:border-indigo-900/30">
                        <span class="material-symbols-outlined text-[32px]">edit_calendar</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight leading-tight">Perbarui Jadwal</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-450 font-bold mt-1">ID: #SCH-{{ str_pad($schedule->id, 4, '0', STR_PAD_LEFT) }} • Edit detail jadwal posyandu di bawah</p>
                    </div>
                </div>
                <a href="{{ route('admin.schedules.index') }}"
                    class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 dark:hover:border-indigo-600 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[24px]">close</span>
                </a>
            </div>

            <form wire:submit.prevent="save" class="p-10 md:p-12 space-y-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Left Column: Informasi Kegiatan --}}
                    <div class="space-y-8">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100 dark:border-slate-800/80">
                            <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[24px]">info</span>
                            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">Informasi Kegiatan</h3>
                        </div>

                        <div class="space-y-3">
                            <label
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Nama / Judul Kegiatan <span class="text-red-500 font-black">*</span></label>
                            <input type="text" wire:model="title" placeholder="Contoh: Posyandu Balita RW 01"
                                class="w-full h-16 px-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-base font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/5 transition-all">
                            @error('title')
                                <p class="text-xs font-bold text-red-500 ml-1 mt-1">
                                    {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3">
                            <label
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Deskripsi & Catatan Tambahan</label>
                            <textarea wire:model="description" rows="5" placeholder="Detail kegiatan atau instruksi khusus..."
                                class="w-full px-6 py-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-base font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/5 transition-all resize-none"></textarea>
                        </div>

                        <div class="space-y-3">
                            <label
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Unit Posyandu Pelaksana <span class="text-red-500 font-black">*</span></label>
                            <div class="relative w-full">
                                <select wire:model="posyandu_id"
                                    class="w-full h-16 pl-6 pr-12 appearance-none rounded-2xl border @error('posyandu_id') bg-red-50/10 text-red-900 border-red-400 focus:border-red-500 focus:ring-red-500/10 dark:bg-red-950/10 dark:text-red-400 dark:border-red-500/50 @else border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:border-indigo-500 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/5 @enderror text-base font-semibold transition-all cursor-pointer">
                                    @if(Auth::user()->isSuperAdmin())
                                        <option value="">Pilih Posyandu</option>
                                    @endif
                                    @foreach ($posyandus as $p)
                                        <option value="{{ $p->id }}" {{ $posyandu_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 dark:text-slate-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('posyandu_id')
                                <p class="text-xs font-bold text-red-500 ml-1 mt-1">
                                    {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Right Column: Waktu & Lokasi --}}
                    <div class="space-y-8">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100 dark:border-slate-800/80">
                            <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[24px]">schedule</span>
                            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">Waktu & Lokasi</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label
                                    class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Waktu Mulai <span class="text-red-500 font-black">*</span></label>
                                <input type="datetime-local" wire:model="start_time"
                                    class="w-full h-16 px-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-base font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/5 transition-all">
                                @error('start_time')
                                    <p class="text-xs font-bold text-red-500 ml-1 mt-1">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-3">
                                <label
                                    class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Waktu Selesai <span class="text-red-500 font-black">*</span></label>
                                <input type="datetime-local" wire:model="end_time"
                                    class="w-full h-16 px-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-base font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/5 transition-all">
                                @error('end_time')
                                    <p class="text-xs font-bold text-red-500 ml-1 mt-1">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Lokasi Kegiatan <span class="text-red-500 font-black">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-[24px]">location_on</span>
                                <input type="text" wire:model="location" placeholder="Gedung Posyandu / Balai Desa"
                                    class="w-full h-16 pl-14 pr-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-base font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/5 transition-all">
                            </div>
                            @error('location')
                                <p class="text-xs font-bold text-red-500 ml-1 mt-1">
                                    {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3">
                            <label
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Status Kegiatan</label>
                            <div class="relative w-full">
                                <select wire:model="status"
                                    class="w-full h-16 pl-6 pr-12 appearance-none rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:border-indigo-500 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/5 text-base font-semibold transition-all cursor-pointer">
                                    <option value="upcoming">Mendatang (Upcoming)</option>
                                    <option value="ongoing">Sedang Berlangsung (Ongoing)</option>
                                    <option value="completed">Telah Selesai (Completed)</option>
                                    <option value="cancelled">Dibatalkan (Cancelled)</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 dark:text-slate-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="pt-10 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div
                        class="flex items-start gap-4 p-5 bg-indigo-50/50 dark:bg-indigo-950/20 rounded-2xl border border-indigo-100/50 dark:border-indigo-900/30 max-w-md">
                        <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[24px] mt-0.5">info</span>
                        <p class="text-xs font-bold text-indigo-800 dark:text-indigo-400 leading-relaxed uppercase tracking-wider">Perubahan jadwal ini akan otomatis diperbarui dan ditampilkan di halaman publik website Posyandu.</p>
                    </div>
                    <div class="flex flex-col-reverse sm:flex-row items-center gap-4 w-full sm:w-auto">
                        <a href="{{ route('admin.schedules.index') }}"
                            class="w-full sm:w-auto h-16 px-10 flex items-center justify-center text-sm font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest hover:text-slate-750 dark:hover:text-slate-200 transition-colors whitespace-nowrap">
                            Batalkan
                        </a>
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full sm:w-auto h-16 px-12 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white rounded-2xl text-base font-black uppercase tracking-widest transition-all shadow-xl shadow-teal-600/20 flex items-center justify-center gap-3 active:scale-[0.98] cursor-pointer border-0 whitespace-nowrap">
                            <span wire:loading.remove class="material-symbols-outlined text-[24px]">sync</span>
                            <div wire:loading
                                class="w-6 h-6 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            <span>Perbarui Jadwal</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
