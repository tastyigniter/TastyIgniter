<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add validity columns on menus_specials table
 */
class AddColumnsOnMenuSpecialsTable extends Migration
{
    public function up()
    {
        Schema::table('menus_specials', function (Blueprint $table) {
            $table->string('type');
            $table->string('validity');
            $table->dateTime('start_date')->default('CURRENT_TIMESTAMP')->change();
            $table->dateTime('end_date')->default('CURRENT_TIMESTAMP')->change();
            $table->text('recurring_every')->nullable();
            $table->time('recurring_from')->nullable();
            $table->time('recurring_to')->nullable();
        });
    }

    public function down()
    {
        //
    }
}
