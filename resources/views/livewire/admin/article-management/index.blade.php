<div class="space-y-8 p-6 md:p-8 pt-2 md:pt-4">
    @php
        $getCategoryTheme = function($categoryName) {
            $name = strtolower($categoryName ?? '');
            if (str_contains($name, 'gizi')) {
                return [
                    'bg' => 'bg-emerald-50 dark:bg-emerald-950/30',
                    'text' => 'text-emerald-600 dark:text-emerald-400',
                    'border' => 'border-emerald-100 dark:border-emerald-900/50',
                    'shadow' => 'hover:shadow-emerald-100/50',
                ];
            }
            if (str_contains($name, 'imunisasi') || str_contains($name, 'vaksin')) {
                return [
                    'bg' => 'bg-indigo-50 dark:bg-indigo-950/30',
                    'text' => 'text-indigo-600 dark:text-indigo-400',
                    'border' => 'border-indigo-100 dark:border-indigo-900/50',
                    'shadow' => 'hover:shadow-indigo-100/50',
                ];
            }
            if (str_contains($name, 'hamil') || str_contains($name, 'ibu') || str_contains($name, 'bumil')) {
                return [
                    'bg' => 'bg-pink-50 dark:bg-pink-950/30',
                    'text' => 'text-pink-600 dark:text-pink-400',
                    'border' => 'border-pink-100 dark:border-pink-900/50',
                    'shadow' => 'hover:shadow-pink-100/50',
                ];
            }
            if (str_contains($name, 'lansia') || str_contains($name, 'tua')) {
                return [
                    'bg' => 'bg-orange-50 dark:bg-orange-950/30',
                    'text' => 'text-orange-600 dark:text-orange-400',
                    'border' => 'border-orange-100 dark:border-orange-900/50',
                    'shadow' => 'hover:shadow-orange-100/50',
                ];
            }
            // Default / Umum
            return [
                'bg' => 'bg-teal-50 dark:bg-teal-950/30',
                'text' => 'text-teal-600 dark:text-teal-400',
                'border' => 'border-teal-100 dark:border-teal-900/50',
                'shadow' => 'hover:shadow-teal-100/50',
            ];
        };
    @endphp

    {{-- ── Modern Header with Hero Mesh Banner ── --}}
    <div class="relative rounded-[2rem] p-8 md:p-10 overflow-hidden text-white shadow-2xl shadow-emerald-100"
         style="background-color: #064e3b; background-image: radial-gradient(at 0% 0%, hsla(161, 84%, 39%, 0.5) 0px, transparent 50%), radial-gradient(at 50% 0%, hsla(168, 76%, 36%, 0.5) 0px, transparent 50%), radial-gradient(at 100% 0%, hsla(172, 66%, 50%, 0.3) 0px, transparent 50%);">
        {{-- Decorative Elements --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-12">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-[10px] font-black uppercase tracking-[0.3em] text-white -mt-4 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
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
                   class="h-16 px-10 flex items-center gap-4 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white rounded-[1.5rem] text-xs font-black uppercase tracking-[0.2em] shadow-2xl shadow-teal-500/40 transition-all hover:-translate-y-1 active:scale-95 group whitespace-nowrap shrink-0">
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
        <div class="relative flex-1 w-full group">
            <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-600 transition-colors text-[20px]">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" wire:key="search-input-article"
                  placeholder="Cari judul, kategori, atau penulis..."
                  class="w-full h-12 pl-12 pr-6 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 transition-all">
        </div>

        {{-- Filters Group --}}
        <div class="flex items-center gap-3 w-full lg:w-auto">
            <div class="w-44">
                <x-forms.select-input wire:model.live="status" placeholder="Semua Status" :placeholderDisabled="false" value="{{ $status }}" class="!h-12 !rounded-2xl !bg-slate-50 !border-none !text-[11px] !font-black !text-slate-700 !uppercase !tracking-widest pr-10">
                    <option value="published">Terbit</option>
                    <option value="draft">Draft</option>
                </x-forms.select-input>
            </div>

            <div class="w-44">
                <x-forms.select-input wire:model.live="sort" placeholder="" value="{{ $sort }}" class="!h-12 !rounded-2xl !bg-slate-50 !border-none !text-[11px] !font-black !text-slate-700 !uppercase !tracking-widest pr-10">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </x-forms.select-input>
            </div>

            @if($search || $status || $sort !== 'latest')
            <button wire:click="$set('search', ''); $set('status', ''); $set('sort', 'latest');"
                    class="h-12 w-12 flex items-center justify-center bg-red-50 text-red-600 rounded-2xl hover:bg-red-100 transition-colors shadow-sm" title="Reset Filter">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
            @endif
        </div>
    </div>

{{-- ── Articles Grid Layout ── --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($articles as $article)
    @php
        $categoryName = $article->category->name ?? 'Umum';
        $theme = $getCategoryTheme($categoryName);
    @endphp
    <div class="group bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl {{ $theme['shadow'] }} transition-all duration-300 overflow-hidden flex flex-col h-full">
        
        {{-- Thumbnail — klik untuk baca --}}
        <a href="{{ route('admin.articles.show', $article->id) }}" class="block relative h-48 bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
            @if($article->thumbnail)
                <img src="{{ $article->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $article->title }}">
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-300">
                    <span class="material-symbols-outlined text-[80px]">image</span>
                </div>
            @endif
            {{-- Status Badge --}}
            <div class="absolute top-4 left-4">
                @if($article->status === 'published')
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-500/90 text-white backdrop-blur-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        Terbit
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-500/90 text-white backdrop-blur-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        Draft
                    </span>
                @endif
            </div>
        </a>

        {{-- Content — klik untuk baca --}}
        <a href="{{ route('admin.articles.show', $article->id) }}" class="p-6 flex-1 flex flex-col gap-3 hover:bg-slate-50/50 transition-colors">
            {{-- Category & Meta --}}
            <div class="flex items-center justify-between">
                <span class="px-2.5 py-0.5 rounded-full {{ $theme['bg'] }} {{ $theme['text'] }} text-[9px] font-black uppercase tracking-widest border {{ $theme['border'] }}">
                    {{ $categoryName }}
                </span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    {{ $article->reading_time }}
                </span>
            </div>

            {{-- Title --}}
            <h3 class="text-lg font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-3">
                {{ $article->title }}
            </h3>

            {{-- Excerpt --}}
            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 flex-1">
                {{ $article->excerpt }}
            </p>

            {{-- Author Info --}}
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <div class="w-9 h-9 rounded-full {{ $theme['bg'] }} flex items-center justify-center text-[11px] font-black {{ $theme['text'] }} uppercase flex-shrink-0">
                    {{ substr($article->user->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ $article->user->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-slate-400 uppercase tracking-tight">
                        {{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->translatedFormat('d M Y') }}
                    </p>
                </div>
            </div>
        </a>

        {{-- Action Buttons — hanya Edit & Delete --}}
        <div class="px-6 pb-5 pt-3 flex items-center gap-2 border-t border-slate-100">
            @can('update', $article)
            <a href="{{ route('admin.articles.edit', $article->id) }}"
               class="flex-1 h-10 flex items-center justify-center gap-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-bold text-xs uppercase tracking-widest transition-all">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                Edit
            </a>
            @endcan

            @can('delete', $article)
            <button wire:click="deleteArticle({{ $article->id }})"
                    wire:confirm="Hapus artikel ini secara permanen?"
                    class="flex-1 h-10 flex items-center justify-center gap-2 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white font-bold text-xs uppercase tracking-widest transition-all">
                <span class="material-symbols-outlined text-[16px]">delete</span>
                Hapus
            </button>
            @endcan
        </div>
    </div>
    @empty
    <div class="col-span-full py-32">
        <div class="flex flex-col items-center gap-6 text-center">
            <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center text-slate-200">
                <span class="material-symbols-outlined text-[64px]">article</span>
            </div>
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-300 mb-4">Belum ada konten publikasi</p>
                @can('create', App\Models\Article::class)
                <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-3 text-indigo-600 font-black uppercase tracking-widest text-sm hover:text-indigo-700 transition-colors px-6 py-3 bg-indigo-50 rounded-xl border border-indigo-200">
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
    <div class="pt-12">
        <x-layouts.ui.pagination :paginator="$articles" label="artikel" />
    </div>
    @endif
</div>