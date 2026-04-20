<?php

namespace App\Repositories\Implementations;

use App\Models\Floor;
use App\Models\Room;
use App\Repositories\Contracts\RoomMapRepositoryInterface;

class EloquentRoomMapRepository implements RoomMapRepositoryInterface
{
    /**
     * Get all floors ordered by floor number (extract number from name)
     */
    public function getAllFloors()
    {
        return Floor::orderByRaw("CAST(TRIM(REPLACE(name, 'Tầng', '')) AS UNSIGNED) ASC")->get();
    }

    /**
     * Get all rooms with relationships
     */
    public function getAllRooms()
    {
        return Room::with(['roomType', 'floor'])->get();
    }

    /**
     * Get all rooms by floor
     */
    public function getRoomsByFloor($floorId)
    {
        return Room::where('floor_id', $floorId)
                   ->with(['roomType', 'floor'])
                   ->get();
    }

    /**
     * Get all rooms by room type
     */
    public function getRoomsByRoomType($roomTypeId)
    {
        return Room::where('room_type_id', $roomTypeId)
                   ->with(['roomType', 'floor'])
                   ->get();
    }

    /**
     * Create a new floor
     */
    public function createFloor(array $data)
    {
        return Floor::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Create a new room
     */
    public function createRoom(array $data)
    {
        return Room::create([
            'name' => $data['name'],
            'room_type_id' => $data['room_type_id'],
            'floor_id' => $data['floor_id'],
            'status' => $data['status'] ?? 'available'
        ]);
    }

    /**
     * Update floor
     */
    public function updateFloor($id, array $data)
    {
        $floor = Floor::find($id);
        if (!$floor) {
            return null;
        }

        $floor->update([
            'name' => $data['name'] ?? $floor->name,
        ]);

        return $floor;
    }

    /**
     * Update room
     */
    public function updateRoom($id, array $data)
    {
        $room = Room::find($id);
        if (!$room) {
            return null;
        }

        $room->update([
            'name' => $data['name'] ?? $room->name,
            'room_type_id' => $data['room_type_id'] ?? $room->room_type_id,
            'floor_id' => $data['floor_id'] ?? $room->floor_id,
            'status' => $data['status'] ?? $room->status
        ]);

        return $room;
    }

    /**
     * Delete floor
     */
    public function deleteFloor($id)
    {
        return Floor::destroy($id);
    }

    /**
     * Delete room
     */
    public function deleteRoom($id)
    {
        return Room::destroy($id);
    }

    /**
     * Find floor by ID
     */
    public function findFloorById($id)
    {
        return Floor::find($id);
    }

    /**
     * Find room by ID with relationships
     */
    public function findRoomById($id)
    {
        return Room::with(['roomType', 'floor'])->find($id);
    }
}
