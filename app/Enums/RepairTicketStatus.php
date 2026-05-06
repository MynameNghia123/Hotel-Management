<?php

namespace App\Enums;

enum RepairTicketStatus: string
{
    case PENDING = 'pending';              // Đang chờ xử lý
    case IN_PROGRESS = 'in_progress';      // Đang sửa chữa
    case COMPLETED = 'completed';          // Đã hoàn thành

    /**
     * Get Vietnamese label for repair ticket status
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Đang chờ xử lý',
            self::IN_PROGRESS => 'Đang sửa chữa',
            self::COMPLETED => 'Đã hoàn thành',
        };
    }

    /**
     * Get color badge class for repair ticket status
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::IN_PROGRESS => 'blue',
            self::COMPLETED => 'green',
        };
    }

    /**
     * Get allowed transitions from current status
     */
    public function allowedTransitions(): array
    {
        return match($this) {
            self::PENDING => [self::IN_PROGRESS],           // Chờ → Sửa chữa
            self::IN_PROGRESS => [self::COMPLETED],         // Sửa → Hoàn thành
            self::COMPLETED => [],                           // Hoàn thành: không thể chuyển đổi
        };
    }
}
