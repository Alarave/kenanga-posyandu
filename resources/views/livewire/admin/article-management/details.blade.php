<div>
    
    {{-- Navigation inline --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.articles.index') }}" 
        class="w-9 h-9 flex items-center justify-center bg-white border border-outline-variant hover:border-outline-variant rounded-xl text-on-surface-variant hover:text-on-surface transition-all shadow-sm group">
            <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('public.articles.show', $article->slug) }}" target="_blank"
            class="h-9 px-4 flex items-center gap-2 bg-white border border-outline-variant hover:border-outline-variant rounded-xl text-xs font-bold text-on-surface-variant transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                <span class="hidden sm:inline">Lihat di Web</span>
            </a>
            <a href="{{ route('admin.articles.edit', $article) }}" 
            class="h-9 px-4 flex items-center gap-2 bg-secondary hover:bg-indigo-700 rounded-xl text-xs font-bold text-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span class="hidden sm:inline">Edit</span>
            </a>
            @can('delete', $article)
            <button wire:click="deleteArticle" wire:confirm="Hapus artikel ini secara permanen?"
                    class="h-9 px-4 flex items-center gap-2 bg-red-50 hover:bg-error border border-error hover:border-red-600 rounded-xl text-xs font-bold text-error hover:text-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">delete</span>
                <span class="hidden sm:inline">Hapus</span>
            </button>
            @endcan
        </div>
    </div>

    {{-- ── Article Content ── --}}
    <article class="py-4">
        <div class="max-w-5xl mx-auto px-6 md:px-12 space-y-8 w-full">

            @if($article->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->thumbnail))
                <div class="w-full max-w-3xl mx-auto aspect-video rounded-2xl overflow-hidden shadow-md">
                    <img src="{{ asset('storage/'.$article->thumbnail) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-full object-cover">
                </div>
            @endif

            <div class="space-y-4">
                <h1 class="text-4xl md:text-5xl font-black text-on-surface leading-tight">
                    {{ $article->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 py-4 border-y border-outline-variant">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-bold text-body-lg">
                            {{ substr($article->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-on-surface">{{ $article->user->name }}</p>
                            <p class="text-xs text-outline">{{ $article->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="h-8 border-l border-outline-variant"></div>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[16px]">schedule</span>
                            <span class="font-bold">{{ $article->reading_time }}</span>
                        </div>
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[16px]">article</span>
                            <span class="font-bold">{{ str_word_count(\App\Services\ArticleService::getExcerpt($article->content, 999999)) }} kata</span>
                        </div>
                    </div>
                    @if($article->category)
                        <div class="h-8 border-l border-outline-variant"></div>
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-surface-container rounded-lg text-sm font-bold text-on-surface-variant">
                            <span class="material-symbols-outlined text-[14px]">label</span>
                            {{ $article->category->name }}
                        </span>
                    @endif
                </div>

                @if($article->description)
                    <p class="text-body-lg text-on-surface-variant leading-relaxed font-medium italic border-l-4 border-indigo-600 pl-6">
                        {{ $article->description }}
                    </p>
                @endif
            </div>

            <div class="article-content max-w-none">
                {!! \App\Services\ArticleService::renderContent($article->content) !!}
            </div>

            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-2xl border border-secondary p-6 md:p-8">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-black text-display-sm flex-shrink-0">
                        {{ substr($article->user->name, 0, 1) }}
                    </div>
                    <div class="space-y-2 flex-1">
                        <h3 class="text-body-lg font-black text-on-surface">{{ $article->user->name }}</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">Penulis artikel di Kenanga Posyandu. Berbagi pengetahuan kesehatan dan gizi untuk masyarakat.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4 py-6 border-t border-outline-variant">
                <div class="flex items-center gap-3">
                    @if($article->status === 'published')
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg font-bold text-sm">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            Dipublikasikan
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 text-amber-700 rounded-lg font-bold text-sm">
                            <span class="material-symbols-outlined text-[16px]">draft</span>
                            Draf
                        </span>
                    @endif
                    <span class="text-xs text-outline">Dibuat {{ $article->created_at->diffForHumans() }}</span>
                </div>
                <a href="{{ route('public.articles.show', $article->slug) }}" target="_blank"
                   class="h-10 px-4 flex items-center gap-2 bg-surface-container hover:bg-surface-container-high rounded-lg text-sm font-bold text-on-surface-variant transition-all">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                    Baca di Web
                </a>
            </div>
        </div>
    </article>

    
</div>