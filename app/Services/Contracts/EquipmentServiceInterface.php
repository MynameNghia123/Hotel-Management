<?php

namespace App\Services\Contracts;

interface EquipmentServiceInterface extends BaseServiceInterface
{
    // Inherits all methods from BaseServiceInterface:
    // - getAll()
    // - create(array $data)
    // - findById($id)
    // - update($id, array $data)
    // - delete($id)
    // - getPaginated(array $filters = [], $perPage = 10)

    /**
     * Prepare data needed for the equipment index page (filters, categories)
     */
    public function prepareDataForIndex(array $filters = [], int $perPage = 10): array;

    /**
     * Prepare data needed for the equipment create form
     */
    public function prepareDataForCreate(): array;

    /**
     * Prepare data needed for the equipment edit form
     */
    public function prepareDataForEdit($id): array;
}
