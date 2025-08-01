<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [\App\Http\Controllers\Auth\AuthorizationController::class,'login']);


Route::get('/users', function () {
    return \App\Models\User::get();
})->middleware('auth:sanctum');
