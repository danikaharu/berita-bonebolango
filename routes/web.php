<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ProfileController,
    RoleAndPermissionController
};

// Admin Route
Route::middleware(['auth', 'web'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::get('/profile', ProfileController::class)->name('profile');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleAndPermissionController::class);

    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

    Route::get('/articles/draft', [App\Http\Controllers\Admin\ArticleController::class, 'draft'])->name('articles.draft');
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);

    Route::resource('tabloids', App\Http\Controllers\Admin\TabloidController::class);

    Route::resource('albums', App\Http\Controllers\Admin\AlbumController::class);
    Route::put('/galleries/update-image/{id}', [App\Http\Controllers\Admin\AlbumController::class, 'updateImage'])->name('update-image');
    Route::delete('/galleries/remove-image/{id}', [App\Http\Controllers\Admin\AlbumController::class, 'removeImage'])->name('remove-image');

    Route::get('/statistic', [App\Http\Controllers\Admin\StatisticController::class, 'index'])->name('statistic');
});

require_once __DIR__ . '/generator.php';

// Home Route
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/berita', [App\Http\Controllers\HomeController::class, 'article'])->name('article');
Route::get('/potret', [App\Http\Controllers\HomeController::class, 'gallery'])->name('gallery');
Route::get('/kategori/{category}', [App\Http\Controllers\HomeController::class, 'detailCategory'])->name('detailCategory');
Route::get('/potret/{album}', [App\Http\Controllers\HomeController::class, 'detailGallery'])->name('detailGallery');
Route::get('/berita/{article}', [App\Http\Controllers\HomeController::class, 'detailArticle'])->name('detailArticle');
Route::get('/majalah/{tabloid}', [App\Http\Controllers\HomeController::class, 'detailTabloid'])->name('detailTabloid');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
