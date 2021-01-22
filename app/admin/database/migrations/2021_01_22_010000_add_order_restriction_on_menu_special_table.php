<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class AddOrderTimeIsAsapOnOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('menus_specials', function (Blueprint $table) {
            $table->tinyInteger('order_restriction')->nullable();
        });
    }

    public function down()
    {
    }
}
