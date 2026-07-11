<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\User\GetUserRolesAction;
use App\Actions\User\SyncUserRolesAction;
use App\DTOs\Common\ListQueryDTO;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\ListUsersRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\SyncUserRolesRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Support\Pagination;
use Illuminate\Support\Facades\Gate;

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
        $user = $this->service->findOrFail($id);

        Gate::authorize('view', $user);

        return $this->success(
            data: new UserResource($user),
            message: 'User fetched successfully.'
        );
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->service->findOrFail($id);

        Gate::authorize('update', $user);

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
        $user = $this->service->findOrFail($id);

        Gate::authorize('delete', $user);

        $this->service->delete($id);

        return $this->success(
            message: 'User deleted successfully.'
        );
    }

    public function roles(
        int $id,
        GetUserRolesAction $action,
    ) {

        $user = $this->service->findOrFail($id);

        Gate::authorize('view', $user);

        return $this->success(
            data: new UserResource(
                $action->execute($id)
            ),
            message: 'User roles fetched successfully.',
        );
    }

    public function syncRoles(
        int $id,
        SyncUserRolesRequest $request,
        SyncUserRolesAction $action,
    ) {

        $user = $this->service->findOrFail($id);

        Gate::authorize('update', $user);

        return $this->success(
            data: new UserResource(
                $action->execute(
                    $id,
                    $request->toDto()
                )
            ),
            message: 'User roles synchronized successfully.',
        );
    }
}
