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

        $this->app->bind(
            \App\Services\Contracts\EquipmentServiceInterface::class,
            \App\Services\Implementations\EquipmentService::class
        );

        $this->app->bind(
            \App\Services\Contracts\EquipmentCategoryServiceInterface::class,
            \App\Services\Implementations\EquipmentCategoryService::class
        );
        $this->app->bind(
            \App\Services\Contracts\ServiceServiceInterface::class,
            \App\Services\Implementations\ServiceService::class
        );
        $this->app->bind(
            \App\Services\Contracts\ServiceGroupServiceInterface::class,
            \App\Services\Implementations\ServiceGroupService::class
        );

        $this->app->bind(
            \App\Services\Contracts\FloorServiceInterface::class,
            \App\Services\Implementations\FloorService::class
        );

        $this->app->bind(
            \App\Services\Contracts\RoomServiceInterface::class,
            \App\Services\Implementations\RoomService::class
        );
    }
}
