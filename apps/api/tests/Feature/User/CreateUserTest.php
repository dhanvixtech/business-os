<?php

use App\Models\User;

it('can create a user', function () {

    actingAsUser();

    $response = $this->postJson('/api/v1/users', [
        'name' => 'Ganesh Kumar',
        'email' => 'ganesh@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.email', 'ganesh@example.com');

    $this->assertDatabaseHas('users', [
        'email' => 'ganesh@example.com',
    ]);
});

it('validates duplicate email', function () {

    actingAsUser();

    User::factory()->create([
        'email' => 'ganesh@example.com',
    ]);

    $response = $this->postJson('/api/v1/users', [
        'name' => 'Ganesh',
        'email' => 'ganesh@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

it('requires authentication', function () {

    $response = $this->postJson('/api/v1/users', []);

    $response->assertUnauthorized();
});
