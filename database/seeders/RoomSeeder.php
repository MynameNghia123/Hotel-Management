<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // room_type_id: 1=Standard, 2=Superior, 3=Deluxe, 4=Suite
        // floor_id: 1=T1, 2=T2, 3=T3, 4=T4, 5=T5
        $rooms = [
            // Tầng 1 — Standard
            ['room_type_id' => 1, 'floor_id' => 1, 'name' => '101', 'status' => 'available'],
            ['room_type_id' => 1, 'floor_id' => 1, 'name' => '102', 'status' => 'available'],
            ['room_type_id' => 1, 'floor_id' => 1, 'name' => '103', 'status' => 'occupied'],
            ['room_type_id' => 1, 'floor_id' => 1, 'name' => '104', 'status' => 'maintenance'],

            // Tầng 2 — Superior
            ['room_type_id' => 2, 'floor_id' => 2, 'name' => '201', 'status' => 'available'],
            ['room_type_id' => 2, 'floor_id' => 2, 'name' => '202', 'status' => 'available'],
            ['room_type_id' => 2, 'floor_id' => 2, 'name' => '203', 'status' => 'occupied'],

            // Tầng 3 — Deluxe
            ['room_type_id' => 3, 'floor_id' => 3, 'name' => '301', 'status' => 'available'],
            ['room_type_id' => 3, 'floor_id' => 3, 'name' => '302', 'status' => 'available'],

            // Tầng 4 — Deluxe
            ['room_type_id' => 3, 'floor_id' => 4, 'name' => '401', 'status' => 'available'],
            ['room_type_id' => 3, 'floor_id' => 4, 'name' => '402', 'status' => 'occupied'],

            // Tầng 5 — Suite
            ['room_type_id' => 4, 'floor_id' => 5, 'name' => '501', 'status' => 'available'],
            ['room_type_id' => 4, 'floor_id' => 5, 'name' => '502', 'status' => 'available'],
        ];

        DB::table('rooms')->insert($rooms);
    }
}
