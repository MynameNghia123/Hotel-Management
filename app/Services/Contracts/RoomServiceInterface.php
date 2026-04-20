<?php

namespace App\Services\Contracts;

interface RoomServiceInterface
{
    public function getAllRooms();
    public function createRoom(array $data);
    public function findRoomById($id);
    public function updateRoom($id, array $data);
    public function deleteRoom($id);
}
