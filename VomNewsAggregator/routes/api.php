<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/articles', [ArticleController::class, 'getAllArticles'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'getSingleArticle'])->name('articles.show');
Route::get('/featured', [ArticleController::class, 'getFeaturedArticles'])->name('articles.featured');
