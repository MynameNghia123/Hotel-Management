<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // room_type_id: 1=Standard, 2=Superior, 3=Deluxe, 4=Suite
        // equipment_id: 1=Máy lạnh, 2=Tủ lạnh mini, 3=TV, 4=Điện thoại, 5=Máy sấy,
        //               6=Giường đôi, 7=Bàn làm việc, 8=Tủ quần áo, 9=Bồn cầu, 10=Vòi sen,
        //               11=Đèn ngủ, 12=Đèn trần
        $data = [
            // Standard
            ['room_type_id' => 1, 'equipment_id' => 1,  'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 3,  'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 4,  'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 5,  'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 7,  'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 8,  'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 9,  'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 10, 'quantity' => 1],
            ['room_type_id' => 1, 'equipment_id' => 11, 'quantity' => 2],
            ['room_type_id' => 1, 'equipment_id' => 12, 'quantity' => 1],

            // Superior (thêm Tủ lạnh mini + Giường đôi)
            ['room_type_id' => 2, 'equipment_id' => 1,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 2,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 3,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 4,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 5,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 6,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 7,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 8,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 9,  'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 10, 'quantity' => 1],
            ['room_type_id' => 2, 'equipment_id' => 11, 'quantity' => 2],
            ['room_type_id' => 2, 'equipment_id' => 12, 'quantity' => 1],

            // Deluxe (như Superior, TV to hơn)
            ['room_type_id' => 3, 'equipment_id' => 1,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 2,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 3,  'quantity' => 2],
            ['room_type_id' => 3, 'equipment_id' => 4,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 5,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 6,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 7,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 8,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 9,  'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 10, 'quantity' => 1],
            ['room_type_id' => 3, 'equipment_id' => 11, 'quantity' => 4],
            ['room_type_id' => 3, 'equipment_id' => 12, 'quantity' => 2],

            // Suite (đầy đủ + mỗi thứ nhiều hơn)
            ['room_type_id' => 4, 'equipment_id' => 1,  'quantity' => 2],
            ['room_type_id' => 4, 'equipment_id' => 2,  'quantity' => 1],
            ['room_type_id' => 4, 'equipment_id' => 3,  'quantity' => 3],
            ['room_type_id' => 4, 'equipment_id' => 4,  'quantity' => 2],
            ['room_type_id' => 4, 'equipment_id' => 5,  'quantity' => 2],
            ['room_type_id' => 4, 'equipment_id' => 6,  'quantity' => 1],
            ['room_type_id' => 4, 'equipment_id' => 7,  'quantity' => 2],
            ['room_type_id' => 4, 'equipment_id' => 8,  'quantity' => 2],
            ['room_type_id' => 4, 'equipment_id' => 9,  'quantity' => 2],
            ['room_type_id' => 4, 'equipment_id' => 10, 'quantity' => 2],
            ['room_type_id' => 4, 'equipment_id' => 11, 'quantity' => 6],
            ['room_type_id' => 4, 'equipment_id' => 12, 'quantity' => 4],
        ];

        DB::table('room_equipment')->insert($data);
    }
}
