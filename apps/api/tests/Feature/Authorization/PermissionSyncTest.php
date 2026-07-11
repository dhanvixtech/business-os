<?php

use App\Enums\RoleType;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\putJson;

it('syncs permissions to role', function () {

    actingAsSuperAdmin([
        'roles.update',
    ]);

    createRole(RoleType::MANAGER->value);
    createRole(RoleType::EMPLOYEE->value);
    createPermission('users.view');
    createPermission('users.create');


    $role = Role::firstOrCreate([
        'name' => RoleType::MANAGER->value,
        'guard_name' => 'sanctum',
    ]);

    putJson("/api/v1/roles/{$role->id}/permissions", [

        'permissions' => [
            'users.view',
            'users.create',
        ],

    ])->assertOk();

    expect(
        $role->fresh()->hasPermissionTo('users.view')
    )->toBeTrue();
});
