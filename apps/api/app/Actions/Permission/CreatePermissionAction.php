<?php

namespace App\Actions\Permission;

use App\DTOs\Permission\StorePermissionDTO;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Services\ActivityLogService;
use Spatie\Permission\Models\Permission;

class CreatePermissionAction
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(StorePermissionDTO $dto): Permission
    {
        $permission = $this->repository->create($dto);

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
