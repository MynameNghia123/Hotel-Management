<?php

namespace App\Actions\RoomMap;

use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\BookingServiceInterface;

class PrepareIncomingDetailAction
{
    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
        protected BookingServiceInterface $bookingService,
    ) {}

    public function execute(?int $roomId): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $latestBookingDetail = $roomId ? $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId) : null;
        $booking = $latestBookingDetail?->booking;
        $customer = $booking?->customer;
        $customerName = $customer?->full_name ?: 'Khách lẻ';

        $otherBookingRooms = ($booking && $roomId)
            ? $this->roomMapRepository->getOtherBookingRooms((int) $booking->id, (int) $roomId)
            : collect();

        return [
            'roomId' => $roomId,
            'room' => $room,
            'booking' => $booking,
            'bookingDetail' => $latestBookingDetail,
            'customer' => $customer,
            'customerName' => $customerName,
            'otherBookingRooms' => $otherBookingRooms,
            'incomingBookings' => $this->bookingService->getPaginated(['status' => 'pending'], 10),
        ];
    }
}
