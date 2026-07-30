<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('igniter_coupon_customers', function(Blueprint $table): void {
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('customer_id');
        });

        Schema::create('igniter_coupon_customer_groups', function(Blueprint $table): void {
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('customer_group_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_coupon_customers');
        Schema::dropIfExists('igniter_coupon_customer_groups');
    }
};

