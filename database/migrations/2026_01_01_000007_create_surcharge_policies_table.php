<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surcharge_policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_type');
            $table->decimal('hour_mark', 8, 2);
            $table->decimal('price', 15, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surcharge_policies');
    }
};
