<?php

namespace App\Repositories\Contracts;

interface RoomTypeRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all room types with their room count
     */
    public function getAllWithRoomCount();

    /**
     * Find a room type with all related details (images, amenities, equipments)
     */
    public function findWithDetails($id);
}
