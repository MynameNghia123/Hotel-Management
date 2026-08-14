<?php

namespace App\Repositories\Contracts;

interface RoomMapRepositoryInterface
{
    // Query methods for room map screen
    public function getFilteredRooms(array $filters = []);

    public function getRoomStatusCounts(array $filters = []): array;

    // Basic read methods
    public function getAllFloors();

    public function getAllRooms();

    public function getRoomsByFloor($floorId);

    public function getRoomsByRoomType($roomTypeId);

    // Write methods
    public function createFloor(array $data);

    public function createRoom(array $data);

    public function updateFloor($id, array $data);

    public function updateRoom($id, array $data);

    public function deleteFloor($id);

    public function deleteRoom($id);

    // Find methods
    public function findFloorById($id);

    public function findRoomById($id);

    public function findLatestBookingDetailByRoomId(int $roomId, array $filters = []);

    public function getOtherBookingRooms(int $bookingId, int $excludedRoomId);

    public function getBookingRoomIds(int $bookingId);

    // Booking/service actions from room-map flow
    public function updateBookingStatusById(int $bookingId, string $status);

    public function updateBookingCheckInAt(int $bookingId, $checkedInAt);

    public function updateRoomStatusById(int $roomId, string $status);

    public function createServiceUsage(array $data);

    public function incrementServiceAmounts(int $bookingId, int $bookingDetailId, float $amount): void;

    public function checkoutBookingRooms(int $bookingId, array $roomIds, string $pricingMode, $billingStartAt, $billingEndAt): array;
}
