<?php

namespace App\Actions;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Services\Contracts\BookingDetailServiceInterface;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateBookingAction
{
    public function __construct(
        private readonly BookingServiceInterface $bookingService,
        private readonly BookingDetailServiceInterface $bookingDetailService,
        private readonly CustomerServiceInterface $customerService,
        private readonly RoomServiceInterface $roomService
    ) {}

    /**
     * Create booking with customer and booking details.
     *
     * @param array $validated Validated request data
     * @return object Created booking
     * @throws \Exception
     */
    public function execute(array $validated)
    {
        return DB::transaction(function () use ($validated) {
            $customer = null;

            if ($validated['customer_id'] ?? null) {
                $customer = $this->customerService->findById($validated['customer_id']);

                if (!$customer) {
                    throw new \Exception('Khách hàng không tồn tại (id=' . $validated['customer_id'] . ')');
                }
            } elseif ($validated['customer_new_email'] ?? null) {
                $customer = $this->customerService->create([
                    'first_name' => $validated['customer_first_name'] ?? '',
                    'last_name' => $validated['customer_last_name'] ?? '',
                    'email' => $validated['customer_new_email'],
                    'phone_number' => $validated['customer_phone'] ?? null,
                    'country' => $validated['customer_country'] ?? null,
                ]);
            }

            if (!$customer) {
                throw new \Exception('Vui lòng xác thực email khách hàng');
            }

            $roomIds = array_values($validated['room_ids'] ?? []);

            if (count($roomIds) !== count(array_unique($roomIds))) {
                throw new \Exception('Danh sách phòng đang bị chọn trùng.');
            }

            foreach ($roomIds as $roomId) {
                $room = $this->roomService->findById($roomId);
                $roomIndex = array_search($roomId, $roomIds, true);
                // tìm kiếm room index trong mảng roomIds để lấy ngày checkin/checkout tương ứng
                
                $checkInDate = $validated['checkin_dates'][$roomIndex] ?? null;
                $checkOutDate = $validated['checkout_dates'][$roomIndex] ?? null;

                if (!$checkInDate || !$checkOutDate) {
                    throw new \Exception("Thiếu ngày nhận/trả phòng cho phòng {$room->name}.");
                }

                $availableRoomIds = $this->roomService->getAvailableRooms($checkInDate, $checkOutDate)
                    ->pluck('id')
                    ->map(fn ($id) => (int) $id)
                    ->all();

                if (!in_array((int) $roomId, $availableRoomIds, true)) {
                    throw new \Exception("Phòng {$room->name} đã có lịch trong khoảng ngày đã chọn. Vui lòng chọn phòng khác.");
                }
            }

            $booking = $this->bookingService->create([
                'customer_id' => $customer->id,
                'booking_date' => $validated['booking_date'],
                'staff_id' => $validated['staff_id'] ?? null,
                'total_service_amount' => $validated['total_service_amount'] ?? 0,
                'total_room_amount' => $validated['total_room_amount'] ?? 0,
                'surcharge_amount' => $validated['surcharge_amount'] ?? 0,
                'final_amount' => $validated['final_amount'] ?? 0,
                'status' => BookingStatus::PENDING->value,
            ]);

            foreach ($roomIds as $index => $roomId) {
                $checkInDate = $validated['checkin_dates'][$index] ?? now();

                $this->bookingDetailService->create([
                    'booking_id' => $booking->id,
                    'room_id' => $roomId,
                    'checkin_date' => $checkInDate,
                    'checkout_date' => $validated['checkout_dates'][$index] ?? now()->addDay(),
                    'hourly_price' => $validated['hourly_prices'][$index] ?? 0,
                    'daily_price' => $validated['daily_prices'][$index] ?? 0,
                    'room_amount' => 0,
                    'service_amount' => 0,
                    'surcharge_amount' => 0,
                    'payment_status' => 'unpaid',
                    'paid_at' => null,
                ]);

                // Booking mới luôn ở trạng thái pending (chưa xác nhận) nên hiển thị "Đã đặt".
                $roomStatus = RoomStatus::BOOKED->value;

                $this->roomService->update($roomId, [
                    'status' => $roomStatus,
                ]);
            }

            return $booking;
        });
    }
}
