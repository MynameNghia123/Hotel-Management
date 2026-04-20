<?php

namespace App\Services\Contracts;

interface RoomTypeImageServiceInterface
{
    /**
     * Upload a temporary image during room type creation
     */
    public function uploadTempImage($file, $sessionId);

    /**
     * Delete a temporary image
     */
    public function deleteTempImage($path, $sessionId);

    /**
     * Upload image to permanent storage (for editing)
     */
    public function uploadImage($file, $roomTypeId);

    /**
     * Delete image from permanent storage
     */
    public function deleteImage($imageId, $roomTypeId);

    /**
     * Attach temporary images to room type after creation
     */
    public function attachTempImagesToRoomType($roomTypeId);

    /**
     * Get all images for a room type
     */
    public function getImagesByRoomType($roomTypeId);

    /**
     * Reorder images
     */
    public function reorderImages($roomTypeId, array $imageIds);
}
