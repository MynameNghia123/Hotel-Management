<?php

namespace App\Services\Contracts;

interface RoomMapServiceInterface
{
    public function prepareDataForIndex(array $filters = []): array;
    public function prepareDataForDetail(?int $roomId): array;
    public function prepareDataForAvailableDetail(?int $roomId): array;
    public function prepareDataForIncomingDetail(?int $roomId): array;
    public function prepareDataForInvoice(?int $roomId = null, array $roomIds = []): array;
    public function updateRoomStatus(int $roomId, string $status): void;
    public function cancelIncomingBooking(int $roomId): void;
    public function checkInIncomingBooking(int $roomId): void;
    public function addServiceToCheckout(int $roomId, int $serviceId, int $quantity): void;
    public function previewCheckoutSelectedRooms(int $roomId, array $selectedRoomIds, string $pricingMode): array;
    public function checkoutSelectedRooms(int $roomId, array $selectedRoomIds, string $pricingMode): array;
}
