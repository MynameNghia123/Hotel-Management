<?php

namespace App\Services\Contracts;

interface RoomTypeServiceInterface
{
    public function getAllWithRoomCount();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
