<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Receptionist'],    // Lễ tân
            ['name' => 'Technician'],      // Kỹ thuật viên
            ['name' => 'Accountant'],      // Kế toán
        ];

        DB::table('roles')->insert($roles);
    }
}
