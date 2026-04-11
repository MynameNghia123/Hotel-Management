<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Thêm các cột còn thiếu
            if (!Schema::hasColumn('rooms', 'room_type_id')) {
                $table->foreignId('room_type_id')->nullable()->after('id')->constrained('room_types');
            }
            if (!Schema::hasColumn('rooms', 'floor_id')) {
                $table->foreignId('floor_id')->nullable()->after('room_type_id')->constrained('floors');
            }

            // Xóa các cột thừa (vốn thuộc về RoomType)
            $unnecessaryColumns = ['code', 'area', 'single_beds', 'double_beds', 'hourly_price', 'daily_price', 'quantity'];
            foreach ($unnecessaryColumns as $col) {
                if (Schema::hasColumn('rooms', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Hoàn tác nếu cần
            $table->dropForeign(['room_type_id']);
            $table->dropForeign(['floor_id']);
            $table->dropColumn(['room_type_id', 'floor_id']);
        });
    }
};
