<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'first_name' => 'Nguyễn',
                'last_name' => 'Văn An',
                'phone_number' => '0981234501',
                'country' => 'Việt Nam',
                'email' => 'nguyen.van.an@gmail.com',
            ],
            [
                'first_name' => 'Trần',
                'last_name' => 'Thị Bình',
                'phone_number' => '0981234502',
                'country' => 'Việt Nam',
                'email' => 'tran.thi.binh@gmail.com',
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'phone_number' => '+14151234567',
                'country' => 'United States',
                'email' => 'john.smith@gmail.com',
            ],
            [
                'first_name' => 'Li',
                'last_name' => 'Wei',
                'phone_number' => '+8613812345678',
                'country' => 'China',
                'email' => 'li.wei@outlook.com',
            ],
            [
                'first_name' => 'Phạm',
                'last_name' => 'Minh Tuấn',
                'phone_number' => '0981234505',
                'country' => 'Việt Nam',
                'email' => 'pham.minh.tuan@gmail.com',
            ],
        ];

        DB::table('customers')->insert($customers);
    }
}
