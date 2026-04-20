<?php

namespace App\Services\Implementations;

use App\Services\Contracts\EquipmentCategoryServiceInterface;
use App\Repositories\Contracts\EquipmentCategoryRepositoryInterface;

class EquipmentCategoryService implements EquipmentCategoryServiceInterface
{
    public function __construct(
        private readonly EquipmentCategoryRepositoryInterface $equipmentCategoryRepository
    ) {}

    public function getAll()
    {
        return $this->equipmentCategoryRepository->getAll();
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->equipmentCategoryRepository->getPaginated($filters, $perPage);
    }

    public function create(array $data)
    {
        return $this->equipmentCategoryRepository->create($data);
    }

    public function findById($id)
    {
        return $this->equipmentCategoryRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->equipmentCategoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->equipmentCategoryRepository->delete($id);
    }
}
