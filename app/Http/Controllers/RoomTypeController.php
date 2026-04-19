<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomTypeServiceInterface;
use App\Services\Contracts\AmenityServiceInterface;
use App\Services\Contracts\EquipmentServiceInterface;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;
use App\Http\Traits\PaginationTrait;
use App\Models\RoomTypeImage;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    use PaginationTrait;

    public function __construct(
        protected RoomTypeServiceInterface $roomTypeService,
        protected AmenityServiceInterface $amenityService,
        protected EquipmentServiceInterface $equipmentService
    ) {}

    /**
     * Display a listing of room types
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', $this->getPerPage(10));
        $filters = $request->input('filter', []);
        $roomTypes = $this->roomTypeService->getPaginated($filters, $perPage);

        $this->validatePageNumber($roomTypes->currentPage(), $roomTypes->lastPage(), 'abort');

        return view('admin.room-types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new room type
     */
    public function create()
    {
        $allAmenities = $this->amenityService->getAll();
        $allEquipments = $this->equipmentService->getAll();
        return view('admin.room-types.create', compact('allAmenities', 'allEquipments'));
    }

    /**
     * Display the specified room type
     */
    public function show($id)
    {
        $roomType = $this->roomTypeService->findWithDetails($id);
        return view('admin.room-types.show', compact('roomType'));
    }

    /**
     * Store a newly created room type
     */
    public function store(StoreRoomTypeRequest $request)
    {
        $this->roomTypeService->create($request->validated());
        return redirect()->route('admin.rooms.index')->with('success', 'Thêm loại phòng thành công!');
    }

    /**
     * Show the form for editing a room type
     */
    public function edit($id)
    {
        $roomType = $this->roomTypeService->findWithDetails($id);
        $allAmenities = $this->amenityService->getAll();
        $allEquipments = $this->equipmentService->getAll();

        return view('admin.room-types.edit', compact('roomType', 'allAmenities', 'allEquipments'));
    }

    /**
     * Update the specified room type
     */
    public function update(UpdateRoomTypeRequest $request, $id)
    {
        $this->roomTypeService->update($id, $request->validated());
        return redirect()->route('admin.rooms.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Delete the specified room type
     */
    public function destroy($id)
    {
        $this->roomTypeService->delete($id);
        return redirect()->route('admin.rooms.index')->with('success', 'Đã xóa loại phòng!');
    }

    /**
     * Upload an image for a room type
     */
    public function uploadImage(Request $request, $id)
    {
        $request->validate(['image' => 'required|image|max:5120']);
        $path = $request->file('image')->store('room-types', 'public');
        $image = RoomTypeImage::create([
            'room_type_id' => $id,
            'image_url' => '/storage/' . $path,
            'order' => RoomTypeImage::where('room_type_id', $id)->max('order') + 1,
        ]);
        return response()->json(['success' => true, 'image' => $image]);
    }

    /**
     * Delete an image from a room type
     */
    public function deleteImage(Request $request, $id, $imageId)
    {
        $image = RoomTypeImage::where('id', $imageId)->where('room_type_id', $id)->firstOrFail();
        $filePath = str_replace('/storage/', '', $image->image_url);
        \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
        $image->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Sync amenities for a room type
     */
    public function syncAmenities(Request $request, $id)
    {
        $roomType = $this->roomTypeService->findById($id);
        $amenityIds = $request->input('amenity_ids', []);
        $roomType->amenities()->sync($amenityIds);
        return response()->json(['success' => true, 'count' => count($amenityIds)]);
    }

    /**
     * Sync equipments for a room type
     */
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
