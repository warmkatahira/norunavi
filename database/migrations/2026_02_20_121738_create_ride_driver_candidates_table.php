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
        Schema::create('ride_driver_candidates', function (Blueprint $table) {
            $table->increments('ride_driver_candidate_id');
            $table->unsignedInteger('ride_id');
            $table->unsignedInteger('user_no');
            $table->unsignedInteger('use_vehicle_id')->nullable();
            $table->unsignedInteger('driver_status_id');
            $table->timestamps();
            // 外部キー
            $table->foreign('ride_id')->references('ride_id')->on('rides')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_no')->references('user_no')->on('users')->cascadeOnUpdate();
            $table->foreign('use_vehicle_id')->references('vehicle_id')->on('vehicles')->cascadeOnUpdate();
            $table->foreign('driver_status_id')->references('driver_status_id')->on('driver_statuses')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_driver_candidates');
    }
};
