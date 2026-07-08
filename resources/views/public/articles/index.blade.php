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
    .featured-hero-wrap {
        position: relative;
        background: #f8fafc;
        border-radius: 28px;
        overflow: hidden;
        margin-bottom: 72px;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    /* Subtle teal glow accent top-right */
    .featured-hero-wrap::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(13,148,136,0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .featured-hero {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
        align-items: stretch;
    }

    @media (min-width: 1024px) {
        .featured-hero {
            grid-template-columns: 1fr 420px;
        }
    }

    /* Text side */
    .featured-hero-text {
        padding: 52px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    @media (max-width: 1023px) {
        .featured-hero-text { padding: 40px 32px 32px; }
    }

    .featured-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(13,148,136,0.08);
        border: 1px solid rgba(13,148,136,0.2);
        color: #0d9488;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-bottom: 20px;
        width: fit-content;
    }

    .featured-badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #0d9488;
        animation: featured-pulse 2s ease-in-out infinite;
    }

    @keyframes featured-pulse {
        0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(13,148,136,0.5); }
        50% { opacity: 0.5; box-shadow: 0 0 0 5px rgba(13,148,136,0); }
    }

    .featured-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: clamp(1.8rem, 4vw, 3rem);
        font-weight: 900;
        color: #0f172a;
        line-height: 1.12;
        letter-spacing: -0.03em;
        margin: 0 0 16px;
    }

    .featured-excerpt {
        font-family: 'Public Sans', sans-serif;
        font-size: 15px;
        color: #64748b;
        line-height: 1.75;
        margin: 0 0 32px;
    }

    .featured-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn-featured-read {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 48px;
        padding: 0 24px;
        background: linear-gradient(135deg, #0d9488 0%, #006c49 100%);
        color: #fff;
        border-radius: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 300ms cubic-bezier(0.16,1,0.3,1);
        white-space: nowrap;
        box-shadow: 0 4px 16px rgba(13,148,136,0.3);
    }

    .btn-featured-read:hover {
        background: linear-gradient(135deg, #0f766e 0%, #005a3c 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(13,148,136,0.4);
    }

    .featured-meta {
        font-family: 'Public Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Image side */
    .featured-img-wrap {
        position: relative;
        overflow: hidden;
        min-height: 280px;
    }

    @media (min-width: 1024px) {
        .featured-img-wrap {
            border-radius: 0 28px 28px 0;
        }
    }

    @media (max-width: 1023px) {
        .featured-img-wrap {
            border-radius: 0 0 28px 28px;
            min-height: 240px;
        }
    }

    .featured-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 3s ease;
        position: absolute;
        inset: 0;
    }

    .featured-img-wrap:hover img {
        transform: scale(1.05);
    }

    /* Gradient overlay on image */
    .featured-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(248,250,252,0.15) 0%, rgba(248,250,252,0) 100%);
        z-index: 1;
        pointer-events: none;
    }

    /* Floating label on image */
    .featured-img-label {
        position: absolute;
        bottom: 16px;
        left: 16px;
        right: 16px;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(12px);
        border-radius: 14px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid rgba(15,23,42,0.08);
        box-shadow: 0 4px 16px rgba(15,23,42,0.08);
        z-index: 2;
    }

    .featured-img-label-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, #0d9488 0%, #006c49 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #fff;
    }

    .featured-img-label-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .featured-img-label-sub {
        font-family: 'Public Sans', sans-serif;
        font-size: 10px;
        color: #0d9488;
        font-weight: 700;
        margin-top: 2px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
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

    /* ── STREAM HEADER ── */
    .stream-header {
        margin-bottom: 40px;
    }

    .stream-header-top {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 28px;
    }

    .stream-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 900;
        color: #0d9488;
        text-transform: uppercase;
        letter-spacing: 0.2em;
    }

    .stream-eyebrow-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #0d9488;
        animation: blink-dot 2s ease-in-out infinite;
    }

    @keyframes blink-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.7); }
    }

    .stream-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: clamp(26px, 4vw, 36px);
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.03em;
        line-height: 1.1;
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .stream-title-accent {
        color: #0d9488;
        position: relative;
    }

    /* Underline stroke signature element */
    .stream-title-accent::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -3px;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #0d9488, #5eead4);
        border-radius: 2px;
    }

    .stream-subtitle {
        font-family: 'Public Sans', sans-serif;
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        margin: 10px 0 0;
        line-height: 1.5;
    }

    /* Category filter band */
    .category-filter-band {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px;
        background: #f8fafc;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        overflow-x: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
        width: fit-content;
        max-width: 100%;
    }

    .category-filter-band::-webkit-scrollbar { display: none; }

    .filter-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 38px;
        padding: 0 16px;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        white-space: nowrap;
        text-decoration: none;
        transition: all 220ms cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
        position: relative;
    }

    .filter-tab-active {
        background: linear-gradient(135deg, #0d9488 0%, #006c49 100%);
        color: #fff;
        box-shadow: 0 4px 16px rgba(13,148,136,0.3);
    }

    .filter-tab-inactive {
        background: transparent;
        color: #64748b;
    }

    .filter-tab-inactive:hover {
        background: #fff;
        color: #0d9488;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
    }

    .filter-tab-icon {
        font-size: 14px;
        line-height: 1;
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
        background: linear-gradient(135deg, #0d9488, #006c49);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(13,148,136,0.3);
    }

    .author-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
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
        background: rgba(13,148,136,0.08);
        color: #0d9488;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        border-radius: 6px;
    }

    .article-item-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
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
        color: #0d9488;
    }

    .article-item-excerpt {
        font-family: 'Public Sans', sans-serif;
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
        background: rgba(13,148,136,0.08);
        color: #0d9488;
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
        background: rgba(13,148,136,0.08);
        color: #0d9488;
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
        background: linear-gradient(135deg, #0d9488 0%, #006c49 100%);
        border-color: #0d9488;
        color: #fff;
        box-shadow: 0 4px 14px rgba(13,148,136,0.25);
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
        background: rgba(13,148,136,0.08);
        border-color: rgba(13,148,136,0.3);
        color: #0d9488;
    }

    .page-num-btn.current {
        background: linear-gradient(135deg, #0d9488 0%, #006c49 100%);
        border-color: #0d9488;
        color: #fff;
        font-weight: 900;
        box-shadow: 0 4px 14px rgba(13,148,136,0.3);
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
        background: linear-gradient(135deg, #0d9488 0%, #006c49 100%);
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
        border-color: #0d9488;
        box-shadow: 0 0 0 4px rgba(13,148,136,0.08);
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
        color: #0d9488;
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

    .popular-item:hover .popular-title { color: #0d9488; }

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

    .sidebar-cta h4 span { color: #5eead4; }

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
        background: linear-gradient(135deg, #0d9488 0%, #006c49 100%);
        color: #fff;
        border-radius: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 250ms cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 8px 24px rgba(13,148,136,0.3);
    }

    .btn-cta-sidebar:hover {
        background: linear-gradient(135deg, #0f766e 0%, #005a3c 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(13,148,136,0.4);
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
        background: rgba(13,148,136,0.2);
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
    }
</style>

<div class="articles-page">

    {{-- ── FEATURED HERO ── --}}
    @if($featured)
    <div class="featured-hero-wrap">
        <div class="featured-hero">
            <div class="featured-hero-text">
                <div class="featured-badge">
                    <span class="featured-badge-dot"></span>
                    Artikel Terpopuler
                </div>
                <h1 class="featured-title">{{ $featured->title }}</h1>
                <p class="featured-excerpt">{{ \App\Services\ArticleService::getExcerpt($featured->content, 180) }}</p>
                <div class="featured-actions">
                    <a href="{{ route('public.articles.show', $featured->slug) }}" class="btn-featured-read">
                        Mulai Membaca
                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                    </a>
                    <span class="featured-meta">
                        <span class="material-symbols-outlined" style="font-size:14px;">schedule</span>
                        {{ ceil(str_word_count(\App\Services\ArticleService::getExcerpt($featured->content, 999999)) / 200) }} mnt baca
                    </span>
                </div>
            </div>
            <div class="featured-img-wrap">
                <div class="featured-img-overlay"></div>
                <img src="{{ $featured->thumbnail ? asset('storage/'.$featured->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=1200&auto=format&fit=crop' }}"
                     alt="{{ $featured->title }}"
                     fetchpriority="high" loading="eager" decoding="sync">
                <div class="featured-img-label">
                    <div class="featured-img-label-icon">
                        <span class="material-symbols-outlined" style="font-size:18px;">auto_stories</span>
                    </div>
                    <div>
                        <div class="featured-img-label-text">{{ $featured->title }}</div>
                        <div class="featured-img-label-sub">{{ $featured->category->name ?? 'Artikel Pilihan' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── MAIN LAYOUT ── --}}
    <div class="articles-layout">

        {{-- ── STREAM ── --}}
        <div>
            <div class="stream-header">
                <div class="stream-header-top">
                    <span class="stream-eyebrow">
                        <span class="stream-eyebrow-dot"></span>
                        Edisi Terkini
                    </span>
                    <h2 class="stream-title">Koleksi <span class="stream-title-accent">Pengetahuan</span></h2>
                    <p class="stream-subtitle">Edukasi dan tips kesehatan terpercaya dari kader Posyandu Kenanga</p>
                </div>
                <div class="category-filter-band">
                    <a href="{{ route('public.articles.index') }}"
                       class="filter-tab {{ !request('category') ? 'filter-tab-active' : 'filter-tab-inactive' }}">
                        <span class="material-symbols-outlined filter-tab-icon">grid_view</span>
                        Semua
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('public.articles.index', ['category' => $cat->slug]) }}"
                       class="filter-tab {{ request('category') === $cat->slug ? 'filter-tab-active' : 'filter-tab-inactive' }}">
                        {{ $cat->name }}
                    </a>
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
