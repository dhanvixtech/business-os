<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function createToken(User $user): string
    {
        return $user->createToken('business-os')->plainTextToken;
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
