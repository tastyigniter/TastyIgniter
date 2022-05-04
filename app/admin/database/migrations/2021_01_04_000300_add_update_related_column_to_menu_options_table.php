<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateRelatedColumnToMenuOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('menu_options', function (Blueprint $table) {
            $table->boolean('update_related_menu_item')->default(false);
        });
    }
}
