<?php

namespace App\Actions;

use App\Enums\BookingStatus;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\BookingDetailServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;

class CreateBookingAction
{
    public function __construct(
        private readonly BookingServiceInterface $bookingService,
        private readonly BookingDetailServiceInterface $bookingDetailService,
        private readonly CustomerServiceInterface $customerService
    ) {}

    /**
     * Create booking with customer and booking details
     * 
     * @param array $validated Validated request data
     * @return object Created booking
     * @throws \Exception
     */
    public function execute(array $validated)
    {
        // Get or create customer
        $customer = null;
        
        // Case 1: Existing customer (verified via email)
        if ($validated['customer_id'] ?? null) {
            $customer = $this->customerService->findById($validated['customer_id']);
            if (!$customer) {
                throw new \Exception('Khách hàng không tồn tại (id=' . $validated['customer_id'] . ')');
            }
        } 
        // Case 2: New customer from form
        else if ($validated['customer_new_email'] ?? null) {
            $customer = $this->customerService->create([
                'first_name' => $validated['customer_first_name'] ?? '',
                'last_name'  => $validated['customer_last_name'] ?? '',
                'email'      => $validated['customer_new_email'],
                'phone_number' => $validated['customer_phone'] ?? null,
                'country'    => $validated['customer_country'] ?? null,
            ]);
        }

        if (!$customer) {
            throw new \Exception('Vui lòng xác thực email khách hàng');
        }
        // Create booking
        $bookingData = [
            'customer_id' => $customer->id,
            'booking_date' => $validated['booking_date'],
            'staff_id' => $validated['staff_id'] ?? null,
            'total_service_amount' => $validated['total_service_amount'] ?? 0,
            'total_room_amount' => $validated['total_room_amount'] ?? 0,
            'surcharge_amount' => $validated['surcharge_amount'] ?? 0,
            'final_amount' => $validated['final_amount'] ?? 0,
            'status' => BookingStatus::PENDING->value,
        ];
        $booking = $this->bookingService->create($bookingData);

        // Create booking details for each room
        $roomIds = $validated['room_ids'] ?? [];
        if (!empty($roomIds)) {
            foreach ($roomIds as $index => $roomId) {
                $this->bookingDetailService->create([
                    'booking_id' => $booking->id,
                    'room_id' => $roomId,
                    'checkin_date' => $validated['checkin_dates'][$index] ?? now(),
                    'checkout_date' => $validated['checkout_dates'][$index] ?? now()->addDay(),
                    'hourly_price' => $validated['hourly_prices'][$index] ?? 0,
                    'daily_price' => $validated['daily_prices'][$index] ?? 0,
                    'service_amount' => 0,
                    'surcharge_amount' => 0,
                ]);
            }
        }

        return $booking;
    }
}
