<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (! function_exists('createRole')) {

    function createRole(string $name): Role
    {
        return Role::firstOrCreate([
            'name' => $name,
            'guard_name' => 'sanctum',
        ]);
    }
}

if (! function_exists('createPermission')) {

    function createPermission(string $name): Permission
    {
        return Permission::firstOrCreate([
            'name' => $name,
            'guard_name' => 'sanctum',
        ]);
    }
}

if (! function_exists('actingAsRole')) {

    function actingAsRole(
        string $role,
        array $permissions = [],
    ): User {

        $roleModel = createRole($role);

        foreach ($permissions as $permission) {

            createPermission($permission);

            if (! $roleModel->hasPermissionTo($permission)) {
                $roleModel->givePermissionTo($permission);
            }
        }

        $user = User::factory()->create();

        $user->assignRole($roleModel);

        Sanctum::actingAs($user);

        return $user->fresh();
    }
}

if (! function_exists('createUserWithRole')) {

    function createUserWithRole(string $role): User
    {
        $roleModel = createRole($role);

        $user = User::factory()->create();

        $user->assignRole($roleModel);

        return $user->fresh();
    }
}

function actingAsSuperAdmin(array $permissions = []): User
{
    return actingAsRole('Super Admin', $permissions);
}

function actingAsManager(array $permissions = []): User
{
    return actingAsRole('Manager', $permissions);
}

function actingAsEmployee(array $permissions = []): User
{
    return actingAsRole('Employee', $permissions);
}

function actingAsCustomer(array $permissions = []): User
{
    return actingAsRole('Customer', $permissions);
}
