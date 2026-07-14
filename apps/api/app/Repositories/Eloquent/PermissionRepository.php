<?php

namespace App\Repositories\Eloquent;

use App\DTOs\Common\ListQueryDTO;
use App\DTOs\Permission\StorePermissionDTO;
use App\DTOs\Permission\UpdatePermissionDTO;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    private const SEARCHABLE = [
        'name',
        'guard_name',
    ];

    private const SORTABLE = [
        'id',
        'name',
        'guard_name',
        'created_at',
    ];

    public function list(ListQueryDTO $dto): LengthAwarePaginator
    {
        $query = Permission::query();

        if ($dto->search !== null) {

            $query->where(function ($query) use ($dto) {

                foreach (self::SEARCHABLE as $column) {

                    $query->orWhere(
                        $column,
                        'LIKE',
                        "%{$dto->search}%"
                    );
                }
            });
        }

        $sort = in_array($dto->sort, self::SORTABLE)
            ? $dto->sort
            : 'id';

        $query->orderBy(
            $sort,
            $dto->direction->value
        );

        return $query->paginate($dto->perPage);
    }

    public function findById(int $id): Permission
    {
        return Permission::query()->findOrFail($id);
    }

    public function create(StorePermissionDTO $dto): Permission
    {
        $attributes = $dto->toArray();

        $attributes['guard_name'] = config('auth.defaults.guard', 'sanctum');

        return Permission::query()->create($attributes);
    }

    public function update(UpdatePermissionDTO $dto): Permission
    {
        $permission = $this->findById($dto->id);

        $attributes = $dto->toArray();

        $attributes['guard_name'] = config('auth.defaults.guard', 'sanctum');

        $permission->update($attributes);

        return $permission->refresh();
    }

    public function delete(int $id): bool
    {
        $permission = $this->findById($id);

        return $permission->delete();
    }
}
