<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Set PRIMARY key on user_preferences table
 */
return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('user_preferences', 'id')) {
            Schema::table('user_preferences', function(Blueprint $table) {
                $table->increments('id')->first()->change();
            });
        } else {
            Schema::table('user_preferences', function(Blueprint $table) {
                $table->increments('id')->first();
            });
        }
    }

    public function down()
    {
        //
    }
};
