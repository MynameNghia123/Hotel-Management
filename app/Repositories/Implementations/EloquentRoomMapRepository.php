<?php

namespace App\Repositories\Implementations;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Floor;
use App\Models\Room;
use App\Models\ServiceUsage;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Repositories\Filters\RoomMapFilter;

class EloquentRoomMapRepository implements RoomMapRepositoryInterface
{
    public function getFilteredRooms(array $filters = [])
    {
        $query = Room::with([
            'roomType',
            'floor',
            'bookingDetails' => function ($bookingDetailQuery) {
                $bookingDetailQuery
                    ->with(['booking.customer', 'serviceUsages.service'])
                    ->orderByDesc('checkin_date');
            },
        ]);

        $query = RoomMapFilter::apply($query, $filters);

        return $query->orderBy('name')->get();
    }

    public function getRoomStatusCounts(array $filters = []): array
    {
        $query = Room::query();

        $statusAgnosticFilters = $filters;
        unset($statusAgnosticFilters['status']);

        $query = RoomMapFilter::apply($query, $statusAgnosticFilters);
        $rawCounts = $query->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $counts = [];
        foreach (RoomStatus::all() as $status) {
            $counts[$status->value] = (int) ($rawCounts[$status->value] ?? 0);
        }

        return $counts;
    }

    public function getAllFloors()
    {
        return Floor::orderByRaw("CAST(TRIM(REPLACE(name, 'Tầng', '')) AS UNSIGNED) ASC")->get();
    }

    public function getAllRooms()
    {
        return Room::with(['roomType', 'floor'])->orderBy('name')->get();
    }

    public function getRoomsByFloor($floorId)
    {
        return Room::where('floor_id', $floorId)
            ->with(['roomType', 'floor'])
            ->get();
    }

    public function getRoomsByRoomType($roomTypeId)
    {
        return Room::where('room_type_id', $roomTypeId)
            ->with(['roomType', 'floor'])
            ->get();
    }

    public function createFloor(array $data)
    {
        return Floor::create([
            'name' => $data['name'],
        ]);
    }

    public function createRoom(array $data)
    {
        return Room::create([
            'name' => $data['name'],
            'room_type_id' => $data['room_type_id'],
            'floor_id' => $data['floor_id'],
            'status' => $data['status'] ?? RoomStatus::EMPTY->value,
        ]);
    }

    public function updateFloor($id, array $data)
    {
        $floor = Floor::find($id);
        if (!$floor) {
            return null;
        }

        $floor->update([
            'name' => $data['name'] ?? $floor->name,
        ]);

        return $floor;
    }

    public function updateRoom($id, array $data)
    {
        $room = Room::find($id);
        if (!$room) {
            return null;
        }

        $room->update([
            'name' => $data['name'] ?? $room->name,
            'room_type_id' => $data['room_type_id'] ?? $room->room_type_id,
            'floor_id' => $data['floor_id'] ?? $room->floor_id,
            'status' => $data['status'] ?? $room->status,
        ]);

        return $room;
    }

    public function deleteFloor($id)
    {
        return Floor::destroy($id);
    }

    public function deleteRoom($id)
    {
        return Room::destroy($id);
    }

    public function findFloorById($id)
    {
        return Floor::find($id);
    }

    public function findRoomById($id)
    {
        return Room::with([
            'roomType.amenities',
            'roomType.equipments',
            'floor',
            'bookingDetails' => function ($bookingDetailQuery) {
                $bookingDetailQuery
                    ->with(['booking.customer', 'booking.bookingDetails.room.roomType', 'serviceUsages.service'])
                    ->orderByDesc('checkin_date');
            },
        ])->find($id);
    }

    public function findLatestBookingDetailByRoomId(int $roomId)
    {
        return BookingDetail::with([
            'room.roomType.amenities',
            'room.roomType.equipments',
            'booking.customer',
            'booking.bookingDetails.room.roomType',
            'booking.bookingDetails.serviceUsages.service',
            'serviceUsages.service',
        ])
            ->where('room_id', $roomId)
            ->orderByDesc('checkin_date')
            ->orderByDesc('id')
            ->first();
    }

    public function getOtherBookingRooms(int $bookingId, int $excludedRoomId)
    {
        return BookingDetail::with('room.roomType')
            ->where('booking_id', $bookingId)
            ->where('room_id', '!=', $excludedRoomId)
            ->orderByDesc('checkin_date')
            ->get()
            ->map(function ($bookingDetail) {
                $linkedRoom = $bookingDetail->room;
                if (!$linkedRoom) {
                    return null;
                }

                return [
                    'id' => $linkedRoom->id,
                    'name' => $linkedRoom->name,
                    'room_type' => $linkedRoom->roomType->name ?? '',
                ];
            })
            ->filter()
            ->values();
    }

    public function getBookingRoomIds(int $bookingId)
    {
        return BookingDetail::where('booking_id', $bookingId)
            ->pluck('room_id')
            ->filter()
            ->unique()
            ->values();
    }

    public function updateBookingStatusById(int $bookingId, string $status)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = $status;
        $booking->save();

