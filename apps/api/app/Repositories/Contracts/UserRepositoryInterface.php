<?php

namespace App\Repositories\Contracts;

use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Common\ListQueryDTO;
use App\DTOs\User\StoreUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function register(RegisterDTO $dto): User;

    public function paginate(ListQueryDTO $dto): LengthAwarePaginator;

    public function create(StoreUserDTO $dto): User;

    public function findOrFail(int $id): User;

    public function update(UpdateUserDTO $dto): User;

    public function delete(int $id): bool;

    public function syncRoles(
        User $user,
        array $roles,
    ): User;

    public function getRoles(
        User $user,
    ): User;
}
