<?php

namespace App\Actions\Role;

use App\DTOs\Role\StoreRoleDTO;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    public function __construct(
        private readonly RoleService $service,
    ) {}

    public function execute(StoreRoleDTO $dto): Role
    {
        return $this->service->create($dto);
    }
}
