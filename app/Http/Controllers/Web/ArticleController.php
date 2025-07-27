<?php

namespace App\Http\Controllers\Web;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('admin.article-management.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.article-management.create');
    }

    public function store(ArticleRequest $request)
    {
        Article::create($request->validated());
        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return view('admin.article-management.details', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('admin.article-management.update', compact('article'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->validated());
        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
