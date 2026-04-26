<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleApiController extends Controller
{
    public function index()
    {
        $articles = Article::latest('published_at')->get();
        return response()->json($articles);
    }

    public function store(ArticleRequest $request, \App\Services\ArticleService $articleService)
    {
        $article = $articleService->createArticle($request->validated(), auth()->id());
        return response()->json($article, 201);
    }

    public function show(Article $article)
    {
        return response()->json($article);
    }

    public function update(ArticleRequest $request, Article $article, \App\Services\ArticleService $articleService)
    {
        $articleService->updateArticle($article, $request->validated());
        return response()->json($article);
    }

    public function destroy(Article $article, \App\Services\ArticleService $articleService)
    {
        $articleService->deleteArticle($article);
        return response()->json(['message' => 'Article deleted successfully']);
    }
}
