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
        Schema::table('maintenance_tickets', function (Blueprint $table) {
            $table->dropForeign('maintenance_tickets_reported_by_staff_id_foreign');
            $table->dropForeign('maintenance_tickets_technician_id_foreign');
            $table->dropColumn(['reported_by_staff_id', 'technician_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_tickets', function (Blueprint $table) {
            $table->foreignId('reported_by_staff_id')->nullable();
            $table->foreignId('technician_id')->nullable();
        });
    }
};
