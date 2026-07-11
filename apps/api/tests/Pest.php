<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
)->in('Feature');

require_once __DIR__ . '/Helpers/Auth.php';
