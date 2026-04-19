<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomTypeServiceInterface;
use App\Services\Contracts\AmenityServiceInterface;
use App\Services\Contracts\EquipmentServiceInterface;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;
use App\Services\Contracts\RoomTypeImageServiceInterface;
use App\Http\Traits\PaginationTrait;
use Illuminate\Http\Request;

/**
 * RoomTypeController
 * Handles all web requests for room type operations
 * (Pages: index, create, edit, show, store, update, destroy)
 * 
 * Separation of concerns:
 * - Web routing logic is here (index, create, edit, etc.)
 * - Action/API logic is in RoomTypeActionController (uploadImage, syncAmenities, etc.)
 */
class RoomTypeController extends Controller
{
    use PaginationTrait;

    public function __construct(
        protected RoomTypeServiceInterface $roomTypeService,
        protected AmenityServiceInterface $amenityService,
        protected EquipmentServiceInterface $equipmentService,
        protected RoomTypeImageServiceInterface $roomTypeImageService
    ) {}

    /**
     * Display a listing of room types with pagination
     */
    public function index(Request $request)
    {
        $perPage = $this->getPerPage(10); // Default: 10, Allowed: [5, 10, 20, 50, 100]
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
     * Store a newly created room type in storage
     */
    public function store(StoreRoomTypeRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Create room type with amenities and equipments
            $roomType = $this->roomTypeService->create($validated);
            
            // Attach temporary images to the newly created room type
            $this->roomTypeImageService->attachTempImagesToRoomType($roomType->id);
            
            // Return JSON for AJAX requests (from create form)
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'room_type_id' => $roomType->id,
                    'message' => 'Loại phòng được tạo thành công!'
                ]);
            }

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Loại phòng được tạo thành công!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi tạo loại phòng: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Lỗi khi tạo loại phòng.');
        }
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
     * Show the form for editing the specified room type
     */
    public function edit($id)
    {
        $roomType = $this->roomTypeService->findWithDetails($id);
        
        // Format data for edit form using service
        $formData = $this->roomTypeService->formatForEditForm($roomType);
        
        $allAmenities = $this->amenityService->getAll();
        $allEquipments = $this->equipmentService->getAll();
        
        return view('admin.room-types.edit', array_merge(
            $formData,
            compact('allAmenities', 'allEquipments')
        ));
    }

    /**
     * Update the specified room type in storage
     */
    public function update(UpdateRoomTypeRequest $request, $id)
    {
        try {
            $roomType = $this->roomTypeService->findById($id);
            
            $validated = $request->validated();
            $this->roomTypeService->update($id, $validated);
            
            return redirect()->route('admin.rooms.index')
                ->with('success', 'Loại phòng được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi cập nhật loại phòng.');
        }
    }

    /**
     * Remove the specified room type from storage
     */
    public function destroy(Request $request, $id)
    {
        try {
            $roomType = $this->roomTypeService->findById($id);
            $this->roomTypeService->delete($id);

            
            return redirect()->route('admin.rooms.index')
                ->with('success', 'Loại phòng được xóa thành công!');
        } catch (\Exception $e) {

            return back()->with('error', 'Lỗi khi xóa loại phòng.');
        }
    }
}

