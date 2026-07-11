<?php

use App\Http\Controllers\Api\V1\PermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('permission:permissions.view')
        ->get('/permissions', [PermissionController::class, 'index']);

    Route::middleware('permission:permissions.view')
        ->get('/permissions/{id}', [PermissionController::class, 'show']);

    Route::middleware('permission:permissions.create')
        ->post('/permissions', [PermissionController::class, 'store']);

    Route::middleware('permission:permissions.update')
        ->put('/permissions/{id}', [PermissionController::class, 'update']);

    Route::middleware('permission:permissions.delete')
        ->delete('/permissions/{id}', [PermissionController::class, 'destroy']);
});
