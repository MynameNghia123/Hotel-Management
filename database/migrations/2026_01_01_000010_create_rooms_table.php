<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained('room_types');
            $table->foreignId('floor_id')->constrained('floors');
            $table->string('name', 100)->unique();
            $table->string('status')->default('available');
            // available | occupied | maintenance
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
