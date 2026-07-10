<?php

namespace App\Services;

use App\Actions\User\CreateUserAction;
use App\Actions\User\UpdateUserAction;
use App\DTOs\Common\ListQueryDTO;
use App\DTOs\User\StoreUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly CreateUserAction $createUserAction,
        private readonly UpdateUserAction $updateUserAction,
    ) {}

    public function list(ListQueryDTO $dto)
    {
        return $this->repository->paginate($dto);
    }

    public function create(StoreUserDTO $dto): User
    {
        return $this->createUserAction->execute($dto);
    }

    public function find(int $id): User
    {
        return $this->repository->findOrFail($id);
    }

    public function update(UpdateUserDTO $dto): User
    {
        return $this->updateUserAction->execute($dto);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
