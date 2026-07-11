<?php

namespace App\Actions\Role;

use App\Services\RoleService;

class DeleteRoleAction
{
    public function __construct(
        private readonly RoleService $service,
    ) {}

    public function execute(int $id): void
    {
        $this->service->delete($id);
    }
}
