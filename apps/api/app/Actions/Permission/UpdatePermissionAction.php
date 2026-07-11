<?php

namespace App\Actions\Permission;

use App\DTOs\Permission\UpdatePermissionDTO;
use App\Services\PermissionService;
use Spatie\Permission\Models\Permission;

class UpdatePermissionAction
{
    public function __construct(
        private readonly PermissionService $service,
    ) {}

    public function execute(
        int $id,
        UpdatePermissionDTO $dto,
    ): Permission {

        return $this->service->update($id, $dto);
    }
}
