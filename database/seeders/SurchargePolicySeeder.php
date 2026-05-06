<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurchargePolicySeeder extends Seeder
{
    public function run(): void
    {
        // Chính sách phụ thu khi trả phòng trễ
        $policies = [
            [
                'policy_type' => 'late_checkout',
                'hour_mark'   => 1,     // Từ 1 tiếng trở lên tính thêm
                'price'       => 50000, // Phụ thu 50k/giờ
            ],
            [
                'policy_type' => 'late_checkout',
                'hour_mark'   => 3,     // Từ 3 tiếng: tính nửa ngày
                'price'       => 150000,
            ],
            [
                'policy_type' => 'late_checkout',
                'hour_mark'   => 6,     // Từ 6 tiếng: tính cả ngày
                'price'       => 300000,
            ],
            [
                'policy_type' => 'early_checkin',
                'hour_mark'   => 3,     // Đến sớm trước 3 tiếng
                'price'       => 100000,
            ],
        ];

        DB::table('surcharge_policies')->insertOrIgnore($policies);
    }
}
