<?php

use App\Livewire\Admin\Management\ArticleUpdate;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('superadmin can access edit article page and see form', function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);

    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    $category = Category::factory()->create([
        'name' => 'Kesehatan Anak',
        'slug' => 'kesehatan-anak',
    ]);

    $article = Article::factory()->create([
        'user_id' => $superadmin->id,
        'category_id' => $category->id,
        'title' => 'Judul Artikel Test',
        'content' => '[{"type":"paragraph","content":"Ini konten artikel"}]',
        'status' => 'draft',
    ]);

    $this->actingAs($superadmin);

    $response = $this->get(route('admin.articles.edit', $article));

    $response->assertStatus(200);
    $response->assertSeeLivewire('admin.management.article-update');
    // Ensure it uses the admin-layout which contains "Edit Artikel" (demarcated as uppercase tracking-widest in template)
    $response->assertSee('Edit Artikel');
});

test('superadmin can update article content', function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);

    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    $category = Category::factory()->create([
        'name' => 'Kesehatan Anak',
        'slug' => 'kesehatan-anak',
    ]);

    $category2 = Category::factory()->create([
        'name' => 'Kesehatan Ibu',
        'slug' => 'kesehatan-ibu',
    ]);

    $article = Article::factory()->create([
        'user_id' => $superadmin->id,
        'category_id' => $category->id,
        'title' => 'Judul Artikel Test',
        'content' => '[{"type":"paragraph","content":"Ini konten artikel"}]',
        'status' => 'draft',
    ]);

    $this->actingAs($superadmin);

    Livewire::test(ArticleUpdate::class, ['article' => $article])
        ->set('title', 'Judul Artikel Diperbarui')
        ->set('content', '[{"type":"paragraph","content":"Konten baru"}]')
        ->set('status', 'published')
        ->set('category_id', $category2->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.articles.index'));

    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'title' => 'Judul Artikel Diperbarui',
        'content' => '[{"type":"paragraph","content":"Konten baru"}]',
        'status' => 'published',
        'category_id' => $category2->id,
    ]);
});
