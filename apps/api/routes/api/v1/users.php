<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('permission:users.view')
        ->get('/users', [UserController::class, 'index']);

    Route::middleware('permission:users.view')
        ->get('/users/{id}', [UserController::class, 'show']);

    Route::middleware('permission:users.create')
        ->post('/users', [UserController::class, 'store']);

    Route::middleware('permission:users.update')
        ->put('/users/{id}', [UserController::class, 'update']);

    Route::middleware('permission:users.delete')
        ->delete('/users/{id}', [UserController::class, 'destroy']);

    Route::middleware('permission:users.view')
        ->get('users/{id}/roles', [UserController::class, 'roles']);

    Route::middleware('permission:users.update')
        ->put('users/{id}/roles', [UserController::class, 'syncRoles']);
});
