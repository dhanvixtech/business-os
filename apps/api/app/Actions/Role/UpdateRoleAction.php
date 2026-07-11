<?php

namespace App\Actions\Role;

use App\DTOs\Role\UpdateRoleDTO;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    public function __construct(
        private readonly RoleService $service,
    ) {}

    public function execute(
        int $id,
        UpdateRoleDTO $dto,
    ): Role {
        return $this->service->update($id, $dto);
    }
}
