<?php

namespace App\Services;

use App\Actions\Role\CreateRoleAction;
use App\Actions\Role\DeleteRoleAction;
use App\Actions\Role\ListRolesAction;
use App\Actions\Role\ShowRoleAction;
use App\Actions\Role\UpdateRoleAction;
use App\DTOs\Common\ListQueryDTO;
use App\DTOs\Role\StoreRoleDTO;
use App\DTOs\Role\UpdateRoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly ListRolesAction $listAction,
        private readonly ShowRoleAction $showAction,
        private readonly CreateRoleAction $createAction,
        private readonly UpdateRoleAction $updateAction,
        private readonly DeleteRoleAction $deleteAction,
    ) {}

    public function list(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->listAction->execute($dto);
    }

    public function show(int $id): Role
    {
        return $this->showAction->execute($id);
    }

    public function create(StoreRoleDTO $dto): Role
    {
        return $this->createAction->execute($dto);
    }

    public function update(UpdateRoleDTO $dto)
    {
        return $this->updateAction->execute($dto);
    }

    public function delete(int $id)
    {
        return $this->deleteAction->execute($id);
    }

    public function syncPermissions(
        int $id,
        array $permissions,
    ): Role {

        $role = $this->repository
            ->findById($id);

        return $this->repository
            ->syncPermissions(
                $role,
                $permissions
            );
    }
}
