<?php

namespace App\Services;

use App\DTOs\Auth\RegisterDTO;
use App\Enums\RoleType;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    public function createToken(User $user): string
    {
        return $user->createToken('business-os')->plainTextToken;
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function register(RegisterDTO $dto): array
    {
        $user = $this->users->register($dto);

        $user->assignRole(
            RoleType::CUSTOMER->value
        );

        return [
            'user' => $user,
            'token' => $this->createToken($user),
        ];
    }
}
