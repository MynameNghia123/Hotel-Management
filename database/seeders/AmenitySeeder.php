<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            ['name' => 'WiFi miễn phí',       'icon' => 'wifi'],
            ['name' => 'Điều hòa nhiệt độ',    'icon' => 'air-conditioner'],
            ['name' => 'TV màn hình phẳng',    'icon' => 'tv'],
            ['name' => 'Tủ lạnh mini',          'icon' => 'fridge'],
            ['name' => 'Két an toàn',           'icon' => 'safe'],
            ['name' => 'Bồn tắm',              'icon' => 'bathtub'],
            ['name' => 'Vòi sen',              'icon' => 'shower'],
            ['name' => 'Ban công',             'icon' => 'balcony'],
            ['name' => 'Máy pha cà phê',       'icon' => 'coffee'],
            ['name' => 'Minibar',              'icon' => 'minibar'],
        ];

        DB::table('amenities')->insert($amenities);
    }
}
