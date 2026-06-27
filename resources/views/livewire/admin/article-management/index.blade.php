<div class="space-y-8 p-6 md:p-8 pt-2 md:pt-4">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
        <div class="relative pl-6">
            {{-- Vertical Bar --}}
            <div class="absolute left-0 top-1 bottom-1 w-1.5 bg-gradient-to-b from-teal-500 via-emerald-400 to-transparent rounded-lg"></div>
            
            <div class="flex flex-col gap-4">

                <div>
                    <h1 class="font-display-sm md:font-display-lg text-display-sm-mobile md:text-display-lg text-teal-700 mb-2 tracking-tight">
                        Artikel & Berita
                    </h1>
                    <p class="text-sm font-bold text-on-surface mt-3">Kelola konten edukasi kesehatan dan informasi penting posyandu.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Modern Header with Hero Mesh Banner ── --}}
    <div class="relative rounded-[2rem] p-8 md:p-10 overflow-hidden text-white shadow-2xl shadow-emerald-100"
         style="background-color: #064e3b; background-image: radial-gradient(at 0% 0%, hsla(161, 84%, 39%, 0.5) 0px, transparent 50%), radial-gradient(at 50% 0%, hsla(168, 76%, 36%, 0.5) 0px, transparent 50%), radial-gradient(at 100% 0%, hsla(172, 66%, 50%, 0.3) 0px, transparent 50%);">
        {{-- Decorative Elements --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-lg blur-[100px] animate-pulse"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-12">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-lg bg-white/10 backdrop-blur-md border border-white/10 text-[10px] font-black uppercase tracking-[0.3em] text-white -mt-4 mb-2">
                    <span class="w-2 h-2 rounded-lg bg-emerald-400 animate-pulse"></span>
                    Content & Education
                </div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight text-white">Manajemen Artikel</h1>
                <p class="text-base text-white font-medium max-w-2xl leading-relaxed">
                    Kelola materi edukasi kesehatan, berita kegiatan, dan informasi penting untuk warga Posyandu secara profesional.
                </p>
            </div>

            <div class="flex items-center">
                @can('create', App\Models\Article::class)
                <a href="{{ route('admin.articles.create') }}"
                   class="h-16 px-10 flex items-center gap-4 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white rounded-[1.5rem] text-xs font-black uppercase tracking-[0.2em] shadow-2xl shadow-teal-500/40 transition-all hover:-translate-y-1 active:scale-95 group">
                    <span class="material-symbols-outlined text-[24px] group-hover:rotate-90 transition-transform">add_circle</span>
                    Tulis Artikel Baru
                </a>
                @endcan
            </div>
        </div>
    </div>

    {{-- ── Search & Advanced Filters (Compact & High Contrast) ── --}}
    <div class="bg-white rounded-[2rem] p-4 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col lg:flex-row items-center gap-4">
        {{-- Search Input --}}
        <div class="flex-1 flex items-center gap-2 px-4 py-2 bg-surface-container rounded-lg w-full md:max-w-md">
    <span class="material-symbols-outlined text-outline">search</span>
    <input wire:model.live.debounce.300ms="search" class="bg-transparent border-none focus:ring-0 w-full font-body-md text-body-md text-on-surface placeholder-outline-variant outline-none" placeholder="Cari judul, kategori, atau penulis..." type="text"/>
</div>

        {{-- Filters Group --}}
        <div class="flex items-center gap-3 w-full lg:w-auto">
            <div class="w-44">
                <x-forms.select-input wire:model.live="status" placeholder="Semua Status" :placeholderDisabled="false" value="{{ $status }}" class="!h-12 !rounded-2xl !bg-surface-container-low !border-none !text-[11px] !font-black !text-on-surface-variant !uppercase !tracking-widest pr-10">
                    <option value="published">Terbit</option>
                    <option value="draft">Draft</option>
                </x-forms.select-input>
            </div>

            <div class="w-44">
                <x-forms.select-input wire:model.live="sort" placeholder="" value="{{ $sort }}" class="!h-12 !rounded-2xl !bg-surface-container-low !border-none !text-[11px] !font-black !text-on-surface-variant !uppercase !tracking-widest pr-10">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </x-forms.select-input>
            </div>

            @if($search || $status || $sort !== 'latest')
            <button wire:click="$set('search', ''); $set('status', ''); $set('sort', 'latest');"
                    class="h-12 w-12 flex items-center justify-center bg-red-50 text-error rounded-2xl hover:bg-red-100 transition-colors shadow-sm" title="Reset Filter">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
            @endif
        </div>
    </div>

    {{-- ── Articles Grid Layout (Medium Style) ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
        <div class="group relative bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full cursor-pointer"
        x-data
        @click="window.location='{{ route('admin.articles.show', $article->id) }}'">
            {{-- Thumbnail Section --}}
            <div class="relative h-48 bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                @if($article->thumbnail && Storage::disk('public')->exists($article->thumbnail))
                    <img src="{{ asset('storage/'.$article->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $article->title }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <span class="material-symbols-outlined text-[80px]">image</span>
                    </div>
                @endif
                {{-- Status Badge --}}
                <div class="absolute top-4 left-4 flex items-center gap-2">
                    @if($article->status === 'published')
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-primary/90 text-white backdrop-blur-md">
                            <span class="w-1.5 h-1.5 rounded-lg bg-white animate-pulse"></span>
                            Terbit
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-amber-500/90 text-white backdrop-blur-md">
                            <span class="w-1.5 h-1.5 rounded-lg bg-white"></span>
                            Draft
                        </span>
                    @endif
                </div>
            </div>

            {{-- Content Section --}}
            <div class="p-6 flex-1 flex flex-col gap-4">
                {{-- Category & Meta --}}
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-lg bg-secondary-container text-secondary text-[9px] font-black uppercase tracking-widest border border-indigo-100">
                        {{ $article->category->name ?? 'Umum' }}
                    </span>
                    <span class="text-[10px] font-bold text-outline-variant uppercase tracking-wide">
                        <span class="material-symbols-outlined text-[14px] align-middle">schedule</span> {{ $article->reading_time }}
                    </span>
                </div>

                {{-- Title --}}
                <h3 class="text-body-lg font-black text-on-surface leading-tight group-hover:text-secondary transition-colors line-clamp-3">
                    {{ $article->title }}
                </h3>

                {{-- Excerpt --}}
                <p class="text-sm text-outline leading-relaxed line-clamp-2 flex-1">
                    {{ $article->excerpt }}
                </p>

                {{-- Author Info --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-50">
                    <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center text-[11px] font-black text-secondary uppercase flex-shrink-0">
                        {{ substr($article->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-on-surface truncate">{{ $article->user->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-outline-variant uppercase tracking-tight">
                            {{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->translatedFormat('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
            @can('delete', $article)
            <button wire:click="deleteArticle({{ $article->id }})"
                    wire:confirm="Hapus artikel ini secara permanen?"
                    @click.stop
                    class="absolute top-3 right-3 z-20 w-8 h-8 bg-white/80 backdrop-blur-sm hover:bg-red-500 text-outline hover:text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[15px]">delete</span>
            </button>
            @endcan
        </div>
        @empty
        <div class="col-span-full py-32">
            <div class="flex flex-col items-center gap-6 text-center">
                <div class="w-24 h-24 rounded-lg bg-surface-container-low flex items-center justify-center text-slate-200">
                    <span class="material-symbols-outlined text-[64px]">article</span>
                </div>
                <div>
                    <p class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-300 mb-4">Belum ada konten publikasi</p>
                    @can('create', App\Models\Article::class)
                    <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-3 text-secondary font-black uppercase tracking-widest text-sm hover:text-indigo-700 transition-colors px-6 py-3 bg-secondary-container rounded-xl border border-secondary">
                        <span class="material-symbols-outlined">add_circle</span>
                        Mulai Menulis Artikel Pertama
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Enhanced Pagination --}}
    @if($articles->hasPages())
    <div class="flex justify-center pt-12">
        {{ $articles->links() }}
    </div>
    @endif
</div>