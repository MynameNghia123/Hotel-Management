<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('adult_quantity');
            $table->integer('child_quantity');
            $table->integer('single_bed_quantity');
            $table->integer('double_bed_quantity');
            $table->decimal('width', 8, 2);
            $table->decimal('height', 8, 2);
            $table->decimal('hourly_price', 15, 2);
            $table->decimal('daily_price', 15, 2);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
