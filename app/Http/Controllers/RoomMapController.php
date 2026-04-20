<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomMapServiceInterface;
use App\Services\Contracts\RoomTypeServiceInterface;
use App\Http\Requests\RoomMap\StoreFloorRequest;
use App\Http\Requests\RoomMap\UpdateFloorRequest;
use App\Http\Requests\RoomMap\StoreRoomRequest;
use App\Http\Requests\RoomMap\UpdateRoomRequest;
use Illuminate\Http\Request;

/**
 * RoomMapController
 * Manages Room Map (Floor and Room management)
 * Handles: index, create/store/edit/update/delete for both Floor and Room
 */
class RoomMapController extends Controller
{
    public function __construct(
        protected RoomMapServiceInterface $roomMapService,
        protected RoomTypeServiceInterface $roomTypeService
    ) {}

    /**
     * Display the room map with all floors and rooms
     */
    public function index()
    {
        $floors = $this->roomMapService->getAllFloors();
        $rooms = $this->roomMapService->getAllRooms();
        $roomTypes = $this->roomTypeService->getAll();

        return view('admin.room-map-edit.index', compact('floors', 'rooms', 'roomTypes'));
    }

    // ============================================
    // 🏢 FLOOR METHODS
    // ============================================

    /**
     * Show the form for creating a new floor
     */
    public function createFloor()
    {
        return view('admin.room-map-edit.create-floor');
    }

    /**
     * Store a newly created floor
     */
    public function storeFloor(StoreFloorRequest $request)
    {
        try {
            $validated = $request->validated();
            $floor = $this->roomMapService->createFloor($validated);

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Tầng '{$floor->name}' được tạo thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing a floor
     */
    public function editFloor($id)
    {
        $floor = $this->roomMapService->findFloorById($id);

        if (!$floor) {
            return redirect()->route('admin.room-map-edit.index')
                ->with('error', 'Không tìm thấy tầng này!');
        }

        return view('admin.room-map-edit.edit-floor', compact('floor'));
    }

    /**
     * Update the specified floor
     */
    public function updateFloor(UpdateFloorRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $floor = $this->roomMapService->updateFloor($id, $validated);

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Tầng '{$floor->name}' được cập nhật thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete the specified floor
     * 
     * KIỂM TRA TRƯỚC: Nếu floor có phòng → không được xóa
     */
    public function deleteFloor($id)
    {
        try {
            $floor = $this->roomMapService->findFloorById($id);

            if (!$floor) {
                return back()->with('error', 'Không tìm thấy tầng này!');
            }

            // Service sẽ check xem floor có phòng không
            // Nếu có → throw exception
            // Nếu không → xóa bình thường
            $this->roomMapService->deleteFloor($id);

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Tầng '{$floor->name}' được xóa thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ============================================
    // ROOM METHODS
    // ============================================

    /**
     * Show the form for creating a new room
     */
    public function createRoom()
    {
        $floors = $this->roomMapService->getAllFloors();
        $roomTypes = $this->roomTypeService->getAll();

        return view('admin.room-map-edit.create-room', compact('floors', 'roomTypes'));
    }

    /**
     * Store a newly created room
     */
    public function storeRoom(StoreRoomRequest $request)
    {
        try {
            $validated = $request->validated();
            $room = $this->roomMapService->createRoom($validated);

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Phòng '{$room->name}' được tạo thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing a room
     */
    public function editRoom($id)
    {
        $room = $this->roomMapService->findRoomById($id);

        if (!$room) {
            return redirect()->route('admin.room-map-edit.index')
                ->with('error', 'Không tìm thấy phòng này!');
        }

        $floors = $this->roomMapService->getAllFloors();
        $roomTypes = $this->roomTypeService->getAll();

        return view('admin.room-map-edit.edit-room', compact('room', 'floors', 'roomTypes'));
    }

    /**
     * Update the specified room
     */
    public function updateRoom(UpdateRoomRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $room = $this->roomMapService->updateRoom($id, $validated);

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Phòng '{$room->name}' được cập nhật thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete the specified room
     */
    public function deleteRoom($id)
    {
        try {
            $room = $this->roomMapService->findRoomById($id);

            if (!$room) {
                return back()->with('error', 'Không tìm thấy phòng này!');
            }

            $this->roomMapService->deleteRoom($id);

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Phòng '{$room->name}' được xóa thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
