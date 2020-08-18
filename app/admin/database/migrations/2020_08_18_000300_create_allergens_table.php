<?php namespace Admin\Database\Migrations;

use DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *
 */
class CreateAllergensTable extends Migration
{
    public function up()
    {
        Schema::create('allergens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('allergen_id');
            $table->string('name');
            $table->string('description');
            $table->integer('status', 1);
        });
	    
	    
        Schema::create('menu_allergens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('menu_id')->unsigned()->index();
            $table->integer('allergen_id')->unsigned()->index();
            $table->unique(['menu_id', 'allergen_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('allergens');
        Schema::dropIfExists('menu_allergens');
    }
}