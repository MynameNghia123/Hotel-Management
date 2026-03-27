<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // equipment_category_id: 1=Điện lạnh, 2=Điện tử, 3=Nội thất, 4=Vệ sinh, 5=Ánh sáng
        $equipments = [
            ['name' => 'Máy lạnh',          'equipment_category_id' => 1, 'import_price' => 8000000],
            ['name' => 'Tủ lạnh mini',      'equipment_category_id' => 1, 'import_price' => 3000000],
            ['name' => 'TV 43 inch',        'equipment_category_id' => 2, 'import_price' => 7000000],
            ['name' => 'Điện thoại bàn',    'equipment_category_id' => 2, 'import_price' => 500000],
            ['name' => 'Máy sấy tóc',       'equipment_category_id' => 2, 'import_price' => 300000],
            ['name' => 'Giường đôi',        'equipment_category_id' => 3, 'import_price' => 5000000],
            ['name' => 'Bàn làm việc',      'equipment_category_id' => 3, 'import_price' => 2000000],
            ['name' => 'Tủ quần áo',        'equipment_category_id' => 3, 'import_price' => 3000000],
            ['name' => 'Bồn cầu',           'equipment_category_id' => 4, 'import_price' => 2500000],
            ['name' => 'Vòi sen',           'equipment_category_id' => 4, 'import_price' => 1500000],
            ['name' => 'Đèn ngủ',           'equipment_category_id' => 5, 'import_price' => 300000],
            ['name' => 'Đèn trần',          'equipment_category_id' => 5, 'import_price' => 800000],
        ];

        DB::table('equipments')->insert($equipments);
    }
}
