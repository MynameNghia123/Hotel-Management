<?php

namespace App\Actions\Booking;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CancelBookingAction
{
    public function __construct(
        private readonly RoomMapRepositoryInterface $roomMapRepository
    ) {}

    public function execute(int $roomId): void
    {
        $room = $this->roomMapRepository->findRoomById($roomId);
        $latestBookingDetail = $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId);
        $booking = $latestBookingDetail?->booking;

        if (!$room || !$booking) {
            throw new RuntimeException('Không tìm thấy booking để hủy.');
        }

        $currentStatus = BookingStatus::tryFrom((string) $booking->status);
        if (!$currentStatus || !$currentStatus->canTransitionTo(BookingStatus::CANCELLED)) {
            $statusLabel = $currentStatus?->label() ?? (string) $booking->status;
            throw new RuntimeException("Không thể hủy booking ở trạng thái {$statusLabel}.");
        }

        DB::transaction(function () use ($roomId, $booking) {
            $this->roomMapRepository->updateBookingStatusById($booking->id, BookingStatus::CANCELLED->value);
            $bookingDetailRoomIds = $this->roomMapRepository->getBookingRoomIds((int) $booking->id);

            if ($bookingDetailRoomIds->isEmpty()) {
                $this->roomMapRepository->updateRoomStatusById($roomId, RoomStatus::EMPTY->value);
                return;
            }

            foreach ($bookingDetailRoomIds as $bookingRoomId) {
                $this->roomMapRepository->updateRoomStatusById((int) $bookingRoomId, RoomStatus::EMPTY->value);
            }
        });
    }
}
