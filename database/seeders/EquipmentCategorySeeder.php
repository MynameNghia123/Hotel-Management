<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Điện lạnh'],
            ['name' => 'Đồ điện tử'],
            ['name' => 'Đồ nội thất'],
            ['name' => 'Thiết bị vệ sinh'],
            ['name' => 'Ánh sáng'],
        ];

        DB::table('equipment_categories')->insert($categories);
    }
}
