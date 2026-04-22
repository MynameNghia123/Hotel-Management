<?php

namespace App\Services\Contracts;

interface BookingServiceInterface extends BaseServiceInterface
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
     * Check room availability for date range
     */
    public function checkRoomAvailability($roomId, $checkInDate, $checkOutDate);

    /**
     * Update booking status with validation
     */
    public function updateStatus($bookingId, $newStatus);

    /**
     * Get all statuses with their booking counts
     */
    public function getStatusCounts();

    /**
     * Prepare data for booking creation form
     */
    public function prepareDataForCreate();

    /**
     * Get booking details with related rooms
     */
    public function getBookingWithDetails($bookingId);
}
