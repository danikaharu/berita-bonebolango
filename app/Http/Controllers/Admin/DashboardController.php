<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index()
    {
        $totalGallery = \App\Models\Album::count();
        $totalTabloid = \App\Models\Tabloid::count();
        $totalArticle = \App\Models\Article::count();
        $totalArticleByCategory = \App\Models\Category::withCount('article')->orderBy('article_count', 'desc')->get();
        $latestArticle = \App\Models\Article::with('user')->limit(2)->latest()->get();


        return view('admin.dashboard', compact('totalGallery', 'totalTabloid', 'totalArticle', 'totalArticleByCategory', 'latestArticle'));
    }
}
