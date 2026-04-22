<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomMapServiceInterface;
use App\Http\Requests\RoomMap\StoreFloorRequest;
use App\Http\Requests\RoomMap\UpdateFloorRequest;
use App\Http\Requests\RoomMap\StoreRoomRequest;
use App\Http\Requests\RoomMap\UpdateRoomRequest;

class RoomMapController extends Controller
{
    public function __construct(
        protected RoomMapServiceInterface $roomMapService
    ) {}

    // ============================================
    // ROOM MAP
    // ============================================

    public function index()
    {
        return view('admin.room-map-edit.index',[
            'floors'    => $floors,
            'rooms'     => $rooms,
            'roomTypes' => $roomTypes,
        ] = $this->roomMapService->prepareDataForIndex());
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
        try {
            $floor = $this->roomMapService->createFloor($request->validated());

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Tầng '{$floor->name}' được tạo thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editFloor($id)
    {
        $floor = $this->roomMapService->findFloorById($id);

        if (!$floor) {
            return redirect()->route('admin.room-map-edit.index')
                ->with('error', 'Không tìm thấy tầng này!');
        }

        return view('admin.room-map-edit.edit-floor', compact('floor'));
    }

    public function updateFloor(UpdateFloorRequest $request, $id)
    {
        try {
            $floor = $this->roomMapService->updateFloor($id, $request->validated());

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Tầng '{$floor->name}' được cập nhật thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteFloor($id)
    {
        try {
            $floor = $this->roomMapService->findFloorById($id);

            if (!$floor) {
                return back()->with('error', 'Không tìm thấy tầng này!');
            }

            $this->roomMapService->deleteFloor($id);

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Tầng '{$floor->name}' được xóa thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ============================================
    // ROOM
    // ============================================

    public function createRoom()
    {
        return view('admin.room-map-edit.create-room',[
            'floors'    => $floors,
            'roomTypes' => $roomTypes,
        ] = $this->roomMapService->prepareDataForCreateRoom());
    }

    public function storeRoom(StoreRoomRequest $request)
    {
        try {
            $room = $this->roomMapService->createRoom($request->validated());

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Phòng '{$room->name}' được tạo thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editRoom($id)
    {
        [
            'room'      => $room,
            'floors'    => $floors,
            'roomTypes' => $roomTypes,
        ] = $this->roomMapService->prepareDataForEditRoom($id);

        if (!$room) {
            return redirect()->route('admin.room-map-edit.index')
                ->with('error', 'Không tìm thấy phòng này!');
        }

        return view('admin.room-map-edit.edit-room', compact('room', 'floors', 'roomTypes'));
    }

    public function updateRoom(UpdateRoomRequest $request, $id)
    {
        try {
            $room = $this->roomMapService->updateRoom($id, $request->validated());

            return redirect()->route('admin.room-map-edit.index')
                ->with('success', "Phòng '{$room->name}' được cập nhật thành công!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

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
