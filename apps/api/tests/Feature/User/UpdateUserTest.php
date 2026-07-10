<?php

use App\Models\User;

it('can update a user', function () {

    actingAsUser();

    $user = User::factory()->create();

    $response = $this->putJson("/api/v1/users/{$user->id}", [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('data.name', 'Updated Name');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
    ]);
});

it('returns 404 when updating unknown user', function () {

    actingAsUser();

    $response = $this->putJson('/api/v1/users/999999', [
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);

    $response->assertNotFound();
});
