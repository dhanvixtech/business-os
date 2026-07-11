<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Role\CreateRoleAction;
use App\Actions\Role\DeleteRoleAction;
use App\Actions\Role\ListRolesAction;
use App\Actions\Role\ShowRoleAction;
use App\Actions\Role\SyncRolePermissionsAction;
use App\Actions\Role\UpdateRoleAction;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Role\ListRolesRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\SyncRolePermissionsRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Support\Pagination;

class RoleController extends BaseController
{
    public function index(
        ListRolesRequest $request,
        ListRolesAction $action,
    ) {
        $roles = $action->execute($request->toDto());

        return $this->success(
            data: RoleResource::collection($roles),
            message: 'Roles fetched successfully.',
            meta: Pagination::meta($roles),
        );
    }

    public function show(
        int $id,
        ShowRoleAction $action,
    ) {
        return $this->success(
            data: new RoleResource(
                $action->execute($id)
            ),
            message: 'Role fetched successfully.',
        );
    }

    public function store(
        StoreRoleRequest $request,
        CreateRoleAction $action,
    ) {
        return $this->success(
            data: new RoleResource(
                $action->execute($request->toDto())
            ),
            message: 'Role created successfully.',
            status: 201,
        );
    }

    public function update(
        int $id,
        UpdateRoleRequest $request,
        UpdateRoleAction $action,
    ) {
        return $this->success(
            data: new RoleResource(
                $action->execute($id, $request->toDto())
            ),
            message: 'Role updated successfully.',
        );
    }

    public function destroy(
        int $id,
        DeleteRoleAction $action,
    ) {
        $action->execute($id);

        return $this->success(
            message: 'Role deleted successfully.',
        );
    }

    public function syncPermissions(
        int $id,
        SyncRolePermissionsRequest $request,
        SyncRolePermissionsAction $action,
    ) {
        $role = $action->execute(
            $id,
            $request->toDto()
        );

        return $this->success(
            data: new RoleResource($role),
            message: 'Permissions synchronized successfully.',
        );
    }
}
