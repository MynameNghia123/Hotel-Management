<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleClaimSeeder extends Seeder
{
    public function run(): void
    {
        // role_id: 1=Admin, 2=Receptionist, 3=Technician, 4=Accountant
        $claims = [
            // Admin: toàn quyền
            ['claim_name' => 'permission', 'claim_value' => 'booking.manage',     'role_id' => 1],
            ['claim_name' => 'permission', 'claim_value' => 'room.manage',         'role_id' => 1],
            ['claim_name' => 'permission', 'claim_value' => 'staff.manage',        'role_id' => 1],
            ['claim_name' => 'permission', 'claim_value' => 'report.view',         'role_id' => 1],
            ['claim_name' => 'permission', 'claim_value' => 'settings.manage',     'role_id' => 1],

            // Receptionist: quản lý booking
            ['claim_name' => 'permission', 'claim_value' => 'booking.manage',     'role_id' => 2],
            ['claim_name' => 'permission', 'claim_value' => 'customer.view',       'role_id' => 2],

            // Technician: quản lý bảo trì
            ['claim_name' => 'permission', 'claim_value' => 'maintenance.manage', 'role_id' => 3],
            ['claim_name' => 'permission', 'claim_value' => 'room.view',           'role_id' => 3],

            // Accountant: xem báo cáo, thanh toán
            ['claim_name' => 'permission', 'claim_value' => 'payment.manage',     'role_id' => 4],
            ['claim_name' => 'permission', 'claim_value' => 'report.view',         'role_id' => 4],
        ];

        DB::table('role_claims')->insert($claims);
    }
}
