<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\RoomMapServiceInterface;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\FloorServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Services\Contracts\RoomTypeServiceInterface;

class RoomMapService implements RoomMapServiceInterface
{
    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
        protected RoomServiceInterface $roomService,
        protected FloorServiceInterface $floorService,
        protected RoomTypeServiceInterface $roomTypeService,
        protected CustomerServiceInterface $customerService,
        protected BookingServiceInterface $bookingService
    ) {}

    public function prepareDataForIndex(array $filters = []): array
    {
        return [
            'rooms'            => $this->roomMapRepository->getFilteredRooms($filters),
            'roomStatusCounts' => $this->roomMapRepository->getRoomStatusCounts($filters),
            'floors'           => $this->floorService->getAll(),
            'roomTypes'        => $this->roomTypeService->getAll(),
            'customers'        => $this->customerService->getAll(),
            'recentBookings'   => $this->bookingService->getPaginated([], 5),
            'filters'          => $filters,
        ];
    }

    public function prepareDataForDetail(?int $roomId): array
    {
        return [
            'roomId' => $roomId,
            'room' => $roomId ? $this->roomMapRepository->findRoomById($roomId) : null,
            'recentBookings' => $this->bookingService->getPaginated([], 10),
        ];
    }

    public function prepareDataForAvailableDetail(?int $roomId): array
    {
        return [
            'roomId' => $roomId,
            'room' => $roomId ? $this->roomMapRepository->findRoomById($roomId) : null,
            'roomTypes' => $this->roomTypeService->getAll(),
        ];
    }

    public function prepareDataForIncomingDetail(?int $roomId): array
    {
        return [
            'roomId' => $roomId,
            'room' => $roomId ? $this->roomMapRepository->findRoomById($roomId) : null,
            'incomingBookings' => $this->bookingService->getPaginated(['status' => 'pending'], 10),
        ];
    }

    public function prepareDataForInvoice(): array
    {
        return [
            'generatedAt' => now(),
            'bookingSummary' => $this->bookingService->getStatusCounts(),
        ];
    }
}
