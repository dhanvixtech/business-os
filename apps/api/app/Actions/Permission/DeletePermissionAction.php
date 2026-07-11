<?php

namespace App\Actions\Permission;

use App\Services\PermissionService;

class DeletePermissionAction
{
    public function __construct(
        private readonly PermissionService $service,
    ) {}

    public function execute(int $id): void
    {
        $this->service->delete($id);
    }
}
