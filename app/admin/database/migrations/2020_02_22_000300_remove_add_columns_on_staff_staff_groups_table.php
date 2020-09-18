<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAddColumnsOnStaffStaffGroupsTable extends Migration
{
    public function up()
    {
        Schema::table('staff_groups', function (Blueprint $table) {
            $table->dropColumn('customer_account_access');
            $table->dropColumn('location_access');
            $table->text('description');
            $table->boolean('auto_assign')->default(0)->nullable();
            $table->tinyInteger('auto_assign_mode')->default(1)->nullable();
            $table->integer('auto_assign_limit')->default(20)->nullable();
            $table->boolean('auto_assign_availability')->default(1)->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('last_seen')->nullable();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dateTime('last_seen')->nullable();
        });
    }

    public function down()
    {
    }
}
