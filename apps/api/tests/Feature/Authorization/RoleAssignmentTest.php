<?php

use App\Enums\RoleType;

use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

it('syncs user roles', function () {

    actingAsSuperAdmin([
        'users.update',
    ]);

    createRole(RoleType::MANAGER->value);
    createRole(RoleType::EMPLOYEE->value);

    $user = createUserWithRole(
        RoleType::EMPLOYEE->value
    );

    putJson("/api/v1/users/{$user->id}/roles", [

        'roles' => [
            RoleType::MANAGER->value,
        ],

    ])->assertOk();

    expect(
        $user->fresh()->hasRole(RoleType::MANAGER->value)
    )->toBeTrue();
});

it('gets user roles', function () {

    actingAsSuperAdmin([
        'users.view',
    ]);

    $user = createUserWithRole(
        RoleType::MANAGER->value
    );

    getJson("/api/v1/users/{$user->id}/roles")
        ->assertOk()
        ->assertJsonPath(
            'data.roles.0.name',
            RoleType::MANAGER->value
        );
});
