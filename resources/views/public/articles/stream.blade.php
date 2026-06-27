<div class="flex-1 space-y-16">
    {{-- Header Section: Title & Category Filters --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-slate-100">
        <div>
            <h2 class="text-display-sm-mobile font-black text-on-surface tracking-tight font-jakarta">Koleksi Pengetahuan</h2>
            <p class="text-outline text-xs md:text-sm mt-1">Edukasi dan tips kesehatan terpercaya dari kader Posyandu</p>
        </div>
        
        {{-- Category Filter Pills --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 scrollbar-none max-w-full sm:max-w-[400px] -mx-6 px-6 sm:mx-0 sm:px-0">
            <a href="{{ route('public.articles.index') }}" 
               class="px-5 py-2.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border transition-all duration-300 whitespace-nowrap {{ !request('category') ? 'bg-secondary text-white border-indigo-600 shadow-md shadow-indigo-100' : 'bg-surface-container-low text-on-surface-variant border-outline-variant/60 hover:bg-surface-container hover:text-on-surface hover:border-outline-variant' }}">
                Semua
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('public.articles.index', ['category' => $cat->slug]) }}" 
               class="px-5 py-2.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border transition-all duration-300 whitespace-nowrap {{ request('category') === $cat->slug ? 'bg-secondary text-white border-indigo-600 shadow-md shadow-indigo-100' : 'bg-surface-container-low text-on-surface-variant border-outline-variant/60 hover:bg-surface-container hover:text-on-surface hover:border-outline-variant' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Articles List --}}
    <div class="space-y-12">
        @forelse($articles as $article)
        <article class="group relative flex flex-col md:flex-row gap-8 items-start pb-12 border-b border-slate-100 last:border-0 last:pb-0">
            <div class="flex-1 space-y-4">
                {{-- Meta Info --}}
                <div class="flex items-center gap-3">
                    {{-- Author Avatar --}}
                    @php
                        $authorName = $article->user->name ?? 'Tim Redaksi';
                        $initial = strtoupper(substr($authorName, 0, 1));
                    @endphp
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 text-white flex items-center justify-center text-[10px] font-black shadow-sm ring-2 ring-white">
                        {{ $initial }}
                    </div>
                    <span class="text-xs font-bold text-on-surface tracking-tight">{{ $authorName }}</span>
                    <span class="w-1 h-1 rounded-lg bg-surface-container-high"></span>
                    <span class="px-2.5 py-1 bg-secondary-container text-secondary font-extrabold rounded-md text-[9px] uppercase tracking-widest">
                        {{ $article->category->name ?? 'Umum' }}
                    </span>
                </div>
                
                {{-- Title & Excerpt --}}
                <a href="{{ route('public.articles.show', $article->slug) }}" class="block space-y-3 group/title">
                    <h3 class="text-headline-sm md:text-headline-md font-extrabold text-on-surface leading-snug tracking-tight group-hover/title:text-secondary transition-colors duration-300">
                        {{ $article->title }}
                    </h3>
                    <p class="text-outline text-sm font-medium leading-relaxed line-clamp-2">
                        {{ \App\Services\ArticleService::getExcerpt($article->content, 160) }}
                    </p>
                </a>

                {{-- Date, Read Time & Actions --}}
                <div class="flex items-center justify-between pt-4">
                    <div class="flex items-center gap-4 text-[10px] font-extrabold text-outline-variant uppercase tracking-widest">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                            {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}
                        </span>
                        <span class="w-1 h-1 rounded-lg bg-surface-container-high"></span>
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} mnt baca
                        </span>
                    </div>
                    
                    {{-- Social/Bookmark Action Buttons --}}
                    <div class="flex items-center gap-2 opacity-65 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="w-8 h-8 rounded-lg flex items-center justify-center text-outline-variant hover:text-secondary hover:bg-secondary-container transition-all duration-300" title="Bagikan">
                            <span class="material-symbols-outlined text-[18px]">share</span>
                        </button>
                        <button class="w-8 h-8 rounded-lg flex items-center justify-center text-outline-variant hover:text-red-500 hover:bg-red-50 transition-all duration-300" title="Simpan">
                            <span class="material-symbols-outlined text-[18px]">bookmark</span>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Article Thumbnail --}}
            <div class="w-full md:w-52 aspect-[16/10] md:aspect-[4/3] rounded-2xl overflow-hidden shadow-md ring-1 ring-slate-100 flex-shrink-0 relative group-hover:shadow-lg transition-all duration-500">
                <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=800&auto=format&fit=crop' }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
            </div>
        </article>
        @empty
        {{-- Elegant Empty State --}}
        <div class="py-24 px-8 text-center bg-gradient-to-b from-slate-50/50 to-slate-100/30 rounded-[3rem] border border-slate-100 shadow-inner">
            <div class="w-20 h-20 mx-auto bg-secondary-container text-indigo-500 flex items-center justify-center rounded-2xl mb-6 shadow-sm">
                <span class="material-symbols-outlined text-[40px]">description</span>
            </div>
            <h3 class="text-headline-sm font-bold text-on-surface tracking-tight">Belum Ada Cerita Baru</h3>
            <p class="text-outline-variant text-sm mt-2 max-w-sm mx-auto font-medium">Kami sedang merapikan konten edukasi terbaik dan informasi terbaru untuk Anda. Kembali lagi segera!</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($articles->hasPages())
        <div class="pt-8 mt-12 border-t border-slate-100 flex justify-center">
            {{ $articles->links() }}
        </div>
        @endif
    </div>
</div>
