<?php

namespace App\Enums;

enum RoomStatus: string
{
    case EMPTY = 'empty';           // Trống
    case BOOKED = 'booked';         // Đã đặt
    case INCOMING = 'incoming';     // Sắp đến
    case OCCUPIED = 'occupied';     // Có khách
    case CHECKOUT = 'checkout';     // Chuẩn bị đi
    case DIRTY = 'dirty';           // Bẩn

    /**
     * Get Vietnamese label for status
     */
    public function label(): string
    {
        return match($this) {
            self::EMPTY => 'Trống',
            self::BOOKED => 'Đã đặt',
            self::INCOMING => 'Sắp đến',
            self::OCCUPIED => 'Có khách',
            self::CHECKOUT => 'Chuẩn bị đi',
            self::DIRTY => 'Bẩn',
        };
    }

    /**
     * Get color badge class for status
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::EMPTY => 'green',
            self::BOOKED => 'blue',
            self::INCOMING => 'purple',
            self::OCCUPIED => 'red',
            self::CHECKOUT => 'orange',
            self::DIRTY => 'dark',
        };
    }

    /**
     * Get all statuses
     */
    public static function all(): array
    {
        return [
            self::EMPTY,
            self::BOOKED,
            self::INCOMING,
            self::OCCUPIED,
            self::CHECKOUT,
            self::DIRTY,
        ];
    }
}
