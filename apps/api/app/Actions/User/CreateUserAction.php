<?php

namespace App\Actions\User;

use App\DTOs\User\StoreUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class CreateUserAction
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {}

    public function execute(StoreUserDTO $dto): User
    {
        return $this->repository->create($dto);
    }
}
