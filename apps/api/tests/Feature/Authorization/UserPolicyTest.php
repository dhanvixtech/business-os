<?php

use App\Enums\RoleType;
use function Pest\Laravel\putJson;

it('allows employee to update himself', function () {

    $employee = actingAsEmployee([
        'users.update',
    ]);

    putJson("/api/v1/users/{$employee->id}", [

        'id' => $employee->id,
        'name' => 'Updated Name',
        'email' => $employee->email,

    ])->assertOk();
});

it('prevents employee updating another employee', function () {

    actingAsEmployee([
        'users.update',
    ]);

    createRole(RoleType::EMPLOYEE->value);

    $other = createUserWithRole(
        RoleType::EMPLOYEE->value
    );

    putJson("/api/v1/users/{$other->id}", [

        'id' => $other->id,
        'name' => 'Updated',
        'email' => $other->email,

    ])->assertForbidden();
});
