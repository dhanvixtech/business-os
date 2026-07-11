<?php

namespace App\Actions\Permission;

use App\DTOs\Common\ListQueryDTO;
use App\Services\PermissionService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListPermissionsAction
{
    public function __construct(
        private readonly PermissionService $service,
    ) {}

    public function execute(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->service->list($dto);
    }
}
