<?php

namespace App\Actions\User;

use App\Models\User;
use App\Services\UserService;

class GetUserRolesAction
{
    public function __construct(
        private readonly UserService $service,
    ) {}

    public function execute(int $id): User
    {
        return $this->service->getRoles($id);
    }
}
