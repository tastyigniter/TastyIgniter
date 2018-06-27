<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationMenuCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('location_menu', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('location_id');
            $table->integer('menu_id');
        });

        Schema::create('location_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('location_id');
            $table->integer('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_menu');
        Schema::dropIfExists('location_category');
    }
}
