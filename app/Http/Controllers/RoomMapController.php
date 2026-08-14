<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomMap\AddCheckoutServiceRequest;
use App\Http\Requests\RoomMap\CheckoutSelectedRoomsRequest;
use App\Http\Requests\RoomMap\PreviewCheckoutSelectedRoomsRequest;
use App\Http\Requests\RoomMap\UpdateRoomStatusRequest;
use App\Services\Contracts\RoomMapServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            'rooms' => $rooms,
            'roomStatusCounts' => $roomStatusCounts,
            'floors' => $floors,
            'totalRooms' => $totalRooms,
            'activeStatus' => $activeStatus,
            'statusMeta' => $statusMeta,
            'groupBy' => $groupBy,
            'groups' => $groups,
            'filtersWithoutStatus' => $filtersWithoutStatus,
            'filtersWithoutSearch' => $filtersWithoutSearch,
            'filtersWithoutDate' => $filtersWithoutDate,
            'roomTypes' => $roomTypes,
            'customers' => $customers,
            'recentBookings' => $recentBookings,
            'filters' => $filters,
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

    public function detail(Request $request, ?int $id = null): View
    {
        return view('admin.room-map.detail', $this->roomMapService->prepareDataForDetail($id, $this->roomMapContextFilters($request)));
    }

    public function availableDetail(?int $id = null): View
    {
        return view('admin.room-map.available-detail', $this->roomMapService->prepareDataForAvailableDetail($id));
    }

    public function incomingDetail(Request $request, ?int $id = null): View
    {
        return view('admin.room-map.incoming-detail', $this->roomMapService->prepareDataForIncomingDetail($id, $this->roomMapContextFilters($request)));
    }

    private function roomMapContextFilters(Request $request): array
    {
        $filters = $request->input('filters', []);

        if ($request->filled('booking_detail_id')) {
            $filters['booking_detail_id'] = (int) $request->query('booking_detail_id');
        }

        return $filters;
    }

    public function updateRoomStatus(UpdateRoomStatusRequest $request, int $id)
    {
        try {
            $this->roomMapService->updateRoomStatus($id, $request->validated('status'));

            return redirect()->back()->with('success', 'Cập nhật trạng thái phòng thành công.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
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

    public function addCheckoutService(AddCheckoutServiceRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
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

    public function checkoutSelectedRooms(CheckoutSelectedRoomsRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $formattedResult = $this->roomMapService->checkoutSelectedRooms(
                $id,
                $validated['selected_room_ids'],
                $validated['pricing_mode']
            );

            if ($formattedResult['processed_count'] < 1) {
                return redirect()->back()->with('error', 'Không có phòng nào cần thanh toán.');
            }

            return redirect()->route('admin.room-map.detail', ['id' => $formattedResult['invoice_room_id']])
                ->with('checkout_success', $formattedResult)
                ->with('success', sprintf(
                    'Đã thanh toán %d phòng theo %s. Tổng tiền: %sđ (đã bao gồm VAT).',
                    $formattedResult['processed_count'],
                    ($validated['pricing_mode'] === 'daily' ? 'ngày' : 'giờ'),
                    number_format($formattedResult['grand_total'], 0, ',', '.')
                ));
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function previewCheckoutSelectedRooms(PreviewCheckoutSelectedRoomsRequest $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validated();

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
