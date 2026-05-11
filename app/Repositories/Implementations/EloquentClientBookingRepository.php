<?php

namespace App\Repositories\Implementations;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomType;
use App\Repositories\Contracts\ClientBookingRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentClientBookingRepository implements ClientBookingRepositoryInterface
{
    public function __construct(
        private readonly RoomType $roomTypeModel,
        private readonly Booking $bookingModel,
        private readonly Payment $paymentModel
    ) {
    }

    public function getRoomTypesByIds(array $roomTypeIds): Collection
    {
        if (empty($roomTypeIds)) {
            return collect();
        }

        return $this->roomTypeModel
            ->newQuery()
            ->with([
                'images' => fn ($query) => $query->orderBy('order'),
                'amenities',
            ])
            ->whereIn('id', $roomTypeIds)
            ->get();
    }

    public function findRoomTypeById(int $roomTypeId): ?RoomType
    {
        return $this->roomTypeModel
            ->newQuery()
            ->with([
                'images' => fn ($query) => $query->orderBy('order'),
                'amenities',
            ])
            ->find($roomTypeId);
    }

    public function findBookingById(int $bookingId): ?Booking
    {
        return $this->bookingModel
            ->newQuery()
            ->find($bookingId);
    }

    public function findBookingForPayment(int $bookingId): ?Booking
    {
        return $this->bookingModel
            ->newQuery()
            ->with([
                'bookingDetails.room.roomType.images' => fn ($query) => $query->orderBy('order'),
            ])
            ->find($bookingId);
    }

    public function findBookingForSuccess(int $bookingId): ?Booking
    {
        return $this->bookingModel
            ->newQuery()
            ->with([
                'customer',
                'bookingDetails.room.roomType.images' => fn ($query) => $query->orderBy('order'),
            ])
            ->find($bookingId);
    }

    public function paymentTransactionExists(int $bookingId, string $transactionCode): bool
    {
        return $this->paymentModel
            ->newQuery()
            ->where('booking_id', $bookingId)
            ->where('transaction_code', $transactionCode)
            ->exists();
    }

    public function createPayment(array $data): Payment
    {
        return $this->paymentModel->create($data);
    }

    public function updateBookingStatus(int $bookingId, string $status): bool
    {
        return $this->bookingModel
            ->newQuery()
            ->where('id', $bookingId)
            ->update(['status' => $status]) > 0;
    }
}
