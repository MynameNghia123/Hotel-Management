<?php

namespace App\Services\Contracts;

interface RoomTypeServiceInterface extends BaseServiceInterface
{
    public function getAllWithRoomCount();
    public function findWithDetails($id);
    public function formatForEditForm($roomType);
    public function syncEquipmentsWithQuantities($roomType, array $equipmentData);

    /** Prepare data for the create form (amenities, equipments) */
    public function prepareDataForCreate(): array;

    /** Prepare data for the edit form (room type details + amenities + equipments) */
    public function prepareDataForEdit($id): array;
}
