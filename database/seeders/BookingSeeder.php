<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // customer_id: 1-5 | staff_id: 1-4 (nullable)
        // Status: pending | confirmed | occupied | paid | cancelled
        $bookings = [
            [
                // Khách 1 — đã thanh toán (lịch sử)
                'customer_id' => 1,
                'booking_date' => '2026-03-18 14:00:00',
                'staff_id' => 2,
                'total_service_amount' => 200000,
                'total_room_amount' => 1000000,
                'surcharge_amount' => 0,
                'final_amount' => 1200000,
                'status' => 'paid',
            ],
            [
                // Khách 2 — đang ở
                'customer_id' => 2,
                'booking_date' => '2026-03-27 09:00:00',
                'staff_id' => 2,
                'total_service_amount' => 420000,
                'total_room_amount' => 1600000,
                'surcharge_amount' => 0,
                'final_amount' => 2020000,
                'status' => 'occupied',
            ],
            [
                // Khách 3 — đã xác nhận, chờ check-in
                'customer_id' => 3,
                'booking_date' => '2026-03-26 10:30:00',
                'staff_id' => 2,
                'total_service_amount' => 0,
                'total_room_amount' => 2400000,
                'surcharge_amount' => 0,
                'final_amount' => 2400000,
                'status' => 'confirmed',
            ],
            [
                // Khách 4 — đặt qua web, chưa xác nhận
                'customer_id' => 4,
                'booking_date' => '2026-03-27 15:00:00',
                'staff_id' => null,
                'total_service_amount' => 0,
                'total_room_amount' => 5000000,
                'surcharge_amount' => 0,
                'final_amount' => 5000000,
                'status' => 'pending',
            ],
            [
                // Khách 5 — đang ở
                'customer_id' => 5,
                'booking_date' => '2026-03-26 16:00:00',
                'staff_id' => 2,
                'total_service_amount' => 350000,
                'total_room_amount' => 2400000,
                'surcharge_amount' => 50000,
                'final_amount' => 2800000,
                'status' => 'occupied',
            ],
        ];

        DB::table('bookings')->insert($bookings);
    }
}
