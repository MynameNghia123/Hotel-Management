<?php

namespace App\Services\Contracts;

interface EquipmentCategoryServiceInterface
{
    public function getAllEquipmentCategories();
    public function createEquipmentCategory(array $data);
    public function getEquipmentCategoryById($id);
    public function updateEquipmentCategory($id, array $data);
    public function deleteEquipmentCategory($id);
}
