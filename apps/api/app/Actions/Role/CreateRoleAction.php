<?php

namespace App\Actions\Role;

use App\DTOs\Role\StoreRoleDTO;
use App\Services\ActivityLogService;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    public function __construct(
        private readonly RoleService $service,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(StoreRoleDTO $dto): Role
    {
        $role = $this->service->create($dto);

        $this->activity->log(
            description: 'Role created',
            subject: $role,
            properties: [
                'name' => $role->name,
            ]
        );

        return $role;
    }
}
