<?php

namespace App\Actions\Role;

use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Services\ActivityLogService;

class DeleteRoleAction
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(int $id): bool
    {
        $role = $this->repository->findById($id);

        $status = $this->repository->delete($id);

        $this->activity->log(
            description: 'Role deleted',
            subject: $role,
            properties: [
                'name' => $role->name,
            ]
        );

        return $status;
    }
}
