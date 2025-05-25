<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');

Route::prefix('favorite')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [FavoriteController::class, 'show'])->name('favorite.show');
    Route::post('/', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/', [FavoriteController::class, 'delete'])->name('favorite.destroy');
});
