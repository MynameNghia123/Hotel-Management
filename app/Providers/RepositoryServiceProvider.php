<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\StaffRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentStaffRepository::class
        );

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
            \App\Repositories\Contracts\CustomerRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentCustomerRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\AmenityRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentAmenityRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\EquipmentRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentEquipmentRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\EquipmentCategoryRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentEquipmentCategoryRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\ServiceGroupRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentServiceGroupRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\ServiceRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentServiceRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\FloorRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentFloorRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\BookingRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentBookingRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\BookingDetailRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentBookingDetailRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\RoomMapRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentRoomMapRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\RepairTicketRepositoryInterface::class,
            \App\Repositories\Implementations\EloquentRepairTicketRepository::class
        );
    }
}
