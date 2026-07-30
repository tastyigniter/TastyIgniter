<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $items = [
        'checkout' => [
            'guest_order' => 'guest_order',
            'limit_orders' => 'limit_orders',
            'limit_orders_count' => 'limit_orders_count',
            'payments' => 'payments',
        ],
        'delivery' => [
            'offer_delivery' => 'is_enabled',
            'delivery_add_lead_time' => 'add_lead_time',
            'delivery_time_interval' => 'time_interval',
            'delivery_lead_time' => 'lead_time',
            'delivery_time_restriction' => 'time_restriction',
            'delivery_cancellation_timeout' => 'cancellation_timeout',
            'delivery_min_order_amount' => 'min_order_amount',
            'future_days' => 'future_days',
        ],
        'collection' => [
            'offer_collection' => 'is_enabled',
            'collection_add_lead_time' => 'add_lead_time',
            'collection_time_interval' => 'time_interval',
            'collection_lead_time' => 'lead_time',
            'collection_time_restriction' => 'time_restriction',
            'collection_cancellation_timeout' => 'cancellation_timeout',
            'collection_min_order_amount' => 'min_order_amount',
            'future_days' => 'future_days',
        ],
    ];

    public function up()
    {
        Schema::table('locations', function(Blueprint $table) {
            $table->boolean('is_auto_lat_lng')->default(0);
        });

        DB::table('locations')->get()->each(function($location) {
            foreach ($this->items as $code => $keys) {
                $values = DB::table('location_options')
                    ->where('location_id', $location->location_id)
                    ->whereIn('item', array_keys($keys))
                    ->pluck('value', 'item')
                    ->all();

                if (array_key_exists('future_days', $keys)) {
                    $values['future_days'] = array_only($values['future_days'] ?? [],
                        $code === 'delivery' ? [
                            'enable_delivery', 'min_delivery_days', 'delivery_days',
                        ] : [
                            'enable_collection', 'min_collection_days', 'collection_days',
                        ]
                    );

                    $futureDaysKey = [
                        'enable_delivery' => 'is_enabled',
                        'min_delivery_days' => 'min_days',
                        'delivery_days' => 'days',
                        'enable_collection' => 'is_enabled',
                        'min_collection_days' => 'min_days',
                        'collection_days' => 'days',
                    ];

                    foreach ($futureDaysKey as $key => $value) {
                        if (isset($values['future_days'][$key])) {
                            $values['future_days'][$value] = $values['future_days'][$key];
                            unset($values['future_days'][$key]);
                        }
                    }
                }

                foreach ($values as $key => $value) {
                    $values[$keys[$key]] = $value;
                    unset($values[$key]);
                }

                DB::table('location_settings')->insert([
                    'location_id' => $location->location_id,
                    'item' => $code,
                    'data' => json_encode($values),
                ]);
            }

            $values = DB::table('location_options')
                ->where('location_id', $location->location_id)
                ->whereIn('item', ['auto_lat_lng', 'gallery', 'hours'])
                ->pluck('value', 'item')
                ->all();

            DB::table('locations')
                ->where('location_id', $location->location_id)
                ->update([
                    'is_auto_lat_lng' => $values['auto_lat_lng'] ?? 0,
                ]);

            foreach (array_only($values, ['gallery', 'hours']) as $item => $data) {
                DB::table('location_settings')->insert([
                    'location_id' => $location->location_id,
                    'item' => $item,
                    'data' => json_encode($data),
                ]);
            }
        });
    }
};
