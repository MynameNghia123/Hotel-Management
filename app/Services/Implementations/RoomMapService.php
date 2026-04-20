<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\RoomMapServiceInterface;
use Exception;

class RoomMapService implements RoomMapServiceInterface
{
    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository
    ) {}

    /**
     * Get all floors
     */
    public function getAllFloors()
    {
        return $this->roomMapRepository->getAllFloors();
    }

    /**
     * Get all rooms
     */
    public function getAllRooms()
    {
        return $this->roomMapRepository->getAllRooms();
    }

    /**
     * Get all rooms by floor
     */
    public function getRoomsByFloor($floorId)
    {
        return $this->roomMapRepository->getRoomsByFloor($floorId);
    }

    /**
     * Get all rooms by room type
     */
    public function getRoomsByRoomType($roomTypeId)
    {
        return $this->roomMapRepository->getRoomsByRoomType($roomTypeId);
    }

    /**
     * Create a new floor
     */
    public function createFloor(array $data)
    {
        try {
            return $this->roomMapRepository->createFloor($data);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi tạo tầng: ' . $e->getMessage());
        }
    }

    /**
     * Create a new room
     */
    public function createRoom(array $data)
    {
        try {
            return $this->roomMapRepository->createRoom($data);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi tạo phòng: ' . $e->getMessage());
        }
    }

    /**
     * Update floor
     */
    public function updateFloor($id, array $data)
    {
        try {
            $floor = $this->roomMapRepository->updateFloor($id, $data);
            if (!$floor) {
                throw new Exception('Không tìm thấy tầng này!');
            }
            return $floor;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi cập nhật tầng: ' . $e->getMessage());
        }
    }

    /**
     * Update room
     */
    public function updateRoom($id, array $data)
    {
        try {
            $room = $this->roomMapRepository->updateRoom($id, $data);
            if (!$room) {
                throw new Exception('Không tìm thấy phòng này!');
            }
            return $room;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi cập nhật phòng: ' . $e->getMessage());
        }
    }

    /**
     * Delete floor - KIỂM TRA TRƯỚC xem có phòng nào không
     * 
     * Logic:
     * 1. Check xem floor này có phòng không
     * 2. Nếu có phòng → Throw exception (không được xóa)
     * 3. Nếu không có → Xóa floor
     */
    public function deleteFloor($id)
    {
        try {
            // 1️⃣ Check xem floor này có phòng không
            if ($this->floorHasRooms($id)) {
                throw new Exception('Không thể xóa tầng vì tầng này vẫn còn phòng! Hãy xóa tất cả phòng trước.');
            }

            // 2️⃣ Nếu không có phòng → xóa floor
            return $this->roomMapRepository->deleteFloor($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete room
     */
    public function deleteRoom($id)
    {
        try {
            return $this->roomMapRepository->deleteRoom($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi xóa phòng: ' . $e->getMessage());
        }
    }

    /**
     * Find floor by ID
     */
    public function findFloorById($id)
    {
        return $this->roomMapRepository->findFloorById($id);
    }

    /**
     * Find room by ID
     */
    public function findRoomById($id)
    {
        return $this->roomMapRepository->findRoomById($id);
    }

    /**
     * Check if floor has any rooms
     * 
     * Return: true nếu floor có phòng, false nếu không
     */
    public function floorHasRooms($floorId)
    {
        $rooms = $this->roomMapRepository->getRoomsByFloor($floorId);
        return $rooms->count() > 0;
    }
}
