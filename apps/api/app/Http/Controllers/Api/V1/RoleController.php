<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Role\SyncRolePermissionsAction;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Role\ListRolesRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\SyncRolePermissionsRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use App\Support\Pagination;

class RoleController extends BaseController
{

    public function __construct(
        private readonly RoleService $service
    ) {}

    public function index(ListRolesRequest $request)
    {
        $roles = $this->service->list($request->toDto());

        return $this->success(
            data: RoleResource::collection($roles),
            message: 'Roles fetched successfully.',
            meta: Pagination::meta($roles),
        );
    }

    public function show(int $id)
    {
        $role = $this->service->show($id);

        return $this->success(
            data: new RoleResource($role),
            message: 'Role fetched successfully.',
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $this->service->create($request->toDto());

        return $this->created(
            data: new RoleResource($role),
            message: 'Role created successfully.'
        );
    }

    public function update(UpdateRoleRequest $request, int $id)
    {
        $role = $this->service->update($request->toDto());

        return $this->updated(
            data: new RoleResource($role),
            message: 'Role updated successfully.',
        );
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return $this->deleted(
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
