<?php

namespace App\Services;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Service untuk mengelola logika bisnis Artikel.
 * Mendukung block-based JSON content dari Medium-style editor.
 */
class ArticleService
{
    /**
     * Membuat artikel baru.
     */
    public function createArticle(array $data, User $author): Article
    {
        return DB::transaction(function () use ($data, $author) {
            $data['user_id'] = $author->id;
            $data['slug'] = $this->generateUniqueSlug($data['title']);

            if (isset($data['status']) && $data['status'] === 'published') {
                $data['published_at'] = now();
            }

            // Handle cover/thumbnail upload
            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                $data['thumbnail'] = $data['thumbnail']->store('articles', 'public');
            }

            return Article::create($data);
        });
    }

    /**
     * Memperbarui artikel yang ada.
     */
    public function updateArticle(Article $article, array $data): Article
    {
        return DB::transaction(function () use ($article, $data) {
            if (isset($data['title'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $article->id);
            }

            if (isset($data['status']) && $data['status'] === 'published' && ! $article->published_at) {
                $data['published_at'] = now();
            }

            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                if ($article->thumbnail) {
                    Storage::disk('public')->delete($article->thumbnail);
                }
                $data['thumbnail'] = $data['thumbnail']->store('articles', 'public');
            }

            $article->update($data);

            return $article;
        });
    }

    /**
     * Menghapus artikel.
     */
    public function deleteArticle(Article $article): bool
    {
        return DB::transaction(function () use ($article) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            return $article->delete();
        });
    }

    /**
     * Menyiapkan query artikel berdasarkan filter.
     */
    public function getFilteredArticles(array $filters)
    {
        $query = Article::with(['user', 'category']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $searchTerm = '%'.strtolower($search).'%';
                $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(content) LIKE ?', [$searchTerm])
                    ->orWhereHas('category', function ($catQuery) use ($searchTerm) {
                        $catQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
                    })
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
                    });
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        $sort = $filters['sort'] ?? 'latest';
        $query->orderBy('created_at', $sort === 'oldest' ? 'asc' : 'desc');

        return $query;
    }

    /**
     * Render block-based JSON content ke HTML untuk tampilan publik.
     * Handles all block types: paragraph, h1, h2, h3, quote, callout,
     * bullet, numbered, image, video, divider.
     */
    public static function renderContent(string $content): string
    {
        if (empty(trim($content))) {
            return '<p class="text-slate-400 italic">Konten artikel belum tersedia.</p>';
        }

        try {
            $blocks = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($blocks) || empty($blocks)) {
                throw new \Exception('Not a valid block array');
            }
        } catch (\Throwable $e) {
            return '<p class="article-paragraph">'.nl2br(e($content)).'</p>';
        }

        $html = '';
        $len = count($blocks);

        for ($i = 0; $i < $len; $i++) {
            $block = $blocks[$i];
            $type = $block['type'] ?? 'paragraph';
            $blockContent = $block['content'] ?? '';

            // Bersihkan inline style, class, dan id dari HTML untuk mencegah polusi layout (misal copy-paste dari Google Docs)
            if (is_string($blockContent)) {
                $blockContent = preg_replace('/\s*(style|class|id)\s*=\s*("|\')(.*?)\2/i', '', $blockContent);
            }

            switch ($type) {
                case 'paragraph':
                    if (trim(strip_tags($blockContent)) === '' || $blockContent === '<br>') {
                        break;
                    }
                    $html .= '<p class="article-paragraph">'.$blockContent.'</p>';
                    break;

                case 'h1':
                    if (trim(strip_tags($blockContent)) === '') {
                        break;
                    }
                    $html .= '<h2 class="article-h1">'.$blockContent.'</h2>';
                    break;

                case 'h2':
                    if (trim(strip_tags($blockContent)) === '') {
                        break;
                    }
                    $html .= '<h3 class="article-h2">'.$blockContent.'</h3>';
                    break;

                case 'h3':
                    if (trim(strip_tags($blockContent)) === '') {
                        break;
                    }
                    $html .= '<h4 class="article-h3">'.$blockContent.'</h4>';
                    break;

                case 'quote':
                    if (trim(strip_tags($blockContent)) === '') {
                        break;
                    }
                    $html .= '<blockquote class="article-quote"><p>'.$blockContent.'</p></blockquote>';
                    break;

                case 'callout':
                    if (trim(strip_tags($blockContent)) === '') {
                        break;
                    }
                    $html .= '<div class="article-callout"><span class="article-callout-icon">💡</span><div>'.$blockContent.'</div></div>';
                    break;

                case 'bullet':
                    $items = [];
                    while ($i < $len && ($blocks[$i]['type'] ?? '') === 'bullet') {
                        $itemContent = $blocks[$i]['content'] ?? '';
                        if (trim(strip_tags($itemContent)) !== '') {
                            $items[] = preg_replace('/\s*(style|class|id)\s*=\s*("|\')(.*?)\2/i', '', $itemContent);
                        }
                        $i++;
                    }
                    $i--;

                    if (! empty($items)) {
                        $html .= '<ul class="article-list article-list--bulleted">';
                        foreach ($items as $item) {
                            $html .= '<li>'.$item.'</li>';
                        }
                        $html .= '</ul>';
                    }
                    break;

                case 'numbered':
                    $items = [];
                    while ($i < $len && ($blocks[$i]['type'] ?? '') === 'numbered') {
                        $itemContent = $blocks[$i]['content'] ?? '';
                        if (trim(strip_tags($itemContent)) !== '') {
                            $items[] = preg_replace('/\s*(style|class|id)\s*=\s*("|\')(.*?)\2/i', '', $itemContent);
                        }
                        $i++;
                    }
                    $i--;

                    if (! empty($items)) {
                        $html .= '<ol class="article-list article-list--numbered">';
                        foreach ($items as $item) {
                            $html .= '<li>'.$item.'</li>';
                        }
                        $html .= '</ol>';
                    }
                    break;

                case 'image':
                    $src = $block['src'] ?? '';
                    if (! $src || str_starts_with($src, 'data:')) {
                        break;
                    }
                    $caption = e($block['caption'] ?? '');
                    $html .= '<figure class="article-figure">';
                    $html .= '<img src="'.e($src).'" alt="'.$caption.'" class="article-image" loading="lazy">';
                    if ($caption) {
                        $html .= '<figcaption class="article-caption">'.$caption.'</figcaption>';
                    }
                    $html .= '</figure>';
                    break;

                case 'video':
                    $src = $block['embedSrc'] ?? $block['src'] ?? '';
                    if (! $src) {
                        break;
                    }
                    if (str_contains($src, 'youtube.com/embed') || str_contains($src, 'drive.google.com')) {
                        $html .= '<div class="article-video"><iframe src="'.e($src).'" allowfullscreen frameborder="0" class="w-full h-full"></iframe></div>';
                        if (str_contains($src, 'youtube.com/embed')) {
                            preg_match('/youtube\.com\/embed\/([^?&\s]+)/', $src, $matches);
                            if (!empty($matches[1])) {
                                $videoId = $matches[1];
                                $html .= '<p class="article-caption" style="margin-top:-2rem; margin-bottom:2.5rem; text-align:center;">Video tidak tampil? <a href="https://www.youtube.com/watch?v='.$videoId.'" target="_blank" class="text-indigo-600 hover:underline font-bold inline-flex items-center gap-1" style="color:#4f46e5;">Tonton langsung di YouTube <span class="material-symbols-outlined text-[14px]">open_in_new</span></a></p>';
                            }
                        }
                    } else {
                        $html .= '<video controls class="w-full rounded-xl my-6"><source src="'.e($src).'"></video>';
                    }
                    break;

                case 'divider':
                    $html .= '<hr class="article-divider">';
                    break;
            }
        }

        return $html ?: '<p class="text-slate-400 italic">Konten artikel belum tersedia.</p>';
    }

    /**
     * Extract plain text excerpt from block content (for previews/SEO).
     */
    public static function getExcerpt(string $content, int $length = 160): string
    {
        try {
            $blocks = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            if (is_array($blocks)) {
                $text = '';
                $textTypes = ['paragraph', 'h1', 'h2', 'h3', 'quote', 'callout', 'bullet', 'numbered'];
                foreach ($blocks as $block) {
                    if (in_array($block['type'] ?? '', $textTypes)) {
                        $text .= strip_tags($block['content'] ?? '').' ';
                    }
                }

                return Str::limit(trim($text), $length);
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return Str::limit(strip_tags($content), $length);
    }

    /**
     * Generate unique slug.
     */
    protected function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $base = $slug;
        $i = 1;

        while (true) {
            $query = Article::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (! $query->exists()) {
                break;
            }
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
