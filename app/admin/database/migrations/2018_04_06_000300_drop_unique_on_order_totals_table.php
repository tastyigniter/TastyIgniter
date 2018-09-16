<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Drop primary key order_id and add unique keys
 */
class DropUniqueOnOrderTotalsTable extends Migration
{
    public function up()
    {
        Schema::table('order_totals', function (Blueprint $table) {
            $table->integer('order_total_id')->unsigned()->change();
            $table->integer('order_id')->unsigned()->change();
            $table->dropPrimary('order_id');
            $table->primary('order_total_id');
        });
    }

    public function down()
    {
        //
    }
}