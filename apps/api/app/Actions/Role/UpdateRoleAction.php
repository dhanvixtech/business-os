<?php

namespace App\Actions\Role;

use App\DTOs\Role\UpdateRoleDTO;
use App\Services\ActivityLogService;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    public function __construct(
        private readonly RoleService $service,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(
        int $id,
        UpdateRoleDTO $dto,
    ): Role {
        $role = $this->service->update($id, $dto);

        $this->activity->log(
            description: 'Role updated',
            subject: $role,
            properties: [
                'name' => $role->name,
            ]
        );

        return $role;
    }
}
