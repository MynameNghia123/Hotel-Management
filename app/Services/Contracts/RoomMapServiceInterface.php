<?php

namespace App\Services\Contracts;

interface RoomMapServiceInterface
{
    public function getAllFloors();
    public function getAllRooms();
    public function getRoomsByFloor($floorId);
    public function getRoomsByRoomType($roomTypeId);
    public function createFloor(array $data);
    public function createRoom(array $data);
    public function updateFloor($id, array $data);
    public function updateRoom($id, array $data);
    public function deleteFloor($id);
    public function deleteRoom($id);
    public function findFloorById($id);
    public function findRoomById($id);
    public function floorHasRooms($floorId);

    /** Prepare data for the room-map index page */
    public function prepareDataForIndex(): array;

    /** Prepare data for the create-room form */
    public function prepareDataForCreateRoom(): array;

    /** Prepare data for the edit-room form */
    public function prepareDataForEditRoom($id): array;
}
