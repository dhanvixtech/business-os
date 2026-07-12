<?php

use Illuminate\Support\Facades\Route;
use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(RestrictedDocsAccess::class)
    ->group(function () {

        // Scramble routes

    });
