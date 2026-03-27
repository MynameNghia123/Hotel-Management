<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeImageSeeder extends Seeder
{
    public function run(): void
    {
        // Mỗi loại phòng có 3 ảnh. URL dạng placeholder để thay sau.
        $data = [
            // Standard (room_type_id = 1)
            ['room_type_id' => 1, 'image_url' => 'images/room-types/standard/standard-1.jpg', 'order' => 1],
            ['room_type_id' => 1, 'image_url' => 'images/room-types/standard/standard-2.jpg', 'order' => 2],
            ['room_type_id' => 1, 'image_url' => 'images/room-types/standard/standard-3.jpg', 'order' => 3],

            // Superior (room_type_id = 2)
            ['room_type_id' => 2, 'image_url' => 'images/room-types/superior/superior-1.jpg', 'order' => 1],
            ['room_type_id' => 2, 'image_url' => 'images/room-types/superior/superior-2.jpg', 'order' => 2],
            ['room_type_id' => 2, 'image_url' => 'images/room-types/superior/superior-3.jpg', 'order' => 3],

            // Deluxe (room_type_id = 3)
            ['room_type_id' => 3, 'image_url' => 'images/room-types/deluxe/deluxe-1.jpg', 'order' => 1],
            ['room_type_id' => 3, 'image_url' => 'images/room-types/deluxe/deluxe-2.jpg', 'order' => 2],
            ['room_type_id' => 3, 'image_url' => 'images/room-types/deluxe/deluxe-3.jpg', 'order' => 3],

            // Suite (room_type_id = 4)
            ['room_type_id' => 4, 'image_url' => 'images/room-types/suite/suite-1.jpg', 'order' => 1],
            ['room_type_id' => 4, 'image_url' => 'images/room-types/suite/suite-2.jpg', 'order' => 2],
            ['room_type_id' => 4, 'image_url' => 'images/room-types/suite/suite-3.jpg', 'order' => 3],
        ];

        DB::table('room_type_images')->insert($data);
    }
}
