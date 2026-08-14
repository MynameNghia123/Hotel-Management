<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Chỉ booking đã checked_out (booking_id=1) mới có payment hoàn chỉnh
        // Booking đang checked_in (2, 5) có thể thanh toán trước (đặt cọc)
        $payments = [
            [
                // Thanh toán đầy đủ cho Booking 1 (checked_out)
                'booking_id' => 1,
                'amount' => 1200000,
                'payment_method' => 'cash',
                'note' => 'Thanh toán khi check-out',
                'transaction_code' => null,
                'staff_id' => 2,
                'created_at' => '2026-03-22 11:30:00',
                'updated_at' => '2026-03-22 11:30:00',
            ],
            [
                // Đặt cọc trước cho Booking 3 (confirmed)
                'booking_id' => 3,
                'amount' => 1000000,
                'payment_method' => 'transfer',
                'note' => 'Đặt cọc 50% qua chuyển khoản',
                'transaction_code' => 'TXN20260326001',
                'staff_id' => null,
                'created_at' => '2026-03-26 11:00:00',
                'updated_at' => '2026-03-26 11:00:00',
            ],
            [
                // Đặt cọc trước cho Booking 4 (pending)
                'booking_id' => 4,
                'amount' => 2000000,
                'payment_method' => 'card',
                'note' => 'Thanh toán qua thẻ quốc tế',
                'transaction_code' => 'TXN20260327001',
                'staff_id' => null,
                'created_at' => '2026-03-27 15:05:00',
                'updated_at' => '2026-03-27 15:05:00',
            ],
        ];

        DB::table('payments')->insert($payments);
    }
}
