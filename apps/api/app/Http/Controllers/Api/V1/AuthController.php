<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Auth\LoginAction;
use App\DTOs\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(
        LoginRequest $request,
        LoginAction $action
    ) {
        $result = $action->execute(
            LoginDTO::fromArray($request->validated())
        );

        return ApiResponse::success(
            data: $result,
            message: 'Login successful.'
        );
    }

    public function me(Request $request)
    {
        return ApiResponse::success(
            data: $request->user(),
            message: 'Authenticated user.'
        );
    }

    public function logout(
        Request $request,
        LogoutAction $action
    ) {
        $action->execute($request->user());

        return ApiResponse::success(
            message: 'Logout successful.'
        );
    }
}
