<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityColumnToOrderMenuOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('order_options', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->nullable();
        });
    }

    public function down()
    {
    }
}
