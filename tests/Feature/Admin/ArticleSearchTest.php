<?php

use App\Livewire\Admin\Management\ArticleManagement;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $this->author1 = User::factory()->create([
        'name' => 'Dr. Arimbi',
        'role' => 'admin',
    ]);

    $this->author2 = User::factory()->create([
        'name' => 'Bidan Siti',
        'role' => 'admin',
    ]);

    $this->category1 = Category::factory()->create([
        'name' => 'Nutrisi & Gizi',
        'slug' => 'nutrisi-gizi',
    ]);

    $this->category2 = Category::factory()->create([
        'name' => 'Kesehatan Ibu',
        'slug' => 'kesehatan-ibu',
    ]);

    // Create target search articles
    $this->article1 = Article::factory()->create([
        'user_id' => $this->author1->id,
        'category_id' => $this->category1->id,
        'title' => 'Menu MPASI Bergizi',
        'description' => 'Panduan lengkap MPASI',
        'content' => '[{"type":"paragraph","content":"Ini isi artikel MPASI"}]',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->article2 = Article::factory()->create([
        'user_id' => $this->author2->id,
        'category_id' => $this->category2->id,
        'title' => 'Kehamilan Sehat',
        'description' => 'Tips selama kehamilan',
        'content' => '[{"type":"paragraph","content":"Kesehatan bunda saat mengandung"}]',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->draftArticle = Article::factory()->create([
        'user_id' => $this->author1->id,
        'category_id' => $this->category1->id,
        'title' => 'Draf Artikel Rahasia',
        'description' => 'Ini draf kesehatan anak',
        'content' => '[{"type":"paragraph","content":"Hanya untuk admin"}]',
        'status' => 'draft',
    ]);
});

test('public search correctly groups queries and filters out drafts', function () {
    // Act: search for "kesehatan"
    // "Kehamilan Sehat" has content containing "Kesehatan bunda saat mengandung"
    // "Draf Artikel Rahasia" has description "Ini draf kesehatan anak"
    // But since "Draf Artikel Rahasia" is a draft, it must NOT show up in public search results!
    $response = $this->get(route('public.articles.index', ['search' => 'kesehatan']));

    $response->assertStatus(200);
    $response->assertSee('Kehamilan Sehat');
    $response->assertDontSee('Draf Artikel Rahasia');
});

test('admin search filters by title, content, description, category, or author name', function () {
    $this->actingAs($this->author1);

    // Search by title
    Livewire::test(ArticleManagement::class)
        ->set('search', 'MPASI')
        ->assertSee('Menu MPASI Bergizi')
        ->assertDontSee('Kehamilan Sehat');

    // Search by description
    Livewire::test(ArticleManagement::class)
        ->set('search', 'Panduan lengkap')
        ->assertSee('Menu MPASI Bergizi')
        ->assertDontSee('Kehamilan Sehat');

    // Search by category name
    Livewire::test(ArticleManagement::class)
        ->set('search', 'Kesehatan Ibu')
        ->assertSee('Kehamilan Sehat')
        ->assertDontSee('Menu MPASI Bergizi');

    // Search by author/user name
    Livewire::test(ArticleManagement::class)
        ->set('search', 'Siti')
        ->assertSee('Kehamilan Sehat')
        ->assertDontSee('Menu MPASI Bergizi');
});
