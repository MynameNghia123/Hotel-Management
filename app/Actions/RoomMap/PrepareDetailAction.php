<?php

namespace App\Actions\RoomMap;

use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\ServiceServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PrepareDetailAction
{
    private const VAT_RATE = 0.1;

    private const MINUTES_IN_DAY = 1440;

    private const MINUTES_IN_HOUR = 60;

    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
        protected ServiceServiceInterface $serviceService,
    ) {}

    public function execute(?int $roomId, array $filters = []): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $latestBookingDetail = $roomId ? $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId, $filters) : null;
        $booking = $latestBookingDetail?->booking;
        $customer = $booking?->customer;
        $customerName = $customer?->full_name ?: 'Khách lẻ';

        $billingAnchorAt = $this->calculateBillingAnchor($booking, $latestBookingDetail);
        $serviceCatalog = $this->buildServiceCatalog();
        $bookingRooms = $this->buildBookingRooms($booking, $latestBookingDetail, $roomId);

        if ($bookingRooms->isEmpty() && $room) {
            $bookingRooms = $this->buildFallbackBookingRoom($room, $latestBookingDetail, []);
        }

        $invoiceTotals = $this->calculateInvoiceTotals($bookingRooms);
        $serviceUsageHistory = $this->buildServiceUsageHistory($booking, $latestBookingDetail);
        $selectedRoomServiceUsageHistory = $this->buildSelectedRoomServiceUsageHistory($booking, $latestBookingDetail, $roomId);

        return [
            'roomId' => $roomId,
            'room' => $room,
            'booking' => $booking,
            'bookingDetail' => $latestBookingDetail,
            'bookingRooms' => $bookingRooms,
            'billingAnchorAt' => $billingAnchorAt->format('d/m/Y H:i'),
            'customerName' => $customerName,
            'invoiceTotals' => $invoiceTotals,
            'serviceCatalog' => $serviceCatalog,
            'serviceUsageHistory' => $serviceUsageHistory,
            'selectedRoomServiceUsageHistory' => $selectedRoomServiceUsageHistory,
        ];
    }

    private function calculateBillingAnchor($booking, $latestBookingDetail): Carbon
    {
        if ($booking?->checked_in_at) {
            return Carbon::parse($booking->checked_in_at);
        }

        $fallbackDate = $latestBookingDetail?->checkin_date ?? $booking?->booking_date ?? now();

        return Carbon::parse($fallbackDate);
    }

    private function buildServiceCatalog(): Collection
    {
        return $this->serviceService->getAll()->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'unit_price' => (float) ($service->unit_price ?? 0),
                'unit' => $service->unit ?? '',
            ];
        })->values();
    }

    private function buildBookingRooms($booking, $latestBookingDetail, ?int $roomId): Collection
    {
        $bookingDetails = collect($booking?->bookingDetails ?? []);

        return $bookingDetails->map(function ($detail) use ($roomId, $booking) {
            return $this->transformBookingDetail($detail, $roomId, $booking);
        })->filter(fn ($item) => ! empty($item['room_id']))->values();
    }

    private function transformBookingDetail($detail, ?int $roomId, $booking): array
    {
        $detailRoom = $detail->room;
        $roomTypeHourlyPrice = (float) ($detailRoom?->roomType->hourly_price ?? $detail->hourly_price ?? 0);
        $roomTypeDailyPrice = (float) ($detailRoom?->roomType->daily_price ?? $detail->daily_price ?? 0);

        $billingStartAt = $booking?->checked_in_at
            ? Carbon::parse($booking->checked_in_at)
            : Carbon::parse($detail->checkin_date ?? now());
        $billingEndAt = ($detail->payment_status ?? 'unpaid') === 'paid'
            ? Carbon::parse($detail->paid_at ?? $detail->checkout_date ?? now())
            : now();

        $minutes = max(1, $billingEndAt->diffInMinutes($billingStartAt));
        $stayedHours = max(1, (int) ceil($minutes / self::MINUTES_IN_HOUR));
        $stayedDays = max(1, (int) ceil($minutes / self::MINUTES_IN_DAY));

        $estimatedRoomAmount = $minutes < self::MINUTES_IN_DAY
            ? $stayedHours * $roomTypeHourlyPrice
            : $stayedDays * $roomTypeDailyPrice;

        $displayRoomAmount = ($detail->payment_status ?? 'unpaid') === 'paid'
            ? (float) ($detail->room_amount ?? 0)
            : $estimatedRoomAmount;

        $displayPricingMode = $minutes < self::MINUTES_IN_DAY ? 'hourly' : 'daily';

        return [
            'room_id' => $detailRoom?->id,
            'room_name' => $detailRoom?->name ?? '--',
            'room_type_name' => $detailRoom?->roomType->name ?? 'N/A',
            'checkin_at' => $detail->formatted_checkin_at,
            'checkout_at' => $detail->formatted_checkout_at,
            'room_amount' => (float) ($detail->room_amount ?? 0),
            'display_room_amount' => $displayRoomAmount,
            'display_pricing_mode' => $displayPricingMode,
            'display_pricing_units' => $displayPricingMode === 'hourly' ? $stayedHours : $stayedDays,
            'hourly_price' => $roomTypeHourlyPrice,
            'daily_price' => $roomTypeDailyPrice,
            'service_amount' => (float) ($detail->service_amount ?? 0),
            'surcharge_amount' => (float) ($detail->surcharge_amount ?? 0),
            'payment_status' => (string) ($detail->payment_status ?? 'unpaid'),
            'paid_at' => $detail->formatted_paid_at,
            'is_selected_room' => (int) ($detailRoom?->id ?? 0) === (int) ($roomId ?? 0),
        ];
    }

    private function buildFallbackBookingRoom($room, $latestBookingDetail, array $invoiceTotals): Collection
    {
        return collect([
            [
                'room_id' => $room->id,
                'room_name' => $room->name ?? '--',
                'room_type_name' => $room->roomType->name ?? 'N/A',
                'checkin_at' => $latestBookingDetail?->formatted_checkin_at,
                'checkout_at' => $latestBookingDetail?->formatted_checkout_at,
                'room_amount' => (float) ($invoiceTotals['room_amount'] ?? 0),
                'display_room_amount' => (float) ($latestBookingDetail?->room_amount ?? 0),
                'display_pricing_mode' => 'daily',
                'display_pricing_units' => 1,
                'hourly_price' => (float) ($room->roomType->hourly_price ?? $latestBookingDetail?->hourly_price ?? 0),
                'daily_price' => (float) ($room->roomType->daily_price ?? $latestBookingDetail?->daily_price ?? 0),
                'service_amount' => (float) ($latestBookingDetail?->service_amount ?? 0),
                'surcharge_amount' => (float) ($latestBookingDetail?->surcharge_amount ?? 0),
                'payment_status' => (string) ($latestBookingDetail?->payment_status ?? 'unpaid'),
                'paid_at' => $latestBookingDetail?->formatted_paid_at,
                'is_selected_room' => true,
            ],
        ]);
    }

    private function calculateInvoiceTotals(Collection $bookingRooms): array
    {
        $roomAmountTotal = (float) $bookingRooms->sum(fn ($item) => (float) ($item['display_room_amount'] ?? $item['room_amount'] ?? 0));
        $serviceAmountTotal = (float) $bookingRooms->sum(fn ($item) => (float) ($item['service_amount'] ?? 0));
        $surchargeAmountTotal = (float) $bookingRooms->sum(fn ($item) => (float) ($item['surcharge_amount'] ?? 0));

        $subtotal = $roomAmountTotal + $serviceAmountTotal + $surchargeAmountTotal;
        $vatAmount = $subtotal * self::VAT_RATE;

        return [
            'room_amount' => $roomAmountTotal,
            'service_amount' => $serviceAmountTotal,
            'surcharge_amount' => $surchargeAmountTotal,
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'grand_total' => $subtotal + $vatAmount,
        ];
    }

    private function buildServiceUsageHistory($booking, $latestBookingDetail): Collection
    {
        $details = collect($booking?->bookingDetails ?? [$latestBookingDetail])->filter();

        return $details
            ->flatMap(function ($detail) {
                $roomName = $detail->room->name ?? '--';

                return collect($detail->serviceUsages ?? [])->map(function ($usage) use ($roomName) {
                    $lineTotal = ((int) $usage->quantity) * (float) $usage->unit_price;

                    return [
                        'room_name' => $roomName,
                        'service_name' => $usage->service->name ?? 'Dịch vụ',
                        'quantity' => (int) $usage->quantity,
                        'unit_price' => (float) $usage->unit_price,
                        'line_total' => $lineTotal,
                        'created_at' => $usage->created_at?->format('d/m/Y H:i') ?? null,
                        'created_at_sort' => $usage->created_at,
                    ];
                });
            })
            ->sortByDesc('created_at_sort')
            ->values()
            ->map(function ($item) {
                unset($item['created_at_sort']);

                return $item;
            });
    }

    private function buildSelectedRoomServiceUsageHistory($booking, $latestBookingDetail, ?int $roomId): Collection
    {
        $selectedRoomDetail = collect($booking?->bookingDetails ?? [])
            ->first(fn ($detail) => (int) ($detail->room_id ?? 0) === (int) ($roomId ?? 0))
            ?? $latestBookingDetail;

        return collect($selectedRoomDetail?->serviceUsages ?? [])->map(function ($usage) {
            $lineTotal = ((int) $usage->quantity) * (float) $usage->unit_price;

            return [
                'service_name' => $usage->service->name ?? 'Dịch vụ',
                'quantity' => (int) $usage->quantity,
                'unit_price' => (float) $usage->unit_price,
                'line_total' => $lineTotal,
                'created_at' => $usage->created_at?->format('d/m/Y H:i') ?? null,
            ];
        })->values();
    }
}
