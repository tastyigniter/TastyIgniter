<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToTables extends Migration
{
    public function up()
    {
        foreach ([
            'addresses',
            'allergens',
            'categories',
            'customer_groups',
            'locations',
            'mealtimes',
            'menus',
            'menu_options',
            'menu_item_options',
            'menu_item_option_values',
            'menus_specials',
            'staff_groups',
            'statuses',
            'tables',
            'users',
        ] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->timestamps();
            });
        }

        Schema::table('activities', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_updated')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_updated', 'updated_at');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->timestamp('updated_at');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_modified')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_modified', 'updated_at');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_updated')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_updated', 'updated_at');
        });

        Schema::table('payment_logs', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_updated')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_updated', 'updated_at');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_modified')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_modified', 'updated_at');
        });

        Schema::table('staffs', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->timestamp('updated_at');
        });

        Schema::table('status_history', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
    }
}
