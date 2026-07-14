<?php

namespace App\Services;

use App\Actions\Permission\CreatePermissionAction;
use App\Actions\Permission\DeletePermissionAction;
use App\Actions\Permission\ListPermissionsAction;
use App\Actions\Permission\ShowPermissionAction;
use App\Actions\Permission\UpdatePermissionAction;
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
        private readonly ListPermissionsAction $listAction,
        private readonly ShowPermissionAction $showAction,
        private readonly CreatePermissionAction $createAction,
        private readonly UpdatePermissionAction $updateAction,
        private readonly DeletePermissionAction $deleteAction,
    ) {}

    public function list(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->listAction->execute($dto);
    }

    public function show(int $id): Permission
    {
        return $this->showAction->execute($id);
    }

    public function create(StorePermissionDTO $dto): Permission
    {
        return $this->createAction->execute($dto);
    }

    public function update(UpdatePermissionDTO $dto)
    {
        return $this->updateAction->execute($dto);
    }

    public function delete(int $id)
    {
        return $this->deleteAction->execute($id);
    }
}
