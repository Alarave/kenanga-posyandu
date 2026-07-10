<?php

namespace App\Models;

use App\Services\ArticleService;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'content', 'content_blocks', 'thumbnail', 'slug', 'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'content_blocks' => 'array',
    ];

    protected $appends = [
        'thumbnail_url',
    ];

    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->thumbnail)) {
            return null;
        }

        return Storage::disk(config('filesystems.cloud', 'public'))->url($this->thumbnail);
    }

    protected static function booted()
    {
        static::saved(function ($article) {
            Cache::forget('public_categories_count');
            Cache::forget('popular_articles');
            Cache::forget('featured_article');
            Cache::forget('article_show_'.$article->slug);
            Cache::forever('public_articles_cache_version', time());
        });

        static::deleted(function ($article) {
            Cache::forget('public_categories_count');
            Cache::forget('popular_articles');
            Cache::forget('featured_article');
            Cache::forget('article_show_'.$article->slug);
            Cache::forever('public_articles_cache_version', time());
        });
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Cache untuk plaintext konten artikel agar menghindari redundant JSON parsing.
     */
    protected ?string $plainTextCache = null;

    /**
     * Dapatkan plaintext lengkap dari konten artikel (block-based JSON).
     */
    public function getPlainText(): string
    {
        if ($this->plainTextCache === null) {
            $this->plainTextCache = ArticleService::getExcerpt($this->content ?? '', 999999);
        }

        return $this->plainTextCache;
    }

    /**
     * Hitung waktu baca artikel (perkiraan membaca per menit)
     * Rata-rata 200 kata per menit untuk pembaca dalam bahasa Indonesia
     */
    public function getReadingTimeAttribute(): string
    {
        $text = $this->getPlainText();
        $wordCount = str_word_count($text);
        $readingTime = max(1, (int) ceil($wordCount / 200));

        return $readingTime.' menit';
    }

    /**
     * Dapatkan excerpt dari konten artikel
     */
    public function getExcerptAttribute(): string
    {
        $text = $this->getPlainText();
        $limited = Str::limit($text, 160);

        return $limited ?: 'Tidak ada ringkasan tersedia.';
    }

    /**
     * Scope a query to apply standard filters.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $searchTerm = '%'.strtolower($search).'%';
                $sub->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(content) LIKE ?', [$searchTerm])
                    ->orWhereHas('category', function ($catQuery) use ($searchTerm) {
                        $catQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
                    })
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
                    });
            });
        });

        $query->when($filters['status'] ?? false, function ($q, $status) {
            if ($status !== 'all') {
                $q->where('status', $status);
            }
        });

        $query->when($filters['category'] ?? false, function ($q, $category) {
            $q->whereHas('category', fn ($q) => $q->where('slug', $category));
        });

        $sort = $filters['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->oldest('published_at');
        } else {
            $query->latest('published_at');
        }

        return $query;
    }

    /**
     * Parse YouTube URL to get clean embed URL.
     */
    public static function getYoutubeEmbedUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        $shortsPattern = '/youtube\.com\/shorts\/([^"&?\/ ]{11})/i';
        if (preg_match($shortsPattern, $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return null;
    }

    /**
     * Parse Google Drive URL to get clean preview/embed URL.
     */
    public static function getGoogleDriveEmbedUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $pattern = '/\/file\/d\/([a-zA-Z0-9_-]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return 'https://drive.google.com/file/d/'.$matches[1].'/preview';
        }

        return null;
    }
}
