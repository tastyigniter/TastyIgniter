<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergensTable extends Migration
{
    public function up()
    {
        Schema::create('allergens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('allergen_id');
            $table->string('name');
            $table->string('description');
            $table->boolean('status')->default(1);
        });

        Schema::create('allergenables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('allergen_id')->unsigned()->index();
            $table->morphs('allergenable', 'allergenable_index');
            $table->unique(['allergen_id', 'allergenable_id', 'allergenable_type'], 'allergenable_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('allergens');
        Schema::dropIfExists('allergenables');
    }
}
