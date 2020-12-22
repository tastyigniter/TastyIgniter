<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityColumnToLocationAreasTable extends Migration
{
    public function up()
    {
        Schema::table('location_areas', function (Blueprint $table) {
            $table->integer('priority')->default(0);
        });
    }
}
