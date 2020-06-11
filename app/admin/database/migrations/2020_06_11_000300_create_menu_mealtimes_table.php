<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *
 */
class CreateMenuMealtimesTable extends Migration
{
    public function up()
    {
        Schema::create('menu_mealtimes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('menu_id')->unsigned()->index();
            $table->integer('mealtime_id')->unsigned()->index();
            $table->unique(['menu_id', 'mealtime_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_mealtimes');
    }
}