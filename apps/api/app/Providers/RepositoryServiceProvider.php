<?php

namespace App\Providers;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
    }
}
