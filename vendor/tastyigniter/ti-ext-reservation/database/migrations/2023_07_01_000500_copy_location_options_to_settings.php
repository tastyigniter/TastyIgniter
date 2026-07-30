<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected array $items = [
        'booking' => [
            'offer_reservation' => 'is_enabled',
            'limit_guests' => 'limit_guests',
            'limit_guests_count' => 'limit_guests_count',
            'reservation_time_interval' => 'time_interval',
            'reservation_stay_time' => 'stay_time',
            'auto_allocate_table' => 'auto_allocate_table',
            'min_reservation_advance_time' => 'min_advance_time',
            'max_reservation_advance_time' => 'max_advance_time',
            'reservation_cancellation_timeout' => 'cancellation_timeout',
        ],
    ];

    public function up(): void
    {
        DB::table('locations')->get()->each(function($location): void {
            foreach ($this->items as $code => $keys) {
                $values = DB::table('location_options')
                    ->where('location_id', $location->location_id)
                    ->whereIn('item', array_keys($keys))
                    ->pluck('value', 'item')
                    ->all();

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
        });
    }
};
