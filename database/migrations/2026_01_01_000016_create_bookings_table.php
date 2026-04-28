<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->dateTime('booking_date');
            $table->dateTime('checked_in_at')->nullable();
            $table->dateTime('checked_out_at')->nullable();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('cascade');
            $table->decimal('total_service_amount', 15, 2)->default(0);
            $table->decimal('total_room_amount', 15, 2)->default(0);
            $table->decimal('surcharge_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);
            $table->string('status')->default('pending');
            // pending | confirmed | occupied | paid | cancelled
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
