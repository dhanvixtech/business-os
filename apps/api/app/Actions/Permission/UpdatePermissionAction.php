<?php

namespace App\Actions\Permission;

use App\DTOs\Permission\UpdatePermissionDTO;
use App\Services\ActivityLogService;
use App\Services\PermissionService;
use Spatie\Permission\Models\Permission;

class UpdatePermissionAction
{
    public function __construct(
        private readonly PermissionService $service,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(
        int $id,
        UpdatePermissionDTO $dto,
    ): Permission {

        $permission = $this->service->update($id, $dto);

        $this->activity->log(
            description: 'Permission updated',
            subject: $permission,
            properties: [
                'name' => $permission->name,
            ]
        );

        return $permission;
    }
}
