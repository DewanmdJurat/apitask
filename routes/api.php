<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [\App\Http\Controllers\Auth\AuthorizationController::class,'Register']);
Route::post('/login', [\App\Http\Controllers\Auth\AuthorizationController::class,'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthorizationController::class,'logout']);
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile']);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->middleware('can:admin-only');
    Route::post('/users/{id}/assign-role', [\App\Http\Controllers\UserController::class, 'assignRole'])->middleware('can:admin-only');

    Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index'])->middleware('permission:view-published');
    Route::get('/articles/mine', [\App\Http\Controllers\ArticleController::class, 'mine'])->middleware('permission:view-own-articles');
    Route::post('/articles', [\App\Http\Controllers\ArticleController::class, 'store'])->middleware('permission:create-article');
    Route::put('/articles/{article}', [\App\Http\Controllers\ArticleController::class, 'update'])->middleware('permission:edit-own-article');
    Route::delete('/articles/{article}', [\App\Http\Controllers\ArticleController::class, 'destroy'])->middleware('permission:delete-article');
    Route::patch('/articles/{article}/publish', [\App\Http\Controllers\ArticleController::class, 'publish'])->middleware('permission:publish-article');

});
