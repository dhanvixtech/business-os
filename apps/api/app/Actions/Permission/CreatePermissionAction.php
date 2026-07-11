<?php

namespace App\Actions\Permission;

use App\DTOs\Permission\StorePermissionDTO;
use App\Services\PermissionService;
use Spatie\Permission\Models\Permission;

class CreatePermissionAction
{
    public function __construct(
        private readonly PermissionService $service,
    ) {}

    public function execute(StorePermissionDTO $dto): Permission
    {
        return $this->service->create($dto);
    }
}
