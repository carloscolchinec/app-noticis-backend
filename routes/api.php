<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/Route::post('/posts/create', [PostController::class, 'store'])->name('posts.store');


Route::prefix('v1')->group(function () {
    Route::get('/posts', [PostController::class, 'index_api']);
    Route::post('/posts/{id}/like', [PostController::class, 'like_api']);
    Route::delete('/posts/{id}/like', [PostController::class, 'dislike_api']);    
    Route::get('/posts/{id}', [PostController::class, 'show_api']);
    Route::post('posts/{postId}/comments', [CommentController::class, 'store']);
    // Route::post('/posts', [PostController::class, 'store']);
    // Route::put('/posts/{id}', [PostController::class, 'update']);
    // Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});
