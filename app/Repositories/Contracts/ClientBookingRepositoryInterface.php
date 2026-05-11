<?php

namespace App\Repositories\Contracts;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomType;
use Illuminate\Support\Collection;

interface ClientBookingRepositoryInterface
{
    public function getRoomTypesByIds(array $roomTypeIds): Collection;

    public function findRoomTypeById(int $roomTypeId): ?RoomType;

    public function findBookingById(int $bookingId): ?Booking;

    public function findBookingForPayment(int $bookingId): ?Booking;

    public function findBookingForSuccess(int $bookingId): ?Booking;

    public function paymentTransactionExists(int $bookingId, string $transactionCode): bool;

    public function createPayment(array $data): Payment;

    public function updateBookingStatus(int $bookingId, string $status): bool;
}
