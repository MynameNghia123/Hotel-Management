<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\RoleRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentRoleRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\RoleClaimRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentRoleClaimRepository::class
        );
        $this->app->bind(
            \App\Services\Contracts\RoleServiceInterface::class,
            \App\Services\Implementations\RoleService::class
        );
    }
}