        return $booking;
    }

    public function updateBookingCheckInAt(int $bookingId, $checkedInAt)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->checked_in_at = $checkedInAt;
        $booking->save();

        return $booking;
    }

    public function updateRoomStatusById(int $roomId, string $status)
    {
        $room = Room::findOrFail($roomId);
        $room->status = $status;
        $room->save();

        return $room;
    }

    public function createServiceUsage(array $data)
    {
        return ServiceUsage::create($data);
    }

    public function incrementServiceAmounts(int $bookingId, int $bookingDetailId, float $amount): void
    {
        $bookingDetail = BookingDetail::findOrFail($bookingDetailId);

        $bookingDetail->service_amount = (float) ($bookingDetail->service_amount ?? 0) + $amount;
        $bookingDetail->save();

        $this->recomputeBookingTotalsFromPaidDetails($bookingId);
    }

    public function checkoutBookingRooms(int $bookingId, array $roomIds, string $pricingMode, $billingStartAt, $billingEndAt): array
    {
        $booking = Booking::with('bookingDetails')->findOrFail($bookingId);
        $targetRoomIds = collect($roomIds)->map(fn ($id) => (int) $id)->unique()->values();

        $bookingDetails = $booking->bookingDetails
            ->whereIn('room_id', $targetRoomIds)
            ->filter(fn ($detail) => (string) ($detail->payment_status ?? 'unpaid') !== 'paid')
            ->values();

        if ($bookingDetails->isEmpty()) {
            return [
                'processed_room_ids' => [],
                'processed_count' => 0,
                'room_amount' => 0,
                'service_amount' => 0,
                'surcharge_amount' => 0,
                'subtotal' => 0,
                'pricing_mode' => $pricingMode,
            ];
        }

        $totalRoomAmount = 0.0;
        $totalServiceAmount = 0.0;
        $totalSurchargeAmount = 0.0;
        $processedRoomIds = [];

        foreach ($bookingDetails as $detail) {
            $plannedCheckoutAt = $detail->checkout_date ? $detail->checkout_date->copy() : null;
            $minutes = max(1, $billingEndAt->diffInMinutes($billingStartAt));
            $roomAmount = 0.0;
            $earlyCheckoutSurcharge = 0.0;

            if ($pricingMode === 'daily') {
                $stayedDays = max(1, (int) ceil($minutes / 1440));
                $roomAmount = $stayedDays * (float) ($detail->daily_price ?? 0);
            } else {
                $stayedHours = max(1, (int) ceil($minutes / 60));
                $roomAmount = $stayedHours * (float) ($detail->hourly_price ?? 0);
            }

            // Checkout sớm hơn thời gian dự kiến: phụ thu 1 giờ tiền phòng cho từng phòng.
            if ($plannedCheckoutAt && $billingEndAt->lt($plannedCheckoutAt)) {
                $earlyCheckoutSurcharge = (float) ($detail->hourly_price ?? 0);
            }

            $detail->room_amount = $roomAmount;
            $detail->surcharge_amount = (float) ($detail->surcharge_amount ?? 0) + $earlyCheckoutSurcharge;
            $detail->checkout_date = $billingEndAt;
            $detail->payment_status = 'paid';
            $detail->paid_at = $billingEndAt;
            $detail->save();

            $processedRoomIds[] = (int) $detail->room_id;
            $totalRoomAmount += $roomAmount;
            $totalServiceAmount += (float) ($detail->service_amount ?? 0);
            $totalSurchargeAmount += (float) ($detail->surcharge_amount ?? 0);
        }

        $this->recomputeBookingTotalsFromPaidDetails($bookingId);

        $hasUnpaidRooms = BookingDetail::where('booking_id', $bookingId)
            ->where('payment_status', '!=', 'paid')
            ->exists();

        if (!$hasUnpaidRooms) {
            $bookingCheckout = Booking::findOrFail($bookingId);
            $bookingCheckout->checked_out_at = $billingEndAt;
            $bookingCheckout->status = BookingStatus::PAID->value;
            $bookingCheckout->save();
        }

        return [
            'processed_room_ids' => $processedRoomIds,
            'processed_count' => count($processedRoomIds),
            'room_amount' => $totalRoomAmount,
            'service_amount' => $totalServiceAmount,
            'surcharge_amount' => $totalSurchargeAmount,
            'subtotal' => $totalRoomAmount + $totalServiceAmount + $totalSurchargeAmount,
            'pricing_mode' => $pricingMode,
        ];
    }

    private function recomputeBookingTotalsFromPaidDetails(int $bookingId): void
    {
        $paidDetails = BookingDetail::where('booking_id', $bookingId)
            ->where('payment_status', 'paid')
            ->get();

        $totalRoomAmount = (float) $paidDetails->sum(fn ($detail) => (float) ($detail->room_amount ?? 0));
        $totalServiceAmount = (float) $paidDetails->sum(fn ($detail) => (float) ($detail->service_amount ?? 0));
        $totalSurchargeAmount = (float) $paidDetails->sum(fn ($detail) => (float) ($detail->surcharge_amount ?? 0));

        $booking = Booking::findOrFail($bookingId);
        $booking->total_room_amount = $totalRoomAmount;
        $booking->total_service_amount = $totalServiceAmount;
        $booking->surcharge_amount = $totalSurchargeAmount;
        $booking->final_amount = $totalRoomAmount + $totalServiceAmount + $totalSurchargeAmount;
        $booking->save();
    }
}
