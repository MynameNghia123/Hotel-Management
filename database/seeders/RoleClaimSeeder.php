<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleClaimSeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách các chức năng từ database
        $modules = [
            'room-map', 'room-map-edit', 'bookings', 'rooms',
            'room-types', 'equipment', 'repair-ticket', 'customers',
            'services', 'amenities', 'employees', 'roles', 'configuration'
        ];

        $actions = ['view', 'edit', 'create', 'delete'];
        $claims = [];

        // Admin (role_id=1): toàn quyền trên tất cả chức năng
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $claims[] = ['claim_name' => $module, 'claim_value' => $action, 'role_id' => 1];
            }
        }

        // Receptionist (role_id=2): bookings, customers
        foreach (['bookings', 'customers'] as $module) {
            foreach (['view', 'create', 'edit'] as $action) {
                $claims[] = ['claim_name' => $module, 'claim_value' => $action, 'role_id' => 2];
            }
        }

        // Technician (role_id=3): repair-ticket, rooms, equipment
        foreach (['repair-ticket', 'rooms', 'equipment'] as $module) {
            foreach ($actions as $action) {
                $claims[] = ['claim_name' => $module, 'claim_value' => $action, 'role_id' => 3];
            }
        }

        // Accountant (role_id=4): chỉ có quyền view
        foreach ($modules as $module) {
            $claims[] = ['claim_name' => $module, 'claim_value' => 'view', 'role_id' => 4];
        }

        DB::table('role_claims')->insert($claims);
    }
}
