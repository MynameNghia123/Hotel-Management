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

        $this->app->bind(
            \App\Services\Contracts\RoomTypeImageServiceInterface::class,
            \App\Services\Implementations\RoomTypeImageService::class
        );

        $this->app->bind(
            \App\Services\Contracts\RoomMapServiceInterface::class,
            \App\Services\Implementations\RoomMapService::class
        );

        $this->app->bind(
            \App\Services\Contracts\BookingServiceInterface::class,
            \App\Services\Implementations\BookingService::class
        );

        $this->app->bind(
            \App\Services\Contracts\BookingDetailServiceInterface::class,
            \App\Services\Implementations\BookingDetailService::class
        );

        $this->app->bind(
            \App\Services\Contracts\RepairTicketServiceInterface::class,
            \App\Services\Implementations\RepairTicketService::class
        );

        $this->app->bind(
            \App\Services\Contracts\SystemSettingServiceInterface::class,
            \App\Services\Implementations\SystemSettingService::class
        );

        $this->app->bind(
            \App\Services\Contracts\SurchargePolicyServiceInterface::class,
            \App\Services\Implementations\SurchargePolicyService::class
        );

        $this->app->bind(
            \App\Services\Contracts\StatisticalServiceInterface::class,
            \App\Services\Implementations\StatisticalService::class
        );

        $this->app->bind(
            \App\Services\Contracts\HomeServiceInterface::class,
            \App\Services\Implementations\HomeService::class
        );

        $this->app->bind(
            \App\Services\Contracts\SearchServiceInterface::class,
            \App\Services\Implementations\SearchService::class
        );
    }
}
