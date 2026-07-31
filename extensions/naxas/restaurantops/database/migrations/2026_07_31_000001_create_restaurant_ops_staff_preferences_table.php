<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naxas_restaurant_ops_staff_preferences', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->unique();
            $table->unsignedBigInteger('default_location_id')->nullable();
            $table->timestamps();
            $table->index('default_location_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('naxas_restaurant_ops_staff_preferences');
    }
};
