<?php

namespace App\Livewire\Admin\Management;

use App\Models\Article;
use App\Services\ArticleService;
use App\Livewire\Shared\BaseAdminComponent;
use Illuminate\View\View;

/**
 * Komponen Manajemen Artikel (OOP & Clean Code).
 * Mengelola daftar artikel, pencarian, dan penghapusan.
 */
class ArticleManagement extends BaseAdminComponent
{
    public string $search = '';
    public string $status = '';
    public string $sort = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sort' => ['except' => 'latest'],
    ];

    /**
     * Render halaman manajemen artikel.
     */
    public function render(ArticleService $service): View
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->status,
            'sort'   => $this->sort,
        ];

        return view('livewire.admin.article-management.index', [
            'articles' => $service->getFilteredArticles($filters)->paginate(10),
        ]);
    }

    /**
     * Hapus artikel dengan autorisasi.
     */
    public function deleteArticle(int $id, ArticleService $service): void
    {
        $article = Article::findOrFail($id);
        $this->authorize('delete', $article);
        
        $service->deleteArticle($article);
        $this->notify('Artikel berhasil dihapus permanen.');
    }
}
