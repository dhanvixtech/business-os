<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can list users', function () {

    actingAsUser();

    User::factory()->count(15)->create();

    $response = $this->getJson('/api/v1/users');

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Users fetched successfully.',
        ])
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
            'meta' => [
                'current_page',
                'last_page',
                'per_page',
                'total',
            ],
            'errors',
        ]);
});

it('requires authentication to list users', function () {

    $response = $this->getJson('/api/v1/users');

    $response->assertUnauthorized();
});

it('supports pagination', function () {

    actingAsUser();

    User::factory()->count(25)->create();

    $response = $this->getJson('/api/v1/users?per_page=10');

    $response
        ->assertOk()
        ->assertJsonPath('meta.per_page', 10);
});

it('supports search', function () {

    actingAsUser();

    User::factory()->create([
        'name' => 'Ganesh Kumar',
    ]);

    User::factory()->create([
        'name' => 'John Doe',
    ]);

    $response = $this->getJson('/api/v1/users?search=Ganesh');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data');
});

it('supports sorting', function () {

    actingAsUser();

    User::factory()->create([
        'name' => 'Zebra',
    ]);

    User::factory()->create([
        'name' => 'Apple',
    ]);

    $response = $this->getJson(
        '/api/v1/users?sort=name&direction=asc'
    );

    $response
        ->assertOk()
        ->assertJsonPath('data.0.name', 'Apple');
});
