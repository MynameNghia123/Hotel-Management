<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomTypeServiceInterface;
use App\Services\Contracts\AmenityServiceInterface;
use App\Services\Contracts\EquipmentServiceInterface;
use App\Models\RoomTypeImage;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomTypeService;
    protected $amenityService;
    protected $equipmentService;

    public function __construct(
        RoomTypeServiceInterface $roomTypeService,
        AmenityServiceInterface $amenityService,
        EquipmentServiceInterface $equipmentService
    ) {
        $this->roomTypeService = $roomTypeService;
        $this->amenityService = $amenityService;
        $this->equipmentService = $equipmentService;
    }

    public function index()
    {
        $roomTypes = $this->roomTypeService->getAllWithRoomCount();
        return view('admin.rooms.index', compact('roomTypes'));
    }


    public function create()
    {
        return view('admin.rooms.create');
    }


    public function show($id)
    {
        $roomType = $this->roomTypeService->findWithDetails($id);
        return view('admin.room-types.index', compact('roomType'));
    }

    public function store(Request $request)
    {
        
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
    public function edit($id)
    {
        $roomType = $this->roomTypeService->findWithDetails($id);
        $allAmenities = $this->amenityService->getAllAmenities();
        $allEquipments = $this->equipmentService->getAllEquipment();
        
        return view('admin.room-types.edit', compact('roomType', 'allAmenities', 'allEquipments'));
    }
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

    public function destroy($id)
    {
        $this->roomTypeService->delete($id);
        return redirect()->route('admin.rooms.index')->with('success', 'Đã xóa loại phòng!');
    }
    public function uploadImage(Request $request, $id)
    {
        $request->validate(['image' => 'required|image|max:5120']);
        $path = $request->file('image')->store('room-types', 'public');
        $image = RoomTypeImage::create([
            'room_type_id' => $id,
            'image_url'    => '/storage/' . $path,
            'order'        => RoomTypeImage::where('room_type_id', $id)->max('order') + 1,
        ]);
        return response()->json(['success' => true, 'image' => $image]);
    }
    public function deleteImage(Request $request, $id, $imageId)
    {
        $image = RoomTypeImage::where('id', $imageId)->where('room_type_id', $id)->firstOrFail();
        $filePath = str_replace('/storage/', '', $image->image_url);
        \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
        $image->delete();
        return response()->json(['success' => true]);
    }
    public function syncAmenities(Request $request, $id)
    {
        $roomType = $this->roomTypeService->findById($id);
        $amenityIds = $request->input('amenity_ids', []);
        $roomType->amenities()->sync($amenityIds);
        return response()->json(['success' => true, 'count' => count($amenityIds)]);
    }
    public function syncEquipments(Request $request, $id)
    {
        $roomType = $this->roomTypeService->findById($id);
        $equipments = $request->input('equipments', []);
        $syncData = [];
        foreach ($equipments as $item) {
            $syncData[$item['id']] = ['quantity' => (int)$item['quantity']];
        }
        $roomType->equipments()->sync($syncData);
        return response()->json(['success' => true, 'count' => count($syncData)]);
    }
}
