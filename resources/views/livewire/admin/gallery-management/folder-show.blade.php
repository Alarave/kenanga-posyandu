<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.gallery.index') }}"
               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 hover:border-slate-300 text-slate-600 hover:text-slate-900 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $folder->name }}</h2>
                @if($folder->description)
                    <p class="text-sm text-slate-500 font-medium mt-0.5">{{ $folder->description }}</p>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.gallery.create', ['folder_id' => $folder->id]) }}"
           class="h-11 px-6 flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-all shadow-sm">
            <span class="material-symbols-outlined text-[18px]">add_photo_alternate</span>
            Unggah Media
        </a>
    </div>

    {{-- Grid Media --}}
    @if($galleries->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 py-24 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-slate-300 text-[40px]">image_not_supported</span>
            </div>
            <h3 class="text-base font-black text-slate-900 mb-1">Belum ada media</h3>
            <p class="text-sm text-slate-400 mb-6">Unggah foto atau video untuk folder ini.</p>
            <a href="{{ route('admin.gallery.create', ['folder_id' => $folder->id]) }}"
               class="inline-flex items-center gap-2 h-10 px-6 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all">
                <span class="material-symbols-outlined text-[16px]">add</span>
                Unggah Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
            @php $isVideo = $gallery->type === 'video'; @endphp
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden"
                 x-data="{ playing: false }">
                
                {{-- Media --}}
                <div class="aspect-[4/3] relative overflow-hidden bg-slate-950">
                    @if($isVideo)
                        <video x-ref="vid" src="{{ asset('storage/'.$gallery->photo) }}"
                               muted loop playsinline class="w-full h-full object-cover"
                               @mouseenter="$refs.vid.play(); playing = true"
                               @mouseleave="$refs.vid.pause(); $refs.vid.currentTime = 0; playing = false"></video>
                        <div class="absolute top-3 right-3">
                            <span class="bg-indigo-600/90 text-white text-[9px] font-black px-2 py-1 rounded-lg flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">videocam</span> Video
                            </span>
                        </div>
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none transition-opacity"
                             :class="playing ? 'opacity-0' : 'opacity-100'">
                            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md border border-white/40 flex items-center justify-center text-white">
                                <span class="material-symbols-outlined text-[28px]">play_arrow</span>
                            </div>
                        </div>
                    @else
                        <img src="{{ asset('storage/'.$gallery->photo) }}"
                             alt="{{ $gallery->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-3 right-3">
                            <span class="bg-emerald-600/90 text-white text-[9px] font-black px-2 py-1 rounded-lg flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">image</span> Foto
                            </span>
                        </div>
                    @endif

                    {{-- Action overlay --}}
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3">
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}"
                           class="w-10 h-10 bg-white text-slate-700 rounded-xl flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus media ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-10 h-10 bg-white text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-black text-slate-900 text-sm line-clamp-1">{{ $gallery->title }}</h3>
                    @if($gallery->description)
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $gallery->description }}</p>
                    @endif
                    <p class="text-[10px] text-slate-400 font-bold mt-3">
                        {{ $gallery->created_at->translatedFormat('d M Y, H:i') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    @endif
</div>