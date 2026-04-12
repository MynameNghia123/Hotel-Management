<?php

namespace App\Services\Implementations;

use App\Services\Contracts\EquipmentServiceInterface;
use App\Repositories\Contracts\EquipmentRepositoryInterface;

class EquipmentService implements EquipmentServiceInterface
{
    public function __construct(
        private readonly EquipmentRepositoryInterface $equipmentRepository
    ) {}

    public function getAllEquipment()
    {
        return $this->equipmentRepository->getAll();
    }

    public function createEquipment(array $data)
    {
        return $this->equipmentRepository->create($data);
    }

    public function getEquipmentById($id)
    {
        return $this->equipmentRepository->findById($id);
    }

    public function updateEquipment($id, array $data)
    {
        return $this->equipmentRepository->update($id, $data);
    }

    public function deleteEquipment($id)
    {
        return $this->equipmentRepository->delete($id);
    }
}
