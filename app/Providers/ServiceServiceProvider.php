<?php

namespace App\Providers;

use App\Services\Contracts\AmenityServiceInterface;
use App\Services\Contracts\BookingDetailServiceInterface;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\ClientBookingServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\EquipmentCategoryServiceInterface;
use App\Services\Contracts\EquipmentServiceInterface;
use App\Services\Contracts\FloorServiceInterface;
use App\Services\Contracts\HomeServiceInterface;
use App\Services\Contracts\RepairTicketServiceInterface;
use App\Services\Contracts\RoleClaimServiceInterface;
use App\Services\Contracts\RoleServiceInterface;
use App\Services\Contracts\RoomMapServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Services\Contracts\RoomTypeImageServiceInterface;
use App\Services\Contracts\RoomTypeServiceInterface;
use App\Services\Contracts\SearchServiceInterface;
use App\Services\Contracts\ServiceGroupServiceInterface;
use App\Services\Contracts\ServiceServiceInterface;
use App\Services\Contracts\StaffServiceInterface;
use App\Services\Contracts\StatisticalServiceInterface;
use App\Services\Contracts\SurchargePolicyServiceInterface;
use App\Services\Contracts\SystemSettingServiceInterface;
use App\Services\Implementations\AmenityService;
use App\Services\Implementations\BookingDetailService;
use App\Services\Implementations\BookingService;
use App\Services\Implementations\ClientBookingService;
use App\Services\Implementations\CustomerService;
use App\Services\Implementations\EquipmentCategoryService;
use App\Services\Implementations\EquipmentService;
use App\Services\Implementations\FloorService;
use App\Services\Implementations\HomeService;
use App\Services\Implementations\RepairTicketService;
use App\Services\Implementations\RoleClaimService;
use App\Services\Implementations\RoleService;
use App\Services\Implementations\RoomMapService;
use App\Services\Implementations\RoomService;
use App\Services\Implementations\RoomTypeImageService;
use App\Services\Implementations\RoomTypeService;
use App\Services\Implementations\SearchService;
use App\Services\Implementations\ServiceGroupService;
use App\Services\Implementations\ServiceService;
use App\Services\Implementations\StaffService;
use App\Services\Implementations\StatisticalService;
use App\Services\Implementations\SurchargePolicyService;
use App\Services\Implementations\SystemSettingService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RoleServiceInterface::class,
            RoleService::class
        );

        $this->app->bind(
            CustomerServiceInterface::class,
            CustomerService::class
        );

        $this->app->bind(
            RoleClaimServiceInterface::class,
            RoleClaimService::class
        );

        $this->app->bind(
            RoomTypeServiceInterface::class,
            RoomTypeService::class
        );

        $this->app->bind(
            AmenityServiceInterface::class,
            AmenityService::class
        );

        $this->app->bind(
            StaffServiceInterface::class,
            StaffService::class
        );

        $this->app->bind(
            EquipmentServiceInterface::class,
            EquipmentService::class
        );

        $this->app->bind(
            EquipmentCategoryServiceInterface::class,
            EquipmentCategoryService::class
        );
        $this->app->bind(
            ServiceServiceInterface::class,
            ServiceService::class
        );
        $this->app->bind(
            ServiceGroupServiceInterface::class,
            ServiceGroupService::class
        );

        $this->app->bind(
            FloorServiceInterface::class,
            FloorService::class
        );

        $this->app->bind(
            RoomServiceInterface::class,
            RoomService::class
        );

        $this->app->bind(
            RoomTypeImageServiceInterface::class,
            RoomTypeImageService::class
        );

        $this->app->bind(
            RoomMapServiceInterface::class,
            RoomMapService::class
        );

        $this->app->bind(
            BookingServiceInterface::class,
            BookingService::class
        );

        $this->app->bind(
            BookingDetailServiceInterface::class,
            BookingDetailService::class
        );

        $this->app->bind(
            RepairTicketServiceInterface::class,
            RepairTicketService::class
        );

        $this->app->bind(
            SystemSettingServiceInterface::class,
            SystemSettingService::class
        );

        $this->app->bind(
            SurchargePolicyServiceInterface::class,
            SurchargePolicyService::class
        );

        $this->app->bind(
            StatisticalServiceInterface::class,
            StatisticalService::class
        );

        $this->app->bind(
            HomeServiceInterface::class,
            HomeService::class
        );

        $this->app->bind(
            SearchServiceInterface::class,
            SearchService::class
        );

        $this->app->bind(
            ClientBookingServiceInterface::class,
            ClientBookingService::class
        );
    }
}
