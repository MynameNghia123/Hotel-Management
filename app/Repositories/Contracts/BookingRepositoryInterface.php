<?php

namespace App\Repositories\Contracts;

interface BookingRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get bookings by status
     */
    public function getByStatus($status);

    /**
     * Get bookings by customer ID
     */
    public function getByCustomerId($customerId);

    /**
     * Get bookings with rooms (eager loaded)
     */
    public function getWithRooms(array $filters = [], $perPage = 10);

    /**
     * Check room availability for date range
     */
    public function checkRoomAvailability($roomId, $checkInDate, $checkOutDate);

    /**
     * Update booking status
     */
    public function updateStatus($id, $status);
}
