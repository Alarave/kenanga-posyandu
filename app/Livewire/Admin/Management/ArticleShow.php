<?php

namespace App\Livewire\Admin\Management;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\Article;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use App\Services\ArticleService;

/**
 * Komponen untuk melihat detail artikel (OOP & Clean Code).
 */
#[Layout('layouts.admin-layout')]
class ArticleShow extends BaseAdminComponent
{
    public Article $article;

    /**
     * Inisialisasi data.
     */
    public function mount(Article $article): void
    {
        $this->article = $article->load(['user', 'category']);
    }

    /**
     * Render view.
     */
    public function render(): View
    {
        return view('livewire.admin.article-management.details');
    }

        public function deleteArticle(ArticleService $service): void
    {
        $this->authorize('delete', $this->article);
        $service->deleteArticle($this->article);
        $this->notify('Artikel berhasil dihapus.', 'success', true);
        redirect()->route('admin.articles.index');
    }
}
