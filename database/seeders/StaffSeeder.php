<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // role_id: 1=Admin, 2=Receptionist, 3=Technician, 4=Accountant
        $staff = [
            [
                'role_id'       => 1,
                'first_name'    => 'Admin',
                'last_name'     => 'Hotel',
                'phone_number'  => '0933666999',
                'email'         => 'nghialam1509@gmail.com',
                'is_active'     => true,
                'password'      => Hash::make('123456'),
            ],
            [
                'role_id'       => 2,
                'first_name'    => 'Trần',
                'last_name'     => 'Thị Lễ Tân',
                'phone_number'  => '0912345678',
                'email'         => 'letan@hotel.com',
                'is_active'     => true,
                'password'      => Hash::make('password'),
            ],
            [
                'role_id'       => 3,
                'first_name'    => 'Lê',
                'last_name'     => 'Văn Kỹ Thuật',
                'phone_number'  => '0923456789',
                'email'         => 'kythuat@hotel.com',
                'is_active'     => true,
                'password'      => Hash::make('password'),
            ],
            [
                'role_id'       => 4,
                'first_name'    => 'Phạm',
                'last_name'     => 'Thị Kế Toán',
                'phone_number'  => '0934567890',
                'email'         => 'ketoan@hotel.com',
                'is_active'     => true,
                'password'      => Hash::make('password'),
            ],
        ];

        DB::table('staff')->insert($staff);
    }
}
