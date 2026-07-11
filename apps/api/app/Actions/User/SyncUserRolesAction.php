<?php

namespace App\Actions\User;

use App\DTOs\User\SyncUserRolesDTO;
use App\Models\User;
use App\Services\UserService;

class SyncUserRolesAction
{
    public function __construct(
        private readonly UserService $service,
    ) {}

    public function execute(
        int $id,
        SyncUserRolesDTO $dto,
    ): User {

        return $this->service->syncRoles(
            $id,
            $dto->roles,
        );
    }
}
