<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterAction;
use App\DTOs\Auth\LoginDTO;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function login(
        LoginRequest $request,
        LoginAction $action
    ) {
        $result = $action->execute($request->toDto());

        return $this->success(
            data: $result,
            message: 'Login successful.'
        );
    }

    public function register(
        RegisterRequest $request,
        RegisterAction $action
    ) {
        $result = $action->execute(
            $request->toDto()
        );

        return $this->success(
            data: $result,
            message: 'Registered successfully.',
            status: 201
        );
    }

    public function me(Request $request)
    {
        return $this->success(
            data: $request->user(),
            message: 'Authenticated user.'
        );
    }

    public function logout(
        Request $request,
        LogoutAction $action
    ) {
        $action->execute($request->user());

        return $this->success(
            message: 'Logout successful.'
        );
    }
}
