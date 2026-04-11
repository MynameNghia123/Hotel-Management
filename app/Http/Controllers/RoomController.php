<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomTypeServiceInterface;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomTypeService;

    public function __construct(RoomTypeServiceInterface $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }

    /**
     * Danh sách loại phòng
     */
    public function index()
    {
        $roomTypes = $this->roomTypeService->getAllWithRoomCount();
        return view('admin.rooms.index', compact('roomTypes'));
    }

    /**
     * Trang tạo mới loại phòng
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Lưu loại phòng mới
     */
    public function store(Request $request)
    {
        // Bạn có thể tạo Request riêng để validate chuẩn hơn
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:room_types,code',
            'hourly_price' => 'required|numeric',
            'daily_price' => 'required|numeric',
            'adult_quantity' => 'required|integer',
            'child_quantity' => 'required|integer',
            'single_bed_quantity' => 'required|integer',
            'double_bed_quantity' => 'required|integer',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $this->roomTypeService->create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Thêm loại phòng thành công!');
    }

    /**
     * Trang chỉnh sửa
     */
    public function edit($id)
    {
        $roomType = $this->roomTypeService->findById($id);
        return view('admin.rooms.edit', compact('roomType'));
    }

    /**
     * Cập nhật loại phòng
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:room_types,code,' . $id,
            'hourly_price' => 'required|numeric',
            'daily_price' => 'required|numeric',
            'adult_quantity' => 'required|integer',
            'child_quantity' => 'required|integer',
            'single_bed_quantity' => 'required|integer',
            'double_bed_quantity' => 'required|integer',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $this->roomTypeService->update($id, $data);

        return redirect()->route('admin.rooms.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa loại phòng
     */
    public function destroy($id)
    {
        $this->roomTypeService->delete($id);
        return redirect()->route('admin.rooms.index')->with('success', 'Đã xóa loại phòng!');
    }
}
