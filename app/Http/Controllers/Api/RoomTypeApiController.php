<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Services\Contracts\RoomTypeImageServiceInterface;
use App\Services\Contracts\RoomTypeServiceInterface;

/**
 * RoomTypeApiController
 * Handles AJAX/API requests for RoomType store operation.
 * Called from the create form via fetch/XHR.
 */
class RoomTypeApiController extends Controller
{
    public function __construct(
        private readonly RoomTypeServiceInterface $roomTypeService,
        private readonly RoomTypeImageServiceInterface $roomTypeImageService
    ) {}

    /**
     * Create a new room type via AJAX
     * POST /api/room-types
     */
    public function store(StoreRoomTypeRequest $request)
    {
        try {
            $roomType = $this->roomTypeService->create($request->validated());
            $this->roomTypeImageService->attachTempImagesToRoomType($roomType->id);

            return response()->json([
                'success' => true,
                'room_type_id' => $roomType->id,
                'message' => 'Loại phòng được tạo thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo loại phòng: '.$e->getMessage(),
            ], 500);
        }
    }
}
