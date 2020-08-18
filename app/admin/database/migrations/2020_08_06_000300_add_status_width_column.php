<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusWidthColumn extends Migration
{
    public function up()
    {
        Schema::table('statuses', function (Blueprint $table) {
            $table->integer('status_width')->default(25)->nullable();
        });
    }
}