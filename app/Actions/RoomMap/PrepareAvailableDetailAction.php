<?php

namespace App\Actions\RoomMap;

use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\RoomTypeServiceInterface;

class PrepareAvailableDetailAction
{
    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
        protected RoomTypeServiceInterface $roomTypeService,
    ) {}

    public function execute(?int $roomId): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $roomType = $room?->roomType;

        $bedDescription = $this->buildBedDescription($roomType);
        $facilityNames = $this->buildFacilityNames($roomType);

        return [
            'roomId' => $roomId,
            'room' => $room,
            'roomType' => $roomType,
            'bedDescription' => $bedDescription ?: 'Đang cập nhật',
            'facilityNames' => $facilityNames,
            'roomTypes' => $this->roomTypeService->getAll(),
        ];
    }

    private function buildBedDescription($roomType): ?string
    {
        if (!$roomType) {
            return null;
        }

        $beds = trim(
            (($roomType->double_bed_quantity ?? 0) > 0 ? ($roomType->double_bed_quantity . ' giường đôi ') : '')
            . (($roomType->single_bed_quantity ?? 0) > 0 ? ($roomType->single_bed_quantity . ' giường đơn') : '')
        );

        return $beds !== '' ? $beds : null;
    }

    private function buildFacilityNames($roomType): array
    {
        if (!$roomType) {
            return [];
        }

        $amenityNames = $roomType?->amenities?->pluck('name')->filter()->values()->all() ?? [];
        $equipmentNames = $roomType?->equipments?->pluck('name')->filter()->values()->all() ?? [];

        return array_values(array_unique(array_merge($amenityNames, $equipmentNames)));
    }
}
