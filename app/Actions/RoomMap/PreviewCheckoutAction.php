<?php

namespace App\Actions\RoomMap;

use App\Enums\BookingStatus;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use Carbon\Carbon;

class PreviewCheckoutAction
{
    private const VAT_RATE = 0.1;
    private const MINUTES_IN_DAY = 1440;
    private const MINUTES_IN_HOUR = 60;

    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
    ) {}

    public function execute(int $roomId, array $selectedRoomIds, string $pricingMode): array
    {
        $latestBookingDetail = $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId);
        $booking = $latestBookingDetail?->booking;

        if (!$booking) {
            throw new \RuntimeException('Không tìm thấy booking để tạm tính thanh toán.');
        }

        $this->validateBookingStatus($booking);
        
        $bookingRoomIds = collect($booking->bookingDetails ?? [])->pluck('room_id')->map(fn ($id) => (int) $id)->all();
        $targetRoomIds = $this->filterTargetRoomIds($selectedRoomIds, $bookingRoomIds);

        if ($targetRoomIds->isEmpty()) {
            return $this->emptyCheckoutPreview($pricingMode);
        }

        $checkedInAt = $this->getCheckedInTime($booking, $latestBookingDetail);
        $normalizedPricingMode = $pricingMode === 'daily' ? 'daily' : 'hourly';
        $billingStartAt = Carbon::parse($checkedInAt);
        $billingEndAt = now();

        if ($billingEndAt->lt($billingStartAt)) {
            throw new \RuntimeException('Thời gian checkout không hợp lệ so với thời điểm check-in.');
        }

        $minutes = max(1, $billingEndAt->diffInMinutes($billingStartAt, true));
        $pricingUnits = $normalizedPricingMode === 'daily'
            ? max(1, (int) ceil($minutes / self::MINUTES_IN_DAY))
            : max(1, (int) ceil($minutes / self::MINUTES_IN_HOUR));

        $rooms = $this->buildCheckoutRooms($booking, $targetRoomIds, $normalizedPricingMode, $pricingUnits, $billingEndAt);
        $totals = $this->calculateCheckoutTotals($rooms);

        return [
            'pricing_mode' => $normalizedPricingMode,
            'pricing_units' => $pricingUnits,
            'billing_start_at' => $this->formatDateTime($billingStartAt),
            'billing_end_at' => $this->formatDateTime($billingEndAt),
            'rooms' => $rooms->values()->all(),
            'totals' => $totals,
        ];
    }

    private function validateBookingStatus($booking): void
    {
        $currentStatus = BookingStatus::tryFrom((string) $booking->status);
        if (!$currentStatus || !$currentStatus->canTransitionTo(BookingStatus::PAID)) {
            $statusLabel = $currentStatus?->label() ?? (string) $booking->status;
            throw new \RuntimeException("Chỉ booking ở trạng thái Đang ở mới được tạm tính thanh toán. Trạng thái hiện tại: {$statusLabel}.");
        }
    }

    private function filterTargetRoomIds($selectedRoomIds, $bookingRoomIds)
    {
        return collect($selectedRoomIds)
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => in_array($id, $bookingRoomIds, true))
            ->unique()
            ->values();
    }

    private function getCheckedInTime($booking, $latestBookingDetail): string
    {
        if ($booking->checked_in_at) {
            return $booking->checked_in_at;
        }

        if ((string) $booking->status === BookingStatus::OCCUPIED->value) {
            return $latestBookingDetail?->checkin_date ?? $booking->booking_date ?? now();
        }

        throw new \RuntimeException('Booking chưa xác nhận check-in, chưa thể tạm tính checkout.');
    }

    private function buildCheckoutRooms($booking, $targetRoomIds, $normalizedPricingMode, $pricingUnits, $billingEndAt)
    {
        return collect($booking->bookingDetails ?? [])
            ->filter(function ($detail) use ($targetRoomIds) {
                return $targetRoomIds->contains((int) ($detail->room_id ?? 0))
                    && (string) ($detail->payment_status ?? 'unpaid') !== 'paid';
            })
            ->values()
            ->map(function ($detail) use ($normalizedPricingMode, $pricingUnits, $billingEndAt) {
                $detailRoom = $detail->room;
                $unitPrice = $normalizedPricingMode === 'daily'
                    ? (float) ($detail->daily_price ?? $detailRoom?->roomType->daily_price ?? 0)
                    : (float) ($detail->hourly_price ?? $detailRoom?->roomType->hourly_price ?? 0);

                $roomAmount = $pricingUnits * $unitPrice;
                $earlyCheckoutSurcharge = $this->calculateEarlyCheckoutSurcharge($detail, $detailRoom, $billingEndAt);
                $serviceAmount = (float) ($detail->service_amount ?? 0);
                $surchargeAmount = (float) ($detail->surcharge_amount ?? 0) + $earlyCheckoutSurcharge;

                return [
                    'room_id' => (int) ($detail->room_id ?? 0),
                    'room_name' => $detailRoom?->name ?? '--',
                    'room_type_name' => $detailRoom?->roomType->name ?? 'N/A',
                    'unit_price' => $unitPrice,
                    'pricing_mode' => $normalizedPricingMode,
                    'pricing_units' => $pricingUnits,
                    'room_amount' => $roomAmount,
                    'service_amount' => $serviceAmount,
                    'surcharge_amount' => $surchargeAmount,
                    'early_checkout_surcharge' => $earlyCheckoutSurcharge,
                    'line_total' => $roomAmount + $serviceAmount + $surchargeAmount,
                ];
            });
    }

    private function calculateEarlyCheckoutSurcharge($detail, $detailRoom, $billingEndAt): float
    {
        if (!$detail->checkout_date) {
            return 0.0;
        }

        $plannedCheckoutAt = Carbon::parse($detail->checkout_date);
        if ($billingEndAt->lt($plannedCheckoutAt)) {
            return (float) ($detail->hourly_price ?? $detailRoom?->roomType->hourly_price ?? 0);
        }

        return 0.0;
    }

    private function calculateCheckoutTotals($rooms): array
    {
        $roomAmount = (float) $rooms->sum('room_amount');
        $serviceAmount = (float) $rooms->sum('service_amount');
        $surchargeAmount = (float) $rooms->sum('surcharge_amount');
        $subtotal = $roomAmount + $serviceAmount + $surchargeAmount;
        $vatAmount = $subtotal * self::VAT_RATE;

        return [
            'room_amount' => $roomAmount,
            'service_amount' => $serviceAmount,
            'surcharge_amount' => $surchargeAmount,
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'grand_total' => $subtotal + $vatAmount,
        ];
    }

    private function emptyCheckoutPreview(string $pricingMode): array
    {
        $normalizedPricingMode = $pricingMode === 'daily' ? 'daily' : 'hourly';

        return [
            'pricing_mode' => $normalizedPricingMode,
            'pricing_units' => 0,
            'billing_start_at' => null,
            'billing_end_at' => null,
            'rooms' => [],
            'totals' => [
                'room_amount' => 0,
                'service_amount' => 0,
                'surcharge_amount' => 0,
                'subtotal' => 0,
                'vat_amount' => 0,
                'grand_total' => 0,
            ],
        ];
    }

    private function formatDateTime($dateTimeValue): ?string
    {
        if (!$dateTimeValue) {
            return null;
        }

        return $dateTimeValue->format('d/m/Y H:i');
    }
}
