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
        Schema::create('washing_stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('altitude')->nullable();
            $table->string('type_of_soil')->nullable();
            $table->string('coffee_variety')->nullable();
            $table->integer('farmers_working')->nullable();
            $table->string('total_area_under_production')->nullable();
            $table->string('harvest_period')->nullable();
            $table->text('processing')->nullable();
            $table->string('other_coffee_available')->nullable();
            $table->string('cupping_score')->nullable();
            $table->text('traceability')->nullable();
            $table->string('certification')->nullable();
            $table->text('environment')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('washing_stations');
    }
};
