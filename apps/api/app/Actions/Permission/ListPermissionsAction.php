<?php

namespace App\Actions\Permission;

use App\DTOs\Common\ListQueryDTO;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListPermissionsAction
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
    ) {}

    public function execute(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->repository->list($dto);
    }
}
