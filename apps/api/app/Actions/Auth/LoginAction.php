<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Repositories\Eloquent\UserRepository;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly AuthService $auth
    ) {}

    public function execute(LoginDTO $dto): array
    {
        $user = $this->users->findByEmail($dto->email);

        if (! $user || ! Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $this->auth->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
