<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomMapServiceInterface;
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
            'rooms'            => $rooms,
            'roomStatusCounts' => $roomStatusCounts,
            'floors'           => $floors,
            'roomTypes'        => $roomTypes,
            'customers'        => $customers,
            'recentBookings'   => $recentBookings,
            'filters'          => $filters,
        ] = $this->roomMapService->prepareDataForIndex($filters);

        return view('admin.room-map.index', compact(
            'rooms',
            'roomStatusCounts',
            'floors',
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

    public function invoice(): View
    {
        return view('admin.room-map.invoice', $this->roomMapService->prepareDataForInvoice());
    }
}
