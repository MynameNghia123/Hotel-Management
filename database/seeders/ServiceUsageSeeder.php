<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceUsageSeeder extends Seeder
{
    public function run(): void
    {
        // booking_detail_id: 1=Booking1(checked_out), 2=Booking2(checked_in), 5=Booking5(checked_in)
        // service_id: 1=Bữa sáng(80k), 2=Nước khoáng(20k), 3=Cà phê(35k),
        //             4=Giặt áo(30k), 5=Giặt quần(40k), 6=Massage(350k), 7=Chăm sóc da(250k)
        $usages = [
            // Booking Detail 1 (đã check-out)
            [
                'booking_detail_id' => 1,
                'service_id' => 1,    // Bữa sáng
                'quantity' => 2,
                'unit_price' => 80000,
                'created_at' => '2026-03-21 08:00:00',
                'updated_at' => '2026-03-21 08:00:00',
            ],
            [
                'booking_detail_id' => 1,
                'service_id' => 2,    // Nước khoáng
                'quantity' => 2,
                'unit_price' => 20000,
                'created_at' => '2026-03-21 10:00:00',
                'updated_at' => '2026-03-21 10:00:00',
            ],

            // Booking Detail 2 (đang ở)
            [
                'booking_detail_id' => 2,
                'service_id' => 6,    // Massage 60 phút
                'quantity' => 1,
                'unit_price' => 350000,
                'created_at' => '2026-03-27 16:00:00',
                'updated_at' => '2026-03-27 16:00:00',
            ],
            [
                'booking_detail_id' => 2,
                'service_id' => 3,    // Cà phê
                'quantity' => 2,
                'unit_price' => 35000,
                'created_at' => '2026-03-27 08:30:00',
                'updated_at' => '2026-03-27 08:30:00',
            ],

            // Booking Detail 5 (đang ở)
            [
                'booking_detail_id' => 5,
                'service_id' => 6,    // Massage 60 phút
                'quantity' => 1,
                'unit_price' => 350000,
                'created_at' => '2026-03-26 18:00:00',
                'updated_at' => '2026-03-26 18:00:00',
            ],
            [
                'booking_detail_id' => 5,
                'service_id' => 8,    // Đưa đón sân bay
                'quantity' => 1,
                'unit_price' => 250000,
                'created_at' => '2026-03-26 13:00:00',
                'updated_at' => '2026-03-26 13:00:00',
            ],
        ];

        DB::table('service_usages')->insert($usages);
    }
}
