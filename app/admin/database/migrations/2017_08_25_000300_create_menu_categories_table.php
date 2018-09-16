<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Create menu_categories table
 */
class CreateMenuCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('menu_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->unique(['menu_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_categories');
    }
}