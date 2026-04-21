<?php

namespace App\Enums;

enum BookingStatus: string
{
    case PENDING = 'pending';           // Chờ xác nhận (trạng thái khi đặt online)
    case CONFIRMED = 'confirmed';       // Đã xác nhận (nhân viên gọi điện xác nhận)
    case OCCUPIED = 'occupied';         // Đang ở (đã check-in)
    case CANCELLED = 'cancelled';       // Đã hủy

    /**
     * Get Vietnamese label for booking status
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Chờ xác nhận',
            self::CONFIRMED => 'Đã xác nhận',
            self::OCCUPIED => 'Đang ở',
            self::CANCELLED => 'Đã hủy',
        };
    }

    /**
     * Get color badge class for booking status
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::CONFIRMED => 'green',
            self::OCCUPIED => 'blue',
            self::CANCELLED => 'red',
        };
    }

    /**
     * Get allowed transitions from current status
     */
    public function allowedTransitions(): array
    {
        return match($this) {
            self::PENDING => [self::CONFIRMED, self::CANCELLED],      // Chờ → Xác nhận hoặc Hủy
            self::CONFIRMED => [self::OCCUPIED, self::CANCELLED],     // Xác nhận → Đang ở hoặc Hủy
            self::OCCUPIED => [self::CANCELLED],                      // Đang ở → Hủy
            self::CANCELLED => [],                                    // Hủy: không thể chuyển đổi
        };
    }

    /**
     * Check if can transition to another status
     */
    public function canTransitionTo(self $newStatus): bool
    {
        return in_array($newStatus, $this->allowedTransitions());
    }

    /**
     * Get all statuses
     */
    public static function all(): array
    {
        return [
            self::PENDING,
            self::CONFIRMED,
            self::OCCUPIED,
            self::CANCELLED,
        ];
    }
}
