<?php

namespace App\Services\Contracts;

interface EquipmentServiceInterface
{
    public function getAllEquipment();
    public function createEquipment(array $data);
    public function getEquipmentById($id);
    public function updateEquipment($id, array $data);
    public function deleteEquipment($id);
}
