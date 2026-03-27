<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('equipment_category_id')->constrained('equipment_categories');
            $table->decimal('import_price', 15, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
