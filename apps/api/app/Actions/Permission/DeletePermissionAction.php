<?php

namespace App\Actions\Permission;

use App\Services\ActivityLogService;
use App\Services\PermissionService;

class DeletePermissionAction
{
    public function __construct(
        private readonly PermissionService $service,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(int $id): void
    {
        $permission = $this->service->show($id);

        $this->service->delete($id);

        $this->activity->log(
            description: 'Permission deleted',
            subject: $permission,
            properties: [
                'name' => $permission->name,
            ]
        );
    }
}
