<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Add new cart total extension records as type 'total' in extensions table
 */
return new class extends Migration
{
    public function up(): void
    {
        $conditions = [];
        $seedConditions = $this->getConditions();

        foreach ($seedConditions as $condition) {
            $data = array_get((array)$condition, 'data');
            if (!is_array($data)) {
                $data = unserialize($data);
            }

            $conditions[$data['priority']] = array_get($data, 'name');
        }

        $table = DB::table('extension_settings')->where('item', 'igniter_cart_settings');
        if (!$table->exists()) {
            $table->update(['data' => json_encode(['conditions' => $conditions])]);
        }
    }

    public function down(): void {}

    protected function getConditions()
    {
        $existingConditions = [];
        if (Schema::hasColumn('extensions', 'data')) {
            $existingConditions = DB::table('extensions')->select('data')->where('type', 'cart_total')->get();
        }

        if (count($existingConditions) === 0) {
            return [
                [
                    'data' => [
                        'priority' => '3',
                        'name' => 'coupon',
                        'title' => 'Coupon {coupon}',
                        'status' => '1',
                    ],
                ],
                [
                    'data' => [
                        'priority' => '4',
                        'name' => 'delivery',
                        'title' => 'Delivery',
                        'status' => '1',
                    ],
                ],
                [
                    'data' => [
                        'priority' => '5',
                        'name' => 'taxes',
                        'title' => 'VAT {tax}',
                        'status' => '1',
                    ],
                ],
            ];
        }

        return $existingConditions;
    }
};
