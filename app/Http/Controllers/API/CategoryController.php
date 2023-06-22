<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        try {
            $categories = \App\Models\Article::whereHas('category', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
                ->where('published_at', '<=', now())
                ->where('status', 'Published')
                ->with(['user', 'category'])
                ->latest()
                ->paginate();

            return CategoryResource::collection($categories);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
