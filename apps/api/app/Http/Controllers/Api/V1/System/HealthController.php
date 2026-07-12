<?php

namespace App\Http\Controllers\Api\V1\System;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\JsonResponse;

class HealthController extends BaseController
{
    public function __invoke(): JsonResponse
    {
        return $this->success(
            data: [
                'application' => config('app.name'),
                'version' => config('app.version'),
                'environment' => app()->environment(),
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'timestamp' => now()->toIso8601String(),
            ],
            message: 'Application is healthy.'
        );
    }
}
