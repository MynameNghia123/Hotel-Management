<?php

namespace App\Services\Implementations;

use App\Enums\BookingStatus;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\StaffServiceInterface;
use App\Services\Contracts\BookingDetailServiceInterface;

class BookingService implements BookingServiceInterface
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
        private readonly RoomServiceInterface $roomService,
        private readonly CustomerServiceInterface $customerService,
        private readonly StaffServiceInterface $staffService,
        private readonly BookingDetailServiceInterface $bookingDetailService
    ) {}

    public function getAll()
    {
        return $this->bookingRepository->getAll();
    }

    public function create(array $data)
    {
        // Set default status as PENDING if not provided
        if (!isset($data['status'])) {
            $data['status'] = BookingStatus::PENDING->value;
        }
        return $this->bookingRepository->create($data);
    }

    public function findById($id)
    {
        return $this->bookingRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->bookingRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->bookingRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->bookingRepository->getPaginated($filters, $perPage);
    }

    public function getByStatus($status)
    {
        return $this->bookingRepository->getByStatus($status);
    }

    public function getByCustomerId($customerId)
    {
        return $this->bookingRepository->getByCustomerId($customerId);
    }

    public function checkRoomAvailability($roomId, $checkInDate, $checkOutDate)
    {
        return $this->bookingRepository->checkRoomAvailability($roomId, $checkInDate, $checkOutDate);
    }

    public function updateStatus($bookingId, $newStatus)
    {
        $booking = $this->findById($bookingId);
        $currentStatus = BookingStatus::from($booking->status);

        // Validate transition
        if (!$currentStatus->canTransitionTo($newStatus)) {
            throw new \Exception(
                "Cannot transition from {$currentStatus->label()} to {$newStatus->label()}"
            );
        }

        return $this->bookingRepository->updateStatus($bookingId, $newStatus->value);
    }

    public function getWithFilter(array $filters = [], $perPage = 10)
    {
        return $this->bookingRepository->getWithRooms($filters, $perPage);
    }

    public function getStatusCounts()
    {
        $statusCounts = [];
        foreach (BookingStatus::cases() as $status) {
            $statusCounts[$status->value] = count($this->getByStatus($status->value) ?? []);
        }
        return $statusCounts;
    }

    /**
     * Prepare data needed for booking creation form
     */
    public function prepareDataForCreate()
    {
        return [
            'rooms' => $this->roomService->getAll(),
            'customers' => $this->customerService->getAll(),
            'staffs' => $this->staffService->getAll(),
        ];
    }

    /**
     * Get booking with all related details
     */
    public function getBookingWithDetails($bookingId)
    {
        return [
            'booking' => $this->findById($bookingId),
            'bookingDetails' => $this->bookingDetailService->getWithRooms($bookingId),
            'statuses' => BookingStatus::cases(),
        ];
    }
}
