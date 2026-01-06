<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrendingController;

Route::get('/', [TrendingController::class, 'index']);
Route::post('/post', [TrendingController::class, 'store']);
Route::get('/trending/{keyword}', [TrendingController::class, 'show']);
Route::get('/post/{id}', [TrendingController::class, 'postDetail']);
Route::post('/like/{id}', [TrendingController::class, 'like']);
Route::post('/comment/{id}', [TrendingController::class, 'comment']);
Route::get('/search', [TrendingController::class, 'search']);
