<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyConstraintsToTables extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->getForeignConstraints() as $tableName => $constraints) {
            foreach ($constraints as $options) {
                $this->addForeignKey($tableName, $options);
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        foreach ($this->getForeignConstraints() as $tableName => $constraints) {
            foreach ($constraints as $options) {
                $this->dropForeignKey($tableName, $options);
            }
        }
    }

    protected function addForeignKey($tableName, $options)
    {
        Schema::table($tableName, function (Blueprint $table) use ($options) {
            $foreignTableName = $options[0];

            $keys = (array)$options[1];
            $foreignKey = $keys[0];
            $parentKey = $keys[1] ?? $keys[0];

            $blueprint = $table->foreignId($foreignKey);

            if (array_get($options, 'nullable', TRUE))
                $blueprint->nullable();

            $blueprint->change();

            $blueprint = $table->foreign($foreignKey)->references($parentKey)->on($foreignTableName);

            if (array_get($options, 'nullOnDelete'))
                $blueprint->nullOnDelete();

            if (array_get($options, 'cascadeOnDelete'))
                $blueprint->cascadeOnDelete();

            if (array_get($options, 'cascadeOnUpdate', TRUE))
                $blueprint->cascadeOnUpdate();
        });
    }

    protected function dropForeignKey($tableName, $options)
    {
        try {
            Schema::table($tableName, function (Blueprint $table) use ($options) {
                $keys = (array)$options[1];
                $foreignKey = $keys[0];

                $table->dropForeign([$foreignKey]);
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
                ['customers', 'customer_id', 'nullOnDelete' => TRUE],
                ['countries', 'country_id', 'nullOnDelete' => TRUE],
            ],
            'allergenables' => [
                ['allergens', 'allergen_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'assignable_logs' => [
                ['staffs', ['assignee_id', 'staff_id'], 'nullable' => FALSE, 'nullOnDelete' => TRUE],
                ['staff_groups', ['assignee_group_id', 'staff_group_id'], 'nullable' => FALSE, 'nullOnDelete' => TRUE],
                ['statuses', ['status_id', 'status_id'], 'nullable' => FALSE, 'nullOnDelete' => TRUE],
            ],
            'categories' => [
                ['categories', ['parent_id', 'category_id'], 'nullOnDelete' => TRUE],
            ],
            'customers' => [
                ['addresses', 'address_id', 'nullOnDelete' => TRUE],
                ['customer_groups', 'customer_group_id', 'nullOnDelete' => TRUE],
            ],
            'location_areas' => [
                ['locations', 'location_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'locationables' => [
                ['locations', 'location_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'locations' => [
                ['countries', ['location_country_id', 'country_id'], 'cascadeOnDelete' => TRUE],
            ],
            'menu_categories' => [
                ['menus', 'menu_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['categories', 'category_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'menu_item_option_values' => [
                ['menu_item_options', 'menu_option_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['menu_option_values', 'option_value_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'menu_item_options' => [
                ['menus', 'menu_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['menu_options', 'option_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'menu_mealtimes' => [
                ['menus', 'menu_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['mealtimes', 'mealtime_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'menu_option_values' => [
                ['menu_options', 'option_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'menus_specials' => [
                ['menus', 'menu_id', 'cascadeOnDelete' => TRUE],
            ],
            'order_menu_options' => [
                ['orders', 'order_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['order_menus', 'order_menu_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'order_menus' => [
                ['orders', 'order_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['menus', 'menu_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'order_totals' => [
                ['orders', 'order_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'orders' => [
                ['customers', 'customer_id', 'nullOnDelete' => TRUE],
                ['locations', 'location_id', 'nullOnDelete' => TRUE],
                ['addresses', 'address_id', 'nullOnDelete' => TRUE],
                ['statuses', 'status_id', 'nullOnDelete' => TRUE],
                ['staffs', ['assignee_id', 'staff_id'], 'nullOnDelete' => TRUE],
                ['staff_groups', ['assignee_group_id', 'staff_group_id'], 'nullOnDelete' => TRUE],
            ],
            'payment_logs' => [
                ['orders', 'order_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'payment_profiles' => [
                ['customers', 'customer_id', 'cascadeOnDelete' => TRUE],
                ['payments', 'payment_id', 'cascadeOnDelete' => TRUE],
            ],
            'reservation_tables' => [
                ['reservations', 'reservation_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['tables', 'table_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'reservations' => [
                ['tables', 'table_id', 'nullOnDelete' => TRUE],
                ['customers', 'customer_id', 'nullOnDelete' => TRUE],
                ['locations', 'location_id', 'nullOnDelete' => TRUE],
                ['statuses', 'status_id', 'nullOnDelete' => TRUE],
                ['staffs', ['assignee_id', 'staff_id'], 'nullOnDelete' => TRUE],
                ['staff_groups', ['assignee_group_id', 'staff_group_id'], 'nullOnDelete' => TRUE],
            ],
            'staffs' => [
                ['staff_roles', 'staff_role_id', 'nullOnDelete' => TRUE],
                ['languages', 'language_id', 'nullOnDelete' => TRUE],
            ],
            'staffs_groups' => [
                ['staffs', 'staff_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
                ['staff_groups', 'staff_group_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'status_history' => [
                ['staffs', 'staff_id', 'nullOnDelete' => TRUE],
                ['statuses', 'status_id', 'nullOnDelete' => TRUE],
            ],
            'user_preferences' => [
                ['users', 'user_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'users' => [
                ['staffs', 'staff_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
            'working_hours' => [
                ['locations', 'location_id', 'nullable' => FALSE, 'cascadeOnDelete' => TRUE],
            ],
        ];
    }
}
