<?php

namespace App\Services;

use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Services\Contracts\BookingServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BookingService implements BookingServiceInterface
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
        private readonly RoomRepositoryInterface $roomRepository,
    ) {}

    /**
     * Lấy tất cả bookings (có phân trang).
     */
    public function getAllBookings(int $perPage = 15): LengthAwarePaginator
    {
        return $this->bookingRepository->allWithPagination($perPage);d
    }

    /**
     * Lấy chi tiết một booking theo ID.
     */
    public function getBookingById(int $id): Model
    {
        return $this->bookingRepository->findById($id, relations: ['room', 'customer']);
    }

    /**
     * Tạo booking mới sau khi đã kiểm tra tính hợp lệ và availability.
     *
     * @throws \Exception Nếu phòng đã bị đặt trong khoảng thời gian này.
     */
    public function createBooking(array $data): Model
    {
        if (!$this->checkRoomAvailability($data['room_id'], $data['check_in'], $data['check_out'])) {
            throw new \Exception('Phòng không còn trống trong khoảng thời gian đã chọn.');
        }

        return DB::transaction(function () use ($data) {
            $booking = $this->bookingRepository->create($data);
            $this->roomRepository->updateStatus($data['room_id'], 'occupied');
            return $booking;
        });
    }

    /**
     * Cập nhật thông tin một booking.
     */
    public function updateBooking(int $id, array $data): bool
    {
        return $this->bookingRepository->update($id, $data);
    }

    /**
     * Hủy một booking.
     */
    public function cancelBooking(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $booking = $this->bookingRepository->findById($id);
            $result = $this->bookingRepository->updateStatus($id, 'cancelled');

            if ($result) {
                $this->roomRepository->updateStatus($booking->room_id, 'available');
            }

            return $result;
        });
    }

    /**
     * Check-in: Chuyển trạng thái booking sang 'checked_in'.
     */
    public function checkIn(int $bookingId): bool
    {
        return $this->bookingRepository->updateStatus($bookingId, 'checked_in');
    }

    /**
     * Check-out: Chuyển trạng thái booking sang 'checked_out' và giải phóng phòng.
     */
    public function checkOut(int $bookingId): bool
    {
        return DB::transaction(function () use ($bookingId) {
            $booking = $this->bookingRepository->findById($bookingId);
            $result = $this->bookingRepository->updateStatus($bookingId, 'checked_out');

            if ($result) {
                $this->roomRepository->updateStatus($booking->room_id, 'available');
            }

            return $result;
        });
    }

    /**
     * Lấy bookings của một khách hàng cụ thể.
     */
    public function getBookingsByCustomer(int $customerId): Collection
    {
        return $this->bookingRepository->getBookingsByCustomer($customerId);
    }

    /**
     * Lấy bookings sắp đến với phân trang.
     */
    public function getUpcomingBookings(int $perPage = 15): LengthAwarePaginator
    {
        return $this->bookingRepository->getUpcomingBookings($perPage);
    }

    /**
     * Lấy doanh thu trong khoảng thời gian.
     * Trả về: ['total_revenue' => float, 'start_date' => string, 'end_date' => string]
     */
    public function getRevenueReport(string $startDate, string $endDate): array
    {
        $totalRevenue = $this->bookingRepository->getTotalRevenueByDateRange($startDate, $endDate);

        return [
            'total_revenue' => $totalRevenue,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
        ];
    }

    /**
     * Kiểm tra phòng có trống trong khoảng thời gian không.
     */
    public function checkRoomAvailability(int $roomId, string $checkIn, string $checkOut, ?int $excludeBookingId = null): bool
    {
        return $this->bookingRepository->isRoomAvailable($roomId, $checkIn, $checkOut, $excludeBookingId);
    }
}
