<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Remove redundant/unused columns from menu_options_values.....
 */
class DropRedundantColumnsOnKitchenTables extends Migration
{
    public function up()
    {
        Schema::table('menu_option_values', function (Blueprint $table) {
            $table->dropColumn('menu_id');
            $table->dropColumn('option_id');
        });

        Schema::table('menu_options', function (Blueprint $table) {
            $table->dropColumn('default_value_id');
            $table->dropColumn('option_values');
        });
    }

    public function down()
    {
    }
}
