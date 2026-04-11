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
            \App\Repositories\Contracts\RoomTypeRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentRoomTypeRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\RoomRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentRoomRepository::class
        );
        $this->app->bind(
            \App\Services\Contracts\RoleServiceInterface::class,
            \App\Services\Implementations\RoleService::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\CustomerRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentCustomerRepository::class
        );

        $this->app->bind(
            \App\Services\Contracts\CustomerServiceInterface::class,
            \App\Services\Implementations\CustomerService::class
        );

        $this->app->bind(
            \App\Services\Contracts\RoleClaimServiceInterface::class,
            \App\Services\Implementations\RoleClaimService::class
        );

        $this->app->bind(
            \App\Services\Contracts\RoomTypeServiceInterface::class,
            \App\Services\Implementations\RoomTypeService::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\AmenityRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentAmenityRepository::class
        );

        $this->app->bind(
            \App\Services\Contracts\AmenityServiceInterface::class,
            \App\Services\Implementations\AmenityService::class
        );
    }
}