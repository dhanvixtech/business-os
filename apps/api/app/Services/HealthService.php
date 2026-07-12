<?php

namespace App\Services;

use App\Actions\Health\GetHealthAction;
use App\DTOs\Responses\HealthDTO;

class HealthService
{
    public function __construct(
        private readonly GetHealthAction $action,
    ) {}

    public function get(): HealthDTO
    {
        return $this->action->execute();
    }
}
