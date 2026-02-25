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
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('ride_id');
            $table->unsignedInteger('route_type_id');
            $table->unsignedInteger('vehicle_category_id');
            $table->date('schedule_date');
            $table->string('route_name', 20);
            $table->unsignedInteger('driver_user_no')->nullable();
            $table->unsignedInteger('use_vehicle_id')->nullable();
            $table->string('ride_memo', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('ride_status_id');
            $table->timestamps();
            // 外部キー
            $table->foreign('driver_user_no')->references('user_no')->on('users')->cascadeOnUpdate();
            $table->foreign('use_vehicle_id')->references('vehicle_id')->on('vehicles')->cascadeOnUpdate();
            $table->foreign('route_type_id')->references('route_type_id')->on('route_types')->cascadeOnUpdate();
            $table->foreign('vehicle_category_id')->references('vehicle_category_id')->on('vehicle_categories')->cascadeOnUpdate();
            $table->foreign('ride_status_id')->references('ride_status_id')->on('ride_statuses')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
