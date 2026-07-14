<?php

namespace App\Actions\Role;

use App\DTOs\Common\ListQueryDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListRolesAction
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
    ) {}

    public function execute(ListQueryDTO $dto): LengthAwarePaginator
    {
        return $this->repository->list($dto);
    }
}
