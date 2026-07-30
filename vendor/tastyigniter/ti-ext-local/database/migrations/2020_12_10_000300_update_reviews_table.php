<?php

declare(strict_types=1);

use Igniter\Cart\Models\Order;
use Igniter\Reservation\Models\Reservation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_reviews', function(Blueprint $table): void {
            $table->integer('customer_id')->nullable()->change();
            $table->string('author')->nullable()->change();
            $table->text('review_text')->nullable()->change();
        });

        $this->updateMorphsOnReviews();
    }

    public function down(): void {}

    protected function updateMorphsOnReviews(): void
    {
        if (DB::table('igniter_reviews')
            ->where('sale_type', Order::class)
            ->orWhere('sale_type', Reservation::class)
            ->count()
        ) {
            return;
        }

        $morphs = [
            'order' => Order::class,
            'reservation' => Reservation::class,
        ];

        DB::table('igniter_reviews')->get()->each(function($model) use ($morphs) {
            if (!isset($morphs[$model->sale_type])) {
                return false;
            }

            DB::table('igniter_reviews')->where('review_id', $model->review_id)->update([
                'sale_type' => $morphs[$model->sale_type],
            ]);
        });
    }
};
