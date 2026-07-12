<?php

namespace App\Actions\User;

use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\ActivityLogService;

class DeleteUserAction
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly ActivityLogService $activity,
    ) {}

    public function execute(int $id): bool
    {
        $user = $this->repository->findOrFail($id);

        $status = $this->repository->delete($id);

        $this->activity->log(
            description: 'User deleted',
            subject: $user,
            properties: [
                'email' => $user->email,
                'role' => $user->roles->pluck('name'),
            ]
        );

        return $status;
    }
}
