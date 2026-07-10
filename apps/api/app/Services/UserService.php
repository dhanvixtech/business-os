<?php

namespace App\Services;

use App\DTOs\Common\ListQueryDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {}

    public function list(ListQueryDTO $dto)
    {
        return $this->users->paginate($dto);
    }

    public function find(int $id): User
    {
        return $this->users->findOrFail($id);
    }
}
