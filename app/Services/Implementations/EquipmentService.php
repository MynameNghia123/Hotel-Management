<?php

namespace App\Services\Implementations;

use App\Services\Contracts\EquipmentServiceInterface;
use App\Repositories\Contracts\EquipmentRepositoryInterface;

class EquipmentService implements EquipmentServiceInterface
{
    public function __construct(
        private readonly EquipmentRepositoryInterface $equipmentRepository
    ) {}

    public function getAll()
    {
        return $this->equipmentRepository->getAll();
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->equipmentRepository->getPaginated($filters, $perPage);
    }

    public function create(array $data)
    {
        return $this->equipmentRepository->create($data);
    }

    public function findById($id)
    {
        return $this->equipmentRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->equipmentRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->equipmentRepository->delete($id);
    }
}
