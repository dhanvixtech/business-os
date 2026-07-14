<?php

namespace App\Actions\Permission;

use App\DTOs\Permission\UpdatePermissionDTO;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Services\ActivityLogService;
use Spatie\Permission\Models\Permission;

class UpdatePermissionAction
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(UpdatePermissionDTO $dto): Permission
    {
        $permission = $this->repository->update($dto);

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
