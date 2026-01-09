<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrendingController;

Route::get('/', [TrendingController::class, 'index'])->name('home');

/* CREATE POST */
Route::get('/post/create', [TrendingController::class, 'create'])->name('post.create');
Route::post('/post', [TrendingController::class, 'store'])->name('post.store');

/* POST DETAIL */
Route::get('/post/{id}', [TrendingController::class, 'postDetail'])->name('post.show');

/* DELETE POST */
Route::delete('/post/{id}', [TrendingController::class, 'destroy'])->name('post.delete');

/* LIKE & COMMENT */
Route::post('/like/{id}', [TrendingController::class, 'like'])->name('post.like');
Route::post('/comment/{id}', [TrendingController::class, 'comment'])->name('post.comment');

/* TRENDING & SEARCH */
Route::get('/trending/{keyword}', [TrendingController::class, 'show'])->name('trending.show');
Route::get('/search', [TrendingController::class, 'search'])->name('search');
