<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->dateTime('checkin_date');
            $table->dateTime('checkout_date');
            $table->decimal('hourly_price', 15, 2);
            $table->decimal('daily_price', 15, 2);
            $table->decimal('room_amount', 15, 2)->default(0);
            $table->decimal('service_amount', 15, 2)->default(0);
            $table->decimal('surcharge_amount', 15, 2)->default(0);
            $table->string('payment_status')->default('unpaid');
            $table->dateTime('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
