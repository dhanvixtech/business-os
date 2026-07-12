<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\HealthResource;
use App\Services\HealthService;

class HealthController extends BaseController
{
    public function __construct(
        private readonly HealthService $service,
    ) {}

    public function __invoke()
    {
        return $this->success(
            data: new HealthResource(
                $this->service->get()
            ),
            message: 'Application is healthy.',
        );
    }
}
