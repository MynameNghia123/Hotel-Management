<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'setting_key'   => 'hotel_name',
                'setting_value' => 'Grand Palace Hotel',
                'description'   => 'Tên khách sạn',
            ],
            [
                'setting_key'   => 'hotel_address',
                'setting_value' => '123 Đường Lê Lợi, Quận 1, TP.HCM',
                'description'   => 'Địa chỉ khách sạn',
            ],
            [
                'setting_key'   => 'hotel_phone',
                'setting_value' => '028 1234 5678',
                'description'   => 'Số điện thoại liên hệ',
            ],
            [
                'setting_key'   => 'checkin_time',
                'setting_value' => '14:00',
                'description'   => 'Giờ check-in tiêu chuẩn',
            ],
            [
                'setting_key'   => 'checkout_time',
                'setting_value' => '12:00',
                'description'   => 'Giờ check-out tiêu chuẩn',
            ],
            [
                'setting_key'   => 'tax_rate',
                'setting_value' => '0.10',
                'description'   => 'Thuế VAT (10%)',
            ],
        ];

        DB::table('system_settings')->insertOrIgnore($settings);
    }
}
