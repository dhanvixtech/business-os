<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(
    Tests\TestCase::class,
   RefreshDatabase::class
)->in('Feature');

function actingAsUser(array $attributes = []): User
{
    $user = User::factory()->create($attributes);

    Sanctum::actingAs($user);

    return $user;
}
