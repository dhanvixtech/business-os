<?php

namespace App\Actions\Permission;

use App\Services\PermissionService;
use Spatie\Permission\Models\Permission;

class ShowPermissionAction
{
    public function __construct(
        private readonly PermissionService $service,
    ) {}

    public function execute(int $id): Permission
    {
        return $this->service->show($id);
    }
}
