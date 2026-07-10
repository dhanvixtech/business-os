<?php

namespace App\Repositories\Contracts;

use App\DTOs\Common\ListQueryDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function paginate(ListQueryDTO $dto): LengthAwarePaginator;

    public function findOrFail(int $id): User;
}
