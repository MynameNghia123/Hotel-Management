<?php

namespace App\Actions\Booking;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CheckoutAction
{
    public function __construct(
        private readonly RoomMapRepositoryInterface $roomMapRepository
    ) {}

    public function execute(int $roomId, array $selectedRoomIds, string $pricingMode): array
    {
        $latestBookingDetail = $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId);
        $booking = $latestBookingDetail?->booking;

        if (! $booking) {
            throw new RuntimeException('Không tìm thấy booking để thanh toán.');
        }

        $currentStatus = BookingStatus::tryFrom((string) $booking->status);
        if (! $currentStatus || ! $currentStatus->canTransitionTo(BookingStatus::PAID)) {
            $statusLabel = $currentStatus?->label() ?? (string) $booking->status;
            throw new RuntimeException("Chỉ booking ở trạng thái Đang ở mới được thanh toán. Trạng thái hiện tại: {$statusLabel}.");
        }

        $bookingRoomIds = collect($booking->bookingDetails ?? [])->pluck('room_id')->map(fn ($id) => (int) $id)->all();
        $targetRoomIds = collect($selectedRoomIds)
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => in_array($id, $bookingRoomIds, true))
            ->unique()
            ->values()
            ->all();

        if (empty($targetRoomIds)) {
            throw new RuntimeException('Vui lòng chọn ít nhất một phòng thuộc booking để thanh toán.');
        }

        if (! $booking->checked_in_at) {
            if ((string) $booking->status === BookingStatus::OCCUPIED->value) {
                $fallbackCheckInAt = $latestBookingDetail?->checkin_date ?? $booking->booking_date ?? now();
                $this->roomMapRepository->updateBookingCheckInAt((int) $booking->id, $fallbackCheckInAt);
                $booking->checked_in_at = $fallbackCheckInAt;
            } else {
                throw new RuntimeException('Booking chưa xác nhận check-in, chưa thể thanh toán checkout.');
            }
        }

        $normalizedPricingMode = $pricingMode === 'daily' ? 'daily' : 'hourly';
        $billingEndAt = now();
        $billingStartAt = Carbon::parse($booking->checked_in_at);

        if ($billingEndAt->lt($billingStartAt)) {
            throw new RuntimeException('Thời gian checkout không hợp lệ so với thời điểm check-in.');
        }

        return DB::transaction(function () use ($booking, $targetRoomIds, $normalizedPricingMode, $billingStartAt, $billingEndAt) {
            $result = $this->roomMapRepository->checkoutBookingRooms(
                (int) $booking->id,
                $targetRoomIds,
                $normalizedPricingMode,
                $billingStartAt,
                $billingEndAt
            );

            foreach ($result['processed_room_ids'] as $processedRoomId) {
                $this->roomMapRepository->updateRoomStatusById((int) $processedRoomId, RoomStatus::EMPTY->value);
            }

            return $result;
        });
    }
}
