<div class="min-h-screen bg-[#f8f8f7]">
<style>
/* ─── Block Content Styles ─── */

.article-content p, 
.article-content span, 
.article-content li {
    text-align: justify;
}

/* GAMBAR: responsif, tidak fixed size */
.article-content .article-figure {
    margin: 2.5rem 0;
    width: 100%;
}
.article-content .article-image {
    width: 100%;
    height: auto;
    max-width: 100%;
    border-radius: 1.5rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    object-fit: cover;
    display: block;
}

/* HEADINGS */
.article-content .article-h1 {
    font-family: 'Georgia', serif;
    font-size: 2rem;
    font-weight: 900;
    color: #0f172a;
    margin: 2.5rem 0 0.75rem;
    line-height: 1.25;
}
.article-content .article-h2 {
    font-family: 'Georgia', serif;
    font-size: 1.5rem;
    font-weight: 900;
    color: #0f172a;
    margin: 2rem 0 0.5rem;
    line-height: 1.35;
}
.article-content .article-h3 {
    font-family: 'Georgia', serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 1.75rem 0 0.5rem;
    line-height: 1.4;
}

/* QUOTE */
.article-content .article-quote {
    border-left: 4px solid #0f172a;
    margin: 2rem 0;
    padding: 0.5rem 0 0.5rem 1.5rem;
}
.article-content .article-quote p {
    font-family: 'Georgia', serif;
    font-size: 1.2rem;
    font-style: italic;
    color: #475569;
    line-height: 1.9;
    margin: 0;
}

/* CALLOUT */
.article-content .article-callout {
    display: flex;
    gap: 0.75rem;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    margin: 1.5rem 0;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #78350f;
}
.article-content .article-callout-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
    margin-top: 0.1rem;
}

/* LISTS — merge adjacent items visually */
.article-content .article-list {
    padding-left: 1.5rem;
    margin: 0.25rem 0;
    font-family: 'Georgia', serif;
    font-size: 1.15rem;
    line-height: 1.9;
    color: #374151;
}
.article-content .article-list + .article-list {
    margin-top: -0.5rem;
}
.article-content .article-list--numbered {
    list-style-type: decimal !important;
    padding-left: 1.5rem !important;
}
.article-content .article-list--bulleted {
    list-style-type: disc !important;
    padding-left: 3rem !important;
}
.article-content .article-list li::marker {
    color: #0f172a;
}
.article-content .article-list li:has(strong)::marker,
.article-content .article-list li:has(b)::marker {
    font-weight: 800;
}

/* PARAGRAPH */
.article-content .article-paragraph {
    font-family: 'Georgia', 'Times New Roman', serif;
    font-size: 1.25rem;
    line-height: 1.9;
    color: #374151;
    margin-bottom: 1.75rem;
    text-align: justify;
}

/* VIDEO */
.article-content .article-video {
    position: relative;
    margin: 3rem 0;
    border-radius: 1.5rem;
    overflow: hidden;
    aspect-ratio: 16/9;
    background: #0f172a;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}

/* DIVIDER */
.article-content .article-divider {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin: 3rem 0;
}

/* CAPTION */
.article-content .article-caption {
    text-align: center;
    margin-top: 0.75rem;
    font-size: 0.8rem;
    color: #94a3b8;
    font-style: italic;
}

/* Inline formatting dari contenteditable */
.article-content strong, .article-content b { font-weight: 800; color: #0f172a; }
.article-content em, .article-content i     { font-style: italic; }
.article-content u                           { text-decoration: underline; }
.article-content s                           { text-decoration: line-through; color: #94a3b8; }
</style>

    {{-- ── Top Nav ── --}}
    <div class="max-w-[860px] mx-auto px-4 md:px-8 pt-2 md:pt-6 flex items-center gap-3">
        <a href="{{ route('admin.articles.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-sm font-bold text-slate-700 transition-all shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
        <div class="flex items-center gap-2 ml-auto">
            @if($article->status === 'published')
            <a href="{{ route('public.articles.show', $article->slug) }}" target="_blank"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-sm font-bold text-slate-700 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                Lihat di Web
            </a>
            @endif
            <a href="{{ route('admin.articles.edit', $article) }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white transition-all hover:bg-slate-800"
            style="background-color: #0f172a;">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                Edit
            </a>
        </div>
    </div>

    {{-- ── Article ── --}}
    <article class="max-w-[860px] mx-auto px-4 md:px-8 py-4 space-y-6 md:space-y-8">

        {{-- Status Badge --}}
        <div class="flex items-center gap-3">
            @if($article->status === 'published')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Dipublikasikan
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-100 text-amber-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Draft
                </span>
            @endif
            @if($article->category)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 border border-indigo-100">
                    {{ $article->category->name }}
                </span>
            @endif
            <span class="text-xs text-slate-400 ml-auto">{{ $article->created_at->diffForHumans() }}</span>
        </div>

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight tracking-tight"
            style="font-family:'Georgia',serif;">
            {{ $article->title }}
        </h1>

        {{-- Author Meta --}}
        <div class="flex items-center gap-4 py-4 border-y border-slate-100">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-black text-sm flex-shrink-0">
                {{ substr($article->user->name ?? 'A', 0, 1) }}
            </div>
            <div>
                <p class="text-sm font-bold text-slate-900">{{ $article->user->name ?? 'Admin' }}</p>
                <p class="text-xs text-slate-400">{{ $article->created_at->translatedFormat('d F Y') }}</p>
            </div>
            <div class="flex items-center gap-4 ml-auto text-xs text-slate-400 font-bold">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    {{ $article->reading_time }}
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">article</span>
                    {{ str_word_count(strip_tags($article->content)) }} kata
                </span>
            </div>
        </div>

        {{-- Cover Image --}}
        @if($article->thumbnail)
            <div class="w-full aspect-video rounded-2xl overflow-hidden shadow-lg">
                <img src="{{ $article->thumbnail_url }}"
                     alt="{{ $article->title }}"
                     class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Body --}}
        <div class="prose prose-lg max-w-none article-content
                    prose-headings:font-black prose-headings:text-slate-900
                    prose-p:text-slate-700 prose-p:leading-relaxed prose-p:text-justify
                    prose-blockquote:border-slate-300 prose-blockquote:text-slate-600">
            {!! App\Services\ArticleService::renderContent($article->content) !!}
        </div>

        {{-- Author Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-black text-xl flex-shrink-0">
                {{ substr($article->user->name ?? 'A', 0, 1) }}
            </div>
            <div>
                <p class="font-black text-slate-900">{{ $article->user->name ?? 'Admin' }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Penulis artikel di Kenanga Posyandu. Berbagi pengetahuan kesehatan dan gizi untuk masyarakat.</p>
            </div>
        </div>

    </article>
</div>