<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\Common\ListQueryDTO;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\ListUsersRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Support\Pagination;

class UserController extends BaseController
{
    public function __construct(
        private readonly UserService $service
    ) {}

    public function index(ListUsersRequest $request)
    {
        $users = $this->service->list($request->toDto());

        return $this->success(
            data: UserResource::collection($users),
            message: 'Users fetched successfully.',
            meta: Pagination::meta($users)
        );
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->service->create($request->toDto());

        return $this->success(
            data: new UserResource($user),
            message: 'User created successfully.',
            status: 201
        );
    }

    public function show(int $id)
    {
        $user = $this->service->find($id);

        return $this->success(
            data: new UserResource($user),
            message: 'User fetched successfully.'
        );
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->service->update(
            $request->toDto()
        );

        return $this->success(
            data: new UserResource($user),
            message: 'User updated successfully.'
        );
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return $this->success(
            message: 'User deleted successfully.'
        );
    }
}
