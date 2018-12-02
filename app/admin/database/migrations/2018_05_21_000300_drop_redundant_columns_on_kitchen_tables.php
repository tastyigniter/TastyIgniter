<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

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
        Schema::table('menu_option_values', function (Blueprint $table) {
            $table->integer('menu_id')->unsigned();
            $table->integer('option_id')->unsigned();
        });

        Schema::table('menu_options', function (Blueprint $table) {
            $table->integer('default_value_id')->unsigned();
            $table->text('option_values');
        });
    }
}