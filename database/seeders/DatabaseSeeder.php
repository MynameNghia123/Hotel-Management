<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Prevent duplicate seeding if data already exists
        if (\Illuminate\Support\Facades\DB::table('roles')->count() > 0) {
            $this->command->info('Database is already seeded. Skipping...');
            return;
        }
        $this->call([
            // ── Tầng 1: Không có phụ thuộc ───────────────────────
            RoleSeeder::class,
            FloorSeeder::class,
            RoomTypeSeeder::class,
            EquipmentCategorySeeder::class,
            AmenitySeeder::class,
            ServiceGroupSeeder::class,
            SystemSettingSeeder::class,
            SurchargePolicySeeder::class,

            // ── Tầng 2: Phụ thuộc tầng 1 ─────────────────────────
            StaffSeeder::class,             // → roles
            CustomerSeeder::class,
            RoomSeeder::class,              // → room_types, floors
            EquipmentSeeder::class,         // → equipment_categories
            ServiceSeeder::class,           // → service_groups
            RoleClaimSeeder::class,         // → roles
            RoomEquipmentSeeder::class,     // → room_types, equipments
            RoomTypeAmenitySeeder::class,   // → room_types, amenities
            RoomTypeImageSeeder::class,     // → room_types

            // ── Tầng 3: Phụ thuộc tầng 2 ─────────────────────────
            BookingSeeder::class,           // → customers, staff
            MaintenanceTicketSeeder::class, // → rooms, equipments, staff

            // ── Tầng 4: Phụ thuộc tầng 3 ─────────────────────────
            BookingDetailSeeder::class,     // → bookings, rooms
            PaymentSeeder::class,           // → bookings, staff

            // ── Tầng 5: Phụ thuộc tầng 4 ─────────────────────────
            ServiceUsageSeeder::class,      // → booking_details, services
        ]);
    }
}
