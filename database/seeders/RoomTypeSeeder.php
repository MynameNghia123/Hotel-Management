<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $roomTypes = [
            [
                'name' => 'Standard',
                'code' => 'STD',
                'adult_quantity' => 2,
                'child_quantity' => 1,
                'single_bed_quantity' => 1,
                'double_bed_quantity' => 0,
                'width' => 4.50,
                'height' => 3.20,
                'hourly_price' => 80000,
                'daily_price' => 500000,
                'is_active' => true,
                'description' => 'Phòng Tiêu chuẩn, phù hợp cho 2 người lớn và 1 trẻ em.',
            ],
            [
                'name' => 'Superior',
                'code' => 'SUP',
                'adult_quantity' => 2,
                'child_quantity' => 2,
                'single_bed_quantity' => 0,
                'double_bed_quantity' => 1,
                'width' => 5.50,
                'height' => 3.50,
                'hourly_price' => 120000,
                'daily_price' => 800000,
                'is_active' => true,
                'description' => 'Phòng Superior với giường đôi, view đẹp.',
            ],
            [
                'name' => 'Deluxe',
                'code' => 'DLX',
                'adult_quantity' => 2,
                'child_quantity' => 2,
                'single_bed_quantity' => 0,
                'double_bed_quantity' => 1,
                'width' => 6.50,
                'height' => 4.00,
                'hourly_price' => 180000,
                'daily_price' => 1200000,
                'is_active' => true,
                'description' => 'Phòng Deluxe cao cấp, tiện nghi đầy đủ.',
            ],
            [
                'name' => 'Suite',
                'code' => 'SUT',
                'adult_quantity' => 4,
                'child_quantity' => 2,
                'single_bed_quantity' => 1,
                'double_bed_quantity' => 1,
                'width' => 10.00,
                'height' => 4.50,
                'hourly_price' => 350000,
                'daily_price' => 2500000,
                'is_active' => true,
                'description' => 'Phòng Suite sang trọng với phòng khách riêng.',
            ],
        ];

        DB::table('room_types')->insert($roomTypes);
    }
}
