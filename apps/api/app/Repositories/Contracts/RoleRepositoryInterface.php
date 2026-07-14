<?php

namespace App\Repositories\Contracts;

use App\DTOs\Common\ListQueryDTO;
use App\DTOs\Role\StoreRoleDTO;
use App\DTOs\Role\UpdateRoleDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function list(ListQueryDTO $dto): LengthAwarePaginator;

    public function findById(int $id): Role;

    public function create(StoreRoleDTO $dto): Role;

    public function update(UpdateRoleDTO $dto): Role;

    public function delete(int $id): bool;

    public function syncPermissions(
        Role $role,
        array $permissions,
    ): Role;
}
