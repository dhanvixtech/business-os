<?php

namespace App\Actions\Role;

use App\DTOs\Role\SyncRolePermissionsDTO;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class SyncRolePermissionsAction
{
    public function __construct(
        private readonly RoleService $service,
    ) {}

    public function execute(
        int $id,
        SyncRolePermissionsDTO $dto,
    ): Role {

        return $this->service->syncPermissions(
            $id,
            $dto->permissions,
        );
    }
}
