<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/index', [NewsController::class, 'index']);

Route::get('news/{slug}', [NewsController::class, 'show'])
    ->name('news.show');

Route::get('category/{slug}', [NewsController::class, 'category'])
    ->name('news.category');

Route::get('author/{username}', [AuthorController::class, 'show'])
    ->where('username', '^(?!(login|register|logout)$).*')
    ->name('author.show');