<?php

namespace App\Services;

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
    ) {}

    public function list(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->repository->list($dto);
    }

    public function show(int $id): Role
    {
        return $this->repository->findById($id);
    }

    public function create(StoreRoleDTO $dto): Role
    {
        return $this->repository->create($dto);
    }

    public function update(
        int $id,
        UpdateRoleDTO $dto,
    ): Role {

        $role = $this->repository->findById($id);

        return $this->repository->update(
            $role,
            $dto
        );
    }

    public function delete(int $id): void
    {
        $role = $this->repository->findById($id);

        $this->repository->delete($role);
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
