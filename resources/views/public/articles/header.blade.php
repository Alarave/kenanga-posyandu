<header class="max-w-4xl mx-auto mb-16">
    <div class="mb-8">
        <span class="inline-block px-4 py-1 bg-surface-container text-on-surface-variant text-[10px] font-black rounded-lg uppercase tracking-widest">
            {{ $article->category->name ?? 'Informasi Kesehatan' }}
        </span>
    </div>

    <h1 class="text-4xl md:text-6xl font-black text-on-surface leading-tight tracking-tight mb-10">
        {{ $article->title }}
    </h1>

    <div class="flex items-center justify-between py-8 border-y border-slate-100">
        <div class="flex items-center gap-5">
            {{-- Author Avatar --}}
            <div class="w-14 h-14 rounded-lg bg-secondary flex items-center justify-center text-white text-headline-sm font-black shadow-lg shadow-indigo-200">
                {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h4 class="text-[15px] font-black text-on-surface tracking-tight">{{ $article->user->name ?? 'Tim Redaksi' }}</h4>
                    <span class="w-1 h-1 rounded-lg bg-slate-300"></span>
                    <button class="text-[13px] font-bold text-secondary hover:text-indigo-800 transition-colors">Ikuti</button>
                </div>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-[12px] text-outline-variant font-medium italic">{{ ceil(str_word_count(strip_tags($article->content)) / 200) }} mnt baca</span>
                    <span class="w-1 h-1 rounded-lg bg-surface-container-high"></span>
                    <span class="text-[12px] text-outline-variant font-medium">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="hidden sm:flex items-center gap-3">
            <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-100 text-outline-variant hover:text-secondary hover:bg-surface-container-low transition-all">
                <span class="material-symbols-outlined text-[20px]">share</span>
            </button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-100 text-outline-variant hover:text-red-500 hover:bg-surface-container-low transition-all">
                <span class="material-symbols-outlined text-[20px]">bookmark</span>
            </button>
        </div>
    </div>
</header>
