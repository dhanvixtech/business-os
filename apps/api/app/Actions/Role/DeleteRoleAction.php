<?php

namespace App\Actions\Role;

use App\Services\ActivityLogService;
use App\Services\RoleService;

class DeleteRoleAction
{
    public function __construct(
        private readonly RoleService $service,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(int $id): void
    {
        $role = $this->service->show($id);

        $this->service->delete($id);

        $this->activity->log(
            description: 'Role deleted',
            subject: $role,
            properties: [
                'name' => $role->name,
            ]
        );
    }
}
