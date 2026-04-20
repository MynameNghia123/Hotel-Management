<?php

namespace App\Repositories\Contracts;

interface RoomMapRepositoryInterface
{
    /**
     * Get all floors
     */
    public function getAllFloors();

    /**
     * Get all rooms
     */
    public function getAllRooms();

    /**
     * Get all rooms by floor
     */
    public function getRoomsByFloor($floorId);

    /**
     * Get all rooms by room type
     */
    public function getRoomsByRoomType($roomTypeId);

    /**
     * Create a new floor
     */
    public function createFloor(array $data);

    /**
     * Create a new room
     */
    public function createRoom(array $data);

    /**
     * Update floor
     */
    public function updateFloor($id, array $data);

    /**
     * Update room
     */
    public function updateRoom($id, array $data);

    /**
     * Delete floor
     */
    public function deleteFloor($id);

    /**
     * Delete room
     */
    public function deleteRoom($id);

    /**
     * Find floor by ID
     */
    public function findFloorById($id);

    /**
     * Find room by ID
     */
    public function findRoomById($id);
}
