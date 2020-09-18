<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignableLogsTable extends Migration
{
    public function up()
    {
        Schema::create('assignable_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->morphs('assignable');
            $table->integer('assignee_id')->unsigned()->nullable();
            $table->integer('assignee_group_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('status_updated_at')->nullable();
            $table->dateTime('assignee_updated_at')->nullable();
            $table->integer('assignee_group_id')->after('assignee_id')->unsigned()->nullable();
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dateTime('status_updated_at')->nullable();
            $table->dateTime('assignee_updated_at')->nullable();
            $table->integer('assignee_group_id')->after('assignee_id')->unsigned()->nullable();
        });

        Schema::table('status_history', function (Blueprint $table) {
            $table->dropColumn('assignee_id');
            $table->dropColumn('status_for');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignable_logs');
    }
}
