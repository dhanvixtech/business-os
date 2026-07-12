<?php

namespace App\Actions\User;

use App\DTOs\User\StoreUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\ActivityLogService;

class CreateUserAction
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(StoreUserDTO $dto): User
    {
        $user = $this->repository->create($dto);

        $this->activity->log(
            description: 'User created',
            subject: $user,
            properties: [
                'email' => $user->email,
                'role' => $user->roles->pluck('name'),
            ]
        );

        return $user;
    }
}
