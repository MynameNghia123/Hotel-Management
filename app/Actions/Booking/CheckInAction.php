<?php

namespace App\Actions\Booking;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CheckInAction
{
    public function __construct(
        private readonly RoomMapRepositoryInterface $roomMapRepository
    ) {}

    public function execute(int $roomId): void
    {
        $room = $this->roomMapRepository->findRoomById($roomId);
        $latestBookingDetail = $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId);
        $booking = $latestBookingDetail?->booking;

        if (! $room || ! $booking) {
            throw new RuntimeException('Không tìm thấy booking để check-in.');
        }

        DB::transaction(function () use ($roomId, $booking) {
            $this->roomMapRepository->updateBookingStatusById($booking->id, BookingStatus::OCCUPIED->value);
            if (! $booking->checked_in_at) {
                $this->roomMapRepository->updateBookingCheckInAt($booking->id, now());
            }

            $bookingDetailRoomIds = $this->roomMapRepository->getBookingRoomIds((int) $booking->id);

            if ($bookingDetailRoomIds->isEmpty()) {
                $this->roomMapRepository->updateRoomStatusById($roomId, RoomStatus::OCCUPIED->value);

                return;
            }

            foreach ($bookingDetailRoomIds as $bookingRoomId) {
                $this->roomMapRepository->updateRoomStatusById((int) $bookingRoomId, RoomStatus::OCCUPIED->value);
            }
        });
    }
}
