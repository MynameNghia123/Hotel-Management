<?php

namespace App\Services\Implementations;

use App\Actions\RoomMap\PrepareIndexAction;
use App\Actions\RoomMap\PrepareDetailAction;
use App\Actions\RoomMap\PrepareInvoiceAction;
use App\Actions\RoomMap\PrepareAvailableDetailAction;
use App\Actions\RoomMap\PrepareIncomingDetailAction;
use App\Actions\RoomMap\PreviewCheckoutAction;
use App\Actions\RoomMap\UpdateRoomStatusAction;
use App\Actions\RoomMap\SyncRoomStatusAction;
use App\Actions\RoomMap\FormatCheckoutResultAction;
use App\Actions\Booking\AddServiceToBookingAction;
use App\Actions\Booking\CancelBookingAction;
use App\Actions\Booking\CheckInAction;
use App\Actions\Booking\CheckoutAction;
use App\Services\Contracts\RoomMapServiceInterface;

class RoomMapService implements RoomMapServiceInterface
{
    public function __construct(
        protected CancelBookingAction $cancelBookingAction,
        protected CheckInAction $checkInAction,
        protected AddServiceToBookingAction $addServiceToBookingAction,
        protected CheckoutAction $checkoutAction,
        protected PrepareIndexAction $prepareIndexAction,
        protected PrepareDetailAction $prepareDetailAction,
        protected PrepareInvoiceAction $prepareInvoiceAction,
        protected PrepareAvailableDetailAction $prepareAvailableDetailAction,
        protected PrepareIncomingDetailAction $prepareIncomingDetailAction,
        protected PreviewCheckoutAction $previewCheckoutAction,
        protected UpdateRoomStatusAction $updateRoomStatusAction,
        protected SyncRoomStatusAction $syncRoomStatusAction,
        protected FormatCheckoutResultAction $formatCheckoutResultAction,
    ) {}

    public function prepareDataForIndex(array $filters = []): array
    {
        return $this->prepareIndexAction->execute($filters);
    }

    public function prepareDataForDetail(?int $roomId, array $filters = []): array
    {
        return $this->prepareDetailAction->execute($roomId, $filters);
    }

    public function prepareDataForAvailableDetail(?int $roomId): array
    {
        return $this->prepareAvailableDetailAction->execute($roomId);
    }

    public function prepareDataForIncomingDetail(?int $roomId, array $filters = []): array
    {
        return $this->prepareIncomingDetailAction->execute($roomId, $filters);
    }

    public function prepareDataForInvoice(?int $roomId = null, array $roomIds = []): array
    {
        return $this->prepareInvoiceAction->execute($roomId, $roomIds);
    }

    public function cancelIncomingBooking(int $roomId): void
    {
        $this->cancelBookingAction->execute($roomId);
    }

    public function updateRoomStatus(int $roomId, string $status): void
    {
        $this->updateRoomStatusAction->execute($roomId, $status);
    }

    public function checkInIncomingBooking(int $roomId): void
    {
        $this->checkInAction->execute($roomId);
    }

    public function addServiceToCheckout(int $roomId, int $serviceId, int $quantity): void
    {
        $this->addServiceToBookingAction->execute($roomId, $serviceId, $quantity);
    }

    public function previewCheckoutSelectedRooms(int $roomId, array $selectedRoomIds, string $pricingMode): array
    {
        return $this->previewCheckoutAction->execute($roomId, $selectedRoomIds, $pricingMode);
    }

    public function checkoutSelectedRooms(int $roomId, array $selectedRoomIds, string $pricingMode): array
    {
        $result = $this->checkoutAction->execute($roomId, $selectedRoomIds, $pricingMode);
        return $this->formatCheckoutResultAction->execute($result, $roomId);
    }
}
