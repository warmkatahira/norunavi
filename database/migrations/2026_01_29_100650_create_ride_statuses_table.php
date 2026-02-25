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
        Schema::create('ride_statuses', function (Blueprint $table) {
            $table->increments('ride_status_id');
            $table->string('ride_status', 10)->unique();
            $table->unsignedTinyInteger('sort_order')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_statuses');
    }
};
