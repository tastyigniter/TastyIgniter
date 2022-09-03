<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeLocationOptionsFieldsUnique extends Migration
{
    public function up()
    {
        Schema::table('location_options', function (Blueprint $table) {
            $table->unique(['location_id', 'item']);
        });
    }

    public function down()
    {
    }
}
