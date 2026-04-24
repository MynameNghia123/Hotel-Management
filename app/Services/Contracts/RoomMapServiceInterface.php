<?php

namespace App\Services\Contracts;

interface RoomMapServiceInterface
{
    public function prepareDataForIndex(array $filters = []): array;
    public function prepareDataForDetail(?int $roomId): array;
    public function prepareDataForAvailableDetail(?int $roomId): array;
    public function prepareDataForIncomingDetail(?int $roomId): array;
    public function prepareDataForInvoice(): array;
}
