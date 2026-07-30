<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('languages', function(Blueprint $table) {
            $table->string('version')->nullable();
        });
    }

    public function down()
    {
        //
    }
};
