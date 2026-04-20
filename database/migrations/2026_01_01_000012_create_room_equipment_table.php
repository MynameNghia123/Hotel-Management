<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng pivot: RoomType <-> Equipments (many-to-many với quantity)
        Schema::create('room_equipment', function (Blueprint $table) {
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
            $table->integer('quantity');

            $table->primary(['room_type_id', 'equipment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_equipment');
    }
};
