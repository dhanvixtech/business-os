<?php

namespace App\Actions\Role;

use App\DTOs\Role\UpdateRoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Services\ActivityLogService;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(UpdateRoleDTO $dto): Role
    {
        $role = $this->repository->update($dto);

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
