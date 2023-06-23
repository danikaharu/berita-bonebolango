<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function index()
    {
        try {
            $articles = Article::with('category', 'user', 'tagged')->latest()->paginate();
            return ArticleResource::collection($articles);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Article $article)
    {
        try {
            return new ArticleResource($article);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
