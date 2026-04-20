<?php

namespace App\Services\Contracts;

interface RoomTypeServiceInterface extends BaseServiceInterface
{
    /**
     * Get all room types with room count
     * Specialized method for getting room types with their associated room count
     */
    public function getAllWithRoomCount();

    /**
     * Find a room type with all details
     * Specialized method for loading room type with related data (images, amenities, equipments)
     */
    public function findWithDetails($id);

    /**
     * Format room type data for edit form
     * Transforms amenities and equipments into format required by UI
     */
    public function formatForEditForm($roomType);

    /**
     * Sync equipments with quantities
     * Transforms equipment data array into sync format
     */
    public function syncEquipmentsWithQuantities($roomType, array $equipmentData);
}
