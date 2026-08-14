<?php

namespace App\Providers;

use App\Repositories\Contracts\AmenityRepositoryInterface;
use App\Repositories\Contracts\BookingDetailRepositoryInterface;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\ClientBookingRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\EquipmentCategoryRepositoryInterface;
use App\Repositories\Contracts\EquipmentRepositoryInterface;
use App\Repositories\Contracts\FloorRepositoryInterface;
use App\Repositories\Contracts\HomeRepositoryInterface;
use App\Repositories\Contracts\RepairTicketRepositoryInterface;
use App\Repositories\Contracts\RoleClaimRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Repositories\Contracts\RoomTypeRepositoryInterface;
use App\Repositories\Contracts\SearchRepositoryInterface;
use App\Repositories\Contracts\ServiceGroupRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Repositories\Contracts\StaffRepositoryInterface;
use App\Repositories\Contracts\StatisticalRepositoryInterface;
use App\Repositories\Contracts\SurchargePolicyRepositoryInterface;
use App\Repositories\Contracts\SystemSettingRepositoryInterface;
use App\Repositories\Implementations\EloquentAmenityRepository;
use App\Repositories\Implementations\EloquentBookingDetailRepository;
use App\Repositories\Implementations\EloquentBookingRepository;
use App\Repositories\Implementations\EloquentClientBookingRepository;
use App\Repositories\Implementations\EloquentCustomerRepository;
use App\Repositories\Implementations\EloquentEquipmentCategoryRepository;
use App\Repositories\Implementations\EloquentEquipmentRepository;
use App\Repositories\Implementations\EloquentFloorRepository;
use App\Repositories\Implementations\EloquentHomeRepository;
use App\Repositories\Implementations\EloquentRepairTicketRepository;
use App\Repositories\Implementations\EloquentRoleClaimRepository;
use App\Repositories\Implementations\EloquentRoleRepository;
use App\Repositories\Implementations\EloquentRoomMapRepository;
use App\Repositories\Implementations\EloquentRoomRepository;
use App\Repositories\Implementations\EloquentRoomTypeRepository;
use App\Repositories\Implementations\EloquentSearchRepository;
use App\Repositories\Implementations\EloquentServiceGroupRepository;
use App\Repositories\Implementations\EloquentServiceRepository;
use App\Repositories\Implementations\EloquentStaffRepository;
use App\Repositories\Implementations\EloquentStatisticalRepository;
use App\Repositories\Implementations\EloquentSurchargePolicyRepository;
use App\Repositories\Implementations\EloquentSystemSettingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            StaffRepositoryInterface::class,
            EloquentStaffRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            EloquentRoleRepository::class
        );

        $this->app->bind(
            RoleClaimRepositoryInterface::class,
            EloquentRoleClaimRepository::class
        );

        $this->app->bind(
            RoomTypeRepositoryInterface::class,
            EloquentRoomTypeRepository::class
        );

        $this->app->bind(
            RoomRepositoryInterface::class,
            EloquentRoomRepository::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            EloquentCustomerRepository::class
        );

        $this->app->bind(
            AmenityRepositoryInterface::class,
            EloquentAmenityRepository::class
        );

        $this->app->bind(
            EquipmentRepositoryInterface::class,
            EloquentEquipmentRepository::class
        );

        $this->app->bind(
            EquipmentCategoryRepositoryInterface::class,
            EloquentEquipmentCategoryRepository::class
        );
        $this->app->bind(
            ServiceGroupRepositoryInterface::class,
            EloquentServiceGroupRepository::class
        );
        $this->app->bind(
            ServiceRepositoryInterface::class,
            EloquentServiceRepository::class
        );

        $this->app->bind(
            FloorRepositoryInterface::class,
            EloquentFloorRepository::class
        );

        $this->app->bind(
            BookingRepositoryInterface::class,
            EloquentBookingRepository::class
        );

        $this->app->bind(
            BookingDetailRepositoryInterface::class,
            EloquentBookingDetailRepository::class
        );

        $this->app->bind(
            RoomMapRepositoryInterface::class,
            EloquentRoomMapRepository::class
        );

        $this->app->bind(
            RepairTicketRepositoryInterface::class,
            EloquentRepairTicketRepository::class
        );

        $this->app->bind(
            SystemSettingRepositoryInterface::class,
            EloquentSystemSettingRepository::class
        );

        $this->app->bind(
            SurchargePolicyRepositoryInterface::class,
            EloquentSurchargePolicyRepository::class
        );

        $this->app->bind(
            StatisticalRepositoryInterface::class,
            EloquentStatisticalRepository::class
        );

        $this->app->bind(
            HomeRepositoryInterface::class,
            EloquentHomeRepository::class
        );

        $this->app->bind(
            SearchRepositoryInterface::class,
            EloquentSearchRepository::class
        );

        $this->app->bind(
            ClientBookingRepositoryInterface::class,
            EloquentClientBookingRepository::class
        );
    }
}
