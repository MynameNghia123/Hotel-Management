<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Contracts\RoomTypeServiceInterface;
use App\Services\Contracts\FloorServiceInterface;
use App\Services\Contracts\RoomServiceInterface;

class RoomMapEditController extends Controller
{
    protected $roomTypeService;
    protected $floorService;
    protected $roomService;

    public function __construct(
        RoomTypeServiceInterface $roomTypeService,
        FloorServiceInterface $floorService,
        RoomServiceInterface $roomService
    ) {
        $this->roomTypeService = $roomTypeService;
        $this->floorService = $floorService;
        $this->roomService = $roomService;
    }

    public function index(Request $request)
    {
        $roomTypes = $this->roomTypeService->getAllWithRoomCount();
        
        $selectedTypeId = $request->query('type_id');
        if ($selectedTypeId) {
            $selectedType = $this->roomTypeService->findWithDetails($selectedTypeId);
        } else {
            $selectedType = $roomTypes->first();
        }

        $floors = $this->floorService->getAllFloors();

        return view('admin.room-map-edit.index', compact('roomTypes', 'selectedType', 'floors'));
    }

    public function createFloor()
    {
        return view('admin.room-map-edit.create-floor');
    }

    public function storeFloor(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->floorService->createFloor($data);

        return redirect()->route('admin.room-map-edit.index')->with('success', 'Thêm tầng thành công!');
    }

    public function createRoom(Request $request)
    {
        // Get floor and type from query to pre-fill if available
        $floorId = $request->query('floor_id');
        $typeId = $request->query('type_id');
        
        $floors = $this->floorService->getAllFloors();
        $roomTypes = \App\Models\RoomType::all();
        
        return view('admin.room-map-edit.create-room', compact('floors', 'roomTypes', 'floorId', 'typeId'));
    }

    public function storeRoom(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'floor_id' => 'required|exists:floors,id',
            'room_type_id' => 'required|exists:room_types,id',
            'status' => 'nullable|string'
        ]);

        if (!isset($data['status'])) {
            $data['status'] = 'available'; // Default status
        }

        $this->roomService->createRoom($data);

        return redirect()->route('admin.room-map-edit.index', ['type_id' => $data['room_type_id']])->with('success', 'Thêm phòng thành công!');
    }

    public function destroyFloor($id)
    {
        $floor = $this->floorService->findFloorById($id);
        if ($floor->rooms()->count() > 0) {
            return redirect()->route('admin.room-map-edit.index')
                ->with('error', 'Không thể xóa tầng này vì vẫn còn phòng bên trong. Vui lòng xóa hết phòng trước.');
        }

        $this->floorService->deleteFloor($id);
        return redirect()->route('admin.room-map-edit.index')->with('success', 'Xóa tầng thành công!');
    }

    public function destroyRoom($id)
    {
        $this->roomService->deleteRoom($id);
        return redirect()->back()->with('success', 'Xóa phòng thành công!');
    }
}
