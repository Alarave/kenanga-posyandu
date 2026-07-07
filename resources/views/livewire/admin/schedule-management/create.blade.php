<div>
    @section('admin-title', 'Buat Agenda Baru')
    @section('admin-actions')
    <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-500 uppercase tracking-widest hover:text-teal-600 transition-colors group">
        <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
        Kembali ke Jadwal Kegiatan
    </a>
    @endsection

    <div class="w-full">
        <div class="bg-white rounded-3xl border border-slate-100 p-8 md:p-10 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.05)] relative overflow-hidden">
            <div class="absolute -right-24 -top-24 w-64 h-64 bg-slate-100 rounded-full blur-3xl pointer-events-none -z-10 will-change-transform"></div>
            
            <form wire:submit.prevent="save" class="max-w-3xl mx-auto space-y-12">
                
                {{-- Section: Informasi Kegiatan --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <span class="material-symbols-outlined text-teal-600 text-[24px]">info</span>
                        <h3 class="text-lg font-black text-slate-900">Informasi Kegiatan</h3>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Nama / Judul Kegiatan <span class="text-red-500 font-black">*</span></label>
                        <input type="text" wire:model="title" placeholder="Contoh: Posyandu Balita RW 01 / Imunisasi"
                            class="w-full h-16 px-6 rounded-2xl border border-slate-200 bg-slate-50/50 text-base font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/5 transition-all">
                        @error('title')
                            <p class="text-xs font-bold text-red-500 ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Deskripsi & Catatan Tambahan</label>
                        <textarea wire:model="description" rows="4" placeholder="Tuliskan catatan khusus atau instruksi untuk kader dan warga di sini..."
                            class="w-full px-6 py-5 rounded-2xl border border-slate-200 bg-slate-50/50 text-base font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/5 transition-all resize-none"></textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Unit Posyandu Pelaksana <span class="text-red-500 font-black">*</span></label>
                        <div class="relative w-full">
                            <select wire:model="posyandu_id"
                                class="w-full h-16 pl-6 pr-12 appearance-none rounded-2xl border @error('posyandu_id') bg-red-50/10 text-red-900 border-red-400 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 bg-slate-50/50 text-slate-800 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/5 @enderror text-base font-semibold transition-all cursor-pointer">
                                @if(Auth::user()->isSuperAdmin())
                                    <option value="" disabled selected>Pilih Unit Posyandu</option>
                                @endif
                                @foreach ($posyandus as $p)
                                    <option value="{{ $p->id }}" {{ $posyandu_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"></path>
                                </svg>
                            </div>
                        </div>
                        @error('posyandu_id')
                            <p class="text-xs font-bold text-red-500 ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- Section: Waktu & Lokasi --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <span class="material-symbols-outlined text-teal-600 text-[24px]">schedule</span>
                        <h3 class="text-lg font-black text-slate-900">Waktu & Lokasi</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Waktu Mulai <span class="text-red-500 font-black">*</span></label>
                            <input type="datetime-local" wire:model="start_time"
                                class="w-full h-16 px-6 rounded-2xl border border-slate-200 bg-slate-50/50 text-base font-semibold text-slate-800 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/5 transition-all">
                            @error('start_time')
                                <p class="text-xs font-bold text-red-500 ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Waktu Selesai <span class="text-red-500 font-black">*</span></label>
                            <input type="datetime-local" wire:model="end_time"
                                class="w-full h-16 px-6 rounded-2xl border border-slate-200 bg-slate-50/50 text-base font-semibold text-slate-800 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/5 transition-all">
                            @error('end_time')
                                <p class="text-xs font-bold text-red-500 ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Lokasi Kegiatan <span class="text-red-500 font-black">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-[24px]">location_on</span>
                            <input type="text" wire:model="location" placeholder="Gedung Posyandu / Balai Warga"
                                class="w-full h-16 pl-14 pr-6 rounded-2xl border border-slate-200 bg-slate-50/50 text-base font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/5 transition-all">
                        </div>
                        @error('location')
                            <p class="text-xs font-bold text-red-500 ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Status Awal Kegiatan</label>
                        <div class="relative w-full">
                            <select wire:model="status"
                                class="w-full h-16 pl-6 pr-12 appearance-none rounded-2xl border border-slate-200 bg-slate-50/50 text-slate-855 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/5 text-base font-semibold transition-all cursor-pointer">
                                <option value="upcoming">Mendatang (Upcoming)</option>
                                <option value="ongoing">Sedang Berlangsung (Ongoing)</option>
                                <option value="completed">Telah Selesai (Completed)</option>
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Perulangan Kegiatan --}}
                    <div class="p-6 bg-slate-50 rounded-[1.8rem] border border-slate-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-teal-600">repeat</span>
                                <div>
                                    <label class="block text-sm font-bold text-slate-800">Ulangi Setiap Bulan</label>
                                    <span class="block text-[11px] font-semibold text-slate-400">Buat jadwal ini berulang pada tanggal yang sama setiap bulannya</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="is_recurring" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-250 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                            </label>
                        </div>

                        @if($is_recurring)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-100">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Durasi Perulangan</label>
                                    <div class="relative w-full">
                                        <select wire:model.live="repeat_months"
                                            class="w-full h-12 pl-4 pr-10 appearance-none rounded-xl border border-slate-200 bg-white text-slate-800 text-sm font-semibold focus:border-teal-500 focus:outline-none cursor-pointer">
                                            <option value="3">3 Bulan</option>
                                            <option value="6">6 Bulan</option>
                                            <option value="12">12 Bulan (1 Tahun)</option>
                                            <option value="24">24 Bulan (2 Tahun)</option>
                                        </select>
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <p class="text-[11px] font-bold text-slate-455 leading-normal mt-4">
                                        Sistem akan membuat sebanyak <span class="font-black text-teal-600">{{ $repeat_months }} jadwal</span> otomatis untuk periode mendatang.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-10 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-start gap-4 p-5 bg-teal-50/50 rounded-2xl border border-teal-100/50 max-w-md">
                        <span class="material-symbols-outlined text-teal-600 text-[24px] mt-0.5">info</span>
                        <p class="text-xs font-bold text-teal-800 leading-relaxed uppercase tracking-wider">Jadwal kegiatan ini akan otomatis ditampilkan di halaman publik website Posyandu.</p>
                    </div>
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <a href="{{ route('admin.schedules.index') }}"
                            class="flex-1 sm:flex-none h-16 px-10 flex items-center justify-center text-sm font-black text-slate-500 uppercase tracking-widest hover:text-slate-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit" wire:loading.attr="disabled"
                            class="flex-1 sm:flex-none h-16 px-12 bg-linear-to-r from-emerald-600 to-teal-600 hover:opacity-95 text-white rounded-2xl text-base font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-600/10 flex items-center justify-center gap-3 active:scale-[0.98] cursor-pointer">
                            <span wire:loading.remove class="material-symbols-outlined text-[24px]">save</span>
                            <div wire:loading class="w-6 h-6 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            <span>Simpan Jadwal</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
