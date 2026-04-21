<?php

namespace App\Repositories\Contracts;

interface BookingDetailRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get booking details by booking ID
     */
    public function getByBookingId($bookingId);

    /**
     * Create multiple booking details
     */
    public function createMultiple($bookingId, array $roomIds);

    /**
     * Get booking details with room info
     */
    public function getWithRooms($bookingId);
}
