<?php

namespace App\Livewire\Admin\Management;

use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use App\Livewire\Shared\BaseAdminComponent;
use Livewire\WithFileUploads;
use Illuminate\View\View;

/**
 * Komponen untuk membuat artikel baru (OOP & Clean Code).
 */
class ArticleCreate extends BaseAdminComponent
{
    use WithFileUploads;

    public string $title = '';
    public string $content = '';
    public string $status = 'draft';
    public ?int $category_id = null;
    public $thumbnail;

    /**
     * Aturan validasi.
     */
    protected function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'status'      => 'required|in:published,draft',
            'category_id' => 'required|exists:categories,id',
            'thumbnail'   => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    /**
     * Simpan artikel baru.
     */
    public function save(ArticleService $service)
    {
        $this->authorize('create', Article::class);
        $validated = $this->validate();

        $service->createArticle($validated, auth()->user());

        $this->notify('Artikel baru berhasil diterbitkan.');
        return redirect()->route('admin.articles.index');
    }

    /**
     * Render view.
     */
    public function render(): View
    {
        return view('livewire.admin.article-management.create', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }
}
