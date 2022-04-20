<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSelectedColumnsToMenuOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('order_restriction')->default(0);
        });

        Schema::table('menu_options', function (Blueprint $table) {
            $table->integer('min_selected')->default(0);
            $table->integer('max_selected')->default(0);
        });
    }

    public function down()
    {
    }
}
