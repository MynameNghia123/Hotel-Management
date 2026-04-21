<?php

namespace App\Repositories\Contracts;

interface RoomRepositoryInterface extends BaseRepositoryInterface
{
    public function getByRoomType($roomTypeId);
    public function getAvailableRooms($checkInDate, $checkOutDate);
}
