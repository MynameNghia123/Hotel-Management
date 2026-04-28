<?php

namespace App\Actions\RoomMap;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Services\Contracts\RoomServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SyncRoomStatusAction
{
    public function __construct(
        protected RoomServiceInterface $roomService,
    ) {}

    public function execute(Collection $rooms): void
    {
        $now = now();

        foreach ($rooms as $room) {
            $currentRoomStatus = $room->status instanceof RoomStatus
                ? $room->status->value
                : (string) $room->status;

            if ($currentRoomStatus === RoomStatus::MAINTENANCE->value) {
                continue;
            }

            $nextStatus = $this->determineNextStatus($room, $now, $currentRoomStatus);

            if ($nextStatus && $currentRoomStatus !== $nextStatus) {
                $this->roomService->update($room->id, ['status' => $nextStatus]);
                $room->status = $nextStatus;
            }
        }
    }

    private function determineNextStatus($room, $now, $currentRoomStatus): ?string
    {
        $latestActiveDetail = $this->findLatestActiveBookingDetail($room, $now);

        if ($latestActiveDetail) {
            return $this->determineStatusFromActiveDetail($latestActiveDetail, $now);
        }

        if (in_array($currentRoomStatus, [RoomStatus::BOOKED->value, RoomStatus::CONFIRMED->value, RoomStatus::INCOMING->value], true)) {
            return RoomStatus::EMPTY->value;
        }

        return null;
    }

    private function findLatestActiveBookingDetail($room, $now)
    {
        return collect($room->bookingDetails ?? [])
            ->first(function ($detail) use ($now) {
                $bookingStatus = (string) ($detail->booking->status ?? '');

                if (in_array($bookingStatus, [BookingStatus::CANCELLED->value, BookingStatus::PAID->value], true)) {
                    return false;
                }

                return Carbon::parse($detail->checkout_date)->greaterThan($now);
            });
    }

    private function determineStatusFromActiveDetail($detail, $now): ?string
    {
        $bookingStatus = (string) ($detail->booking->status ?? '');
        $checkInAt = Carbon::parse($detail->checkin_date);
        $checkOutAt = Carbon::parse($detail->checkout_date);

        if ($bookingStatus === BookingStatus::PENDING->value) {
            return RoomStatus::BOOKED->value;
        }

        if ($bookingStatus === BookingStatus::CONFIRMED->value) {
            return RoomStatus::CONFIRMED->value;
        }

        if ($checkInAt->lessThanOrEqualTo($now) && $checkOutAt->greaterThan($now)) {
            return RoomStatus::OCCUPIED->value;
        }

        if ($checkInAt->greaterThan($now)) {
            return RoomStatus::INCOMING->value;
        }

        return null;
    }
}
