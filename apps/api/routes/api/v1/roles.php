<?php

use App\Http\Controllers\Api\V1\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('permission:roles.view')
        ->get('/roles', [RoleController::class, 'index']);

    Route::middleware('permission:roles.view')
        ->get('/roles/{id}', [RoleController::class, 'show']);

    Route::middleware('permission:roles.create')
        ->post('/roles', [RoleController::class, 'store']);

    Route::middleware('permission:roles.update')
        ->put('/roles/{id}', [RoleController::class, 'update']);

    Route::middleware('permission:roles.delete')
        ->delete('/roles/{id}', [RoleController::class, 'destroy']);

    Route::middleware('permission:roles.update')
        ->put('/roles/{id}/permissions', [RoleController::class, 'syncPermissions']);
});
