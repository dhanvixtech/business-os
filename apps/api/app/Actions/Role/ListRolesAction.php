<?php

namespace App\Actions\Role;

use App\DTOs\Common\ListQueryDTO;
use App\Services\RoleService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListRolesAction
{
    public function __construct(
        private readonly RoleService $service,
    ) {}

    public function execute(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->service->list($dto);
    }
}
