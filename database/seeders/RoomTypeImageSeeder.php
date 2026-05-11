<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RoomTypeImageSeeder extends Seeder
{
    public function run(): void
    {
        $roomTypeIds = [1, 2, 3, 4];
        $rows = [];

        $storageDir = public_path('storage/room-types');
        $storageImages = [];

        if (File::exists($storageDir)) {
            $storageImages = collect(File::files($storageDir))
                ->filter(
                    fn (\SplFileInfo $file) => in_array(
                        strtolower($file->getExtension()),
                        ['jpg', 'jpeg', 'png', 'webp'],
                        true
                    )
                )
                ->sortBy(fn (\SplFileInfo $file) => $file->getFilename())
                ->map(fn (\SplFileInfo $file) => '/storage/room-types/' . $file->getFilename())
                ->values()
                ->all();
        }

        // Fallback when storage images are not present (keeps seeder runnable on fresh setup).
        $fallbackImages = [
            '/img/room-deluxe.png',
            '/img/room-suite.png',
            '/img/room-penthouse.png',
        ];

        foreach ($roomTypeIds as $roomTypeId) {
            for ($order = 1; $order <= 3; $order++) {
                $index = (($roomTypeId - 1) * 3) + ($order - 1);

                $rows[] = [
                    'room_type_id' => $roomTypeId,
                    'image_url' => $storageImages[$index] ?? $fallbackImages[($order - 1) % count($fallbackImages)],
                    'order' => $order,
                ];
            }
        }

        // Prevent duplicated rows when running this seeder multiple times.
        DB::table('room_type_images')
            ->whereIn('room_type_id', $roomTypeIds)
            ->delete();

        DB::table('room_type_images')->insert($rows);
    }
}
