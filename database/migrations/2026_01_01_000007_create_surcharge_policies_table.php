<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surcharge_policies', function (Blueprint $table) {
            $table->id();
            $table->enum('policy_type', ['early_checkin', 'late_checkout']);
            $table->decimal('hour_mark', 5, 2);
            $table->decimal('price', 15, 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surcharge_policies');
    }
};
