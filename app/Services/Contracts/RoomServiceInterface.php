<?php

namespace App\Services\Contracts;

interface RoomServiceInterface extends BaseServiceInterface
{
    public function getByRoomType($roomTypeId);

    public function getAvailableRooms($checkInDate, $checkOutDate);
}
