<?php

namespace App\Repositories\Contracts;

interface RoomTypeRepositoryInterface extends BaseRepositoryInterface
{
    // Lấy tất cả loại phòng kèm theo số lượng phòng con
    public function getAllWithRoomCount();
    // Lấy loại phòng kèm đầy đủ quan hệ: amenities, equipments, images
    public function findWithDetails($id);
}
