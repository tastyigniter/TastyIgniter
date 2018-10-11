<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Drop primary key order_id and add unique keys
 */
class autoIncrementOnOrderTotalsTable extends Migration
{
    public function up()
    {
        Schema::table('order_totals', function (Blueprint $table) {
            $table->increments('order_total_id')->change();
        });
    }

    public function down()
    {
        //
    }
}