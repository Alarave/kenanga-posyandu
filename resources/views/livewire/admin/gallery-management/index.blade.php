<div class="max-w-[1440px] mx-auto space-y-8 pb-20">
    
    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-2">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Manajemen Galeri</h2>
            <p class="text-sm text-slate-400 font-medium mt-1">Dokumentasi kegiatan dan momen bermakna di Posyandu.</p>
        </div>
        <x-button href="{{ route('admin.gallery.create') }}" variant="secondary" icon="create_new_folder">Tambah Folder Baru</x-button>
    </div>

    {{-- ── Search Bar (Filter Dihapus) ── --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 p-6 flex flex-col lg:flex-row gap-6 items-center justify-between shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        {{-- Search input --}}
        <div class="relative w-full group">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-teal-500 transition-colors pointer-events-none">search</span>
            <input type="text" wire:model.live="search" placeholder="Cari nama folder kegiatan..." 
                class="w-full h-12 pl-12 pr-4 bg-slate-50 border-transparent rounded-2xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-0 focus:border-teal-500 transition-all border-2 border-slate-100">
        </div>
    </div>

    {{-- ── Gallery Folders Grid ── --}}
    @if($folders->isEmpty())
        <div class="bg-white rounded-[2.5rem] border border-slate-100 py-24 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-slate-200 text-[40px]">folder_off</span>
            </div>
            <h3 class="text-lg font-black text-slate-800 mb-1">Belum ada Folder</h3>
            <p class="text-sm text-slate-400 font-medium mb-8">Buat folder baru terlebih dahulu untuk mulai mendokumentasikan kegiatan Posyandu.</p>
            <x-button href="{{ route('admin.gallery.create') }}" variant="secondary" icon="add">Tambah Folder Baru</x-button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($folders as $folder)
                <div class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden group hover:border-slate-300 transition-all duration-500 shadow-md hover:shadow-xl flex flex-col h-full relative">
                    
                    {{-- Folder Cover / Preview --}}
                    <div class="aspect-[4/3] relative overflow-hidden bg-slate-100 flex items-center justify-center border-b border-slate-50">
                        @if($folder->cover_photo)
                            <img src="{{ asset('storage/' . $folder->cover_photo) }}" 
                                 alt="{{ $folder->name }}"
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        @else
                            {{-- Folder Placeholder Graphic --}}
                            <div class="flex flex-col items-center justify-center text-teal-600/80 group-hover:scale-105 transition-transform duration-500">
                                <span class="material-symbols-outlined text-[72px]" style="font-variation-settings: 'FILL' 1;">folder</span>
                            </div>
                        @endif

                        {{-- Media Count Badge --}}
                        <div class="absolute top-4 right-4 z-20">
                            <div class="bg-slate-900/90 text-white backdrop-blur px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-white/10 shadow-md">
                                <span class="material-symbols-outlined text-[14px]">photo_library</span>
                                <span class="text-[9px] font-black uppercase tracking-widest">{{ $folder->galleries_count }} Media</span>
                            </div>
                        </div>

                        {{-- Action Overlay --}}
                        <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-[2px] flex items-center justify-center gap-4 z-30">
                            <a href="{{ route('admin.gallery.show', $folder->id) }}" 
                               class="w-12 h-12 bg-white text-slate-700 rounded-2xl flex items-center justify-center shadow-lg hover:bg-teal-500 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-300"
                               title="Buka Folder">
                                <span class="material-symbols-outlined text-[22px]">folder_open</span>
                            </a>
                            <a href="{{ route('admin.gallery.edit', $folder->id) }}" 
                               class="w-12 h-12 bg-white text-slate-700 rounded-2xl flex items-center justify-center shadow-lg hover:bg-indigo-500 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-300"
                               title="Edit Folder">
                                <span class="material-symbols-outlined text-[22px]">edit</span>
                            </a>
                            <form action="{{ route('admin.gallery.destroy', $folder->id) }}" method="POST" 
                                  onsubmit="return confirm('Menghapus folder ini akan menghapus SELURUH foto dan video di dalamnya. Yakin ingin melanjutkan?');">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        class="w-12 h-12 bg-white text-red-500 rounded-2xl flex items-center justify-center shadow-lg hover:bg-red-500 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-300"
                                        title="Hapus Folder">
                                    <span class="material-symbols-outlined text-[22px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Folder Info --}}
                    <a href="{{ route('admin.gallery.show', $folder->id) }}" class="p-6 flex-1 flex flex-col justify-between space-y-4 block">
                        <div class="space-y-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-500 rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-100">
                                {{ $folder->posyandu->name ?? 'Semua Posyandu' }}
                            </span>
                            <h3 class="text-lg font-black text-slate-800 leading-snug line-clamp-1 group-hover:text-teal-600 transition-colors" title="{{ $folder->name }}">
                                {{ $folder->name }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $folder->description ?? 'Tidak ada deskripsi.' }}
                            </p>
                        </div>
                        <div class="text-[10px] text-slate-400 font-bold flex items-center gap-1.5 pt-4 border-t border-slate-50">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            Dibuat: {{ \Carbon\Carbon::parse($folder->created_at)->translatedFormat('d M Y') }}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $folders->links() }}
        </div>
    @endif
</div>
