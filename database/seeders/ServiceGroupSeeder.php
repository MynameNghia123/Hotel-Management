<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['service_name' => 'Ẩm thực'],
            ['service_name' => 'Giặt ủi'],
            ['service_name' => 'Spa & Làm đẹp'],
            ['service_name' => 'Đưa đón'],
            ['service_name' => 'Thuê xe'],
        ];

        DB::table('service_groups')->insert($groups);
    }
}
