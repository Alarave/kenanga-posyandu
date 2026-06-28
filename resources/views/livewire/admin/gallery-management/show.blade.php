@extends('layouts.admin-layout')

@section('admin-title')
    {{ $folder->name }} - Galeri
@endsection

@section('admin-content')
<div class="max-w-[1440px] mx-auto space-y-8 pb-20" x-data="{ mediaFilter: 'all' }">
    
    {{-- ── Header & Action ── --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 px-2">
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.gallery.index') }}" class="text-teal-600 hover:text-teal-800 flex items-center gap-1 text-sm font-bold transition-colors">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Semua Folder
                </a>
            </div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                <span class="material-symbols-outlined text-[36px] text-teal-600">folder_open</span>
                {{ $folder->name }}
            </h2>
            <p class="text-sm text-slate-400 font-medium max-w-2xl">{{ $folder->description ?? 'Tidak ada deskripsi folder.' }}</p>
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200">
                    Posyandu: {{ $folder->posyandu->name ?? 'Semua Posyandu' }}
                </span>
                <span class="px-2.5 py-1 bg-teal-50 text-teal-700 rounded-lg text-[9px] font-black uppercase tracking-widest border border-teal-100">
                    Dibuat Oleh: {{ $folder->user->full_name ?? 'Petugas Posyandu' }}
                </span>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <x-button href="{{ route('admin.gallery.edit', $folder->id) }}" variant="secondary" icon="edit" class="!bg-white !border-slate-200 !text-slate-700 hover:!bg-slate-50">Edit Folder</x-button>
            <x-button href="{{ route('admin.gallery.media.create', $folder->id) }}" variant="primary" icon="add_to_photos" class="!bg-teal-600 hover:!bg-teal-700 !text-white">Unggah Media Baru</x-button>
        </div>
    </div>

    {{-- ── Filter Tab Bar (Hanya Ada di Dalam Folder) ── --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 p-6 flex flex-col md:flex-row gap-6 items-center justify-between shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Filter Media di dalam folder ini:</p>
        
        <div class="flex items-center bg-slate-100 p-1 rounded-2xl border border-slate-200">
            <button @click="mediaFilter = 'all'" :class="mediaFilter === 'all' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:text-slate-900'" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                Semua ({{ $galleries->count() }})
            </button>
            <button @click="mediaFilter = 'photo'" :class="mediaFilter === 'photo' ? 'bg-teal-600 text-white shadow-md' : 'text-slate-600 hover:text-slate-900'" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                Foto
            </button>
            <button @click="mediaFilter = 'video'" :class="mediaFilter === 'video' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:text-slate-900'" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                Video
            </button>
        </div>
    </div>

    {{-- ── Media Grid ── --}}
    @if($galleries->isEmpty())
        <div class="bg-white rounded-[2.5rem] border border-slate-100 py-24 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-slate-200 text-[40px]">collections</span>
            </div>
            <h3 class="text-lg font-black text-slate-800 mb-1">Folder Kosong</h3>
            <p class="text-sm text-slate-400 font-medium mb-8">Dokumentasikan momen berupa foto atau video kegiatan Posyandu ke folder ini.</p>
            <x-button href="{{ route('admin.gallery.media.create', $folder->id) }}" variant="secondary" icon="add">Unggah Media Sekarang</x-button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($galleries as $gallery)
                @php
                    $isVideo = ($gallery->type === 'video');
                @endphp
                <div x-show="mediaFilter === 'all' || (mediaFilter === 'photo' && !{{ $isVideo ? 'true' : 'false' }}) || (mediaFilter === 'video' && {{ $isVideo ? 'true' : 'false' }})"
                     class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden group hover:border-slate-300 transition-all duration-500 shadow-md hover:shadow-xl flex flex-col h-full"
                     x-data="{ playing: false }">
                    
                    {{-- Media Container --}}
                    <div class="aspect-[4/3] relative overflow-hidden bg-slate-950 flex items-center justify-center">
                        @if($isVideo)
                            <video x-ref="vid" src="{{ asset('storage/' . $gallery->photo) }}" 
                                   muted loop playsinline class="w-full h-full object-cover transition-all duration-500"
                                   @mouseenter="$refs.vid.play(); playing = true" 
                                   @mouseleave="$refs.vid.pause(); $refs.vid.currentTime = 0; playing = false"></video>
                            
                            {{-- Video Indicator Badge --}}
                            <div class="absolute top-4 right-4 z-20">
                                <div class="bg-indigo-600/90 text-white backdrop-blur px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-indigo-400/30 shadow-md">
                                    <span class="material-symbols-outlined text-[14px]">videocam</span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Video</span>
                                </div>
                            </div>
                            
                            {{-- Hover Play State Overlay --}}
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none transition-opacity duration-300" :class="playing ? 'opacity-0' : 'opacity-100'">
                                <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-md border border-white/40 flex items-center justify-center shadow-lg text-white">
                                    <span class="material-symbols-outlined text-[32px] fill-current">play_arrow</span>
                                </div>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $gallery->photo) }}" 
                                 alt="{{ $gallery->title }}"
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                            
                            <div class="absolute top-4 right-4 z-20">
                                <div class="bg-teal-600/90 text-white backdrop-blur px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-teal-400/30 shadow-md">
                                    <span class="material-symbols-outlined text-[14px]">image</span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Foto</span>
                                </div>
                            </div>
                        @endif

                        {{-- Action Overlay --}}
                        <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-[2px] flex items-center justify-center gap-4 z-30">
                            <form action="{{ route('admin.gallery.media.destroy', [$folder->id, $gallery->id]) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus item media ini?');">
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
                            <h3 class="text-lg font-black text-slate-800 leading-snug line-clamp-1" title="{{ $gallery->title }}">
                                {{ $gallery->title }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $gallery->description }}
                            </p>
                        </div>
                        <div class="text-[10px] text-slate-400 font-bold flex items-center gap-1.5 pt-4 border-t border-slate-50">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            Diunggah: {{ \Carbon\Carbon::parse($gallery->created_at)->translatedFormat('d M Y, H:i') }}
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
@endsection
