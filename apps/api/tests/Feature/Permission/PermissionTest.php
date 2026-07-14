<?php

use App\Enums\RoleType;
use Spatie\Permission\Models\Permission;

beforeEach(function () {

    createRole(RoleType::SUPER_ADMIN->value);

    createPermission('permissions.view');
    createPermission('permissions.create');
    createPermission('permissions.update');
    createPermission('permissions.delete');

    actingAsSuperAdmin([
        'permissions.view',
        'permissions.create',
        'permissions.update',
        'permissions.delete',
    ]);
});

it('can list permissions', function () {

    Permission::create([
        'name' => 'users.view',
        'guard_name' => 'sanctum',
    ]);

    Permission::create([
        'name' => 'users.create',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->getJson('/api/v1/permissions');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonCount(6, 'data');
});

it('can show a permission', function () {

    $permission = Permission::create([
        'name' => 'users.export',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->getJson(
        "/api/v1/permissions/{$permission->id}"
    );

    $response
        ->assertOk()
        ->assertJsonPath(
            'data.name',
            'users.export'
        );
});

it('can create a permission', function () {

    $response = $this->postJson(
        '/api/v1/permissions',
        [
            'name' => 'users.import',
        ]
    );

    $response
        ->assertCreated()
        ->assertJsonPath(
            'data.name',
            'users.import'
        );

    $this->assertDatabaseHas('permissions', [
        'name' => 'users.import',
    ]);
});

it('can update a permission', function () {

    $permission = Permission::create([
        'name' => 'users.import',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->putJson(
        "/api/v1/permissions/{$permission->id}",
        [
            'name' => 'users.export',
        ]
    );

    $response
        ->assertOk()
        ->assertJsonPath(
            'data.name',
            'users.export'
        );

    $this->assertDatabaseHas('permissions', [
        'name' => 'users.export',
    ]);
});

it('can delete a permission', function () {

    $permission = Permission::create([
        'name' => 'users.import',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->deleteJson(
        "/api/v1/permissions/{$permission->id}"
    );

    $response->assertOk();

    $this->assertDatabaseMissing(
        'permissions',
        [
            'id' => $permission->id,
        ]
    );
});

it('validates permission creation', function () {

    $response = $this->postJson(
        '/api/v1/permissions',
        []
    );

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'name',
        ]);
});

it('does not allow duplicate permission names', function () {

    Permission::create([
        'name' => 'users.view',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->postJson(
        '/api/v1/permissions',
        [
            'name' => 'users.view',
        ]
    );

    $response->assertUnprocessable();
});
