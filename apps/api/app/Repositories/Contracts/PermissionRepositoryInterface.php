<?php

namespace App\Repositories\Contracts;

use App\DTOs\Common\ListQueryDTO;
use App\DTOs\Permission\StorePermissionDTO;
use App\DTOs\Permission\UpdatePermissionDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    public function list(ListQueryDTO $dto): LengthAwarePaginator;

    public function findById(int $id): Permission;

    public function create(StorePermissionDTO $dto): Permission;

    public function update(UpdatePermissionDTO $dto): Permission;

    public function delete(int $id): bool;
}
