<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(
    TestCase::class,
    RefreshDatabase::class
)->in('Feature');

require_once __DIR__.'/Helpers/Auth.php';
