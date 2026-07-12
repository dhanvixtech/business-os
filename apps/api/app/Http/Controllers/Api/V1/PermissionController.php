<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Permission\CreatePermissionAction;
use App\Actions\Permission\DeletePermissionAction;
use App\Actions\Permission\ListPermissionsAction;
use App\Actions\Permission\ShowPermissionAction;
use App\Actions\Permission\UpdatePermissionAction;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Permission\ListPermissionsRequest;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Support\Pagination;

class PermissionController extends BaseController
{
    public function index(
        ListPermissionsRequest $request,
        ListPermissionsAction $action,
    ) {
        $permissions = $action->execute($request->toDto());

        return $this->success(
            data: PermissionResource::collection($permissions),
            message: 'Permissions fetched successfully.',
            meta: Pagination::meta($permissions),
        );
    }

    public function show(
        int $id,
        ShowPermissionAction $action,
    ) {
        return $this->success(
            data: new PermissionResource(
                $action->execute($id)
            ),
            message: 'Permission fetched successfully.',
        );
    }

    public function store(
        StorePermissionRequest $request,
        CreatePermissionAction $action,
    ) {
        return $this->created(
            data: new PermissionResource(
                $action->execute($request->toDto())
            ),
            message: 'Permission created successfully.'
        );
    }

    public function update(
        int $id,
        UpdatePermissionRequest $request,
        UpdatePermissionAction $action,
    ) {
        return $this->updated(
            data: new PermissionResource(
                $action->execute($id, $request->toDto())
            ),
            message: 'Permission updated successfully.',
        );
    }

    public function destroy(
        int $id,
        DeletePermissionAction $action,
    ) {
        $action->execute($id);

        return $this->deleted(
            message: 'Permission deleted successfully.',
        );
    }
}
