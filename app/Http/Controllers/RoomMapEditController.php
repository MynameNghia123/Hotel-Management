<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\RoomTypeServiceInterface;
use App\Services\Contracts\FloorServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Http\Requests\RoomMap\StoreFloorRequest;
use App\Http\Requests\RoomMap\StoreRoomRequest;

class RoomMapEditController extends Controller
{
    public function __construct(
        private readonly RoomTypeServiceInterface $roomTypeService,
        private readonly FloorServiceInterface    $floorService,
        private readonly RoomServiceInterface     $roomService
    ) {}

    // ============================================
    // ROOM MAP INDEX
    // ============================================

    public function index(Request $request)
    {
        $selectedTypeId = $request->query('type_id');

        return view('admin.room-map-edit.index', [
            'roomTypes'    => $this->roomTypeService->getAllWithRoomCount(),
            'selectedType' => $selectedTypeId
                ? $this->roomTypeService->findWithDetails($selectedTypeId)
                : null,
            'floors'       => $this->floorService->getAll(),
            'rooms'        => $this->roomService->getAll(),
        ]);
    }

    // ============================================
    // FLOOR
    // ============================================

    public function createFloor()
    {
        return view('admin.room-map-edit.create-floor');
    }

    public function storeFloor(StoreFloorRequest $request)
    {
        $this->floorService->create($request->validated());

        return redirect()->route('admin.room-map-edit.index')
            ->with('success', 'Thêm tầng thành công!');
    }

    public function destroyFloor($id)
    {
        $floor = $this->floorService->findById($id);

        if ($floor->rooms()->count() > 0) {
            return redirect()->route('admin.room-map-edit.index')
                ->with('error', 'Không thể xóa tầng này vì vẫn còn phòng bên trong. Vui lòng xóa hết phòng trước.');
        }

        $this->floorService->delete($id);

        return redirect()->route('admin.room-map-edit.index')
            ->with('success', 'Xóa tầng thành công!');
    }

    // ============================================
    // ROOM
    // ============================================

    public function createRoom(Request $request)
    {
        return view('admin.room-map-edit.create-room', [
            'floors'    => $this->floorService->getAll(),
            'roomTypes' => $this->roomTypeService->getAll(),
            'floorId'   => $request->query('floor_id'),
            'typeId'    => $request->query('type_id'),
        ]);
    }

    public function storeRoom(StoreRoomRequest $request)
    {
        $data = $request->validated();
        $data['status'] ??= 'available';

        $this->roomService->create($data);

        return redirect()->route('admin.room-map-edit.index', ['type_id' => $data['room_type_id']])
            ->with('success', 'Thêm phòng thành công!');
    }

    public function destroyRoom($id)
    {
        $this->roomService->delete($id);

        return redirect()->back()->with('success', 'Xóa phòng thành công!');
    }
}
