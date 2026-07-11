<?php

namespace App\Services;

use App\DTOs\Common\ListQueryDTO;
use App\DTOs\Permission\StorePermissionDTO;
use App\DTOs\Permission\UpdatePermissionDTO;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
    ) {}

    public function list(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->repository->list($dto);
    }

    public function show(int $id): Permission
    {
        return $this->repository->findById($id);
    }

    public function create(StorePermissionDTO $dto): Permission
    {
        return $this->repository->create($dto);
    }

    public function update(
        int $id,
        UpdatePermissionDTO $dto,
    ): Permission {

        $permission = $this->repository->findById($id);

        return $this->repository->update(
            $permission,
            $dto
        );
    }

    public function delete(int $id): void
    {
        $permission = $this->repository->findById($id);

        $this->repository->delete($permission);
    }
}
