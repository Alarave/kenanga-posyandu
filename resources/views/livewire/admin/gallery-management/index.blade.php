<div class="max-w-[1440px] mx-auto space-y-8 pb-20" x-data="{ mediaFilter: 'all' }">
    
    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-2">
        <div>
            <h2 class="text-display-sm text-on-surface tracking-tight">Manajemen Galeri</h2>
            <p class="text-sm text-outline-variant font-medium mt-1">Dokumentasi kegiatan dan momen bermakna di Posyandu.</p>
        </div>
        <x-button href="{{ route('admin.gallery.create') }}" variant="secondary" icon="add_to_photos">Unggah Media Baru</x-button>
    </div>

    {{-- ── Search & Filter Pill Bar ── --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 p-6 flex flex-col lg:flex-row gap-6 items-center justify-between shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        {{-- Search input --}}
        <div class="relative w-full lg:max-w-md group">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-teal-500 transition-colors pointer-events-none">search</span>
            <input type="text" wire:model.live="search" placeholder="Cari judul kegiatan..." 
                class="w-full h-12 pl-12 pr-4 bg-surface-container-low border-transparent rounded-2xl text-sm font-semibold text-on-surface-variant focus:bg-white focus:ring-0 focus:border-primary transition-all border-2 border-slate-100">
        </div>

        {{-- Filter Capsules --}}
        <div class="flex items-center bg-surface-container p-1 rounded-2xl border border-outline-variant">
            <button @click="mediaFilter = 'all'" :class="mediaFilter === 'all' ? 'bg-inverse-surface text-white shadow-md' : 'text-on-surface-variant hover:text-on-surface'" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                Semua
            </button>
            <button @click="mediaFilter = 'photo'" :class="mediaFilter === 'photo' ? 'bg-primary text-white shadow-md' : 'text-on-surface-variant hover:text-on-surface'" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                Foto
            </button>
            <button @click="mediaFilter = 'video'" :class="mediaFilter === 'video' ? 'bg-secondary text-white shadow-md' : 'text-on-surface-variant hover:text-on-surface'" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                Video
            </button>
        </div>
    </div>

    {{-- ── Gallery Grid ── --}}
    @if($galleries->isEmpty())
        <div class="bg-white rounded-[2.5rem] border border-slate-100 py-24 text-center">
            <div class="w-20 h-20 bg-surface-container-low rounded-lg flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-slate-200 text-[40px]">image_not_supported</span>
            </div>
            <h3 class="text-body-lg font-black text-on-surface mb-1">Belum ada Media</h3>
            <p class="text-sm text-outline-variant font-medium mb-8">Unggah file foto atau video kegiatan Posyandu Anda di sini.</p>
            <x-button href="{{ route('admin.gallery.create') }}" variant="secondary" icon="add">Unggah Sekarang</x-button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($galleries as $gallery)
                @php
                    $isVideo = ($gallery->type === 'video');
                @endphp
                <div x-show="mediaFilter === 'all' || (mediaFilter === 'photo' && !{{ $isVideo ? 'true' : 'false' }}) || (mediaFilter === 'video' && {{ $isVideo ? 'true' : 'false' }})"
                     class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden group hover:border-outline-variant transition-all duration-500 shadow-md hover:shadow-xl flex flex-col h-full"
                     x-data="{ playing: false }">
                    
                    {{-- Media Container --}}
                    <div class="aspect-[4/3] relative overflow-hidden bg-slate-950 flex items-center justify-center">
                        @if($isVideo)
                            <video x-ref="vid" src="{{ asset('storage/' . $gallery->photo) }}" 
                                   muted loop playsinline class="w-full h-full object-cover transition-all duration-500"
                                   @mouseenter="$refs.vid.play(); playing = true" 
                                   @mouseleave="$refs.vid.pause(); $refs.vid.currentTime = 0; playing = false"></video>
                            
                            {{-- Video Camera Indicator Badge --}}
                            <div class="absolute top-4 right-4 z-20">
                                <div class="bg-secondary/90 text-white backdrop-blur px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-indigo-400/30 shadow-md">
                                    <span class="material-symbols-outlined text-[14px]">videocam</span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Video</span>
                                </div>
                            </div>
                            
                            {{-- Hover Play State Overlay --}}
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none transition-opacity duration-300" :class="playing ? 'opacity-0' : 'opacity-100'">
                                <div class="w-14 h-14 rounded-lg bg-white/20 backdrop-blur-md border border-white/40 flex items-center justify-center shadow-lg text-white">
                                    <span class="material-symbols-outlined text-[32px] fill-current">play_arrow</span>
                                </div>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $gallery->photo) }}" 
                                 alt="{{ $gallery->title }}"
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                            
                            <div class="absolute top-4 right-4 z-20">
                                <div class="bg-primary/90 text-white backdrop-blur px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-teal-400/30 shadow-md">
                                    <span class="material-symbols-outlined text-[14px]">image</span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Foto</span>
                                </div>
                            </div>
                        @endif

                        {{-- Featured Badge --}}
                        @if($gallery->is_featured)
                            <div class="absolute top-4 left-4 z-20">
                                <div class="bg-white/95 text-on-surface backdrop-blur px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-white/50 shadow-md">
                                    <span class="material-symbols-outlined text-amber-500 text-[14px]">star</span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Unggulan</span>
                                </div>
                            </div>
                        @endif

                        {{-- Action Overlay --}}
                        <div class="absolute inset-0 bg-inverse-surface/60 opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-[2px] flex items-center justify-center gap-4 z-30">
                            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" 
                               class="w-12 h-12 bg-white text-on-surface-variant rounded-2xl flex items-center justify-center shadow-lg hover:bg-primary hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-300">
                                <span class="material-symbols-outlined text-[22px]">edit</span>
                            </a>
                            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus item galeri ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        class="w-12 h-12 bg-white text-red-500 rounded-2xl flex items-center justify-center shadow-lg hover:bg-red-500 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-300">
                                    <span class="material-symbols-outlined text-[22px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Metadata info --}}
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4 border-t border-slate-50">
                        <div class="space-y-2">
                            <span class="px-2.5 py-1 bg-surface-container-low text-outline rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-100">
                                {{ $gallery->posyandu->name ?? 'Semua Posyandu' }}
                            </span>
                            <h3 class="text-body-lg font-black text-on-surface leading-snug line-clamp-1" title="{{ $gallery->title }}">
                                {{ $gallery->title }}
                            </h3>
                            <p class="text-xs font-semibold text-outline-variant line-clamp-2 leading-relaxed">
                                {{ $gallery->description }}
                            </p>
                        </div>
                        <div class="text-[10px] text-outline-variant font-bold flex items-center gap-1.5 pt-4 border-t border-slate-50">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            {{ \Carbon\Carbon::parse($gallery->created_at)->translatedFormat('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
