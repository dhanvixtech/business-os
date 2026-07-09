<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    require base_path('routes/api/v1/health.php');
    require base_path('routes/api/v1/auth.php');
    require base_path('routes/api/v1/users.php');
});
