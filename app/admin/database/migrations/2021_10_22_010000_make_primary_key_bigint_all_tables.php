<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePrimaryKeyBigintAllTables extends Migration
{
    public function up()
    {
        foreach ([
            'addresses' => 'address_id',
            'allergens' => 'allergen_id',
            'assignable_logs' => 'id',
            'categories' => 'category_id',
            'customer_groups' => 'customer_group_id',
            'customers' => 'customer_id',
            'location_areas' => 'area_id',
            'locations' => 'location_id',
            'mealtimes' => 'mealtime_id',
            'menu_item_option_values' => 'menu_option_value_id',
            'menu_item_options' => 'menu_option_id',
            'menu_option_values' => 'option_value_id',
            'menu_options' => 'option_id',
            'menus' => 'menu_id',
            'menus_specials' => 'special_id',
            'order_menu_options' => 'order_option_id',
            'order_menus' => 'order_menu_id',
            'order_totals' => 'order_total_id',
            'orders' => 'order_id',
            'payment_logs' => 'payment_log_id',
            'payment_profiles' => 'payment_profile_id',
            'payments' => 'payment_id',
            'reservations' => 'reservation_id',
            'staff_groups' => 'staff_group_id',
            'staff_roles' => 'staff_role_id',
            'staffs' => 'staff_id',
            'status_history' => 'status_history_id',
            'statuses' => 'status_id',
            'tables' => 'table_id',
            'user_preferences' => 'id',
            'users' => 'user_id',
        ] as $table => $key) {
            Schema::table($table, function (Blueprint $table) use ($key) {
                $table->unsignedBigInteger($key, true)->change();
            });
        }
    }

    public function down()
    {
    }
}
