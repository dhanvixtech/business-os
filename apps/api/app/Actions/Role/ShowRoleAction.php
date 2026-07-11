<?php

namespace App\Actions\Role;

use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class ShowRoleAction
{
    public function __construct(
        private readonly RoleService $service,
    ) {}

    public function execute(int $id): Role
    {
        return $this->service->show($id);
    }
}
