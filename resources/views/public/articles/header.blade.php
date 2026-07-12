<header class="max-w-4xl mx-auto mb-16">
    <div class="mb-8">
        <span class="inline-block px-4 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest">
            {{ $article->category->name ?? 'Informasi Kesehatan' }}
        </span>
    </div>

    <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight tracking-tight mb-10">
        {{ $article->title }}
    </h1>

    <div class="flex items-center justify-between py-8 border-y border-slate-100">
        <div class="flex items-center gap-5">
            {{-- Author Avatar --}}
            <div class="w-14 h-14 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-black shadow-lg shadow-indigo-200">
                {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h4 class="text-[15px] font-black text-slate-900 tracking-tight">{{ $article->user->name ?? 'Tim Redaksi' }}</h4>
                </div>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-[12px] text-slate-400 font-medium">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</header>
