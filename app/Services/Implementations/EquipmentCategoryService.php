<?php

namespace App\Services\Implementations;

use App\Services\Contracts\EquipmentCategoryServiceInterface;
use App\Repositories\Contracts\EquipmentCategoryRepositoryInterface;

class EquipmentCategoryService implements EquipmentCategoryServiceInterface
{
    public function __construct(
        private readonly EquipmentCategoryRepositoryInterface $equipmentCategoryRepository
    ) {}

    public function getAllEquipmentCategories()
    {
        return $this->equipmentCategoryRepository->getAll();
    }

    public function createEquipmentCategory(array $data)
    {
        return $this->equipmentCategoryRepository->create($data);
    }

    public function getEquipmentCategoryById($id)
    {
        return $this->equipmentCategoryRepository->findById($id);
    }

    public function updateEquipmentCategory($id, array $data)
    {
        return $this->equipmentCategoryRepository->update($id, $data);
    }

    public function deleteEquipmentCategory($id)
    {
        return $this->equipmentCategoryRepository->delete($id);
    }
}
