<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStayTimeDiningTableTable extends Migration
{
    public function up()
    {
        Schema::table('dining_tables', function (Blueprint $table) {
            $table->integer('stay_time')->nullable();
        });
    }

    public function down()
    {
    }
}
