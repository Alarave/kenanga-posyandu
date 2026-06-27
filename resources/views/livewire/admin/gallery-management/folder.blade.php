<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Galeri</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Kelola folder dokumentasi kegiatan Posyandu.</p>
        </div>
        <button type="button" wire:click="openCreate"
                class="h-11 px-6 flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-all shadow-sm">
            <span class="material-symbols-outlined text-[18px]">create_new_folder</span>
            Buat Folder Baru
        </button>
    </div>

    {{-- Search --}}
    <div class="flex items-center gap-3 h-12 px-4 bg-white border border-slate-200 rounded-xl shadow-sm">
        <span class="material-symbols-outlined text-slate-400 text-[20px]">search</span>
        <input type="text" wire:model.live.debounce.300ms="search"
               placeholder="Cari folder..."
               class="flex-1 bg-transparent border-none outline-none text-sm text-slate-700 placeholder:text-slate-400">
    </div>

    {{-- Grid Folders --}}
    @if($folders->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 py-24 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-slate-300 text-[40px]">folder_off</span>
            </div>
            <h3 class="text-base font-black text-slate-900 mb-1">Belum ada folder</h3>
            <p class="text-sm text-slate-400 mb-6">Buat folder untuk mengelompokkan foto dan video kegiatan.</p>
            <button type="button" wire:click="openCreate"
                    class="h-10 px-6 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all">
                Buat Folder Pertama
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($folders as $folder)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                {{-- Cover --}}
                <a href="{{ route('admin.gallery.folder', $folder->id) }}"
                   class="block aspect-[4/3] bg-gradient-to-br from-indigo-50 to-slate-100 relative overflow-hidden">
                    @if($folder->cover_image)
                        <img src="{{ asset('storage/'.$folder->cover_image) }}"
                             alt="{{ $folder->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-300 text-[64px]">folder</span>
                        </div>
                    @endif
                    <div class="absolute bottom-3 right-3 bg-black/50 backdrop-blur-sm text-white text-[10px] font-black px-2.5 py-1 rounded-lg">
                        {{ $folder->galleries_count }} media
                    </div>
                </a>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-black text-slate-900 text-sm leading-tight line-clamp-1">{{ $folder->name }}</h3>
                    @if($folder->description)
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $folder->description }}</p>
                    @endif
                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-50">
                        <span class="text-[10px] text-slate-400 font-bold">
                            {{ $folder->created_at->translatedFormat('d M Y') }}
                        </span>
                        <div class="flex items-center gap-1">
                            <button type="button" wire:click="openEdit({{ $folder->id }})"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-indigo-50 text-slate-400 hover:text-indigo-600 transition-all">
                                <span class="material-symbols-outlined text-[15px]">edit</span>
                            </button>
                            <button type="button" wire:click="delete({{ $folder->id }})"
                                    wire:confirm="Hapus folder ini? Foto di dalamnya tidak akan ikut terhapus."
                                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-500 transition-all">
                                <span class="material-symbols-outlined text-[15px]">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $folders->links() }}
        </div>
    @endif

    {{-- Modal Create/Edit --}}
    <div x-data="{ show: @entangle('showModal') }"
         x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
         x-cloak>
        <div @click.away="show = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-6 space-y-5">

            <h3 class="text-lg font-black text-slate-900">
                {{ $editingId ? 'Edit Folder' : 'Buat Folder Baru' }}
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nama Folder *</label>
                    <input type="text" wire:model="name"
                           placeholder="Contoh: Kegiatan Januari 2026"
                           class="mt-1.5 w-full h-11 px-4 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:border-indigo-400 bg-slate-50">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Deskripsi</label>
                    <textarea wire:model="description" rows="3"
                              placeholder="Deskripsi singkat folder ini..."
                              class="mt-1.5 w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:border-indigo-400 bg-slate-50 resize-none"></textarea>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Foto Cover</label>
                    <input type="file" wire:model="cover_image" accept="image/*"
                           class="mt-1.5 w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    @error('cover_image') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" @click="show = false"
                        class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    Batal
                </button>
                <button type="button" wire:click="save"
                        class="flex-1 h-11 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-all">
                    {{ $editingId ? 'Simpan Perubahan' : 'Buat Folder' }}
                </button>
            </div>
        </div>
    </div>
</div>