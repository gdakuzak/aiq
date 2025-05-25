<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);

Route::prefix('favorite')->group(function () {
    Route::get('/{user_id}', [FavoriteController::class, 'show']);
    Route::post('/', [FavoriteController::class, 'store']);
    Route::delete('/', [FavoriteController::class, 'delete']);
});
