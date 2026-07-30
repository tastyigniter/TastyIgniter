<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_coupons_history', function(Blueprint $table): void {
            $table->unsignedBigInteger('coupon_id')->change();
            $table->unsignedBigInteger('order_id')->nullable()->change();
            $table->unsignedBigInteger('customer_id')->nullable()->change();
        });
    }

    public function down(): void {}
};
