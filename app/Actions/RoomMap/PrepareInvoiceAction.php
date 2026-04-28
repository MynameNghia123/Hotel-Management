<?php

namespace App\Actions\RoomMap;

use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\BookingServiceInterface;
use Carbon\Carbon;

class PrepareInvoiceAction
{
    private const VAT_RATE = 0.1;
    private const MINUTES_IN_DAY = 1440;

    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
        protected BookingServiceInterface $bookingService,
    ) {}

    public function execute(?int $roomId = null, array $roomIds = []): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $latestBookingDetail = $roomId ? $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId) : null;
        $booking = $latestBookingDetail?->booking;
        $customer = $booking?->customer;
        $customerName = $customer?->full_name ?: 'Khách lẻ';

        $invoiceDetails = $this->filterInvoiceDetails($booking, $roomId, $roomIds, $latestBookingDetail);
        $invoiceRooms = $this->buildInvoiceRooms($invoiceDetails);
        $invoiceTotals = $this->calculateInvoiceTotals($invoiceRooms);
        $invoiceStaySummary = $this->buildInvoiceStaySummary($invoiceDetails, $invoiceRooms);

        return [
            'room' => $room,
            'booking' => $booking,
            'bookingDetail' => $latestBookingDetail,
            'invoiceRooms' => $invoiceRooms,
            'invoiceStaySummary' => $invoiceStaySummary,
            'customerName' => $customerName,
            'invoiceTotals' => $invoiceTotals,
            'generatedAt' => now(),
            'bookingSummary' => $this->bookingService->getStatusCounts(),
        ];
    }

    private function filterInvoiceDetails($booking, ?int $roomId, array $roomIds, $latestBookingDetail): \Illuminate\Support\Collection
    {
        $bookingDetails = collect($booking?->bookingDetails ?? [])->filter();
        $targetRoomIds = collect($roomIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($targetRoomIds->isNotEmpty()) {
            return $bookingDetails->filter(fn ($detail) => $targetRoomIds->contains((int) ($detail->room_id ?? 0)))->values();
        }

        if ($roomId) {
            return $bookingDetails->filter(fn ($detail) => (int) ($detail->room_id ?? 0) === (int) $roomId)->values();
        }

        $filtered = $bookingDetails->filter(fn ($detail) => (string) ($detail->payment_status ?? 'unpaid') === 'paid')->values();

        return $filtered->isEmpty() && $latestBookingDetail ? collect([$latestBookingDetail]) : $filtered;
    }

    private function buildInvoiceRooms($invoiceDetails): \Illuminate\Support\Collection
    {
        return $invoiceDetails->map(function ($detail) {
            $detailRoom = $detail->room;
            $roomAmount = (float) ($detail->room_amount ?? 0);
            $serviceAmount = (float) ($detail->service_amount ?? 0);
            $surchargeAmount = (float) ($detail->surcharge_amount ?? 0);

            $serviceItems = collect($detail->serviceUsages ?? [])->map(function ($usage) {
                $quantity = (int) ($usage->quantity ?? 0);
                $unitPrice = (float) ($usage->unit_price ?? 0);

                return [
                    'name' => $usage->service->name ?? 'Dịch vụ',
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $quantity * $unitPrice,
                ];
            })->values();

            return [
                'room_id' => (int) ($detail->room_id ?? 0),
                'room_name' => $detailRoom->name ?? '--',
                'room_type_name' => $detailRoom?->roomType->name ?? 'N/A',
                'checkin_at' => $detail->formatted_checkin_at,
                'checkout_at' => $detail->formatted_checkout_at,
                'duration_text' => $this->formatStayDuration($detail->checkin_date, $detail->checkout_date),
                'room_amount' => $roomAmount,
                'service_amount' => $serviceAmount,
                'surcharge_amount' => $surchargeAmount,
                'line_total' => $roomAmount + $serviceAmount + $surchargeAmount,
                'service_items' => $serviceItems,
            ];
        })->values();
    }

    private function calculateInvoiceTotals($invoiceRooms): array
    {
        $roomAmount = (float) $invoiceRooms->sum('room_amount');
        $serviceAmount = (float) $invoiceRooms->sum('service_amount');
        $surchargeAmount = (float) $invoiceRooms->sum('surcharge_amount');
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

    private function buildInvoiceStaySummary($invoiceDetails, $invoiceRooms): array
    {
        $firstCheckinAt = $invoiceDetails->pluck('checkin_date')->filter()->sort()->first();
        $lastCheckoutAt = $invoiceDetails->pluck('checkout_date')->filter()->sortDesc()->first();

        return [
            'room_names' => $invoiceRooms->pluck('room_name')->filter()->implode(', '),
            'checkin_at' => $this->formatDateTime($firstCheckinAt),
            'checkout_at' => $this->formatDateTime($lastCheckoutAt),
            'duration_text' => $this->formatStayDuration($firstCheckinAt, $lastCheckoutAt),
        ];
    }

    private function formatDateTime($dateTimeValue): ?string
    {
        if (!$dateTimeValue) {
            return null;
        }

        return $dateTimeValue instanceof Carbon
            ? $dateTimeValue->format('d/m/Y H:i')
            : Carbon::parse($dateTimeValue)->format('d/m/Y H:i');
    }

    private function formatStayDuration($startAt, $endAt): string
    {
        if (!$startAt || !$endAt) {
            return '--';
        }

        $minutes = max(1, Carbon::parse($endAt)->diffInMinutes(Carbon::parse($startAt), true));

        if ($minutes < self::MINUTES_IN_DAY) {
            return max(1, (int) ceil($minutes / 60)) . ' giờ';
        }

        return max(1, (int) ceil($minutes / self::MINUTES_IN_DAY)) . ' ngày';
    }
}
