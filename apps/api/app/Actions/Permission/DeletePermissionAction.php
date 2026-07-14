<?php

namespace App\Actions\Permission;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Services\ActivityLogService;

class DeletePermissionAction
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(int $id): bool
    {
        $permission = $this->repository->findById($id);

        $status = $this->repository->delete($id);

        $this->activity->log(
            description: 'Permission deleted',
            subject: $permission,
            properties: [
                'name' => $permission->name,
            ]
        );

        return $status;
    }
}
