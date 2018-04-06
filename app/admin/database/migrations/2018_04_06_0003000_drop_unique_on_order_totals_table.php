<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropUniqueOnOrderTotalsTable extends Migration
{
    public function up()
    {
        Schema::table('order_totals', function (Blueprint $table) {
            $table->dropUnique('order_totals_order_id_unique');
        });
    }

    public function down()
    {
        //
    }
}