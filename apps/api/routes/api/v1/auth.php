<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    // Route::post('/register', []);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me']);
});
