<?php

namespace App\Enums;

enum RoomStatus: string
{
    case EMPTY = 'empty';           // Trống
    case BOOKED = 'booked';         // Đã đặt
    case CONFIRMED = 'confirmed';   // Đã xác nhận
    case INCOMING = 'incoming';     // Sắp đến
    case OCCUPIED = 'occupied';     // Có khách
    case CHECKOUT = 'checkout';     // Chuẩn bị đi
    case DIRTY = 'dirty';           // Bẩn
    case MAINTENANCE = 'maintenance'; // Đang sửa chữa

    /**
     * Get Vietnamese label for status
     */
    public function label(): string
    {
        return match ($this) {
            self::EMPTY => 'Trống',
            self::BOOKED => 'Đã đặt',
            self::CONFIRMED => 'Đã xác nhận',
            self::INCOMING => 'Sắp đến',
            self::OCCUPIED => 'Có khách',
            self::CHECKOUT => 'Chuẩn bị đi',
            self::DIRTY => 'Bẩn',
            self::MAINTENANCE => 'Đang sửa chữa',
        };
    }

    /**
     * Get color badge class for status
     */
    public function badgeClass(): string
    {
        return $this->badgeColor();
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::EMPTY => 'green',
            self::BOOKED => 'blue',
            self::CONFIRMED => 'cyan',
            self::INCOMING => 'purple',
            self::OCCUPIED => 'red',
            self::CHECKOUT => 'orange',
            self::DIRTY => 'dark',
            self::MAINTENANCE => 'maintenance',
        };
    }

    public function cardClass(): string
    {
        return match ($this) {
            self::EMPTY => 'empty',
            self::BOOKED => 'booked',
            self::CONFIRMED => 'confirmed',
            self::INCOMING => 'incoming',
            self::OCCUPIED => 'occupied',
            self::CHECKOUT => 'checkout',
            self::DIRTY => 'dirty',
            self::MAINTENANCE => 'maintenance',
        };
    }

    public function routeName(): string
    {
        return match ($this) {
            self::EMPTY => 'admin.room-map.available-detail',
            self::BOOKED,
            self::CONFIRMED,
            self::INCOMING => 'admin.room-map.incoming-detail',
            self::OCCUPIED,
            self::CHECKOUT,
            self::DIRTY => 'admin.room-map.detail',
            self::MAINTENANCE => 'admin.room-map.available-detail',
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
            self::CONFIRMED,
            self::INCOMING,
            self::OCCUPIED,
            self::CHECKOUT,
            self::DIRTY,
            self::MAINTENANCE,
        ];
    }
}
