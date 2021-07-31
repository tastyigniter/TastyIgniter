<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Set order_total_id to auto increment PRIMARY key
 */
class AutoIncrementOnOrderTotalsTable extends Migration
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
