<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Permission\ListPermissionsRequest;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use App\Support\Pagination;

class PermissionController extends BaseController
{
    public function __construct(
        private readonly PermissionService $service
    ) {}

    public function index(ListPermissionsRequest $request)
    {
        $permissions = $this->service->list($request->toDto());

        return $this->success(
            data: PermissionResource::collection($permissions),
            message: 'Permissions fetched successfully.',
            meta: Pagination::meta($permissions),
        );
    }

    public function show(int $id)
    {
        $permission = $this->service->show($id);

        return $this->success(
            data: new PermissionResource($permission),
            message: 'Permission fetched successfully.',
        );
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = $this->service->create($request->toDto());

        return $this->created(
            data: new PermissionResource($permission),
            message: 'Permission created successfully.'
        );
    }

    public function update(UpdatePermissionRequest $request, int $id)
    {
        $permission = $this->service->update($request->toDto());

        return $this->updated(
            data: new PermissionResource($permission),
            message: 'Permission updated successfully.',
        );
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return $this->deleted(
            message: 'Permission deleted successfully.',
        );
    }
}
