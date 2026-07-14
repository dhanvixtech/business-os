<?php

namespace App\Repositories\Eloquent;

use App\DTOs\Common\ListQueryDTO;
use App\DTOs\Role\StoreRoleDTO;
use App\DTOs\Role\UpdateRoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
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
        $query = Role::query();

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

    public function findById(int $id): Role
    {
        return Role::query()->findOrFail($id);
    }

    public function create(StoreRoleDTO $dto): Role
    {
        return Role::query()->create($dto->toArray());
    }

    public function update(UpdateRoleDTO $dto): Role
    {
        $role = $this->findById($dto->id);

        $role->update($dto->toArray());

        return $role->refresh();
    }

    public function delete(int $id): bool
    {
        $role = $this->findById($id);

        return $role->delete();
    }

    public function syncPermissions(
        Role $role,
        array $permissions,
    ): Role {

        $role->syncPermissions(
            $permissions
        );

        return $role->load('permissions');
    }
}
