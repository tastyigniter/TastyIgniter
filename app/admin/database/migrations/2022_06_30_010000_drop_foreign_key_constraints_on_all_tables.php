<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyConstraintsOnAllTables extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->getForeignConstraints() as $tableName => $constraints) {
            foreach ($constraints as $options) {
                $this->dropForeignKey($tableName, $options);
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
    }

    protected function dropForeignKey($tableName, $options)
    {
        try {
            Schema::table($tableName, function (Blueprint $table) use ($tableName, $options) {
                $keys = (array)$options[1];
                $foreignKey = $keys[0];

                $table->dropForeignKeyIfExists($foreignKey);
                $table->dropIndexIfExists(sprintf('%s%s_%s_foreign', DB::getTablePrefix(), $tableName, $foreignKey));
            });
        }
        catch (\Exception $ex) {
            Log::error($ex);
        }
    }

    protected function getForeignConstraints(): array
    {
        return [
            'addresses' => [
                ['customers', 'customer_id', 'nullOnDelete' => true],
                ['countries', 'country_id', 'nullOnDelete' => true],
            ],
            'allergenables' => [
                ['allergens', 'allergen_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'assignable_logs' => [
                ['staffs', ['assignee_id', 'staff_id'], 'nullable' => false, 'nullOnDelete' => true],
                ['staff_groups', ['assignee_group_id', 'staff_group_id'], 'nullable' => false, 'nullOnDelete' => true],
                ['statuses', ['status_id', 'status_id'], 'nullable' => false, 'nullOnDelete' => true],
            ],
            'categories' => [
                ['categories', ['parent_id', 'category_id'], 'nullOnDelete' => true],
            ],
            'customers' => [
                ['addresses', 'address_id', 'nullOnDelete' => true],
                ['customer_groups', 'customer_group_id', 'nullOnDelete' => true],
            ],
            'location_areas' => [
                ['locations', 'location_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'locationables' => [
                ['locations', 'location_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'locations' => [
                ['countries', ['location_country_id', 'country_id'], 'cascadeOnDelete' => true],
            ],
            'menu_categories' => [
                ['menus', 'menu_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['categories', 'category_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'menu_item_option_values' => [
                ['menu_item_options', 'menu_option_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['menu_option_values', 'option_value_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'menu_item_options' => [
                ['menus', 'menu_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['menu_options', 'option_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'menu_mealtimes' => [
                ['menus', 'menu_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['mealtimes', 'mealtime_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'menu_option_values' => [
                ['menu_options', 'option_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'menus_specials' => [
                ['menus', 'menu_id', 'cascadeOnDelete' => true],
            ],
            'order_menu_options' => [
                ['orders', 'order_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['order_menus', 'order_menu_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'order_menus' => [
                ['orders', 'order_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['menus', 'menu_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'order_totals' => [
                ['orders', 'order_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'orders' => [
                ['customers', 'customer_id', 'nullOnDelete' => true],
                ['locations', 'location_id', 'nullOnDelete' => true],
                ['addresses', 'address_id', 'nullOnDelete' => true],
                ['statuses', 'status_id', 'nullOnDelete' => true],
                ['staffs', ['assignee_id', 'staff_id'], 'nullOnDelete' => true],
                ['staff_groups', ['assignee_group_id', 'staff_group_id'], 'nullOnDelete' => true],
            ],
            'payment_logs' => [
                ['orders', 'order_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'payment_profiles' => [
                ['customers', 'customer_id', 'cascadeOnDelete' => true],
                ['payments', 'payment_id', 'cascadeOnDelete' => true],
            ],
            'reservation_tables' => [
                ['reservations', 'reservation_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['tables', 'table_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'reservations' => [
                ['tables', 'table_id', 'nullOnDelete' => true],
                ['customers', 'customer_id', 'nullOnDelete' => true],
                ['locations', 'location_id', 'nullOnDelete' => true],
                ['statuses', 'status_id', 'nullOnDelete' => true],
                ['staffs', ['assignee_id', 'staff_id'], 'nullOnDelete' => true],
                ['staff_groups', ['assignee_group_id', 'staff_group_id'], 'nullOnDelete' => true],
            ],
            'staffs' => [
                ['staff_roles', 'staff_role_id', 'nullOnDelete' => true],
                ['languages', 'language_id', 'nullOnDelete' => true],
            ],
            'staffs_groups' => [
                ['staffs', 'staff_id', 'nullable' => false, 'cascadeOnDelete' => true],
                ['staff_groups', 'staff_group_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'status_history' => [
                ['staffs', 'staff_id', 'nullOnDelete' => true],
                ['statuses', 'status_id', 'nullOnDelete' => true],
            ],
            'user_preferences' => [
                ['users', 'user_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'users' => [
                ['staffs', 'staff_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
            'working_hours' => [
                ['locations', 'location_id', 'nullable' => false, 'cascadeOnDelete' => true],
            ],
        ];
    }
}
