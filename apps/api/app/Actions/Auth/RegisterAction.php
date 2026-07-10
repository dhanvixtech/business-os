<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\RegisterDTO;
use App\Services\AuthService;

class RegisterAction
{
    public function __construct(
        private readonly AuthService $service
    ) {}

    public function execute(RegisterDTO $dto): array
    {
        return $this->service->register($dto);
    }
}
