<?php

namespace App\Actions\Booking;

use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\ServiceServiceInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AddServiceToBookingAction
{
    public function __construct(
        private readonly RoomMapRepositoryInterface $roomMapRepository,
        private readonly ServiceServiceInterface $serviceService
    ) {}

    public function execute(int $roomId, int $serviceId, int $quantity): void
    {
        $room = $this->roomMapRepository->findRoomById($roomId);
        $latestBookingDetail = $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId);
        $booking = $latestBookingDetail?->booking;
        $service = $this->serviceService->findById($serviceId);

        if (! $room || ! $latestBookingDetail || ! $booking) {
            throw new RuntimeException('Không tìm thấy booking detail để thêm dịch vụ.');
        }

        if (! $service) {
            throw new RuntimeException('Dịch vụ không tồn tại.');
        }

        $qty = max(1, $quantity);
        $unitPrice = (float) ($service->unit_price ?? 0);
        $lineTotal = $qty * $unitPrice;

        DB::transaction(function () use ($latestBookingDetail, $serviceId, $qty, $unitPrice, $booking, $lineTotal) {
            $this->roomMapRepository->createServiceUsage([
                'booking_detail_id' => $latestBookingDetail->id,
                'service_id' => $serviceId,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
            ]);

            $this->roomMapRepository->incrementServiceAmounts($booking->id, $latestBookingDetail->id, $lineTotal);
        });
    }
}
