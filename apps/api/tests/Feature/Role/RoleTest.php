<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;

$user = null;

beforeEach(function () use (&$user) {

    $user = User::factory()->create();

    Sanctum::actingAs($user);
});

it('can list roles', function () {

    Role::create([
        'name' => 'Admin',
        'guard_name' => 'sanctum',
    ]);

    Role::create([
        'name' => 'Manager',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->getJson('/api/v1/roles');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonCount(2, 'data');
});

it('can show a role', function () {

    $role = Role::create([
        'name' => 'Admin',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->getJson(
        "/api/v1/roles/{$role->id}"
    );

    $response
        ->assertOk()
        ->assertJsonPath('data.name', 'Admin');
});

it('can create a role', function () {

    $response = $this->postJson(
        '/api/v1/roles',
        [
            'name' => 'Manager',
        ]
    );

    $response
        ->assertCreated()
        ->assertJsonPath('data.name', 'Manager');

    $this->assertDatabaseHas('roles', [
        'name' => 'Manager',
    ]);
});

it('can update a role', function () {

    $role = Role::create([
        'name' => 'Manager',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->putJson(
        "/api/v1/roles/{$role->id}",
        [
            'name' => 'Administrator',
        ]
    );

    $response
        ->assertOk()
        ->assertJsonPath(
            'data.name',
            'Administrator'
        );

    $this->assertDatabaseHas('roles', [
        'name' => 'Administrator',
    ]);
});

it('can delete a role', function () {

    $role = Role::create([
        'name' => 'Manager',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->deleteJson(
        "/api/v1/roles/{$role->id}"
    );

    $response->assertOk();

    $this->assertDatabaseMissing(
        'roles',
        [
            'id' => $role->id,
        ]
    );
});

it('validates role creation', function () {

    $response = $this->postJson(
        '/api/v1/roles',
        []
    );

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'name',
        ]);
});

it('does not allow duplicate role names', function () {

    Role::create([
        'name' => 'Admin',
        'guard_name' => 'sanctum',
    ]);

    $response = $this->postJson(
        '/api/v1/roles',
        [
            'name' => 'Admin',
        ]
    );

    $response->assertUnprocessable();
});
