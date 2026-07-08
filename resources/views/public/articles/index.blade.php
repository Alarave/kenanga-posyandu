@extends('layouts.public-layout')

@section('title', 'Artikel Kesehatan - Posyandu Kenanga Bekasi Timur')

@section('content')

<style>
    /* ── ARTICLES INDEX PAGE ── */
    .articles-page {
        max-width: 1280px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    @media (min-width: 768px) {
        .articles-page { padding: 64px 48px 96px; }
    }

    /* ── FEATURED HERO ── */
    .featured-hero {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        align-items: center;
        margin-bottom: 72px;
        padding-bottom: 72px;
        border-bottom: 1px solid #f1f5f9;
    }

    @media (min-width: 1024px) {
        .featured-hero {
            grid-template-columns: 1fr 480px;
            gap: 64px;
        }
    }

    .featured-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 999px;
        background: #eef2ff;
        border: 1px solid #e0e7ff;
        color: #4f46e5;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .featured-title {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin: 0 0 20px;
    }

    .featured-excerpt {
        font-size: 16px;
        color: #64748b;
        line-height: 1.75;
        margin: 0 0 32px;
        max-width: 540px;
    }

    .featured-actions {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
    }

    .btn-featured-read {
        display: inline-flex;
        align-items: center;
        height: 52px;
        padding: 0 32px;
        background: #0f172a;
        color: #fff;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        text-decoration: none;
        transition: background 300ms, transform 200ms;
        white-space: nowrap;
    }

    .btn-featured-read:hover {
        background: #4f46e5;
        transform: translateY(-2px);
    }

    .featured-meta {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .featured-img-wrap {
        position: relative;
    }

    .featured-img-glow {
        position: absolute;
        inset: 0;
        background: #4f46e5;
        border-radius: 28px;
        transform: rotate(3deg);
        opacity: 0.08;
        transition: transform 500ms;
    }

    .featured-img-wrap:hover .featured-img-glow {
        transform: rotate(6deg);
    }

    .featured-img-inner {
        position: relative;
        aspect-ratio: 4/3;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 32px 64px -16px rgba(15, 23, 42, 0.18);
        border: 4px solid #fff;
    }

    .featured-img-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 3s ease;
    }

    .featured-img-wrap:hover .featured-img-inner img {
        transform: scale(1.06);
    }

    /* ── MAIN LAYOUT ── */
    .articles-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 48px;
        align-items: start;
    }

    @media (min-width: 1024px) {
        .articles-layout {
            grid-template-columns: 1fr 340px;
            gap: 64px;
        }
    }

    /* ── STREAM ── */
    .stream-header {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 40px;
    }

    @media (min-width: 640px) {
        .stream-header {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .stream-title {
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin: 0 0 4px;
    }

    .stream-subtitle {
        font-size: 13px;
        color: #94a3b8;
        font-weight: 500;
        margin: 0;
    }

    .category-pills {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        flex-shrink: 0;
    }

    .category-pills::-webkit-scrollbar { display: none; }

    .pill {
        display: inline-block;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        border: 1px solid transparent;
        white-space: nowrap;
        text-decoration: none;
        transition: all 250ms;
    }

    .pill-active {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .pill-inactive {
        background: #f8fafc;
        color: #64748b;
        border-color: #e2e8f0;
    }

    .pill-inactive:hover {
        background: #eef2ff;
        color: #4f46e5;
        border-color: #c7d2fe;
    }

    /* ── ARTICLE CARDS ── */
    .article-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .article-item {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 28px 0;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        position: relative;
        transition: background 250ms;
    }

    @media (min-width: 640px) {
        .article-item {
            grid-template-columns: 1fr 160px;
            gap: 28px;
            align-items: center;
        }
    }

    .article-item:last-child {
        border-bottom: none;
    }

    .article-item-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .author-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(79, 70, 229, 0.3);
    }

    .author-name {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
    }

    .dot-sep {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: #cbd5e1;
        flex-shrink: 0;
    }

    .cat-badge {
        display: inline-block;
        padding: 3px 10px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        border-radius: 6px;
    }

    .article-item-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
        letter-spacing: -0.02em;
        margin: 0 0 8px;
        transition: color 250ms;
        text-decoration: none;
        display: block;
    }

    .article-item:hover .article-item-title {
        color: #4f46e5;
    }

    .article-item-excerpt {
        font-size: 13px;
        color: #64748b;
        line-height: 1.65;
        margin: 0 0 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .article-item-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .article-item-dates {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .article-item-dates .material-symbols-outlined {
        font-size: 13px;
    }

    .article-item-actions {
        display: flex;
        align-items: center;
        gap: 4px;
        opacity: 0;
        transition: opacity 250ms;
    }

    .article-item:hover .article-item-actions {
        opacity: 1;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 200ms;
    }

    .action-btn:hover {
        background: #eef2ff;
        color: #4f46e5;
    }

    .article-item-thumb {
        width: 100%;
        aspect-ratio: 16/9;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
        flex-shrink: 0;
        order: -1;
    }

    @media (min-width: 640px) {
        .article-item-thumb {
            width: 160px;
            aspect-ratio: 1;
            order: 0;
        }
    }

    .article-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 600ms ease;
    }

    .article-item:hover .article-item-thumb img {
        transform: scale(1.06);
    }

    /* ── EMPTY STATE ── */
    .empty-articles {
        padding: 64px 32px;
        text-align: center;
        background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
        border-radius: 24px;
        border: 1px solid #e2e8f0;
    }

    .empty-articles-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 20px;
        background: #eef2ff;
        color: #4f46e5;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-articles h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px;
    }

    .empty-articles p {
        font-size: 14px;
        color: #64748b;
        margin: 0 auto;
        max-width: 320px;
    }

    /* ── PAGINATION ── */
    .articles-pagination {
        margin-top: 48px;
        padding-top: 40px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .pagination-info {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
        letter-spacing: 0.05em;
    }

    .pagination-info strong {
        color: #1e293b;
        font-weight: 800;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .page-nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 42px;
        padding: 0 18px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #0f172a;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 220ms;
        white-space: nowrap;
    }

    .page-nav-btn:hover {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
        box-shadow: 0 4px 14px rgba(79,70,229,0.25);
        transform: translateY(-1px);
    }

    .page-nav-btn.disabled {
        opacity: 0.35;
        pointer-events: none;
        cursor: default;
    }

    .page-num-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 200ms;
    }

    .page-num-btn:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #4f46e5;
    }

    .page-num-btn.current {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
        font-weight: 900;
        box-shadow: 0 4px 14px rgba(79,70,229,0.3);
        pointer-events: none;
    }

    .page-num-btn.dots {
        border: none;
        background: transparent;
        color: #94a3b8;
        pointer-events: none;
        font-size: 16px;
        font-weight: 900;
        letter-spacing: 0.1em;
    }

    /* ── SIDEBAR ── */
    .sidebar {
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
        gap: 48px;
    }

    .sidebar-section-label {
        font-size: 10px;
        font-weight: 900;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.25em;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-label-icon {
        width: 24px;
        height: 24px;
        border-radius: 8px;
        background: #4f46e5;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Search */
    .sidebar-search {
        position: relative;
    }

    .sidebar-search-input {
        width: 100%;
        height: 52px;
        padding: 0 16px 0 48px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        box-sizing: border-box;
        transition: border-color 250ms, box-shadow 250ms;
        outline: none;
    }

    .sidebar-search-input::placeholder { color: #94a3b8; }

    .sidebar-search-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }

    .sidebar-search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 20px;
        pointer-events: none;
        transition: color 250ms;
    }

    .sidebar-search:focus-within .sidebar-search-icon {
        color: #4f46e5;
    }

    /* Popular Articles */
    .popular-list {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .popular-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        text-decoration: none;
        group: true;
    }

    .popular-num {
        font-size: 32px;
        font-weight: 900;
        color: #e2e8f0;
        line-height: 1;
        min-width: 36px;
        transition: color 250ms;
        flex-shrink: 0;
    }

    .popular-item:hover .popular-num { color: #eef2ff; }

    .popular-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
        flex-wrap: wrap;
    }

    .popular-author {
        font-size: 10px;
        font-weight: 900;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .popular-cat {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .popular-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.4;
        transition: color 250ms;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .popular-item:hover .popular-title { color: #4f46e5; }

    /* CTA Bento */
    .sidebar-cta {
        position: relative;
        padding: 36px;
        background: #0f172a;
        border-radius: 28px;
        color: #fff;
        overflow: hidden;
    }

    .sidebar-cta-content {
        position: relative;
        z-index: 2;
    }

    .sidebar-cta h4 {
        font-size: 22px;
        font-weight: 900;
        font-style: italic;
        line-height: 1.25;
        margin: 0 0 12px;
    }

    .sidebar-cta h4 span { color: #818cf8; }

    .sidebar-cta p {
        font-size: 13px;
        color: #94a3b8;
        line-height: 1.6;
        margin: 0 0 24px;
    }

    .btn-cta-sidebar {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 48px;
        width: 100%;
        background: #4f46e5;
        color: #fff;
        border-radius: 14px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        text-decoration: none;
        transition: background 250ms, transform 200ms;
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
    }

    .btn-cta-sidebar:hover {
        background: #4338ca;
        transform: translateY(-2px);
    }

    .sidebar-cta-bg-icon {
        position: absolute;
        right: -24px;
        bottom: -24px;
        font-size: 120px;
        color: rgba(255,255,255,0.04);
        z-index: 1;
    }

    .sidebar-cta-glow {
        position: absolute;
        left: -32px;
        top: -32px;
        width: 120px;
        height: 120px;
        background: rgba(79, 70, 229, 0.15);
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
    }
</style>

<div class="articles-page">

    {{-- ── FEATURED HERO ── --}}
    @if($featured)
    <section class="featured-hero">
        <div>
            <div class="featured-badge">
                <span class="material-symbols-outlined" style="font-size:16px;animation:pulse 2s infinite;">star</span>
                Artikel Terpopuler
            </div>
            <h1 class="featured-title">{{ $featured->title }}</h1>
            <p class="featured-excerpt">{{ \App\Services\ArticleService::getExcerpt($featured->content, 180) }}</p>
            <div class="featured-actions">
                <a href="{{ route('public.articles.show', $featured->slug) }}" class="btn-featured-read">
                    Mulai Membaca
                </a>
                <span class="featured-meta">
                    <span class="material-symbols-outlined" style="font-size:14px;">schedule</span>
                    {{ ceil(str_word_count(\App\Services\ArticleService::getExcerpt($featured->content, 999999)) / 200) }} mnt baca
                </span>
            </div>
        </div>
        <div class="featured-img-wrap">
            <div class="featured-img-glow"></div>
            <div class="featured-img-inner">
                <img src="{{ $featured->thumbnail ? asset('storage/'.$featured->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=1200&auto=format&fit=crop' }}"
                     alt="{{ $featured->title }}"
                     fetchpriority="high" loading="eager" decoding="sync">
            </div>
        </div>
    </section>
    @endif

    {{-- ── MAIN LAYOUT ── --}}
    <div class="articles-layout">

        {{-- ── STREAM ── --}}
        <div>
            <div class="stream-header">
                <div>
                    <h2 class="stream-title">Koleksi Pengetahuan</h2>
                    <p class="stream-subtitle">Edukasi dan tips kesehatan terpercaya dari kader Posyandu</p>
                </div>
                <div class="category-pills">
                    <a href="{{ route('public.articles.index') }}"
                       class="pill {{ !request('category') ? 'pill-active' : 'pill-inactive' }}">Semua</a>
                    @foreach($categories as $cat)
                    <a href="{{ route('public.articles.index', ['category' => $cat->slug]) }}"
                       class="pill {{ request('category') === $cat->slug ? 'pill-active' : 'pill-inactive' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="article-list">
                @forelse($articles as $article)
                @php
                    $authorName = $article->user->name ?? 'Tim Redaksi';
                    $initial = strtoupper(substr($authorName, 0, 1));
                @endphp
                <div class="article-item">
                    <div>
                        <div class="article-item-meta">
                            <div class="author-avatar">{{ $initial }}</div>
                            <span class="author-name">{{ $authorName }}</span>
                            <span class="dot-sep"></span>
                            <span class="cat-badge">{{ $article->category->name ?? 'Umum' }}</span>
                        </div>
                        <a href="{{ route('public.articles.show', $article->slug) }}" class="article-item-title">{{ $article->title }}</a>
                        <p class="article-item-excerpt">{{ \App\Services\ArticleService::getExcerpt($article->content, 160) }}</p>
                        <div class="article-item-footer">
                            <div class="article-item-dates">
                                <span style="display:flex;align-items:center;gap:4px;">
                                    <span class="material-symbols-outlined">calendar_today</span>
                                    {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}
                                </span>
                                <span class="dot-sep"></span>
                                <span style="display:flex;align-items:center;gap:4px;">
                                    <span class="material-symbols-outlined">schedule</span>
                                    {{ ceil(str_word_count(\App\Services\ArticleService::getExcerpt($article->content, 999999)) / 200) }} mnt
                                </span>
                            </div>
                            <div class="article-item-actions">
                                <button class="action-btn" title="Bagikan"><span class="material-symbols-outlined" style="font-size:18px;">share</span></button>
                                <button class="action-btn" title="Simpan"><span class="material-symbols-outlined" style="font-size:18px;">bookmark</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="article-item-thumb">
                        <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=600&auto=format&fit=crop' }}"
                             alt="{{ $article->title }}" loading="lazy" decoding="async">
                    </div>
                </div>
                @empty
                <div class="empty-articles">
                    <div class="empty-articles-icon">
                        <span class="material-symbols-outlined" style="font-size:36px;">description</span>
                    </div>
                    <h3>Belum Ada Cerita Baru</h3>
                    <p>Kami sedang merapikan konten edukasi terbaik untuk Anda. Kembali lagi segera!</p>
                </div>
                @endforelse
            </div>

            @if($articles->hasPages())
            @php
                $current  = $articles->currentPage();
                $last     = $articles->lastPage();
                $from     = $articles->firstItem();
                $to       = $articles->lastItem();
                $total    = $articles->total();
                $window   = 2;
                $pStart   = max(1, $current - $window);
                $pEnd     = min($last, $current + $window);
                $query    = request()->except('page');
                $pageUrl  = fn($p) => $articles->url($p) . (count($query) ? '&' . http_build_query($query) : '');
            @endphp
            <div class="articles-pagination">
                <p class="pagination-info">
                    Menampilkan artikel <strong>{{ $from }}–{{ $to }}</strong> dari <strong>{{ $total }}</strong> artikel
                </p>
                <div class="pagination-controls">
                    {{-- Previous --}}
                    @if($articles->onFirstPage())
                        <span class="page-nav-btn disabled">
                            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $articles->previousPageUrl() }}" class="page-nav-btn">
                            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                            Sebelumnya
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @if($pStart > 1)
                        <a href="{{ $pageUrl(1) }}" class="page-num-btn">1</a>
                        @if($pStart > 2)
                            <span class="page-num-btn dots">···</span>
                        @endif
                    @endif

                    @foreach(range($pStart, $pEnd) as $page)
                        @if($page === $current)
                            <span class="page-num-btn current">{{ $page }}</span>
                        @else
                            <a href="{{ $pageUrl($page) }}" class="page-num-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($pEnd < $last)
                        @if($pEnd < $last - 1)
                            <span class="page-num-btn dots">···</span>
                        @endif
                        <a href="{{ $pageUrl($last) }}" class="page-num-btn">{{ $last }}</a>
                    @endif

                    {{-- Next --}}
                    @if($articles->hasMorePages())
                        <a href="{{ $articles->nextPageUrl() }}" class="page-nav-btn">
                            Selanjutnya
                            <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                        </a>
                    @else
                        <span class="page-nav-btn disabled">
                            Selanjutnya
                            <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                        </span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar">

            {{-- Search --}}
            <div>
                <h4 class="sidebar-section-label">Cari Pengetahuan</h4>
                <form action="{{ route('public.articles.index') }}" method="GET">
                    <div class="sidebar-search">
                        <span class="material-symbols-outlined sidebar-search-icon">search</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Ingin cari apa hari ini?"
                               class="sidebar-search-input">
                    </div>
                </form>
            </div>

            {{-- Popular / Recent --}}
            <div>
                <h4 class="sidebar-section-label">
                    <span class="sidebar-label-icon">
                        <span class="material-symbols-outlined" style="font-size:14px;">new_releases</span>
                    </span>
                    Artikel Terbaru
                </h4>
                <div class="popular-list">
                    @foreach($popularArticles as $index => $pop)
                    <a href="{{ route('public.articles.show', $pop->slug) }}" class="popular-item">
                        <span class="popular-num">0{{ $index + 1 }}</span>
                        <div>
                            <div class="popular-meta">
                                <span class="popular-author">{{ $pop->user->name ?? 'Admin' }}</span>
                                <span class="dot-sep"></span>
                                <span class="popular-cat">{{ $pop->category->name ?? 'Umum' }}</span>
                            </div>
                            <div class="popular-title">{{ $pop->title }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- CTA --}}
            <div class="sidebar-cta">
                <div class="sidebar-cta-glow"></div>
                <div class="sidebar-cta-content">
                    <h4>Butuh Konsultasi <br><span>Pribadi?</span></h4>
                    <p>Hubungi tim medis dan kader kami melalui pesan WhatsApp untuk konsultasi cepat.</p>
                    <a href="{{ route('public.contact') }}" class="btn-cta-sidebar">Hubungi Kader Sekarang</a>
                </div>
                <span class="material-symbols-outlined sidebar-cta-bg-icon">medical_services</span>
            </div>

        </aside>
    </div>
</div>

@endsection
