<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingDetailSeeder extends Seeder
{
    public function run(): void
    {
        // booking_id: 1-5
        // room_id: 3=103(Standard,occupied), 7=203(Superior,occupied),
        //          8=301(Deluxe), 12=501(Suite), 11=402(Deluxe,occupied)
        $details = [
            [
                // Booking 1 — phòng 103 (Standard), 2 đêm, đã check-out
                'room_id' => 3,
                'booking_id' => 1,
                'checkin_date' => '2026-03-20 14:00:00',
                'checkout_date' => '2026-03-22 12:00:00',
                'hourly_price' => 80000,
                'daily_price' => 500000,
                'service_amount' => 200000,
                'surcharge_amount' => 0,
            ],
            [
                // Booking 2 — phòng 203 (Superior), 2 đêm, đang ở
                'room_id' => 7,
                'booking_id' => 2,
                'checkin_date' => '2026-03-27 14:00:00',
                'checkout_date' => '2026-03-29 12:00:00',
                'hourly_price' => 120000,
                'daily_price' => 800000,
                'service_amount' => 420000,
                'surcharge_amount' => 0,
            ],
            [
                // Booking 3 — phòng 301 (Deluxe), 2 đêm, confirmed
                'room_id' => 8,
                'booking_id' => 3,
                'checkin_date' => '2026-03-28 14:00:00',
                'checkout_date' => '2026-03-30 12:00:00',
                'hourly_price' => 180000,
                'daily_price' => 1200000,
                'service_amount' => 0,
                'surcharge_amount' => 0,
            ],
            [
                // Booking 4 — phòng 501 (Suite), 2 đêm, pending
                'room_id' => 12,
                'booking_id' => 4,
                'checkin_date' => '2026-03-30 14:00:00',
                'checkout_date' => '2026-04-01 12:00:00',
                'hourly_price' => 350000,
                'daily_price' => 2500000,
                'service_amount' => 0,
                'surcharge_amount' => 0,
            ],
            [
                // Booking 5 — phòng 402 (Deluxe), 2 đêm, đang ở
                'room_id' => 11,
                'booking_id' => 5,
                'checkin_date' => '2026-03-26 14:00:00',
                'checkout_date' => '2026-03-28 12:00:00',
                'hourly_price' => 180000,
                'daily_price' => 1200000,
                'service_amount' => 350000,
                'surcharge_amount' => 50000,
            ],
        ];

        DB::table('booking_details')->insert($details);
    }
}
