<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Define the indexes to be added/removed for each table.
     *
     * @return array<string, array<int, array{columns: array<int, string>, name: string}>>
     */
    protected function getIndexes(): array
    {
        return [
            'categories' => [
                ['columns' => ['status'], 'name' => 'idx_categories_status'],
                ['columns' => ['status', 'priority'], 'name' => 'idx_categories_status_priority'],
            ],
            'menu_categories' => [
                ['columns' => ['category_id', 'menu_id'], 'name' => 'idx_menu_categories_category_menu'],
            ],
            'menu_mealtimes' => [
                ['columns' => ['menu_id', 'mealtime_id'], 'name' => 'idx_menu_mealtimes_menu_mealtime'],
            ],
            'menu_item_options' => [
                ['columns' => ['menu_id'], 'name' => 'idx_menu_item_options_menu'],
            ],
            'menu_item_option_values' => [
                ['columns' => ['menu_option_id'], 'name' => 'idx_menu_item_option_values_menu_option'],
            ],
            'menus' => [
                ['columns' => ['menu_status'], 'name' => 'idx_menus_status'],
                ['columns' => ['menu_status', 'menu_priority'], 'name' => 'idx_menus_status_priority'],
            ],
            'menu_options' => [
                ['columns' => ['option_id'], 'name' => 'idx_menu_options_option'],
            ],
            'menus_specials' => [
                ['columns' => ['menu_id', 'special_id'], 'name' => 'idx_menus_specials_menu_special'],
            ],
            'ingredientables' => [
                ['columns' => ['ingredientable_type', 'ingredientable_id', 'ingredient_id'], 'name' => 'idx_type_id_ingredient'],
            ],
            'stocks' => [
                ['columns' => ['stockable_type', 'stockable_id'], 'name' => 'idx_stocks_type_id'],
            ],
            'orders' => [
                ['columns' => ['location_id', 'order_date', 'status_id'], 'name' => 'idx_ti_orders_location_date_status'],
            ],
            'order_menus' => [
                ['columns' => ['order_id'], 'name' => 'idx_ti_order_menus_order'],
            ],
            'order_menu_options' => [
                ['columns' => ['order_id'], 'name' => 'idx_ti_order_menu_options_order'],
            ],
        ];
    }

    public function up(): void
    {
        foreach ($this->getIndexes() as $table => $indexes) {
            Schema::table($table, function(Blueprint $table) use ($indexes): void {
                foreach ($indexes as $index) {
                    $table->index($index['columns'], $index['name']);
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->getIndexes() as $table => $indexes) {
            Schema::table($table, function(Blueprint $table) use ($indexes): void {
                foreach ($indexes as $index) {
                    $table->dropIndex($index['name']);
                }
            });
        }
    }
};
