<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedColumns extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('menu_photo');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('flag');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('location_image');
        });

        Schema::table('staffs', function (Blueprint $table) {
            $table->dropColumn('staff_location_id');
            $table->dropColumn('timezone');
        });

        Schema::table('staff_groups', function (Blueprint $table) {
            $table->dropColumn('permissions');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('salt');
        });
    }

    public function down()
    {
    }
}
