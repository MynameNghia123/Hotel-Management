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
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('cascade');
            $table->decimal('total_service_amount', 15, 2)->default(0);
            $table->decimal('total_room_amount', 15, 2)->default(0);
            $table->decimal('surcharge_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);
            $table->string('status')->default('pending');
            // pending | confirmed | checked_in | checked_out | cancelled
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
