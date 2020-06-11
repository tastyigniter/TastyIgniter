<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Schema;

class DropMoreUnusedColumns extends Migration
{
    public function up()
    {
        $this->mergeValuesIntoOptionsColumn();

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('cart');
            $table->dropColumn('security_question_id');
            $table->dropColumn('security_answer');
            $table->dropColumn('salt');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('flag');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('notify');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('offer_delivery');
            $table->dropColumn('offer_collection');
            $table->dropColumn('delivery_time');
            $table->dropColumn('collection_time');
            $table->dropColumn('reservation_time_interval');
            $table->dropColumn('reservation_stay_time');
            $table->dropColumn('last_order_time');
        });
    }

    public function down()
    {
    }

    protected function mergeValuesIntoOptionsColumn()
    {
        if (!Schema::hasColumn('locations', 'delivery_time'))
            return;

        DB::table('locations')->get()->each(function ($model) {
            $options = @unserialize($model->options) ?: [];

            $options = array_merge([
                'offer_delivery' => $model->offer_delivery,
                'offer_collection' => $model->offer_collection,
                'delivery_lead_time' => $model->delivery_time,
                'collection_lead_time' => $model->collection_time,
                'delivery_time_interval' => $model->delivery_time,
                'collection_time_interval' => $model->collection_time,
                'reservation_time_interval' => $model->reservation_time_interval,
                'reservation_lead_time' => $model->reservation_stay_time,
                'future_orders' => [
                    'enable_delivery' => $model->future_orders,
                    'enable_collection' => $model->future_orders,
                    'delivery_days' => $model->future_order_days['delivery'] ?? 0,
                    'collection_days' => $model->future_order_days['collection'] ?? 0,
                ],
            ], $options);

            unset($options['future_order_days']);

            DB::table('locations')->where('location_id', $model->location_id)->update([
                'options' => serialize($options),
            ]);
        });
    }
}