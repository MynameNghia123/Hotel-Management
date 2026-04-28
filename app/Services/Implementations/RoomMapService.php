<?php

namespace App\Services\Implementations;

use App\Actions\Booking\AddServiceToBookingAction;
use App\Actions\Booking\CancelBookingAction;
use App\Actions\Booking\CheckInAction;
use App\Actions\Booking\CheckoutAction;
use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Http\Resources\RoomMapResource;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use App\Services\Contracts\RoomMapServiceInterface;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\FloorServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Services\Contracts\ServiceServiceInterface;
use App\Services\Contracts\RoomTypeServiceInterface;
use Carbon\Carbon;

class RoomMapService implements RoomMapServiceInterface
{
    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
        protected RoomServiceInterface $roomService,
        protected FloorServiceInterface $floorService,
        protected RoomTypeServiceInterface $roomTypeService,
        protected CustomerServiceInterface $customerService,
        protected BookingServiceInterface $bookingService,
        protected ServiceServiceInterface $serviceService,
        protected CancelBookingAction $cancelBookingAction,
        protected CheckInAction $checkInAction,
        protected AddServiceToBookingAction $addServiceToBookingAction,
        protected CheckoutAction $checkoutAction
    ) {}

    public function prepareDataForIndex(array $filters = []): array
    {
        $rooms = $this->roomMapRepository->getFilteredRooms($filters);
        $this->syncRoomStatusesFromBookingDetails($rooms);
        $floors = $this->roomMapRepository->getAllFloors();
        $statusMeta = collect(RoomStatus::cases())
            ->mapWithKeys(fn (RoomStatus $status) => [
                $status->value => [
                    'label' => $status->label(),
                    'badge' => $status->badgeColor(),
                ],
            ])
            ->all();

        $groupBy = ($filters['group_by'] ?? 'floor') === 'room_type' ? 'room_type' : 'floor';

        $buildRoomCards = fn ($groupRooms) => RoomMapResource::collection($groupRooms)->resolve();

        $groups = $groupBy === 'room_type'
            ? $this->buildGroupsByRoomType($rooms, $buildRoomCards)
            : $this->buildGroupsByFloor($rooms, $floors, $buildRoomCards);

        $filtersWithoutStatus = $filters;
        unset($filtersWithoutStatus['status']);

        $filtersWithoutSearch = $filters;
        unset($filtersWithoutSearch['search']);

        $filtersWithoutDate = $filters;
        unset($filtersWithoutDate['date_from'], $filtersWithoutDate['date_to']);

        return [
            'rooms'            => $rooms,
            'roomStatusCounts' => $this->roomMapRepository->getRoomStatusCounts($filters),
            'floors'           => $floors,
            'totalRooms'       => $rooms->count(),
            'activeStatus'     => $filters['status'] ?? null,
            'statusMeta'       => $statusMeta,
            'groupBy'          => $groupBy,
            'groups'           => $groups,
            'filtersWithoutStatus' => $filtersWithoutStatus,
            'filtersWithoutSearch' => $filtersWithoutSearch,
            'filtersWithoutDate' => $filtersWithoutDate,
            'roomTypes'        => $this->roomTypeService->getAll(),
            'customers'        => $this->customerService->getAll(),
            'recentBookings'   => $this->bookingService->getPaginated([], 5),
            'filters'          => $filters,
        ];
    }

    public function prepareDataForDetail(?int $roomId): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $latestBookingDetail = $roomId ? $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId) : null;
        $booking = $latestBookingDetail?->booking;
        $customer = $booking?->customer;
        $customerName = $customer?->full_name ?: 'Khách lẻ';

        $billingAnchorAt = $booking?->checked_in_at
            ? Carbon::parse($booking->checked_in_at)
            : Carbon::parse($latestBookingDetail?->checkin_date ?? $booking?->booking_date ?? now());
        $serviceCatalog = $this->serviceService->getAll()->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'unit_price' => (float) ($service->unit_price ?? 0),
                'unit' => $service->unit ?? '',
            ];
        })->values();

        $bookingRooms = collect($booking?->bookingDetails ?? [])->map(function ($detail) use ($roomId, $booking) {
            $detailRoom = $detail->room;
            $roomTypeHourlyPrice = (float) ($detailRoom?->roomType->hourly_price ?? $detail->hourly_price ?? 0);
            $roomTypeDailyPrice = (float) ($detailRoom?->roomType->daily_price ?? $detail->daily_price ?? 0);
            $billingStartAt = $booking?->checked_in_at
                ? Carbon::parse($booking->checked_in_at)
                : Carbon::parse($detail->checkin_date ?? now());
            $billingEndAt = ($detail->payment_status ?? 'unpaid') === 'paid'
                ? Carbon::parse($detail->paid_at ?? $detail->checkout_date ?? now())
                : now();

            $minutes = max(1, $billingEndAt->diffInMinutes($billingStartAt));
            $stayedHours = max(1, (int) ceil($minutes / 60));
            $stayedDays = max(1, (int) ceil($minutes / 1440));
            $estimatedRoomAmount = $minutes < 1440
                ? $stayedHours * $roomTypeHourlyPrice
                : $stayedDays * $roomTypeDailyPrice;
            $displayRoomAmount = ($detail->payment_status ?? 'unpaid') === 'paid'
                ? (float) ($detail->room_amount ?? 0)
                : $estimatedRoomAmount;
            $displayPricingMode = $minutes < 1440 ? 'hourly' : 'daily';

            return [
                'room_id' => $detailRoom?->id,
                'room_name' => $detailRoom?->name ?? '--',
                'room_type_name' => $detailRoom?->roomType->name ?? 'N/A',
                'checkin_at' => $detail->formatted_checkin_at,
                'checkout_at' => $detail->formatted_checkout_at,
                'room_amount' => (float) ($detail->room_amount ?? 0),
                'display_room_amount' => $displayRoomAmount,
                'display_pricing_mode' => $displayPricingMode,
                'display_pricing_units' => $displayPricingMode === 'hourly' ? $stayedHours : $stayedDays,
                'hourly_price' => $roomTypeHourlyPrice,
                'daily_price' => $roomTypeDailyPrice,
                'service_amount' => (float) ($detail->service_amount ?? 0),
                'surcharge_amount' => (float) ($detail->surcharge_amount ?? 0),
                'payment_status' => (string) ($detail->payment_status ?? 'unpaid'),
                'paid_at' => $detail->formatted_paid_at,
                'is_selected_room' => (int) ($detailRoom?->id ?? 0) === (int) ($roomId ?? 0),
            ];
        })->filter(fn ($item) => !empty($item['room_id']))->values();

        if ($bookingRooms->isEmpty() && $room) {
            $bookingRooms = collect([
                [
                    'room_id' => $room->id,
                    'room_name' => $room->name ?? '--',
                    'room_type_name' => $room->roomType->name ?? 'N/A',
                    'checkin_at' => $latestBookingDetail?->formatted_checkin_at,
                    'checkout_at' => $latestBookingDetail?->formatted_checkout_at,
                    'room_amount' => (float) ($invoiceTotals['room_amount'] ?? 0),
                    'display_room_amount' => (float) ($latestBookingDetail?->room_amount ?? 0),
                    'display_pricing_mode' => 'daily',
                    'display_pricing_units' => 1,
                    'hourly_price' => (float) ($room->roomType->hourly_price ?? $latestBookingDetail?->hourly_price ?? 0),
                    'daily_price' => (float) ($room->roomType->daily_price ?? $latestBookingDetail?->daily_price ?? 0),
                    'service_amount' => (float) ($latestBookingDetail?->service_amount ?? 0),
                    'surcharge_amount' => (float) ($latestBookingDetail?->surcharge_amount ?? 0),
                    'payment_status' => (string) ($latestBookingDetail?->payment_status ?? 'unpaid'),
                    'paid_at' => $latestBookingDetail?->formatted_paid_at,
                    'is_selected_room' => true,
                ],
            ]);
        }

        $roomAmountTotal = (float) $bookingRooms->sum(function ($roomItem) {
            return (float) ($roomItem['display_room_amount'] ?? $roomItem['room_amount'] ?? 0);
        });
        $serviceAmountTotal = (float) $bookingRooms->sum(function ($roomItem) {
            return (float) ($roomItem['service_amount'] ?? 0);
        });
        $surchargeAmountTotal = (float) $bookingRooms->sum(function ($roomItem) {
            return (float) ($roomItem['surcharge_amount'] ?? 0);
        });
        $subtotal = $roomAmountTotal + $serviceAmountTotal + $surchargeAmountTotal;
        $vatAmount = $subtotal * 0.1;
        $grandTotal = $subtotal + $vatAmount;
        $invoiceTotals = [
            'room_amount' => $roomAmountTotal,
            'service_amount' => $serviceAmountTotal,
            'surcharge_amount' => $surchargeAmountTotal,
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'grand_total' => $grandTotal,
        ];

        $serviceUsageHistory = collect($booking?->bookingDetails ?? [$latestBookingDetail])
            ->filter()
            ->flatMap(function ($detail) {
                $roomName = $detail->room->name ?? '--';

                return collect($detail->serviceUsages ?? [])->map(function ($usage) use ($roomName) {
                    $lineTotal = ((int) $usage->quantity) * (float) $usage->unit_price;

                    return [
                        'room_name' => $roomName,
                        'service_name' => $usage->service->name ?? 'Dịch vụ',
                        'quantity' => (int) $usage->quantity,
                        'unit_price' => (float) $usage->unit_price,
                        'line_total' => $lineTotal,
                        'created_at' => $usage->created_at?->format('d/m/Y H:i') ?? null,
                        'created_at_sort' => $usage->created_at,
                    ];
                });
            })
            ->sortByDesc('created_at_sort')
            ->values()
            ->map(function ($usageItem) {
                unset($usageItem['created_at_sort']);

                return $usageItem;
            });

        $selectedRoomBookingDetail = collect($booking?->bookingDetails ?? [])
            ->first(fn ($detail) => (int) ($detail->room_id ?? 0) === (int) ($roomId ?? 0))
            ?? $latestBookingDetail;

        $selectedRoomServiceUsageHistory = collect($selectedRoomBookingDetail?->serviceUsages ?? [])->map(function ($usage) {
            $lineTotal = ((int) $usage->quantity) * (float) $usage->unit_price;

            return [
                'service_name' => $usage->service->name ?? 'Dịch vụ',
                'quantity' => (int) $usage->quantity,
                'unit_price' => (float) $usage->unit_price,
                'line_total' => $lineTotal,
                'created_at' => $usage->created_at?->format('d/m/Y H:i') ?? null,
            ];
        })->values();

        return [
            'roomId' => $roomId,
            'room' => $room,
            'booking' => $booking,
            'bookingDetail' => $latestBookingDetail,
            'bookingRooms' => $bookingRooms,
            'billingAnchorAt' => $billingAnchorAt->format('d/m/Y H:i'),
            'customerName' => $customerName,
            'invoiceTotals' => $invoiceTotals,
            'serviceCatalog' => $serviceCatalog,
            'serviceUsageHistory' => $serviceUsageHistory,
            'selectedRoomServiceUsageHistory' => $selectedRoomServiceUsageHistory,
        ];
    }

    public function prepareDataForAvailableDetail(?int $roomId): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $roomType = $room?->roomType;

        $bedDescription = trim(
            (($roomType?->double_bed_quantity ?? 0) > 0 ? ($roomType->double_bed_quantity . ' giường đôi ') : '')
            . (($roomType?->single_bed_quantity ?? 0) > 0 ? ($roomType->single_bed_quantity . ' giường đơn') : '')
        );

        $amenityNames = $roomType?->amenities?->pluck('name')->filter()->values()->all() ?? [];
        $equipmentNames = $roomType?->equipments?->pluck('name')->filter()->values()->all() ?? [];
        $facilityNames = array_values(array_unique(array_merge($amenityNames, $equipmentNames)));

        return [
            'roomId' => $roomId,
            'room' => $room,
            'roomType' => $roomType,
            'bedDescription' => $bedDescription !== '' ? $bedDescription : 'Đang cập nhật',
            'facilityNames' => $facilityNames,
            'roomTypes' => $this->roomTypeService->getAll(),
        ];
    }

    public function prepareDataForIncomingDetail(?int $roomId): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $latestBookingDetail = $roomId ? $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId) : null;
        $booking = $latestBookingDetail?->booking;
        $customer = $booking?->customer;
        $customerName = $customer?->full_name ?: 'Khách lẻ';

        $otherBookingRooms = ($booking && $roomId)
            ? $this->roomMapRepository->getOtherBookingRooms((int) $booking->id, (int) $roomId)
            : collect();

        return [
            'roomId' => $roomId,
            'room' => $room,
            'booking' => $booking,
            'bookingDetail' => $latestBookingDetail,
            'customer' => $customer,
            'customerName' => $customerName,
            'otherBookingRooms' => $otherBookingRooms,
            'incomingBookings' => $this->bookingService->getPaginated(['status' => 'pending'], 10),
        ];
    }

    public function prepareDataForInvoice(?int $roomId = null, array $roomIds = []): array
    {
        $room = $roomId ? $this->roomMapRepository->findRoomById($roomId) : null;
        $latestBookingDetail = $roomId ? $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId) : null;
        $booking = $latestBookingDetail?->booking;
        $customer = $booking?->customer;
        $customerName = $customer?->full_name ?: 'Khách lẻ';

        $targetRoomIds = collect($roomIds)
            ->map(fn ($selectedRoomId) => (int) $selectedRoomId)
            ->filter()
            ->unique()
            ->values();

        $bookingDetails = collect($booking?->bookingDetails ?? [])->filter();

        if ($targetRoomIds->isNotEmpty()) {
            $invoiceDetails = $bookingDetails
                ->filter(fn ($detail) => $targetRoomIds->contains((int) ($detail->room_id ?? 0)))
                ->values();
        } elseif ($roomId) {
            $invoiceDetails = $bookingDetails
                ->filter(fn ($detail) => (int) ($detail->room_id ?? 0) === (int) $roomId)
                ->values();
        } else {
            $invoiceDetails = $bookingDetails
                ->filter(fn ($detail) => (string) ($detail->payment_status ?? 'unpaid') === 'paid')
                ->values();
        }

        if ($invoiceDetails->isEmpty() && $latestBookingDetail) {
            $invoiceDetails = collect([$latestBookingDetail]);
        }

        $invoiceRooms = $invoiceDetails->map(function ($detail) {
            $detailRoom = $detail->room;
            $roomAmount = (float) ($detail->room_amount ?? 0);
            $serviceAmount = (float) ($detail->service_amount ?? 0);
            $surchargeAmount = (float) ($detail->surcharge_amount ?? 0);
            $serviceItems = collect($detail->serviceUsages ?? [])->map(function ($usage) {
                $quantity = (int) ($usage->quantity ?? 0);
                $unitPrice = (float) ($usage->unit_price ?? 0);

                return [
                    'name' => $usage->service->name ?? 'Dịch vụ',
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $quantity * $unitPrice,
                ];
            })->values();

            return [
                'room_id' => (int) ($detail->room_id ?? 0),
                'room_name' => $detailRoom->name ?? '--',
                'room_type_name' => $detailRoom?->roomType->name ?? 'N/A',
                'checkin_at' => $detail->formatted_checkin_at,
                'checkout_at' => $detail->formatted_checkout_at,
                'duration_text' => $this->formatStayDuration($detail->checkin_date, $detail->checkout_date),
                'room_amount' => $roomAmount,
                'service_amount' => $serviceAmount,
                'surcharge_amount' => $surchargeAmount,
                'line_total' => $roomAmount + $serviceAmount + $surchargeAmount,
                'service_items' => $serviceItems,
            ];
        })->values();

        $roomAmount = (float) $invoiceRooms->sum('room_amount');
        $serviceAmount = (float) $invoiceRooms->sum('service_amount');
        $surchargeAmount = (float) $invoiceRooms->sum('surcharge_amount');
        $subtotal = $roomAmount + $serviceAmount + $surchargeAmount;
        $vatAmount = $subtotal * 0.1;
        $invoiceTotals = [
            'room_amount' => $roomAmount,
            'service_amount' => $serviceAmount,
            'surcharge_amount' => $surchargeAmount,
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'grand_total' => $subtotal + $vatAmount,
        ];

        $firstCheckinAt = $invoiceDetails
            ->pluck('checkin_date')
            ->filter()
            ->sort()
            ->first();
        $lastCheckoutAt = $invoiceDetails
            ->pluck('checkout_date')
            ->filter()
            ->sortDesc()
            ->first();
        $invoiceStaySummary = [
            'room_names' => $invoiceRooms->pluck('room_name')->filter()->implode(', '),
            'checkin_at' => $this->formatDateTime($firstCheckinAt),
            'checkout_at' => $this->formatDateTime($lastCheckoutAt),
            'duration_text' => $this->formatStayDuration($firstCheckinAt, $lastCheckoutAt),
        ];

        return [
            'room' => $room,
            'booking' => $booking,
            'bookingDetail' => $latestBookingDetail,
            'invoiceRooms' => $invoiceRooms,
            'invoiceStaySummary' => $invoiceStaySummary,
            'customerName' => $customerName,
            'invoiceTotals' => $invoiceTotals,
            'generatedAt' => now(),
            'bookingSummary' => $this->bookingService->getStatusCounts(),
        ];
    }

    public function cancelIncomingBooking(int $roomId): void
    {
        $this->cancelBookingAction->execute($roomId);
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
        $latestBookingDetail = $this->roomMapRepository->findLatestBookingDetailByRoomId($roomId);
        $booking = $latestBookingDetail?->booking;

        if (!$booking) {
            throw new \RuntimeException('Không tìm thấy booking để tạm tính thanh toán.');
        }

        $currentStatus = BookingStatus::tryFrom((string) $booking->status);
        if (!$currentStatus || !$currentStatus->canTransitionTo(BookingStatus::PAID)) {
            $statusLabel = $currentStatus?->label() ?? (string) $booking->status;
            throw new \RuntimeException("Chỉ booking ở trạng thái Đang ở mới được tạm tính thanh toán. Trạng thái hiện tại: {$statusLabel}.");
        }

        $bookingRoomIds = collect($booking->bookingDetails ?? [])->pluck('room_id')->map(fn ($id) => (int) $id)->all();
        $targetRoomIds = collect($selectedRoomIds)
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => in_array($id, $bookingRoomIds, true))
            ->unique()
            ->values();

        if ($targetRoomIds->isEmpty()) {
            return $this->emptyCheckoutPreview($pricingMode);
        }

        $checkedInAt = $booking->checked_in_at;
        if (!$checkedInAt) {
            if ((string) $booking->status === BookingStatus::OCCUPIED->value) {
                $checkedInAt = $latestBookingDetail?->checkin_date ?? $booking->booking_date ?? now();
            } else {
                throw new \RuntimeException('Booking chưa xác nhận check-in, chưa thể tạm tính checkout.');
            }
        }

        $normalizedPricingMode = $pricingMode === 'daily' ? 'daily' : 'hourly';
        $billingStartAt = Carbon::parse($checkedInAt);
        $billingEndAt = now();

        if ($billingEndAt->lt($billingStartAt)) {
            throw new \RuntimeException('Thời gian checkout không hợp lệ so với thời điểm check-in.');
        }

        $minutes = max(1, $billingEndAt->diffInMinutes($billingStartAt, true));
        $pricingUnits = $normalizedPricingMode === 'daily'
            ? max(1, (int) ceil($minutes / 1440))
            : max(1, (int) ceil($minutes / 60));

        $rooms = collect($booking->bookingDetails ?? [])
            ->filter(function ($detail) use ($targetRoomIds) {
                return $targetRoomIds->contains((int) ($detail->room_id ?? 0))
                    && (string) ($detail->payment_status ?? 'unpaid') !== 'paid';
            })
            ->values()
            ->map(function ($detail) use ($normalizedPricingMode, $pricingUnits, $billingEndAt) {
                $detailRoom = $detail->room;
                $unitPrice = $normalizedPricingMode === 'daily'
                    ? (float) ($detail->daily_price ?? $detailRoom?->roomType->daily_price ?? 0)
                    : (float) ($detail->hourly_price ?? $detailRoom?->roomType->hourly_price ?? 0);
                $roomAmount = $pricingUnits * $unitPrice;
                $earlyCheckoutSurcharge = 0.0;
                $plannedCheckoutAt = $detail->checkout_date ? Carbon::parse($detail->checkout_date) : null;

                if ($plannedCheckoutAt && $billingEndAt->lt($plannedCheckoutAt)) {
                    $earlyCheckoutSurcharge = (float) ($detail->hourly_price ?? $detailRoom?->roomType->hourly_price ?? 0);
                }

                $serviceAmount = (float) ($detail->service_amount ?? 0);
                $surchargeAmount = (float) ($detail->surcharge_amount ?? 0) + $earlyCheckoutSurcharge;

                return [
                    'room_id' => (int) ($detail->room_id ?? 0),
                    'room_name' => $detailRoom?->name ?? '--',
                    'room_type_name' => $detailRoom?->roomType->name ?? 'N/A',
                    'unit_price' => $unitPrice,
                    'pricing_mode' => $normalizedPricingMode,
                    'pricing_units' => $pricingUnits,
                    'room_amount' => $roomAmount,
                    'service_amount' => $serviceAmount,
                    'surcharge_amount' => $surchargeAmount,
                    'early_checkout_surcharge' => $earlyCheckoutSurcharge,
                    'line_total' => $roomAmount + $serviceAmount + $surchargeAmount,
                ];
            });

        $roomAmount = (float) $rooms->sum('room_amount');
        $serviceAmount = (float) $rooms->sum('service_amount');
        $surchargeAmount = (float) $rooms->sum('surcharge_amount');
        $subtotal = $roomAmount + $serviceAmount + $surchargeAmount;
        $vatAmount = $subtotal * 0.1;

        return [
            'pricing_mode' => $normalizedPricingMode,
            'pricing_units' => $pricingUnits,
            'billing_start_at' => $this->formatDateTime($billingStartAt),
            'billing_end_at' => $this->formatDateTime($billingEndAt),
            'rooms' => $rooms->values()->all(),
            'totals' => [
                'room_amount' => $roomAmount,
                'service_amount' => $serviceAmount,
                'surcharge_amount' => $surchargeAmount,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
                'grand_total' => $subtotal + $vatAmount,
            ],
        ];
    }

    public function checkoutSelectedRooms(int $roomId, array $selectedRoomIds, string $pricingMode): array
    {
        return $this->checkoutAction->execute($roomId, $selectedRoomIds, $pricingMode);
    }

    private function formatDateTime($dateTimeValue): ?string
    {
        if (!$dateTimeValue) {
            return null;
        }

        return $dateTimeValue->format('d/m/Y H:i');
    }

    private function emptyCheckoutPreview(string $pricingMode): array
    {
        $normalizedPricingMode = $pricingMode === 'daily' ? 'daily' : 'hourly';

        return [
            'pricing_mode' => $normalizedPricingMode,
            'pricing_units' => 0,
            'billing_start_at' => null,
            'billing_end_at' => null,
            'rooms' => [],
            'totals' => [
                'room_amount' => 0,
                'service_amount' => 0,
                'surcharge_amount' => 0,
                'subtotal' => 0,
                'vat_amount' => 0,
                'grand_total' => 0,
            ],
        ];
    }

    private function formatStayDuration($startAt, $endAt): string
    {
        if (!$startAt || !$endAt) {
            return '--';
        }

        $minutes = max(1, Carbon::parse($endAt)->diffInMinutes(Carbon::parse($startAt), true));

        if ($minutes < 1440) {
            return max(1, (int) ceil($minutes / 60)) . ' giờ';
        }

        return max(1, (int) ceil($minutes / 1440)) . ' ngày';
    }

    private function buildInvoiceTotals($booking): array
    {
        $roomAmount = (float) ($booking->total_room_amount ?? 0);
        $serviceAmount = (float) ($booking->total_service_amount ?? 0);
        $surchargeAmount = (float) ($booking->surcharge_amount ?? 0);
        $subtotal = $roomAmount + $serviceAmount + $surchargeAmount;
        $vatAmount = $subtotal * 0.1;
        $grandTotal = $subtotal + $vatAmount;

        return [
            'room_amount' => $roomAmount,
            'service_amount' => $serviceAmount,
            'surcharge_amount' => $surchargeAmount,
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'grand_total' => $grandTotal,
        ];
    }

    private function buildGroupsByRoomType($rooms, callable $buildRoomCards): array
    {
        $roomsByRoomType = $rooms->groupBy('room_type_id');
        $roomTypes = $this->roomTypeService->getAll()->sortBy('name', SORT_NATURAL)->values();

        return $this->buildGroupsFromEntities($roomsByRoomType, $roomTypes, $buildRoomCards);
    }

    private function buildGroupsByFloor($rooms, $floors, callable $buildRoomCards): array
    {
        $roomsByFloor = $rooms->groupBy('floor_id');

        return $this->buildGroupsFromEntities($roomsByFloor, $floors, $buildRoomCards);
    }

    private function buildGroupsFromEntities($roomsByEntityId, $entities, callable $buildRoomCards): array
    {
        $groups = [];

        foreach ($entities as $entity) {
            $groupRooms = ($roomsByEntityId->get($entity->id) ?? collect())
                ->sortBy('name', SORT_NATURAL)
                ->values();

            if ($groupRooms->isEmpty()) {
                continue;
            }

            $groups[] = [
                'id' => $entity->id,
                'name' => strtoupper((string) $entity->name),
                'count' => $groupRooms->count(),
                'rooms' => $buildRoomCards($groupRooms),
            ];
        }

        return $groups;
    }

    private function syncRoomStatusesFromBookingDetails($rooms): void
    {
        $now = now();

        foreach ($rooms as $room) {
            $currentRoomStatus = $room->status instanceof RoomStatus
                ? $room->status->value
                : (string) $room->status;

            $latestActiveDetail = collect($room->bookingDetails ?? [])
                ->first(function ($detail) use ($now) {
                    $bookingStatus = (string) ($detail->booking->status ?? '');

                    if (in_array($bookingStatus, [BookingStatus::CANCELLED->value, BookingStatus::PAID->value], true)) {
                        return false;
                    }

                    return Carbon::parse($detail->checkout_date)->greaterThan($now);
                });

            $nextStatus = null;

            if ($latestActiveDetail) {
                $bookingStatus = (string) ($latestActiveDetail->booking->status ?? '');
                $checkInAt = Carbon::parse($latestActiveDetail->checkin_date);
                $checkOutAt = Carbon::parse($latestActiveDetail->checkout_date);

                if ($bookingStatus === BookingStatus::PENDING->value) {
                    $nextStatus = RoomStatus::BOOKED->value;
                } elseif ($bookingStatus === BookingStatus::CONFIRMED->value) {
                    $nextStatus = RoomStatus::CONFIRMED->value;
                } elseif ($checkInAt->lessThanOrEqualTo($now) && $checkOutAt->greaterThan($now)) {
                    $nextStatus = RoomStatus::OCCUPIED->value;
                } elseif ($checkInAt->greaterThan($now)) {
                    $nextStatus = RoomStatus::INCOMING->value;
                }
            } elseif (in_array($currentRoomStatus, [RoomStatus::BOOKED->value, RoomStatus::CONFIRMED->value, RoomStatus::INCOMING->value], true)) {
                $nextStatus = RoomStatus::EMPTY->value;
            }

            if ($nextStatus && $currentRoomStatus !== $nextStatus) {
                $this->roomService->update($room->id, ['status' => $nextStatus]);
                $room->status = $nextStatus;
            }
        }
    }
}
