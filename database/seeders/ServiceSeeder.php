<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // group_id: 1=Ẩm thực, 2=Giặt ủi, 3=Spa, 4=Đưa đón, 5=Thuê xe
        $services = [
            // Ẩm thực
            ['name' => 'Bữa sáng',          'group_id' => 1, 'unit_price' => 80000,  'unit' => 'phần'],
            ['name' => 'Nước khoáng',        'group_id' => 1, 'unit_price' => 20000,  'unit' => 'chai'],
            ['name' => 'Cà phê',            'group_id' => 1, 'unit_price' => 35000,  'unit' => 'ly'],
            // Giặt ủi
            ['name' => 'Giặt áo sơ mi',     'group_id' => 2, 'unit_price' => 30000,  'unit' => 'cái'],
            ['name' => 'Giặt quần dài',     'group_id' => 2, 'unit_price' => 40000,  'unit' => 'cái'],
            // Spa
            ['name' => 'Massage 60 phút',   'group_id' => 3, 'unit_price' => 350000, 'unit' => 'lần'],
            ['name' => 'Chăm sóc da mặt',  'group_id' => 3, 'unit_price' => 250000, 'unit' => 'lần'],
            // Đưa đón
            ['name' => 'Đưa đón sân bay',   'group_id' => 4, 'unit_price' => 250000, 'unit' => 'lượt'],
            // Thuê xe
            ['name' => 'Thuê xe 4 chỗ',    'group_id' => 5, 'unit_price' => 600000, 'unit' => 'ngày'],
            ['name' => 'Thuê xe 7 chỗ',    'group_id' => 5, 'unit_price' => 800000, 'unit' => 'ngày'],
        ];

        DB::table('services')->insert($services);
    }
}
