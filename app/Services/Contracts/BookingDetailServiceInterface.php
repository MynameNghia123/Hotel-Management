<?php

namespace App\Services\Contracts;

interface BookingDetailServiceInterface extends BaseServiceInterface
{
    /**
     * Get details by booking ID
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
