<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomType\DeleteImageRequest;
use App\Http\Requests\RoomType\SyncAmenitiesRequest;
use App\Http\Requests\RoomType\SyncEquipmentsRequest;
use App\Http\Requests\RoomType\UploadImageRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Services\Contracts\RoomTypeImageServiceInterface;
use App\Services\Contracts\RoomTypeServiceInterface;
use Illuminate\Http\Request;

/**
 * RoomTypeActionController
 * Handles all AJAX/API requests for room type operations
 * (Image uploads, deletions, and sync operations)
 *
 * Separation of concerns:
 * - Web routing logic is in RoomTypeController (index, create, edit, etc.)
 * - Action/API logic is here (uploadImage, syncAmenities, etc.)
 */
class RoomTypeActionController extends Controller
{
    use JsonResponseTrait;

    public function __construct(
        protected RoomTypeServiceInterface $roomTypeService,
        protected RoomTypeImageServiceInterface $roomTypeImageService
    ) {}

    /**
     * Upload temporary image during room type creation
     */
    public function uploadTempImage(UploadImageRequest $request)
    {
        try {
            $sessionId = $request->session()->getId();
            $result = $this->roomTypeImageService->uploadTempImage($request->file('image'), $sessionId);

            return response()->json([
                'success' => true,
                'image' => [
                    'id' => $result['id'],
                    'image_url' => $result['path'],
                ],
            ]);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Lỗi khi tải ảnh: '.$e->getMessage());
        }
    }

    /**
     * Delete temporary image during room type creation
     */
    public function deleteTempImage(DeleteImageRequest $request)
    {
        try {
            $path = $request->input('path');
            $sessionId = $request->session()->getId();

            $result = $this->roomTypeImageService->deleteTempImage($path, $sessionId);

            return $this->successResponse(null, $result['message'] ?? 'Ảnh được xóa thành công!');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Lỗi khi xóa ảnh: '.$e->getMessage());
        }
    }

    /**
     * Upload image to permanent storage (for editing)
     */
    public function uploadImage(UploadImageRequest $request, $id)
    {
        try {
            $roomType = $this->roomTypeService->findById($id);

            if (! $roomType) {
                return $this->notFoundResponse('Loại phòng không tồn tại.');
            }

            $result = $this->roomTypeImageService->uploadImage($request->file('image'), $id);

            return response()->json([
                'success' => true,
                'image' => [
                    'id' => $result['image']->id,
                    'image_url' => $result['image']->image_url,
                    'order' => $result['image']->order,
                ],
            ]);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Lỗi khi tải ảnh: '.$e->getMessage());
        }
    }

    /**
     * Delete image from permanent storage
     */
    public function deleteImage(Request $request, $id, $imageId)
    {
        try {
            $roomType = $this->roomTypeService->findById($id);

            if (! $roomType) {
                return $this->notFoundResponse('Loại phòng không tồn tại.');
            }

            $result = $this->roomTypeImageService->deleteImage($imageId, $id);

            return $this->successResponse(null, $result['message'] ?? 'Ảnh được xóa thành công!');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Lỗi khi xóa ảnh: '.$e->getMessage());
        }
    }

    /**
     * Sync amenities for a room type
     */
    public function syncAmenities(SyncAmenitiesRequest $request, $id)
    {
        try {
            $roomType = $this->roomTypeService->findById($id);

            if (! $roomType) {
                return $this->notFoundResponse('Loại phòng không tồn tại.');
            }

            $amenityIds = $request->input('amenity_ids', []);
            $roomType->amenities()->sync($amenityIds);

            return $this->successResponse(null, 'Tiện ích được cập nhật thành công!');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Lỗi khi cập nhật tiện ích: '.$e->getMessage());
        }
    }

    /**
     * Sync equipments for a room type
     */
    public function syncEquipments(SyncEquipmentsRequest $request, $id)
    {
        try {
            $roomType = $this->roomTypeService->findById($id);

            if (! $roomType) {
                return $this->notFoundResponse('Loại phòng không tồn tại.');
            }

            $equipmentData = $request->input('equipment_data', []);

            // Use service to handle equipment sync with quantities
            $this->roomTypeService->syncEquipmentsWithQuantities($roomType, $equipmentData);

            return $this->successResponse(null, 'Tài sản được cập nhật thành công!');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Lỗi khi cập nhật tài sản: '.$e->getMessage());
        }
    }
}
