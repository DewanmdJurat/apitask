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

    Route::apiResource('articles', \App\Http\Controllers\ArticleController::class);

});
