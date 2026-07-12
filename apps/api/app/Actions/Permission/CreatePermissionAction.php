<?php

namespace App\Actions\Permission;

use App\DTOs\Permission\StorePermissionDTO;
use App\Services\ActivityLogService;
use App\Services\PermissionService;
use Spatie\Permission\Models\Permission;

class CreatePermissionAction
{
    public function __construct(
        private readonly PermissionService $service,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(StorePermissionDTO $dto): Permission
    {
        $permission = $this->service->create($dto);

        $this->activity->log(
            description: 'Permission created',
            subject: $permission,
            properties: [
                'name' => $permission->name,
            ]
        );

        return $permission;
    }
}
