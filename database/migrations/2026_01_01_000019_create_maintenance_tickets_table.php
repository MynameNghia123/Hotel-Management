<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('equipment_id')->nullable()->constrained('equipments')->onDelete('cascade');
            $table->date('reported_date');
            $table->text('issue_description')->nullable();
            $table->text('technician_note')->nullable();
            $table->string('status');
            // pending | in_progress | completed
            $table->decimal('repair_cost', 15, 2)->default(0);
            $table->foreignId('reported_by_staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('technician_id')->constrained('staff')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_tickets');
    }
};
