<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceTicketSeeder extends Seeder
{
    public function run(): void
    {
        // room_id=4 là phòng 104 (status=maintenance)
        // staff: 1=Admin, 2=Lễ tân, 3=Kỹ thuật, 4=Kế toán
        $tickets = [
            [
                // Phòng 104 — máy lạnh hỏng (đang sửa)
                'room_id' => 4,
                'reported_date' => '2026-03-25',
                'issue_description' => 'Máy lạnh không lạnh, phát ra tiếng ồn lạ',
                'technician_note' => 'Đã kiểm tra, cần thay gas và vệ sinh cục nóng',
                'status' => 'in_progress',
                'repair_cost' => 850000,
                'created_at' => '2026-03-25 09:00:00',
                'updated_at' => '2026-03-25 14:00:00',
            ],
            [
                // Phòng 102 — đèn phòng tắm bị hỏng (đã xử lý)
                'room_id' => 2,
                'reported_date' => '2026-03-20',
                'issue_description' => 'Đèn phòng tắm bị chập, nhấp nháy liên tục',
                'technician_note' => 'Đã thay bóng đèn mới, kiểm tra đường điện ổn định',
                'status' => 'completed',
                'repair_cost' => 150000,
                'created_at' => '2026-03-20 10:00:00',
                'updated_at' => '2026-03-20 16:30:00',
            ],
            [
                // Phòng 301 — vấn đề chung, chưa xác định thiết bị cụ thể
                'room_id' => 8,
                'reported_date' => '2026-03-27',
                'issue_description' => 'Khách phản ánh mùi lạ trong phòng, có thể do hệ thống thoát nước',
                'technician_note' => null,
                'status' => 'pending',
                'repair_cost' => 0,
                'created_at' => '2026-03-27 11:00:00',
                'updated_at' => '2026-03-27 11:00:00',
            ],
        ];

        DB::table('maintenance_tickets')->insert($tickets);
    }
}
