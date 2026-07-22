<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{news}', [NewsController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category:slug}/news', [CategoryController::class, 'news']);

