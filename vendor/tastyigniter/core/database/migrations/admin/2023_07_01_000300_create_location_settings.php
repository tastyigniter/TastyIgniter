<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('location_settings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->string('item');
            $table->json('data')->nullable();

            $table->unique(['location_id', 'item']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_settings');
    }
};
