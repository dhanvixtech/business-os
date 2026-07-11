<?php

use App\Enums\RoleType;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

it('denies customer from listing users', function () {

    actingAsCustomer();

    getJson('/api/v1/users')
        ->assertForbidden();
});

it('allows super admin to list users', function () {

    actingAsSuperAdmin([
        'users.view',
    ]);

    getJson('/api/v1/users')
        ->assertOk();
});

it('allows manager to update employee', function () {

    actingAsManager([
        'users.update',
    ]);

    $employee = createUserWithRole(
        RoleType::EMPLOYEE->value
    );

    putJson("/api/v1/users/{$employee->id}", [

        'id' => $employee->id,
        'name' => 'Updated',
        'email' => 'updated@example.com',

    ])->assertOk();
});

it('prevents manager from updating super admin', function () {

    actingAsManager([
        'users.update',
    ]);

    createRole(RoleType::SUPER_ADMIN->value);

    $admin = createUserWithRole(
        RoleType::SUPER_ADMIN->value
    );

    putJson("/api/v1/users/{$admin->id}", [

        'id' => $admin->id,
        'name' => 'Admin',
        'email' => 'admin@example.com',

    ])->assertForbidden();
});
