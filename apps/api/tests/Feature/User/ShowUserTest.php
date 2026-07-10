<?php

use App\Models\User;

it('can show a user', function () {

    actingAsUser();

    $user = User::factory()->create();

    $response = $this->getJson("/api/v1/users/{$user->id}");

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'User fetched successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

it('returns 404 when user does not exist', function () {

    actingAsUser();

    $response = $this->getJson('/api/v1/users/999999');

    $response->assertNotFound();
});

it('requires authentication', function () {

    $user = User::factory()->create();

    $response = $this->getJson("/api/v1/users/{$user->id}");

    $response->assertUnauthorized();
});
