<?php

use App\Models\User;

it('can delete a user', function () {

    actingAsUser();

    $user = User::factory()->create();

    $response = $this->deleteJson("/api/v1/users/{$user->id}");

    $response->assertOk();

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

it('returns 404 when deleting unknown user', function () {

    actingAsUser();

    $response = $this->deleteJson('/api/v1/users/999999');

    $response->assertNotFound();
});
