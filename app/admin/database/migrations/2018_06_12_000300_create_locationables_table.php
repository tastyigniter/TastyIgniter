<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class CreateLocationablesTable extends Migration
{
    public function up()
    {
        Schema::create('locationables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('location_id');
            $table->integer('locationable_id');
            $table->string('locationable_type');
            $table->text('options');
        });
    }

    public function down()
    {
        Schema::dropIfExists('locationables');
    }
}
