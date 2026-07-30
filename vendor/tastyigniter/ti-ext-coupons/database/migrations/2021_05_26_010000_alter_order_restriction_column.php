<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_coupons', function(Blueprint $table): void {
            $table->text('order_restriction')->nullable()->change();
        });

        $this->updateOrderRestrictionColumn();
    }

    public function down(): void {}

    protected function updateOrderRestrictionColumn(): void
    {
        DB::table('igniter_coupons')->get()->each(function($model): void {
            $restriction = null;
            if ($model->order_restriction) {
                $restriction[] = array_get([
                    1 => 'delivery',
                    2 => 'collection',
                ], $model->order_restriction);

                $restriction = json_encode($restriction);
            }

            DB::table('igniter_coupons')
                ->where('coupon_id', $model->coupon_id)
                ->update(['order_restriction' => $restriction]);
        });
    }
};
