<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeAmenitySeeder extends Seeder
{
    public function run(): void
    {
        // amenity_id: 1=WiFi, 2=Điều hòa, 3=TV, 4=Tủ lạnh, 5=Két, 6=Bồn tắm,
        //             7=Vòi sen, 8=Ban công, 9=Máy pha cà phê, 10=Minibar
        $data = [
            // Standard: WiFi, Điều hòa, TV, Vòi sen
            ['room_type_id' => 1, 'amenity_id' => 1],
            ['room_type_id' => 1, 'amenity_id' => 2],
            ['room_type_id' => 1, 'amenity_id' => 3],
            ['room_type_id' => 1, 'amenity_id' => 7],

            // Superior: thêm Tủ lạnh, Ban công
            ['room_type_id' => 2, 'amenity_id' => 1],
            ['room_type_id' => 2, 'amenity_id' => 2],
            ['room_type_id' => 2, 'amenity_id' => 3],
            ['room_type_id' => 2, 'amenity_id' => 4],
            ['room_type_id' => 2, 'amenity_id' => 7],
            ['room_type_id' => 2, 'amenity_id' => 8],

            // Deluxe: thêm Két an toàn, Máy pha cà phê
            ['room_type_id' => 3, 'amenity_id' => 1],
            ['room_type_id' => 3, 'amenity_id' => 2],
            ['room_type_id' => 3, 'amenity_id' => 3],
            ['room_type_id' => 3, 'amenity_id' => 4],
            ['room_type_id' => 3, 'amenity_id' => 5],
            ['room_type_id' => 3, 'amenity_id' => 7],
            ['room_type_id' => 3, 'amenity_id' => 8],
            ['room_type_id' => 3, 'amenity_id' => 9],

            // Suite: đầy đủ tất cả 10 tiện nghi
            ['room_type_id' => 4, 'amenity_id' => 1],
            ['room_type_id' => 4, 'amenity_id' => 2],
            ['room_type_id' => 4, 'amenity_id' => 3],
            ['room_type_id' => 4, 'amenity_id' => 4],
            ['room_type_id' => 4, 'amenity_id' => 5],
            ['room_type_id' => 4, 'amenity_id' => 6],
            ['room_type_id' => 4, 'amenity_id' => 7],
            ['room_type_id' => 4, 'amenity_id' => 8],
            ['room_type_id' => 4, 'amenity_id' => 9],
            ['room_type_id' => 4, 'amenity_id' => 10],
        ];

        DB::table('room_type_amenities')->insert($data);
    }
}
