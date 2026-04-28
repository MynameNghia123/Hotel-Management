<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomMapServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class RoomMapController extends Controller
{
    public function __construct(
        protected RoomMapServiceInterface $roomMapService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->input('filters', []);

        [
            'rooms'            => $rooms,
            'roomStatusCounts' => $roomStatusCounts,
            'floors'           => $floors,
            'totalRooms'       => $totalRooms,
            'activeStatus'     => $activeStatus,
            'statusMeta'       => $statusMeta,
            'groupBy'          => $groupBy,
            'groups'           => $groups,
            'filtersWithoutStatus' => $filtersWithoutStatus,
            'filtersWithoutSearch' => $filtersWithoutSearch,
            'filtersWithoutDate' => $filtersWithoutDate,
            'roomTypes'        => $roomTypes,
            'customers'        => $customers,
            'recentBookings'   => $recentBookings,
            'filters'          => $filters,
        ] = $this->roomMapService->prepareDataForIndex($filters);

        return view('admin.room-map.index', compact(
            'rooms',
            'roomStatusCounts',
            'floors',
            'totalRooms',
            'activeStatus',
            'statusMeta',
            'groupBy',
            'groups',
            'filtersWithoutStatus',
            'filtersWithoutSearch',
            'filtersWithoutDate',
            'roomTypes',
            'customers',
            'recentBookings',
            'filters',
        ));
    }

    public function detail(?int $id = null): View
    {
        return view('admin.room-map.detail', $this->roomMapService->prepareDataForDetail($id));
    }

    public function availableDetail(?int $id = null): View
    {
        return view('admin.room-map.available-detail', $this->roomMapService->prepareDataForAvailableDetail($id));
    }

    public function incomingDetail(?int $id = null): View
    {
        return view('admin.room-map.incoming-detail', $this->roomMapService->prepareDataForIncomingDetail($id));
    }

    public function cancelIncomingBooking(int $id)
    {
        try {
            $this->roomMapService->cancelIncomingBooking($id);

            return redirect()->route('admin.room-map.index')
                ->with('success', 'Đã hủy đặt lịch thành công.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function checkInIncomingBooking(int $id)
    {
        try {
            $this->roomMapService->checkInIncomingBooking($id);

            return redirect()->route('admin.room-map.detail', ['id' => $id])
                ->with('success', 'Check-in thành công, phòng đã chuyển sang trạng thái Có khách.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function addCheckoutService(Request $request, int $id)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'min:1'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->roomMapService->addServiceToCheckout(
                $id,
                (int) $validated['service_id'],
                (int) $validated['quantity']
            );

            return redirect()->route('admin.room-map.detail', ['id' => $id])
                ->with('success', 'Đã thêm dịch vụ vào phòng.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function checkoutSelectedRooms(Request $request, int $id)
    {
        $validated = $request->validate([
            'selected_room_ids' => ['required', 'array', 'min:1'],
            'selected_room_ids.*' => ['required', 'integer', 'min:1'],
            'pricing_mode' => ['required', 'in:hourly,daily'],
        ]);

        try {
            $result = $this->roomMapService->checkoutSelectedRooms(
                $id,
                $validated['selected_room_ids'],
                $validated['pricing_mode']
            );

            if ((int) ($result['processed_count'] ?? 0) < 1) {
                return redirect()->back()->with('error', 'Không có phòng nào cần thanh toán.');
            }

            $invoiceRoomId = (int) (($result['processed_room_ids'][0] ?? $id));
            $subtotal = (float) ($result['subtotal'] ?? 0);
            $vatAmount = $subtotal * 0.1;
            $grandTotal = $subtotal + $vatAmount;

            return redirect()->route('admin.room-map.detail', ['id' => $invoiceRoomId])
                ->with('checkout_success', [
                    'invoice_room_id' => $invoiceRoomId,
                    'processed_room_ids' => $result['processed_room_ids'] ?? [],
                    'processed_count' => (int) ($result['processed_count'] ?? 0),
                    'pricing_mode' => $result['pricing_mode'] ?? $validated['pricing_mode'],
                    'subtotal' => $subtotal,
                    'vat_amount' => $vatAmount,
                    'grand_total' => $grandTotal,
                ])
                ->with('success', sprintf(
                    'Đã thanh toán %d phòng theo %s. Tổng tiền: %sđ (đã bao gồm VAT).',
                    (int) ($result['processed_count'] ?? 0),
                    ($validated['pricing_mode'] === 'daily' ? 'ngày' : 'giờ'),
                    number_format($grandTotal, 0, ',', '.')
                ));
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function previewCheckoutSelectedRooms(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'selected_room_ids' => ['nullable', 'array'],
            'selected_room_ids.*' => ['required', 'integer', 'min:1'],
            'pricing_mode' => ['required', 'in:hourly,daily'],
        ]);

        try {
            return response()->json($this->roomMapService->previewCheckoutSelectedRooms(
                $id,
                $validated['selected_room_ids'] ?? [],
                $validated['pricing_mode']
            ));
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function invoice(): View
    {
        $roomId = request()->query('id');
        $roomIds = collect(explode(',', (string) request()->query('room_ids', '')))
            ->map(fn ($roomId) => (int) trim($roomId))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return view('admin.room-map.invoice', $this->roomMapService->prepareDataForInvoice($roomId ? (int) $roomId : null, $roomIds));
    }
}
