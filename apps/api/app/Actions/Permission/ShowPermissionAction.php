<?php

namespace App\Actions\Permission;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class ShowPermissionAction
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,

    ) {}

    public function execute(int $id): Permission
    {
        return $this->repository->findById($id);
    }
}
