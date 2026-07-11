<?php

use App\Enums\RoleType;
use App\Models\User;

beforeEach(function () use (&$user) {

    createRole(RoleType::SUPER_ADMIN->value);
    createPermission('users.delete');
});

it('can delete a user', function () {

    actingAsSuperAdmin([
        'users.delete'
    ]);

    $user = User::factory()->create();

    $response = $this->deleteJson("/api/v1/users/{$user->id}");

    $response->assertOk();

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

it('returns 404 when deleting unknown user', function () {

    actingAsSuperAdmin([
        'users.delete'
    ]);

    $response = $this->deleteJson('/api/v1/users/999999');

    $response->assertNotFound();
});
