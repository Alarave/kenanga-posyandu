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
        $articles = Article::all();
        return response()->json($articles);
    }

    public function store(ArticleRequest $request)
    {
        $article = Article::create($request->validated());
        return response()->json($article, 201);
    }

    public function show(Article $article)
    {
        return response()->json($article);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->validated());
        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['message' => 'Article deleted successfully']);
    }
}
