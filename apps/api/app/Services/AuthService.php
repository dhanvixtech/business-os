<?php

namespace App\Services;

use App\DTOs\Auth\RegisterDTO;
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

        return [
            'user' => $user,
            'token' => $this->createToken($user),
        ];
    }
}
