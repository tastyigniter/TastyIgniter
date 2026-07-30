<?php

declare(strict_types=1);

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('igniter_coupons_history', function(Blueprint $table): void {
            $table->dropForeignKeyIfExists('coupon_id');
            $table->dropForeignKeyIfExists('order_id');
            $table->dropForeignKeyIfExists('customer_id');
            $table->dropIndexIfExists(sprintf('%s_%s_foreign', 'igniter_coupons_history', 'coupon_id'));
            $table->dropIndexIfExists(sprintf('%s_%s_foreign', 'igniter_coupons_history', 'order_id'));
            $table->dropIndexIfExists(sprintf('%s_%s_foreign', 'igniter_coupons_history', 'customer_id'));
        });

        Schema::table('igniter_coupon_categories', function(Blueprint $table): void {
            $table->dropForeignKeyIfExists('coupon_id');
            $table->dropForeignKeyIfExists('category_id');
        });

        Schema::table('igniter_coupon_menus', function(Blueprint $table): void {
            $table->dropForeignKeyIfExists('coupon_id');
            $table->dropForeignKeyIfExists('menu_id');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void {}
};
