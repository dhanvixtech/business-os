<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\AuthService;

class LogoutAction
{
    public function __construct(
        private AuthService $service
    ) {}

    public function execute(User $user): void
    {
        $this->service->logout($user);
    }
}
