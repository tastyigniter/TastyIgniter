<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_preferences', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('item');
            $table->text('value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_preferences');
    }
};
