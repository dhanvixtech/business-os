<?php

namespace App\Repositories\Contracts;

use App\DTOs\Common\ListQueryDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function paginate(ListQueryDTO $dto): LengthAwarePaginator;
}
