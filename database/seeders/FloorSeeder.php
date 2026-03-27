<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FloorSeeder extends Seeder
{
    public function run(): void
    {
        $floors = [
            ['name' => 'Tầng 1'],
            ['name' => 'Tầng 2'],
            ['name' => 'Tầng 3'],
            ['name' => 'Tầng 4'],
            ['name' => 'Tầng 5'],
        ];

        DB::table('floors')->insert($floors);
    }
}
