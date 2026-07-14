<?php

namespace App\Actions\Role;

use App\DTOs\Role\StoreRoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Services\ActivityLogService;
use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(StoreRoleDTO $dto): Role
    {
        $role = $this->repository->create($dto);

        $this->activity->log(
            description: 'Role created',
            subject: $role,
            properties: [
                'name' => $role->name,
            ]
        );

        return $role;
    }
}
