<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoomTypeRepositoryInterface;
use App\Services\Contracts\RoomTypeServiceInterface;

class RoomTypeService implements RoomTypeServiceInterface
{
    public function __construct(
        protected RoomTypeRepositoryInterface $roomTypeRepository
    ) {}

    /**
     * Get all room types
     */
    public function getAll()
    {
        return $this->roomTypeRepository->getAll();
    }

    /**
     * Get all room types with room count
     */
    public function getAllWithRoomCount()
    {
        return $this->roomTypeRepository->getAllWithRoomCount();
    }

    /**
     * Find room type by ID
     */
    public function findById($id)
    {
        return $this->roomTypeRepository->findById($id);
    }

    /**
     * Find room type with all details
     */
    public function findWithDetails($id)
    {
        return $this->roomTypeRepository->findWithDetails($id);
    }

    /**
     * Create a new room type
     */
    public function create(array $data)
    {
        // Auto-generate code if missing
        if (empty($data['code'])) {
            $data['code'] = 'RT-' . strtoupper(uniqid());
        }
        return $this->roomTypeRepository->create($data);
    }

    /**
     * Update room type
     */
    public function update($id, array $data)
    {
        return $this->roomTypeRepository->update($id, $data);
    }

    /**
     * Delete room type
     */
    public function delete($id)
    {
        return $this->roomTypeRepository->delete($id);
    }

    /**
     * Get paginated room types
     */
    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->roomTypeRepository->getPaginated($filters, $perPage);
    }

    /**
     * Format room type data for edit form
     * Transforms amenities and equipments into format required by UI
     */
    public function formatForEditForm($roomType)
    {
        if (!$roomType) {
            return null;
        }

        return [
            'roomType' => $roomType,
            'selectedAmenities' => $roomType->amenities->pluck('id')->toArray(),
            'selectedEquipments' => $roomType->equipments->map(function ($equip) {
                return [
                    'id' => $equip->id,
                    'quantity' => $equip->pivot->quantity
                ];
            })->keyBy('id')->toArray()
        ];
    }

    /**
     * Sync equipments with quantities
     * Transforms equipment data array into sync format
     */
    public function syncEquipmentsWithQuantities($roomType, array $equipmentData)
    {
        $syncData = [];

        foreach ($equipmentData as $item) {
            $syncData[$item['equipment_id']] = [
                'quantity' => $item['quantity']
            ];
        }

        return $roomType->equipments()->sync($syncData);
    }
}
