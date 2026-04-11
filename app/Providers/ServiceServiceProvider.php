<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Services\Contracts\RoleServiceInterface::class,
            \App\Services\Implementations\RoleService::class
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
            \App\Services\Contracts\AmenityServiceInterface::class,
            \App\Services\Implementations\AmenityService::class
        );

        $this->app->bind(
            \App\Services\Contracts\StaffServiceInterface::class,
            \App\Services\Implementations\StaffService::class
        );
    }
}
