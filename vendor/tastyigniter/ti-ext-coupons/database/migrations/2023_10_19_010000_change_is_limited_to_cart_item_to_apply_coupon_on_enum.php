<?php

declare(strict_types=1);

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_coupons', function(Blueprint $table): void {
            $table->enum(
                'apply_coupon_on',
                ['whole_cart', 'menu_items', 'delivery_fee']
            )->default('whole_cart')->after('order_restriction');
        });
        $this->updateApplyCouponOnEnum();
        Schema::table('igniter_coupons', function(Blueprint $table): void {
            $table->dropColumn('is_limited_to_cart_item');
        });
    }

    // migrate is_limited_to_cart_item to the new apply_coupon_on enum that supports multiple options
    protected function updateApplyCouponOnEnum(): void
    {
        DB::table('igniter_coupons')
            ->where('is_limited_to_cart_item', 1)->get()->each(
                function($model): void {
                    DB::table('igniter_coupons')
                        ->where('coupon_id', $model->coupon_id)
                        ->update([
                            'apply_coupon_on' => 'menu_items',
                        ]);
                }
            );
    }
};
