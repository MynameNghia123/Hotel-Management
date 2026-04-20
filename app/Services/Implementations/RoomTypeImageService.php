<?php

namespace App\Services\Implementations;

use App\Services\Contracts\RoomTypeImageServiceInterface;
use App\Models\RoomTypeImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RoomTypeImageService implements RoomTypeImageServiceInterface
{
    const TEMP_DIR_PREFIX = 'room-types/temp';
    const PERMANENT_DIR = 'room-types';
    const MAX_FILE_SIZE = 5120; // 5MB in KB

    /**
     * Upload a temporary image during room type creation
     */
    public function uploadTempImage($file, $sessionId)
    {
        try {
            // Validate file
            if (!$file || !$file->isValid()) {
                throw new \Exception('File không hợp lệ.');
            }

            $tempDir = self::TEMP_DIR_PREFIX . "/{$sessionId}";
            $filename = time() . '_' . $file->hashName();
            $path = $file->storeAs($tempDir, $filename, 'public');

            Log::info('Image uploaded', [
                'tempDir' => $tempDir,
                'filename' => $filename,
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'exists' => Storage::disk('public')->exists($path)
            ]);

            // Store in session
            $tempImages = Session::get('temp_images', []);
            $imageId = uniqid();
            $tempImages[] = [
                'id' => $imageId,
                'path' => $path
            ];
            Session::put('temp_images', $tempImages);

            return [
                'success' => true,
                'id' => $imageId,
                'path' => Storage::disk('public')->url($path)
            ];
        } catch (\Exception $e) {
            Log::error('RoomTypeImageService::uploadTempImage - ' . $e->getMessage(), [
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Delete a temporary image
     */
    public function deleteTempImage($path, $sessionId)
    {
        try {
            if (!$path) {
                throw new \Exception('Đường dẫn ảnh không hợp lệ.');
            }

            // Convert URL to storage path if needed
            // If $path is a URL like /storage/room-types/..., convert to storage path
            $storagePath = $path;
            if (strpos($path, '/storage/') === 0) {
                $storagePath = substr($path, strlen('/storage/'));
            }

            // Delete file from storage
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }

            // Remove from session
            $tempImages = Session::get('temp_images', []);
            $tempImages = array_filter($tempImages, function ($img) use ($storagePath) {
                return $img['path'] !== $storagePath;
            });
            Session::put('temp_images', array_values($tempImages));

            return [
                'success' => true,
                'message' => 'Ảnh được xóa thành công!'
            ];
        } catch (\Exception $e) {
            Log::error('RoomTypeImageService::deleteTempImage - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Upload image to permanent storage (for editing)
     */
    public function uploadImage($file, $roomTypeId)
    {
        try {
            if (!$file || !$file->isValid()) {
                throw new \Exception('File không hợp lệ.');
            }

            $filename = time() . '_' . $file->hashName();
            $path = $file->storeAs(self::PERMANENT_DIR, $filename, 'public');

            // Create image record
            $imageUrl = Storage::disk('public')->url($path);
            $maxOrder = RoomTypeImage::where('room_type_id', $roomTypeId)->max('order') ?? 0;

            $image = RoomTypeImage::create([
                'room_type_id' => $roomTypeId,
                'image_url' => $imageUrl,
                'order' => $maxOrder + 1
            ]);

            return [
                'success' => true,
                'image' => $image,
                'image_url' => $imageUrl,
                'message' => 'Ảnh được tải lên thành công!'
            ];
        } catch (\Exception $e) {
            Log::error('RoomTypeImageService::uploadImage - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete image from permanent storage
     */
    public function deleteImage($imageId, $roomTypeId)
    {
        try {
            $image = RoomTypeImage::find($imageId);

            if (!$image || $image->room_type_id != $roomTypeId) {
                throw new \Exception('Ảnh không tồn tại.');
            }

            // Delete file from storage
            $imagePath = $image->image_url;
            if (strpos($imagePath, '/storage/') === 0) {
                $imagePath = substr($imagePath, strlen('/storage/'));
            }
            
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $image->delete();

            return [
                'success' => true,
                'message' => 'Ảnh được xóa thành công!'
            ];
        } catch (\Exception $e) {
            Log::error('RoomTypeImageService::deleteImage - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Attach temporary images to room type after creation
     */
    public function attachTempImagesToRoomType($roomTypeId)
    {
        try {
            $tempImages = Session::get('temp_images', []);

            if (empty($tempImages)) {
                return [
                    'success' => true,
                    'count' => 0,
                    'message' => 'Không có ảnh tạm để đính kèm.'
                ];
            }

            $maxOrder = RoomTypeImage::where('room_type_id', $roomTypeId)->max('order') ?? 0;
            $count = 0;

            foreach ($tempImages as $index => $tempImage) {
                try {
                    // Convert temp path to permanent path
                    $tempPath = $tempImage['path'];
                    $sessionId = Session::getId();
                    $permanentPath = str_replace("/temp/{$sessionId}/", '/', $tempPath);

                    // Move file from temp to permanent
                    if (Storage::disk('public')->exists($tempPath)) {
                        $content = Storage::disk('public')->get($tempPath);
                        Storage::disk('public')->put($permanentPath, $content);
                        Storage::disk('public')->delete($tempPath);
                    }

                    // Create image record
                    RoomTypeImage::create([
                        'room_type_id' => $roomTypeId,
                        'image_url' => Storage::disk('public')->url($permanentPath),
                        'order' => $maxOrder + $index + 1
                    ]);

                    $count++;
                } catch (\Exception $e) {
                    Log::warning('Failed to attach single image: ' . $e->getMessage());
                    continue;
                }
            }

            // Clear temp images from session
            Session::forget('temp_images');

            // Clean up empty temp directory
            $this->cleanupTempDirectory(Session::getId());

            return [
                'success' => true,
                'count' => $count,
                'message' => "Đã đính kèm {$count} ảnh thành công!"
            ];
        } catch (\Exception $e) {
            Log::error('RoomTypeImageService::attachTempImagesToRoomType - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all images for a room type
     */
    public function getImagesByRoomType($roomTypeId)
    {
        try {
            return RoomTypeImage::where('room_type_id', $roomTypeId)
                ->orderBy('order')
                ->get();
        } catch (\Exception $e) {
            Log::error('RoomTypeImageService::getImagesByRoomType - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Reorder images
     */
    public function reorderImages($roomTypeId, array $imageIds)
    {
        try {
            foreach ($imageIds as $order => $imageId) {
                RoomTypeImage::where('id', $imageId)
                    ->where('room_type_id', $roomTypeId)
                    ->update(['order' => $order + 1]);
            }

            return [
                'success' => true,
                'message' => 'Ảnh được sắp xếp lại thành công!'
            ];
        } catch (\Exception $e) {
            Log::error('RoomTypeImageService::reorderImages - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Clean up empty temp directory
     */
    private function cleanupTempDirectory($sessionId)
    {
        try {
            $tempDir = self::TEMP_DIR_PREFIX . "/{$sessionId}";
            if (Storage::disk('public')->exists($tempDir)) {
                $files = Storage::disk('public')->files($tempDir);
                if (empty($files)) {
                    Storage::disk('public')->deleteDirectory($tempDir);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to cleanup temp directory: ' . $e->getMessage());
        }
    }
}
