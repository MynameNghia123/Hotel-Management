<?php

namespace App\Services\Contracts;

interface FloorServiceInterface
{
    public function getAllFloors();
    public function createFloor(array $data);
    public function findFloorById($id);
    public function updateFloor($id, array $data);
    public function deleteFloor($id);
}
