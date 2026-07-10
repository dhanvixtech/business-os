<?php

namespace App\Actions\User;

use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UpdateUserAction
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {}

    public function execute(UpdateUserDTO $dto): User
    {
        return $this->repository->update($dto);
    }
}
